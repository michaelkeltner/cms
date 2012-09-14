<?php 
$sFieldType = 'association';
$sFieldDisplayType = 'Association';
$bSelected = (isset($aOptions['multiple']) && $aOptions['multiple'])?true:false;
$aOptions = isset($oFieldItem->options)?unserialize($oFieldItem->options):array();
$iSelectedModule = isset($aOptions['module_id'])?$aOptions['module_id']:0;
if ($iSelectedModule){
    $aFields = $oModuleBuilder->getModuleFields($iSelectedModule);
}
$iSelectedField = isset($aOptions['field_id'])?$aOptions['field_id']:0;
?>
<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType?>">
    <?php include('action_buttons.php') ?>
        <div class="field_item">
            <p class="name show">
    <?php 
$sFieldName = isset($oFieldItem->name)?$oFieldItem->name:'';
$sFieldDisplayName = isset($oFieldItem->display_name)?$oFieldItem->display_name:'';
$sFieldDescription = isset($oFieldItem->description)?$oFieldItem->description:'';
$iFieldId = isset($oFieldItem->field_id)?$oFieldItem->field_id:'';
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
?>
            <label>Name</label><br/>
            <input type="text" fieldtype="association_name" readonly="readonly" name="module_field[name][]" value="<?php echo $sFieldName?>"/><br/>
            <label>Display Name</label><br/>
            <input type="text" name="module_field[display_name][]" value="<?php echo $sFieldDisplayName?>"/><br/>
            <label>Description</label><br/>
            <textarea rows="2" cols="20" name="module_field[description][]"><?php echo $sFieldDescription?></textarea><br/>
            <input type="hidden" value="<?php echo $sFieldType?>" name="module_field[type][]"/>
            <input type="hidden" value="<?php echo $iFieldId?>" name="module_field[field_id][]"/>
            <input type="hidden" name="module_field[orig_name][]" value="<?php echo $sFieldName?>"/>
            <input type="hidden" value="<?php echo $iId?>" name="module_field[id][]"/><br/>


        </p>
        <p class="options">
            Associate with<br/>
            <select  class="association_module_select" name="module_field[options][module_id][]">
                <option value="0">-- Select Module--</option>
                <?php foreach($aModule as $oModuleItem): ?>
                <option value="<?php echo $oModuleItem->id?>"<?php if($iSelectedModule == $oModuleItem->id):?>selected="selected"<?php endif;?>><?php echo $oModuleItem->display_name?></option>
                <?php endforeach; ?>
            </select><br/>
            <select  class="association_field_select<?php if(!$iSelectedModule):?> hide<?php endif;?>" name="module_field[options][field_id][]">
            <?php if(count($aFields)):?>
                <?php foreach($aFields as $oFieldItem):?>
                    <option value="<?php echo $oFieldItem->id?>" <?php if ($iSelectedField == $oFieldItem->id):?>selected="selected"<?php endif;?>><?php echo $oFieldItem->display_name?></option>
                <?php endforeach;?>
                <?php endif;?>
            </select>
            <?php
            $aOptions = isset($oFieldItem->options)?unserialize($oFieldItem->options):array();
            $bMultipleSelected = (isset($aOptions['multiple']) && $aOptions['multiple'])?true:false;
            $bListSelected = (isset($aOptions['list']) && $aOptions['list'])?true:false;
            $bRequiredSelected = (isset($aOptions['required']) && $aOptions['required'])?true:false;
            ?><br/>
            Options<br/>
            <select name="module_field[options][multiple][]">
                <option <?php if ($bMultipleSelected):?>selected="selected"<?php endif; ?> value=1>Multiple selection</option>
                <option <?php if(!$bMultipleSelected):?>selected="selected"<?php endif; ?> value=0>Single selection</option>
            </select><br/>
            <select name="module_field[options][list][]">
                <option <?php if ($bListSelected):?>selected="selected"<?php endif; ?> value=1>Show on listing page</option>
                <option <?php if(!$bListSelected):?>selected="selected"<?php endif; ?> value=0>Do not show on listing</option>
            </select>
            <select name="module_field[options][required][]">
                <option <?php if ($bRequiredSelected):?>selected="selected"<?php endif; ?> value=1>Required field</option>
                <option <?php if(!$bRequiredSelected):?>selected="selected"<?php endif; ?> value=0>Not Required</option>
            </select>
             <input type="hidden" name="module_field[options][select_values][]" value="0">
        </p>
    </div>
</div>
