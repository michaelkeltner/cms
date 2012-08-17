<?php 
$sActiveLink = 'module';
$oModuleBuilder = new ModuleBuilder();
$oField = new Field();
$aField = $oField->getAll();
$aModuleFields = array();
$bError = false;
$sError = '';
if (formSubmit()){
    if (getParam(3) == 'edit' || getParam(3) == 'add'){
        $sModuleMethod = getParam(3) . 'Module';
        if ($oModuleBuilder->{$sModuleMethod}($_POST)){
            gotoUrl('/cms/module/list/');
            exit;
        }
    }else{
        gotoUrl('/cms/module/list/');
        exit;
    }  
}
$sName = '';
$sDisplayName = '';
$sDescription = '';
$iActive = 1;

if (isset($_SESSION['module_action'] )){
    $sAction = $_SESSION['module_action'];
    unset($_SESSION['module_action']);
    $sFormSubmitText = 'Add';
    $aModuleFields = array(); 
}else{
    $sAction = 'edit';
    $iModuleId = ((int)getParam(4));
 
    $aModuleFields = $oModuleBuilder->getModuleFields($iModuleId);
    $aModuleDetails = $oModuleBuilder->getWithId($iModuleId);
    $sName = $aModuleDetails->name;
    $sDisplayName = $aModuleDetails->display_name;
    $sDescription = $aModuleDetails->description;
    $iActive = $aModuleDetails->active;
    $sFormSubmitText = 'Update';
}
?>

<?php require_once (CMS_INCLUDES . 'header.php');?>
<?php if ($oModuleBuilder->__get('bError')):?>
<div id="error" class="error">
    <?php 
    foreach ($oModuleBuilder->__get('sMessage') as $sMessage){
        echo $sMessage . '<br/>';
    }
    ?>
</div>
<?php endif;?>
<form action="<?php echo currentURL() ?>" method="post" class="module_builder noEnterSubmit">
    <div id="module_details">
        Name: <input name="module_details[name]" type="text" value="<?php echo $sName ?>"/><br/>
        Display Name: <input name="module_details[display_name]" type="text" value="<?php echo $sDisplayName ?>"/><br/>
        Description: <textarea name="module_details[description]"><?php echo $sDescription ?></textarea><br/>
        Is Active: <select name="module_details[active]">
            <option value="1"<?php  if ($iActive):?>selected="selected"<?php endif;?>>Yes</option>
            <option value="0"<?php  if (!$iActive):?>selected="selected"<?php endif;?>>No</option>
        </select><br/>
        <input type="hidden" name="module_details[orig_name]" value="<?php echo $sName ?>"/>
    </div>
    <div id="field_option_list">
        <?php foreach($aField as $oItem): ?>
        <div class="field_option">
            <a href="#" id="link_clone_field_<?php echo $oItem->type ?>" class="add_field" alt="add <?php echo $oItem->name ?>"><image src="/cms/images/add-item.png" alt="Add <?php echo $oItem->name ?>" width="32" heigth="32"/></a><?php echo $oItem->name?>
        </div>
        <?php endforeach; ?>
        
    </div>
    <div id="used_field_list" class="sortable">
        <?php if (count($aModuleFields)):?>
        <?php $sFieldClass = ''?>
            <?php foreach ($aModuleFields as $oFieldItem):?>
            <?php include(MODULES_ROOT .'module/fields/' . $oFieldItem->type . '.php');?>
            <?php endforeach?>
        <?php endif;?>
    </div>
    
    <input type="submit" value="<?php echo $sFormSubmitText?>"/>
    <input type="cancel" value="Cancel"/>
</form>

<div id="clone_field" class="hide">
   
    <?php 
     
    //foreach (scandir(MODULES_ROOT .'module/fields/') as $sFile) {
        foreach ($aField as $oFieldItem){
            $sFieldClass = 'cloneable';
            $oFieldItem->field_id = $oFieldItem->id;
            $oFieldItem->id = '';
            include(MODULES_ROOT .'module/fields/' . $oFieldItem->type . '.php');
        }
    ?>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>