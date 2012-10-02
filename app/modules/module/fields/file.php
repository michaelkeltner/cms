<?php $sFieldType = 'file'?>
<?php $sFieldDisplayType = 'File'?>
<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType?>">
    <?php include('action_buttons.php') ?>
    <div class="field_item">
        <?php include('common.php') ?> 
        <?php include('options.php') ?>
        Allow multiple values<br/>
        <select name="module_field[options][multiple][]">
            <option <?php if ($bSelected):?>selected="selected"<?php endif; ?> value="1">Yes</option>
            <option <?php if(!$bSelected):?>selected="selected"<?php endif; ?> value="0">No</option>
        </select><br/>
    </div>
</div>
