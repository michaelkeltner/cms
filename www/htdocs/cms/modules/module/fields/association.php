<?php 
$sFieldType = 'association';
$sFieldDisplayType = 'Association';
$bSelected = (isset($aOptions['multiple']) && $aOptions['multiple'])?true:false;
$aOptions = isset($oFieldItem->options)?unserialize($oFieldItem->options):array();
$iSelectedModule = isset($aOptions['module_id'])?$aOptions['module_id']:0;
if ($iSelectedModule){
    $aFields = $oModuleBuilder->getModuleFields($iSelectedModule);
}
$iSelectedField = isset($aOptions['field_id'])?$aOptions['field_id']:0;
?>
<div class="<?php echo $sFieldClass ?>" id="clone_field_<?php echo $sFieldType?>">
    <div class="field_item">
        <?php include('action_buttons.php') ?>
        <?php include('common.php') ?> 
        <?php $aOptions = isset($oFieldItem->options)?unserialize($oFieldItem->options):array(); ?>
        <?php $bSelected = (isset($aOptions['list']) && $aOptions['list'])?true:false; ?>
        <p class="options">
            Listing Page Action<br/>
            <select name="module_field[options][list][]">
                <option <?php if ($bSelected):?>selected="selected"<?php endif; ?> value=1>Show</option>
                <option <?php if(!$bSelected):?>selected="selected"<?php endif; ?> value=0>Hide</option>
            </select><br/>
            Allow multiple values<br/>
            <select name="module_field[options][multiple][]">
                <option <?php if ($bSelected):?>selected="selected"<?php endif; ?> value="1">Yes</option>
                <option <?php if(!$bSelected):?>selected="selected"<?php endif; ?> value="0">No</option>
            </select><br/>
            Associate with<br/>
            <select class="association_module_select" name="module_field[options][module_id][]">
                <option value="0">-- Select Module--</option>
                <?php foreach($aModule as $oModuleItem): ?>
                <option value="<?php echo $oModuleItem->id?>"<?php if($iSelectedModule == $oModuleItem->id):?>selected="selected"<?php endif;?>><?php echo $oModuleItem->display_name?></option>
                <?php endforeach; ?>
            </select><br/>
            <select class="association_field_select<?php if(!$iSelectedModule):?> hide<?php endif;?>" name="module_field[options][field_id][]">
            <?php if(count($aFields)):?>
                <?php foreach($aFields as $oFieldItem):?>
                    <option value="<?php echo $oFieldItem->id?>" <?php if ($iSelectedField == $oFieldItem->id):?>selected="selected"<?php endif;?>><?php echo $oFieldItem->display_name?></option>
                <?php endforeach;?>
                <?php endif;?>
            </select>
        </p>
    </div>
</div>
