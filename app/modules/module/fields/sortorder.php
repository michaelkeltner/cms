<?php 
$sFieldType = 'sortorder';
$sFieldDisplayType = 'Sort Order';
$sFieldDisplayName = isset($oFieldItem->display_name)?$oFieldItem->display_name:'';
$sFieldDescription = isset($oFieldItem->description)?$oFieldItem->description:'';
$iFieldId = isset($oFieldItem->field_id)?$oFieldItem->field_id:'';
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
?>

<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType?>">
    <?php include('action_buttons.php') ?>
    <div class="field_item">
        <p class="name show">
    <input type="hidden" name="module_field[name][]" value="sort_order"/><br/>
    <label>Display Name</label><br/>
    <input type="text" name="module_field[display_name][]" value="<?php echo $sFieldDisplayName?>"/><br/>
    <label>Description</label><br/>
    <textarea rows="2" cols="20" name="module_field[description][]"><?php echo $sFieldDescription?></textarea><br/>
    <input type="hidden" name="module_field[type][]" value="<?php echo $sFieldType?>" />
    <input type="hidden" name="module_field[field_id][]" value="<?php echo $iFieldId?>"/>
    <input type="hidden" name="module_field[orig_name][]" value="sort_order"/>
    <input type="hidden" name="module_field[id][]" value="<?php echo $iId?>"/><br/>

</p>
    <?php include('options.php') ?>
    </div>
</div>