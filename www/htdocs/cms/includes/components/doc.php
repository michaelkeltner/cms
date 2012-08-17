<div class="<?php echo $sClass?>" id="clone_item_doc">
       <div class="column_item">
        <?php include('action_buttons.php') ?>
        <input type="hidden" class="hidden_type" name="type[<?php echo $iSectionId?>][]" value="doc"/>
        <p class="name show">
                <select name="content[<?php echo $iSectionId?>][]" id="doc">
                    <?php if (isset($aDocOptions) && count($aDocOptions)):?>
                    <option value="">-- select a document --</option>
                        <?php foreach ($aDocOptions as $oOption):?>
                            <option value="<?php echo $oOption->id?>"<?php if ($sSelected == $oOption->id):?> selected='selected' <?php endif; ?>><?php echo $oOption->display_name?></option>
                         <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <label for="doc">Document</label>
            </p>
            <?php include('start_end_date.php') ?>
    </div>
</div>