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


$sMessage = '';
$sMessageClass = '';
$aInputError = array();
if (formSubmit()) {
    //check to make sure all required fields have an entry
    foreach($aFields as $oPropery){
        $aOptions = isset($oPropery->options)?unserialize($oPropery->options):array();
        $bRequiredSelected = (isset($aOptions['required']) && $aOptions['required'])?true:false;
        if (!$bRequiredSelected || $oPropery->type == 'active'){continue;}
        if (is_array($_POST[$oPropery->name])){
            if (count($_POST[$oPropery->name]) == 0 || $_POST[$oPropery->name][0] == ''){
                $aInputError[$oPropery->name] = 1;
            }
        }else{
            if ($_POST[$oPropery->name] == ''){
                $aInputError[$oPropery->name] = 1;
            }
        }
       
    }
    if (count($aInputError)){
        $sMessage = 'Please enter data for all required fields.';
        $sMessageClass = ' error';
    }else{
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
}
require_once (CMS_INCLUDES . 'header.php');
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_<?echo $sModule?>" method="post" action="<?php echo currentUrl()?>">
         <input id="item_id" type="hidden" name="id"  value="<?php if (isset($oItem->id)){echo $oItem->id;} ?>" />
         <input id="module_name" type="hidden" name="module_name"  value="<?php echo getParam(2) ?>" />
        <?php 
            foreach($aFields as $oPropery){
                $sDisplay = isset($oPropery->display_name)?$oPropery->display_name:'';
                $sFieldName = $oPropery->name;
                if (postVar($sFieldName)){
                    $sValue = postVar($sFieldName);
                }else{
                    $sValue = isset($oItem->{$sFieldName})?$oItem->{$sFieldName}:'';
                }
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