<p class="name">
    <input type="hidden" class="datetime_value_fix" value="<?php echo $sValue?>" id="<?php echo $sFieldName?>"/>
    <input type="text" class="form_time" name="<?php echo $sFieldName?>" value="<?php echo date("h:i A", strtotime($sValue))?>"/><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
</p>