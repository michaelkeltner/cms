<?php
$aFieldOptions = unserialize($oPropery->options);
    
    if ($aFieldOptions['select_populated'] == 'database'){
        $sTable = $aFieldOptions['select_table'];
        $sColumn = $aFieldOptions['select_table_field'];
        $oDB = DB::getDB();
        $sSQL = "SELECT `$sColumn` FROM `$sTable` ORDER BY `$sColumn` ASC";
        $aSelectValues = $oDB->getRowsAsArray($sSQL);
    }else{
        $aSelectValues = explode("\n", $aFieldOptions['select_values']);
        
    }
    //prePrint($sValue);
    if (!isset($sValue) || $sValue == ''){
        $aValue = array();
    }else{
        if (is_array($sValue)){
            $aValue = $sValue;  
        }else{
            $aValue = unserialize($sValue);
        }
    }

    
    $aOptionsCount = count($aSelectValues);  
    
    if ($aFieldOptions['multiple']){
        $sMultiple = ' multiple="multiple"';
        $sFirstEntry = '-- None --';
        $iSelectHeight = ceil($aOptionsCount / 2) * 50;
        
    }else{
        $sMultiple = '';
        $sFirstEntry = '-- Select --';
        $iSelectHeight = 35;
    } 
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
