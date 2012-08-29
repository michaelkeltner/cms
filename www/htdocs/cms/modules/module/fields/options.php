<p class="options">
<?php $aOptions = isset($oFieldItem->options)?unserialize($oFieldItem->options):array();
$iId = isset($oFieldItem->id)?$oFieldItem->id:'';
$bSelected = (isset($aOptions['list']) && $aOptions['list'])?true:false;
?>
 Listing Page Action<br/>
 <select name="module_field[options][list][]">
     <option <?php if ($bSelected):?>selected="selected"<?php endif; ?> value=1>Show</option>
     <option <?php if(!$bSelected):?>selected="selected"<?php endif; ?> value=0>Hide</option>
 </select>
 <input type="hidden" name="module_field[options][module_id][]" value="0">
 <input type="hidden" name="module_field[options][field_id][]" value="0">
 <input type="hidden" name="module_field[options][multiple][]" value="0">
 <br/>
</p>