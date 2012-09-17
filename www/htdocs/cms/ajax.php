<?php

require_once('../../app/includes/config.php');
require_once(APP_INCLUDES . 'init.php');
require_once(APP_INCLUDES . 'functions.php');

$mResult = '';

switch (postVar('action')) {
    case 'load_wysiwyg_content':
        $sTable =  postVar('module_name');
        $iItemId = postVar('item_id');
        $sColumnName = postVar('field_name');
        $oDb = new DB();
        $sSql = 'SELECT `' . $sColumnName . '` FROM `' . $sTable . '` WHERE `id` = ' . $iItemId;
        $aData = $oDb->getRowsAsObjects($sSql);
        $oReturn = array_shift($aData);
        $sReturn = unserialize($oReturn->{$sColumnName});
        echo json_encode($sReturn);
        exit;
        break;
    case 'load_module_fields':
        $oModuleBuilder = new ModuleBuilder();
        echo json_encode($oModuleBuilder->getModuleFields(postVar('module_id')));
        exit;
        break;
    case 'load_database_fields':
        echo json_encode(getModuleFields(postVar('module_name')));
        exit;
        break;
    case 'delete':
        echo deleteItem(postVar('module'), postVar('id'));
        exit;
        break;
    case 'delete_module':
        $oModuleBuilder = new ModuleBuilder();
        if ($oModuleBuilder->delete(postVar('id'))){
            echo json_encode(true);
        }else{
            echo json_encode($oModuleBuilder->__get('aMessage'));
        }
        exit;
   case 'delete_asset':
        $oAsset = new Asset();
        $oAsset->deleteAndRemove(postVar('id'), postVar('school_slug'));
        exit;
        break;
    case 'delete_theme':
        $oTheme = new Theme();
        $oTheme->deleteAndRemove(postVar('id'));
        exit;
        break;
    case 'delete_user':
        $sClass = 'User';
        break;
    case 'delete_role':
        $sClass = 'Role';
        break;
    case 'edit_content':
        echo getContentData(postVar('school_id'), postVar('period_id'), postVar('section_id'));
        exit;
        break;
    case 'populate_asset_options':
        echo getAssetOptions(postVar('asset_type'), postVar('school_id'));
        exit;
        break;
    case 'list_school_sections':
        echo getSchoolSections(postVar('school_id'), postVar('period_id'));
        exit;
        break;
    case 'get_school_period_coverage':
        echo getSchoolPeriodCoverage(postVar('school_id'), postVar('period_id'));
        exit;
        break;
    case 'get_image_src':
        echo getImageUrl(postVar('asset_id'));
        exit;
    case 'check_slug':
        echo isSlugUnique(postVar('slug'), postVar('item'));
        exit;
        break;
    case 'get_unused_periods':
        echo getCopyPeriodMenu(postVar('school_slug'), postVar('period_slug'), postVar('period_name'));
        exit;
    case 'copy_school_period':
        echo copySchoolPeriod(postVar('school_slug'), postVar('copy_from_slug'), postVar('copy_to_slug'));
        exit;
    default:
        echo 0;
        exit;
        break;
}
$oClass = new $sClass();
$mResult = $oClass->delete(postVar('id'));
echo $mResult;
exit;

function getModuleFields($sModuleName){
    $oModuleGeneric = new ModuleGeneric($sModuleName);
    return $oModuleGeneric->__get('aFields');
    
}

function deleteItem($sModule, $iId){
    $oModuleGeneric = new ModuleGeneric($sModule);
    $mResult = $oModuleGeneric->delete($iId);
    return $mResult;
}



function copySchoolPeriod($sSchoolSlug, $sCopyFromPeriodSlug, $sCopyToPeriodSlug){
    $oSchoolPeriod = new SchoolPeriod();
    $oSchool = new School();
    $oPeriod = new Period();
    $oContent = new Content();
    
    $oSchoolItem = $oSchool->getWithSlug($sSchoolSlug);
    $oFromPeriodItem = $oPeriod->getWithSlug($sCopyFromPeriodSlug);
    $oToPeriodItem = $oPeriod->getWithSlug($sCopyToPeriodSlug);
    $aResults = array();
    $aResults[] = $oContent->copyContent($oSchoolItem->id, $oFromPeriodItem->id, $oToPeriodItem->id);
    $aResults[] = $oSchoolPeriod->copyContent($oSchoolItem->id, $oFromPeriodItem->id, $oToPeriodItem->id);
    return json_encode($aResults);
}

