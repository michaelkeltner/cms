<div class="<?php echo $sFieldClass ?>" id="clone_field_header">
<?php 
$sFieldDisplayName = isset($oFieldItem->display_name)?$oFieldItem->display_name:'';
$iFieldId = isset($oFieldItem->field_id)?$oFieldItem->field_id:'';
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
?>
    <?php $sFieldDisplayType = 'Header'?>
    <?php include('action_buttons.php') ?>
    <div class="field_item">
        
        <p class="name show">
            <input type="hidden" name="module_field[name][]" value="header"/><br/>
            <label>Display</label><br/>
            
            <input type="text" name="module_field[display_name][]" value="<?php echo $sFieldDisplayName?>"/><br/>
            <input type="hidden" value="header" name="module_field[type][]"/>
            <input type="hidden" value="" name="module_field[description][]"/>
            <input type="hidden" value="<?php echo $iFieldId?>" name="module_field[field_id][]"/>
            <input type="hidden" name="module_field[orig_name][]" value="header"/>
            <input type="hidden" value="<?php echo $iId?>" name="module_field[id][]"/>
            <input type="hidden" value="0" name="module_field[options][list][]"/><br/>
            <input type="hidden" name="module_field[options][module_id][]" value="0">
            <input type="hidden" name="module_field[options][field_id][]" value="0">
            <input type="hidden" name="module_field[options][multiple][]" value="0">
            <input type="hidden" name="module_field[options][required][]" value="0">          
        </p>
    </div>
</div>