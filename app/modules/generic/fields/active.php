<p class="name<?php include('options.php')?>">
    <input type="checkbox" name="<?php echo $sFieldName?>" <?php if ((int)$sValue !== 0):?>checked="cehcked"<?php endif;?>value="1"/><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
</p>