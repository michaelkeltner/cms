<?php 
    
    $aOptions = $oAssociation->getFieldOptions($oModuleGeneric->oProperties->id, $sFieldName);
    $aFieldOptions = unserialize($oPropery->options);
    if ($aFieldOptions['multiple']){
        $sMultiple = ' multiple="multiple"';
        $sFirstEntry = '-- None --';
    }else{
        $sMultiple = '';
        $sFirstEntry = '-- Select --';
    }
    $aId = array();
    if ($iItemId){
        $aValues = $oAssociation->getAssocationValues($oProperties->id, $sFieldName, $iItemId);
        if (count($aValues)){
            foreach($aValues as $oValue){
                $aId[] = $oValue->id;
            }
        }
       
    }
            
            
?>
<p class="name">
    <?php if (count($aOptions)):?>
    <select name="<?php echo $sFieldName?>[]"<?php echo $sMultiple?>>
        <option value="0"><?php echo $sFirstEntry?></option>
       <?php foreach($aOptions as $oOption):?>
        <option value="<?php echo $oOption->id?>"<?php if(in_array($oOption->id, $aId)):?> selected="selected"<?php endif;?>><?php echo $oOption->field_name?></option>
       <?php endforeach;?>
    </select><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    <?php endif; ?>
</p>