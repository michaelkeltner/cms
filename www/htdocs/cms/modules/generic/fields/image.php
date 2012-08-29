<?php 
    $aOptions = $oAsset->getAll(' WHERE `type` = "image"');
    $aFieldOptions = unserialize($oPropery->options);
    if ($aFieldOptions['multiple']){
        $sMultiple = ' multiple="multiple"';
        $sFirstEntry = '-- None --';
    }else{
        $sMultiple = '';
        $sFirstEntry = '-- Select --';
    }
    $aId = unserialize($sValue);
    $aURL = array();
    if (!is_array($aId)){
        $aId = array();
    }else{
        foreach ($aId as $iId){
            if ($iId == 0 ){continue;}
            $oItem = $oAsset->getWithId($iId);
            $aURL[] = '/assets/images/'. $oItem->name;
        }
        
    }
?>
<p class="name">
    <?php if (count($aOptions)):?>
    
    <select name="<?php echo $sFieldName?>[]"<?php echo $sMultiple?> class="image_select">
        <option value="0"><?php echo $sFirstEntry?></option>
       <?php foreach($aOptions as $oOption):?>
        <option value="<?php echo $oOption->id?>"<?php if(in_array($oOption->id, $aId)):?> selected="selected"<?php endif;?>><?php echo $oOption->display_name?></option>
       <?php endforeach;?>
    </select><label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    <?php endif; ?>
</p>
<div class="preview_image">
    <?php if (count($aURL)):?>
    <?php foreach ($aURL as $sURL):?>
    <img src="<?php echo $sURL?>" class="image_preview"/><br/>
    <?php endforeach;?>
    <?php endif;?>
</div>