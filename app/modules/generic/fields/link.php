<?php 
    $aValues = @unserialize($sValue);
?>
<p class="file name<?php include('options.php')?>">
    <label for="<?php echo $sFieldName?>"><?php echo $sDisplay?></label>
    
    <div class="sortable" id="sortable_<?php echo $sFieldName?>">
        <?php if ($aValues && count($aValues)):?>
        <?php foreach($aValues['url'] as $iIndex=>$sURL):?>
            <span class="span_<?php echo $sFieldName?>">
                <input type="text" name="<?php echo $sFieldName?>[url][]" value="<?php echo $sURL?>"/> URL<br/>
                <input type="text" name="<?php echo $sFieldName?>[display][]" value="<?php echo $aValues['display'][$iIndex]?>"/>Display<br/>
                <select name="<?php echo $sFieldName?>[target][]">
                    <option value="_blank"<?php if ($aValues['target'][$iIndex] == '_blank'):?>selected="selected"<?php endif?>>New Window</option> 
                    <option value="_self"<?php if ($aValues['target'][$iIndex] == '_self'):?>selected="selected"<?php endif?>>Same Window</option>
                </select> Target.
                <image src="/cms/images/move.png" width="28" height="28" alt="move"/>
                <a href="#" class="delete_field"><image src="/cms/images/delete.png" width="28" height="28" alt="remove"/></a>
                <br/>
            </span>
        <?php endforeach;?>
        <?php else:?>
        <span class="span_<?php echo $sFieldName?>">
                <input type="text" name="<?php echo $sFieldName?>[url][]"/> URL<br/>
                <input type="text" name="<?php echo $sFieldName?>[dispaly][]"/> Display<br/>
                <select name="<?php echo $sFieldName?>[target][]">
                    <option value="_blank">New window</option> 
                    <option value="_self">Same window</option>
                </select> Target
                <image src="/cms/images/move.png" width="28" height="28" alt="move"/>
                <a href="#" class="delete_field"><image src="/cms/images/delete.png" width="28" height="28" alt="remove"/></a>
                <br/>
            </span>
        <?php endif; ?>
    </div>
        
    <a class="add_file_select" id="<?php echo $sFieldName?>" alt="add another file" href="#">
        <image src="/cms/images/add-item.png" width="28" height="28" alt="Add another" class="add"/>
    </a>

    
    
</p>
