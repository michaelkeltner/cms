<?php
//used to determine the menu link that should have the class "active" on it
$oAsset = new Asset();
$sActiveLink = getParam(2);
$oModuleGeneric = new ModuleGeneric(getParam(2));
$oAssociation = new Association();
$sAction = getParam(3);
$iItemId = 0;
if ($sAction == 'edit'){
    $iItemId = getParam(4);
    $oItem = $oModuleGeneric->getWithId($iItemId);
    if (!$oItem){
        gotoURL(BASE_URL . '/cms/'.$sModule.'/list/');
        exit;
    }
}
$oProperties = $oModuleGeneric->__get('oProperties');
$aFields = $oModuleGeneric->__get('aFields');
$sModule = $oProperties->name;

require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';

if (formSubmit()) {
    if (strtolower(getParam(3)) == 'edit'){
        $bResults = $oModuleGeneric->updateItem($_POST);
    }else{
        $bResults = $oModuleGeneric->addItem($_POST);
    }
    if ($bResults > 0) {
        $sMessage = $sModule . ' updated.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/'.$sModule.'/list');
    } else {
        $sMessage = 'The entry was not updated.';
        $sMessageClass = ' error';
    }
}

?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_<?echo $sModule?>" method="post" action="">
         <input id="item_id" type="hidden" name="id"  value="<?php if (isset($oItem->id)){echo $oItem->id;} ?>" />
         <input id="module_name" type="hidden" name="module_name"  value="<?php echo getParam(2) ?>" />
        <?php 
            foreach($aFields as $oPropery){
                $sDisplay = isset($oPropery->display_name)?$oPropery->display_name:'';
                $sFieldName = $oPropery->name;
                $sValue = isset($oItem->{$sFieldName})?$oItem->{$sFieldName}:'';
                $sFieldDescription = isset($oPropery->description)?$oPropery->description:'';
                include('fields/' . $oPropery->type . '.php');
                include('fields/common.php');
            }
        ?>
        <p class="submit">
            <input type="submit" value="update" />
            <input type="cancel" value="Cancel"/>
        </p>
    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>