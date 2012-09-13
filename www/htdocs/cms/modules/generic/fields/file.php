<?php 
    $aAssetOptions = $oAsset->getAll(' WHERE `type` = "doc"');

    $aFieldOptions = unserialize($oPropery->options);
    if ($aFieldOptions['multiple']){
        $sMultiple = ' multiple="multiple"';
        $sFirstEntry = '-- None --';
    }else{
        $sMultiple = '';
        $sFirstEntry = '-- Select --';
    }
    $aId = @unserialize($sValue); 
     if (!is_array($aId)){
        $aId = array();
    }
?>
<p class="name<?php include('options.php')?>">
    <?php if (count($aAssetOptions)):?>
    <select name="<?php echo $sFieldName?>[]"<?php echo $sMultiple?>>
        <option value="0"><?php echo $sFirstEntry?></option>
        
       <?php foreach($aAssetOptions as $oOption):?>
        <option value="<?php echo $oOption->id?>"<?php if(in_array($oOption->id, $aId)):?> selected="selected"<?php endif;?>><?php echo $oOption->display_name?></option>
       <?php endforeach;?>
    </select><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    <?php endif; ?>
</p>
