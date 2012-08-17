<div class="<?php echo $sClass ?>" id="clone_item_text">
    <div class="column_item">
        <?php include('action_buttons.php') ?>
        <input type="hidden" class="hidden_type" name="type[<?php echo $iSectionId ?>][]" value="text"/>
        <p class="name show">
            <textarea rows="2" cols="20" name="content[<?php echo $iSectionId ?>][]" id="content"><? echo $sValue ?></textarea>
            <label for="content">Content</label>
        </p>
        <?php include('start_end_date.php') ?>
    </div>
</div>
