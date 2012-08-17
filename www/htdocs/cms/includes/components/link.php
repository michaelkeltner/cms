<div class="<?php echo $sClass ?>" id="clone_item_link">
    <div class="column_item">
        <?php include('action_buttons.php') ?>
        <input type="hidden" class="hidden_type" name="type[<?php echo $iSectionId ?>][]" value="link"/>
        <p class="name show">
            <input class="link_display" type="text" name="content[<?php echo $iSectionId ?>][display][]" value="<?php echo $sDisplay ?>" id="display" />
            <label for="display">Display</label>
        </p>
        <p class="name">
            <input class="link_url" type="text" name="content[<?php echo $iSectionId ?>][url][]" value="<?php echo $sURL ?>" id="url" />
            <label for="url">URL</label>
        </p>
        <p class="name">
            <select class="link_target" name="content[<?php echo $iSectionId ?>][target][]">
                <option value="_self"<?php if ($sTarget == '_self'): ?> selected='selected' <?php endif; ?>>Same Window</option>
                <option value="_blank"<?php if ($sTarget == '_blank'): ?> selected='selected' <?php endif; ?>>New Window</option>
            </select> 
            <label for="target">Target</label>
        </p>
        <?php include('start_end_date.php') ?>
    </div>
</div>