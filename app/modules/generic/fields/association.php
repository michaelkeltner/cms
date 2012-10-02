<?php 
    
    $aAssociationOptions = $oAssociation->getFieldOptions($oModuleGeneric->oProperties->id, $sFieldName);
    $aFieldOptions = unserialize($oPropery->options);
    if ($aFieldOptions['multiple']){
        $sMultiple = ' multiple="multiple"';
        if (count($aAssociationOptions)){
            $iSelectHeight = ceil((count($aAssociationOptions)/5) * 35);
        }
        $sFirstEntry = '-- None --';
    }else{
        $sMultiple = '';
        $sFirstEntry = '-- Select --';
        $iSelectHeight = 35;
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
<p class="name<?php include('options.php')?>">
    <?php if (count($aAssociationOptions)):?>
    <select name="<?php echo $sFieldName?>[]"<?php echo $sMultiple?> style="height: <?php echo $iSelectHeight?>px;width: 275px;">
        <option value=""><?php echo $sFirstEntry?></option>
       <?php foreach($aAssociationOptions as $oOption):?>
        <option value="<?php echo $oOption->id?>"<?php if(in_array($oOption->id, $aId)):?> selected="selected"<?php endif;?>><?php echo $oOption->field_name?></option>
       <?php endforeach;?>
    </select><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    <?php endif; ?>
</p>