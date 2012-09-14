<?php
$sFieldType = 'select';
$sFieldDisplayType = 'Select';
$aOptions = isset($oFieldItem->options) ? unserialize($oFieldItem->options) : array();
$iId = isset($oFieldItem->id) ? $oFieldItem->id : '';
$bListSelected = (isset($aOptions['list']) && $aOptions['list']) ? true : false;
$bRequiredSelected = (isset($aOptions['required']) && $aOptions['required']) ? true : false;
$sSelectValues = (isset($aOptions['select_values']) && $aOptions['select_values']) ? $aOptions['select_values'] : '';
$bMultipleSelected = (isset($aOptions['multiple']) && $aOptions['multiple'])?true:false;
?>


<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType ?>">
    <?php include('action_buttons.php') ?>
    <div class="field_item">

        <?php include('common.php') ?> 
        
        <p class="select_values">
            <label>Values</label><br/>
            
            <textarea rows="4" cols="5" name="module_field[options][select_values][]"><?php echo $sSelectValues ?></textarea><br/>
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
