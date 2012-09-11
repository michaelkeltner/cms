<p class="name<?php include('options.php')?>">
    <input type="hidden" class="datetime_value_fix" value="<?php echo $sValue?>" id="<?php echo $sFieldName?>"/>
    <input type="text" class="form_datetime" name="<?php echo $sFieldName?>" value="<?php echo date("m/d/Y h:i A", strtotime($sValue))?>"/><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
</p>