function getCopyPeriodMenu($sSchoolSlug, $sPeriodSlug, $sPeriodName){
    $oSchoolPeriods = new SchoolPeriod();
    $aItems = $oSchoolPeriods->getAllUnusedSchoolPeriods($sSchoolSlug);
    if (count($aItems)){
        $sHTML = '<span class="menu_title">Copy ' . $sPeriodName . ' to:</span>';
        $sHTML .= '<ul class="copy_content_menu top-level">';
        foreach ($aItems as $oItem){
            $sHTML .= '<li id="' . $sSchoolSlug . '~' . $sPeriodSlug . '~' . $oItem->slug . '" class="copy_content_item"><a href="#">' . $oItem->name . '</a></li>';
        }
        $sHTML .= '</ul>';
    }else{
        $sHTML = 'No unused periods available';
    }
    $oReturn = new stdClass();
    $oReturn->menuOptions = $sHTML;
    return json_encode($oReturn);
}

function getImageUrl($iId){
    $oAsset = new Asset();
    $oItem = $oAsset->getWithId($iId);
    $oObject = new stdClass();
    $oObject->src = '/assets/images/'. $oItem->name;
    //$aReturn[0] = $oObject;
    return json_encode($oObject);
    
}

function isSlugUnique($sSlug, $sTable){
    $oDb = new DB();
    $sSql = 'SELECT 1 from `' . $sTable .'` WHERE `slug` = "' . $sSlug . '"';
    if ($oDb->getNumberOfRows($sSql)){
        return json_encode(false);
    }else{
        return json_encode(true);
    }
}
function getSchoolPeriodCoverage($iSchoolId, $iPeriodId){
    $oSchoolPeriod = new SchoolPeriod();
    return json_encode($oSchoolPeriod->getAllWithId($iSchoolId, $iPeriodId));
}

function getContentData($iSchoolId, $iPeriodId, $iSectionId) {
    $oContent = new Content();
    $oAsset = new Asset();
    $oReturn = new stdClass();
    //getAllBySchoolPeriod
    $oReturn->content = cleanData($oContent->getSectionContentBySectionId($iSchoolId, $iPeriodId, $iSectionId));
    $oReturn->assetImages = $oAsset->getImagesForSchool($iSchoolId);
    $oReturn->assetDocs = $oAsset->getDocsForSchool($iSchoolId);
    
    return json_encode($oReturn);
     
}


function getSchoolSections($iSchoolId, $iPeriodId) {
    $oSection = new Section();
    return json_encode($oSection->getAll());
}

function getAssetOptions($sType, $iSchoolId){
    $oAsset = new Asset();
    if ($sType == 'image'){
       return json_encode($oAsset->getImagesForSchool($iSchoolId));
    }elseif($sType == 'doc'){
       return json_encode($oAsset->getDocsForSchool($iSchoolId)); 
    }else{
        return json_encode(array());
    }
    
}
/**
 *
 * @param type $aData - array of data that may or may not need to be 
 * unserialized.
 * @return array of objects that have been unserialized and had business logic
 * applied
 */
function cleanData($aData) {
    $aReturn = array();
    foreach ($aData as $oData) {
        $oClass = new stdClass();
        if ($oData->type == 'link') {
            $aLinkComponents = unserialize($oData->content);
            $oClass->type = 'link';
            $oClass->url = $aLinkComponents['url'];
            $oClass->display = $aLinkComponents['display'];
            $oClass->target = $aLinkComponents['target'];
            $oClass->section_id = $oData->section_id;
            $aReturn[] = $oClass;
        }else{
            $aReturn[] = $oData;
        }    
    }
    return $aReturn;
}

?>