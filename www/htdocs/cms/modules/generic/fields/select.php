<?php
$aFieldOptions = unserialize($oPropery->options);
    if ($aFieldOptions['multiple']){
        $sMultiple = ' multiple="multiple"';
        $sFirstEntry = '-- None --';
    }else{
        $sMultiple = '';
        $sFirstEntry = '-- Select --';
    }
    $aSelectValues = explode("\n", $aFieldOptions['select_values']);
    $aValue = ($sValue)?unserialize($sValue):array();
    $aOptionsCount = count($aSelectValues);
    $iSelectHeight = ceil($aOptionsCount / 2) * 50;
?>
<?php if ($aOptionsCount > 0):?>
<p class="name<?php include('options.php')?>">

    <select style="height:<?php echo $iSelectHeight?>px" name="<?php echo $sFieldName?>[]"<?php echo $sMultiple?>>
        <option value=""><?php echo $sFirstEntry ?></option>
        <?php foreach($aSelectValues as $sSelectOption):?>
        <?php $sSelectOption = str_replace("\n",'' , str_replace("\r",'',$sSelectOption))?>
        <?php $sSelected = (in_array($sSelectOption, $aValue))?' selected="selected"':'';?>
        <option value="<?php echo $sSelectOption?>" <?php echo $sSelected?>><?php echo $sSelectOption?></option>
        <?php endforeach; ?>
    </select>
    <label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
</p>
<?php endif;?>
