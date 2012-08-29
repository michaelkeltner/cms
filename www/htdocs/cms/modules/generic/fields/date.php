<p class="name">
    <input type="hidden" class="datetime_value_fix" value="<?php echo $sValue?>" id="<?php echo $sFieldName?>"/>
    <input type="text" class="form_date" name="<?php echo $sFieldName?>" value="<?php echo date("m/d/Y", strtotime($sValue))?>"/><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
</p>