
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<?php
//get an instance of Render for the school_content module
$oRender = new Render('school_content');
//get the school slug from the URL (www.academichealthplans.com/{param1}/{param2})
$sSlug = trim(getParam(1));
$sNow = date('Y-m-d H:i:s', strtotime('NOW'));
if (!getParam(2)){
    //they did not specify a period so get all active
    $oRender->where('school|slug|=|' . $sSlug, 'active_date|<|' . $sNow, 'inactive_date|>|' . $sNow);
}else{
    //they did enter a period so add the period slug to the where clause
    $sPeriodWhere = 'period|slug|=|' . getParam(2);
    $oRender->where('school|slug|=|' . $sSlug, 'active_date|<|' . $sNow, 'inactive_date|>|' . $sNow, $sPeriodWhere);
}
//get all matches for the fileter
$aData = $oRender->getData();
if (!count($aData)){
    //there was no data returned for the where clause
    include ('site/404.php');
    exit;    
}
if (count($aData)> 1){
    //there are more than one entries found so we load the multi page
    include ('site/multi-period.php');
    exit;
}
$oData = $aData[0];
if (!getParam(2)){
    //if there is no period in the url then we redirect to this page but add
    //the period slug to the url
    gotoURL(currentURL() . $oData->get('period|slug'));
}
 //If we are here then there is one entry found so we load the single page
include ('site/single-period.php');
exit;
?>