<?php

require_once('../../app/includes/config.php');
require_once(APP_INCLUDES . 'init.php');
require_once(APP_INCLUDES . 'functions.php');

$mResult = '';

switch (postVar('action')) {
    case 'search_change_log':
        echo liveChangeSearch(postVar('value'), postVar('system'), postVar('category'));
        exit;
    case 'search_school':
        echo liveSchoolSearch(postVar('value'));
        exit;
        break;
    case 'search_faq':
        echo liveFAQSearch(postVar('value'), postVar('school'), postVar('category'));
        exit;
        break;
    case 'search_staff':
        echo liveStaffSearch(postVar('value'));
        exit;
        break;
    case 'search_subject':
        echo liveSubjectSearch(postVar('value'));
        exit;
        break;
    case 'search_resolution':
        echo liveResolutionSearch(postVar('value'));
        exit;
        break;
    case 'search_description':
        echo liveDescriptionSearch(postVar('value'));
        exit;
        break;
    case 'search_department':
        echo liveDepartmentSearch(postVar('value'));
        exit;
        break;
    default:
        echo 0;
        exit;
        break;
}


function liveDepartmentSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT distinct(`department`) from `call_information` WHERE `department` like "%'.  $mValue .'%" ORDER BY `department` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function liveDescriptionSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT distinct(`description`) from `call_information` WHERE `subject` like "%'.  $mValue .'%" ORDER BY `description` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function liveResolutionSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT distinct(`resolution`) from `call_information` WHERE `subject` like "%'.  $mValue .'%" ORDER BY `resolution` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function liveSubjectSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT distinct(`subject`) from `call_information` WHERE `subject` like "%'.  $mValue .'%" ORDER BY `subject` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function liveChangeSearch($mValue, $sSystem, $aCategory) {
    $oChangeLog = new Render('change_log');
    $oChangeLog->where('title|LIKE|%' . $mValue .'%| OR', 'reason|LIKE|%' . $mValue .'%| OR', 'changes|LIKE|%' . $mValue .'%| OR');
    $oChangeLog->order('`change_date` ASC');
    $aData = $oChangeLog->getData();
    $aReturn = array();
    if (count($aData)){
        foreach ($aData as $oData){
            //now filter by categories
            if (count($aCategory)){
                $aThisCategory = unserialize($oData->get('category'));
                if(!count(array_intersect($aThisCategory, $aCategory))){
                    //Not in the category we are looking for
                    continue;
                }
            }
            //now filter by system
            
            if ($sSystem != 'none'){
                $mSystem = unserialize($oData->get('system'));
                if (is_array($mSystem)){
                    if (!in_array($sSystem, $mSystem)){
                        //not linked to the system specified
                        continue;
                    }
                }else{
                    if ($mSystem != $sSystem){
                        //not linked to the system specified
                        continue;
                    }
                }
            }
            //everything is matched up so we add this to the return array
            $oReturn = new stdClass();
            $oReturn->system = unserialize($oData->get('system'));
            $oReturn->category = unserialize($oData->get('category'));
            $oReturn->title = $oData->get('title');
            $oReturn->changes = unserialize($oData->get('changes'));
            $oReturn->reason = $oData->get('reason');
            $oReturn->change_date = $oData->get('change_date');
            $aReturn[] = $oReturn;
            unset($oReturn);
        }
    }
    return json_encode($aReturn);

}

function liveSchoolSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT * from `school` WHERE `name` like "%'.  $mValue .'%" ORDER BY `name` ASC';
    return json_encode($oDb->getRowsAsObjects($sSql));
}

function liveStaffSearch($mValue) {
    $oDb = new DB();
    $sSql = 'SELECT * from `staff` WHERE `first_name` like "%'.  $mValue .'%" OR `last_name` like "%'.  $mValue .'%" ORDER BY `first_name` ASC';
    $aStaff = $oDb->getRowsAsObjects($sSql);
    if (!count($aStaff)){ 
        return json_encode(array());
    }
     $aReturn = array();
    foreach($aStaff as $oStaff){
        $oReturn = new stdClass();
        $oReturn->first_name = $oStaff->first_name;
        $oReturn->last_name = $oStaff->last_name;
        $aDepartment = @unserialize($oStaff->department);
        $oReturn->department = '';
        $sReturnDepartment = '';
        if($aDepartment != ''){
            foreach ($aDepartment as $sDepartment){
                $sReturnDepartment .= $sDepartment . '/';
            }
            $sReturnDepartment = substr($sReturnDepartment, 0, -1);
            $oReturn->department ='<li>Department: ' . $sReturnDepartment . '</li>'; 
        }
        $oReturn->title = '';
        if ($oStaff->title){
            $oReturn->title = '<li>Title: ' . $oStaff->title . '</li>';
        }
        
        $oReturn->phone = '';
        if ($oStaff->phone){
            $oReturn->phone = '<li>Phone: ' . $oStaff->phone . '</li>';
        }
        $oReturn->email = '';
        if ($oStaff->email){
            $oReturn->email = '<li><a href="mailto:' . $oStaff->email . '">' . $oStaff->email . '</a></li>';
        }
        $aReturn[] = $oReturn;
        unset($oReturn);
    }
    
    return json_encode($aReturn);
}

function liveFAQSearch($mValue, $sSchool, $aCategory) {
    $oFAQ = new Render('faq');
    $oFAQ->where('question|LIKE|%' . $mValue .'%| OR', 'answer|LIKE|%' . $mValue .'%| OR');
    $oFAQ->order('`sort_order` ASC');
    $aData = $oFAQ->getData();
    $aReturn = array();
    if (count($aData)){
        foreach ($aData as $oData){
            //now filter by categories
            if (count($aCategory)){
                $aThisCategory = unserialize($oData->get('category'));
                if(!count(array_intersect($aThisCategory, $aCategory))){
                    //Not in the category we are looking for
                    continue;
                }
            }
            //now filter by school
            if ($sSchool != 'none'){
                $mSchool = $oData->get('school');
                if (is_array($mSchool)){
                    if (!in_array($sSchool, $oData->get('school'))){
                        //not linked to the school specified
                        continue;
                    }
                }else{
                    if ($mSchool != $sSchool){
                        //not linked to the school specified
                        continue;
                    }
                }
            }
            //everything is matched up so we add this to the return array
            $oReturn = new stdClass();
            $oReturn->question = $oData->get('question');
            $oReturn->answer = $oData->get('answer');
            $aReturn[] = $oReturn;
            unset($oReturn);
        }
    }

    return json_encode($aReturn);
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