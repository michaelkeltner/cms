<div class="<?php echo $sClass?>" id="clone_item_image">
    <div class="column_item">
        <?php include('action_buttons.php') ?>
        <input type="hidden" class="hidden_type" name="type[<?php echo $iSectionId?>][]" value="image"/>
        <p class="name show">
                <select name="content[<?php echo $iSectionId?>][]" id="image" class="image_select">
                    <option value="0"> -- Select an image -- </option>
                    <?php if (isset($aImageOptions) && count($aImageOptions)):?>
                        <?php foreach ($aImageOptions as $oOption):?>
                            <option value="<?php echo $oOption->id?>"<?php if ($sSelected == $oOption->id):?> selected='selected' <?php endif; ?>><?php echo $oOption->display_name?></option>
                         <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="image">Image</label>
            </p>
            <div class="thumbnail preview_image"><?php echo $sPreview?></div>
            <?php include('start_end_date.php') ?>
    </div>
</div>