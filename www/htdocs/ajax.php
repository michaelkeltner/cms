<?php

require_once('../../app/includes/config.php');
require_once(APP_INCLUDES . 'init.php');
require_once(APP_INCLUDES . 'functions.php');

$mResult = '';

switch (postVar('action')) {
 
    case 'search_school':
        echo liveSchoolSearch(postVar('value'));
        exit;
        break;
    case 'search_faq':
        echo liveFAQSearch(postVar('value'));
        exit;
        break;
    default:
        echo 0;
        exit;
        break;
}


function liveSchoolSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT * from `school` WHERE `name` like "%'.  $mValue .'%" ORDER BY `name` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function liveFAQSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT * from `faq` WHERE `question` like "%'.  $mValue .'%" OR `answer` like "%'.  $mValue .'%" ORDER BY `question` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function getAssetOptions($sType){
    $oClass = new Asset();
    return json_encode($oClass->getAll('WHERE `type` = \'' .$sType . '\''));
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