<div class="<?php echo $sFieldClass ?>" id="clone_field_header">
<?php 
$sFieldDisplayName = isset($oFieldItem->display_name)?$oFieldItem->display_name:'';
$iFieldId = isset($oFieldItem->field_id)?$oFieldItem->field_id:'';
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
?>
    
    <div class="field_item">
        <?php $sFieldDisplayType = 'Header'?>
        <?php include('action_buttons.php') ?>
        <p class="name show">
            <input type="hidden" name="module_field[name][]" value="header"/><br/>
            <label>Display</label><br/>
            
            <input type="text" name="module_field[display_name][]" value="<?php echo $sFieldDisplayName?>"/><br/>
            <input type="hidden" value="header" name="module_field[type][]"/>
            <input type="hidden" value="header" name="module_field[description][]"/>
            <input type="hidden" value="<?php echo $iFieldId?>" name="module_field[field_id][]"/>
            <input type="hidden" name="module_field[orig_name][]" value="header"/>
             <input type="hidden" value="<?php echo $iId?>" name="module_field[id][]"/><br/>
        </p>
    </div>
</div>