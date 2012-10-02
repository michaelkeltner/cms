<?php 
    $aAssetOptions = $oAsset->getAll(' WHERE `type` = "image"');

    $aId = @unserialize($sValue); 
     if (!is_array($aId)){
        $aId = array(0);
    }
?>
<p class="file name<?php include('options.php')?>">
    <label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    <?php if (count($aAssetOptions)):?>
    <div class="sortable" id="sortable_<?php echo $sFieldName?>">
        <?php foreach($aId as $iSelectedValue):?>
            <span class="span_<?php echo $sFieldName?>">
                <select class="image_selector" name="<?php echo $sFieldName?>[]">
                    <option value="0">-- Select --</option>
                   <?php foreach($aAssetOptions as $oOption):?>
                    <option value="<?php echo $oOption->id?>"<?php if($oOption->id == $iSelectedValue):?> selected="selected"<?php endif;?>><?php echo $oOption->display_name?></option>
                   <?php endforeach;?>
                </select>
                <image src="/cms/images/move.png" width="28" height="28" alt="move"/>
                <a href="#" class="delete_field"><image src="/cms/images/delete.png" width="28" height="28" alt="remove"/></a>
                <br/>
                <div class="preview_image">
                    <?php 
                        if ($iSelectedValue != 0):
                            $oImage = $oAsset->getWithId($iSelectedValue);
                            $sURL = 'http://' . BASE_URL . '/' . $oAsset->getAssetItemPath($oImage->name, 'image');
                            $aImageProperties = getimagesize($sURL);
                    ?>
                        <img src="<?php echo $sURL?>" class="image_preview"/>(<?php echo $aImageProperties[0]?> x <?php echo  $aImageProperties[1]?> )<br/>
                    <?php endif;?>
                </div>
            </span>
        
        <?php endforeach;?>
    </div>
        
    <a class="add_image_select<?php if($iSelectedValue == 0):?> hide<?php endif;?>" id="<?php echo $sFieldName?>" alt="add another image" href="#">
        <image src="/cms/images/add-item.png" width="28" height="28" alt="Add another" class="add"/>
    </a>
    <?php endif; ?>
    
</p>
