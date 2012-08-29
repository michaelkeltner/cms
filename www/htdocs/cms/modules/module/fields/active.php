<?php 
$sFieldType = 'active';
$sFieldDisplayType = 'Active';
$sFieldDisplayName = isset($oFieldItem->display_name)?$oFieldItem->display_name:'';
$sFieldDescription = isset($oFieldItem->description)?$oFieldItem->description:'';
$iFieldId = isset($oFieldItem->field_id)?$oFieldItem->field_id:'';
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
?>
<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType?>">
    <div class="field_item">
        <?php include('action_buttons.php') ?>
        <p class="name show">
    <input type="hidden" name="module_field[name][]" value="active"/><br/>
    <label>Display Name</label><br/>
    <input type="text" name="module_field[display_name][]" value="<?php echo $sFieldDisplayName?>"/><br/>
    <label>Description</label><br/>
    <textarea rows="2" cols="20" name="module_field[description][]"><?php echo $sFieldDescription ?></textarea><br/>
    <input type="hidden" value="<?php echo $sFieldType?>" name="module_field[type][]"/>
    <input type="hidden" value="<?php echo $iFieldId?>" name="module_field[field_id][]"/>
    <input type="hidden" name="module_field[orig_name][]" value="active"/>
    <input type="hidden" value="<?php echo $iId?>" name="module_field[id][]"/><br/>
    
</p>
<?php include('options.php') ?>
    </div>
</div>