<div class="<?php echo $sClass ?>" id="clone_item_header">
    <div class="column_item">
        <?php include('action_buttons.php') ?>
        <input type="hidden" class="hidden_type" name="type[<?php echo $iSectionId ?>][]" value="header"/>
        <p class="name show">
            <input name="content[<?php echo $iSectionId ?>][]" id="content" value="<? echo $sValue ?>"/>
            <label for="content">Header</label>
        </p>
        <?php include('start_end_date.php') ?> 
    </div>
</div>