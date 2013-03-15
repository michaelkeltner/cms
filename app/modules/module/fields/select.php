<?php
$sFieldType = 'select';
$sFieldDisplayType = 'Select';
$aOptions = isset($oFieldItem->options) ? @unserialize($oFieldItem->options) : array();
$iId = isset($oFieldItem->id) ? $oFieldItem->id : '';
$bListSelected = (isset($aOptions['list']) && $aOptions['list']) ? true : false;
$bRequiredSelected = (isset($aOptions['required']) && $aOptions['required']) ? true : false;
$sSelectValues = (isset($aOptions['select_values']) && $aOptions['select_values']) ? $aOptions['select_values'] : '';
$bMultipleSelected = (isset($aOptions['multiple']) && $aOptions['multiple'])?true:false;
$bSelectType = (isset($aOptions['select_populated']))?$aOptions['select_populated']:'manual';
$sDBModule = '';
if ($bSelectType == 'database'){
    $sDBModule = $aOptions['select_table'];
     $oDBModuleGeneric = new ModuleGeneric($sDBModule);
    $aDBFields = $oDBModuleGeneric->__get('aFields');
    if ($aDBFields){
        foreach ($aDBFields as $oDBField){
            $aDBFieldOptions[$oDBField->name] = $oDBField->display_name;
        }
    }

}
$aModuleItems = $oModuleBuilder->getAll(' WHERE `type` != "system" ORDER BY `name` ASC');
?>


<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType ?>">
    <?php include('action_buttons.php') ?>
    <div class="field_item">

        <?php include('common.php') ?> 
        
        <p class="select_values">
            <input class="radio_select_type" type="radio" name="module_field[options][select_populated][]" value="database" <?php if($bSelectType =='database'){echo 'checked="checked"';}?>/>Database
            <input class="radio_select_type" type="radio" name="module_field[options][select_populated][]" value="manual"  <?php if($bSelectType =='manual'){echo 'checked="checked"';}?>/>Manual
            <div class="database"<?php if($bSelectType !='database'){echo ' style="display: none"';}?>>
                <select class="db_tables" name="module_field[options][select_table][]">
                    <option value="">--choose--</option>
                    <?php foreach($aModuleItems as $oModuleItem):?>
                    <option value="<?php echo $oModuleItem->name?>"<?php if($sDBModule == $oModuleItem->name):?> selected="selected"<?php endif;?>><?php echo $oModuleItem->display_name?></option>
                    <?php endforeach;?>
                </select>
                <select class="table_fields" name="module_field[options][select_table_field][]" <?php if($bSelectType !='database'){echo ' style="display: none"';}?>>
                <?php if (count($aDBFieldOptions)):?>
                <?php foreach ($aDBFieldOptions as $iDBIndex=> $sDBValue):?>
                    <option value="<?php echo $iDBIndex?>"<?php if($iDBIndex == $aOptions['select_table_field']):?> selected="selected"<?php endif;?>><?php echo $sDBValue?></option>
                <?php endforeach;?>
                <?php endif;?>
                </select>
            </div>
            <div class="manual"<?php if($bSelectType !='manual'){echo ' style="display: none"';}?>>
                <label>Values</label><br/>
                <textarea rows="4" cols="5" name="module_field[options][select_values][]"><?php echo $sSelectValues ?></textarea><br/>
            </div>
        </p>
        <p class="options">Options<br/>
            <select name="module_field[options][list][]">
                <option <?php if ($bListSelected): ?>selected="selected"<?php endif; ?> value=1>Show on listing page</option>
                <option <?php if (!$bListSelected): ?>selected="selected"<?php endif; ?> value=0>Do not show on listing</option>
            </select>
            <select name="module_field[options][required][]">
                <option <?php if ($bRequiredSelected): ?>selected="selected"<?php endif; ?> value=1>Required field</option>
                <option <?php if (!$bRequiredSelected): ?>selected="selected"<?php endif; ?> value=0>Not Required</option>
            </select>
            <select name="module_field[options][multiple][]">
                <option <?php if ($bMultipleSelected):?>selected="selected"<?php endif; ?> value=1>Multiple selection</option>
                <option <?php if(!$bMultipleSelected):?>selected="selected"<?php endif; ?> value=0>Single selection</option>
            </select><br/>
            <input type="hidden" name="module_field[options][module_id][]" value="0">
            <input type="hidden" name="module_field[options][field_id][]" value="0">
            <input type="hidden" name="module_field[options][multiple][]" value="0">
            <br/>
        </p>
    </div>
</div>
