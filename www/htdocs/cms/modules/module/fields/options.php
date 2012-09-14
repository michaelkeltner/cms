<p class="options">
<?php $aOptions = isset($oFieldItem->options)?unserialize($oFieldItem->options):array();
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
$bListSelected = (isset($aOptions['list']) && $aOptions['list'])?true:false;
$bRequiredSelected = (isset($aOptions['required']) && $aOptions['required'])?true:false;
?>
 Options<br/>
 <select name="module_field[options][list][]">
     <option <?php if ($bListSelected):?>selected="selected"<?php endif; ?> value=1>Show on listing page</option>
     <option <?php if(!$bListSelected):?>selected="selected"<?php endif; ?> value=0>Do not show on listing</option>
 </select>
  <select name="module_field[options][required][]">
     <option <?php if ($bRequiredSelected):?>selected="selected"<?php endif; ?> value=1>Required field</option>
     <option <?php if(!$bRequiredSelected):?>selected="selected"<?php endif; ?> value=0>Not Required</option>
 </select>
 <input type="hidden" name="module_field[options][module_id][]" value="0">
 <input type="hidden" name="module_field[options][field_id][]" value="0">
 <input type="hidden" name="module_field[options][multiple][]" value="0">
 <input type="hidden" name="module_field[options][select_values][]" value="0">
 <br/>
</p>