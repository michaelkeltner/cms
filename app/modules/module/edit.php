<?php 
$sActiveLink = 'module';
$oModuleBuilder = new ModuleBuilder();
$sRenderPage = strtolower(getParam(3));
$oModule = new Module();
$aModule = $oModule->getAll(' WHERE `type` = "generic"');
$oField = new Field();
$aField = $oField->getAll();
$aModuleFields = array();
$bError = false;
$sError = '';
if (formSubmit()){
    if ($sRenderPage == 'edit' || $sRenderPage == 'add'){
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
<?php if ($sRenderPage == 'edit'   || $sRenderPage == 'add'):?>
<form action="<?php echo currentURL() ?>" method="post" class="module_builder noEnterSubmit">
    <?php endif;?>
    <?php if ($oModuleBuilder->__get('bError')):?>
<div id="topsection">
    <div class="innertube">
        
        <div id="error" class="error">
        <?php 
            foreach ($oModuleBuilder->__get('aMessage') as $sMessage){
                echo $sMessage . '<br/>';
            }
        ?>
        </div>

       
    </div>
</div>
    <?php endif;?>
<div id="listing_div">
<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <div id="used_field_list" class="sortable">
                <?php if (count($aModuleFields)):?>
                <?php $sFieldClass = ''?>
                    <?php foreach ($aModuleFields as $oFieldItem):?>
                    <?php include(MODULES_ROOT .'module/fields/' . $oFieldItem->type . '.php');?>
                    <?php endforeach?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
    </div>

<div id="leftcolumn">
    <div class="innertube">
        <div id="field_option_list">
            <?php foreach($aField as $oItem): ?>
            <div class="field_option">
                <?php echo $oItem->name?><a href="#" id="link_clone_field_<?php echo $oItem->type ?>" class="add_field" alt="add <?php echo $oItem->name ?>"><image src="/cms/images/add-item.png" alt="Add <?php echo $oItem->name ?>" width="32" heigth="32"/></a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
</div>

<div id="rightcolumn">
    <div class="innertube">
        <div class="module_details">
            Name: <input name="module_details[name]" type="text" value="<?php echo $sName ?>"/><br/>
            Display Name: <input name="module_details[display_name]" type="text" value="<?php echo $sDisplayName ?>"/><br/>
            Description: <textarea name="module_details[description]"><?php echo $sDescription ?></textarea><br/>
            Is Active: <select name="module_details[active]">
                <option value="1"<?php  if ($iActive):?>selected="selected"<?php endif;?>>Yes</option>
                <option value="0"<?php  if (!$iActive):?>selected="selected"<?php endif;?>>No</option>
            </select><br/>
            <input type="hidden" name="module_details[orig_name]" value="<?php echo $sName ?>"/>
        </div>
        <div class="form_actions">
            <?php if ($sRenderPage == 'edit' || $sRenderPage == 'add'):?>
            <p class="submit">
                <input type="submit" value="<?php echo $sFormSubmitText?>"/>
            </p>
            <?php endif;?>
        </div>

    </div>
</div>
<?php if ($sRenderPage == 'edit'  || $sRenderPage == 'add'):?>
</form>
<?php endif; ?>

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