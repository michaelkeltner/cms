<p class="name<?php include('options.php')?>">
    <label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    <textarea id="<?php echo $sFieldName?>" class="field_wysiwyg" name="<?php echo $sFieldName?>"><?php echo unserialize($sValue)?></textarea>
</p>
