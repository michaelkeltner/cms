<?php
if (session_id() == ''){
    session_start();
}

require_once('../../app/includes/config.php');
require_once(APP_INCLUDES . 'init.php');
require_once(APP_INCLUDES . 'functions.php');
$sParam1 = str_replace('.php', '', getParam(1));
if ($sParam1 == 'cms') {
    include_once('cms/index.php');
    exit;
}

if (file_exists('ahpsite/' . $sParam1 .'.php')){
    $sIP = getIP();
    $bLocal = ($sIP == '127.0.0.1')?true:false;
    $bInternal = (substr($sIP, 0, 7) == '192.168')?true:false;
    $bInternal2 = (substr($sIP, 0, 5) == '10.8.')?true:false;
    if ($bLocal || $bInternal || $bInternal2){
        include_once('ahpsite/' . $sParam1 .'.php');
        exit;
    }else{
        include_once('ahpsite/403.php');
        exit;
    }
}

$sFile = '';

//If we are here then it is a school page
//pass control to the school site dispatcher
include_once('site/index.php');
exit;

/**TODO Finish out rest of logic to host school sites*/
/*
Render::setSchoolSlug(getParam(1));
Render::setPeriodSlug(getParam(2));
$oRender = new Render();

$aActivePeriods = $oRender->getActivePeriodCoverage(getParam(1));
//are there any active periods for this school
if (count($aActivePeriods)) {
    //are they accessing a sub page?
    if (getParam(3)) {
        switch (getParam(3)) {
            //url may be something like:
            //  /ttu/2013-2014/hippa/  or /ttu/2012-2013/hippa
            case 'contact':
                $sFile = 'site/contact.php';
                break;
            case 'hippa':
                $sFile = 'site/hippa.php';
                break;
            case 'faq':
                $sFile = 'site/faq.php';
                break;
            default:
                $sFile = 'site/404.php';
                break;
        }
    } elseif (getParam(2)) {
        //url may be something like:
        //  /ttu/hippa/  or /ttu/2012-2013
        switch (getParam(2)) {
            case 'contact':
                $sFile = 'site/contact.php';
                break;
            case 'hippa':
                $sFile = 'site/hippa.php';
                break;
            default:
                if ($oRender->isValidURL()) {
                    //if the school and period combination are calid then load
                    $sFile = 'site/single-period.php';
                } else {
                    //redirect to school front page
                    gotoURL('/' . getParam(1));
                }
        }
        if ($oRender->isValidURL()) {
            $sFile = 'site/single-period.php';
        } else {
            //redirect to school front page
            gotoURL('/' . getParam(1));
        }
    } elseif (getParam(1)) {
        if (count($aActivePeriods) > 1) {
            $sFile = 'site/multi-period.php';
        } else {
            //redirect adding the period slug on the end
            gotoURL('/' . getParam(1) . '/' . $aActivePeriods[0]->period_slug);
        }
    }
} else {
    //there is no data with the school provided
    $sFile = 'site/nodata.php';
}
if (file_exists($sFile)) {
    require_once ($sFile);
} else {
    require_once ('site/error.php');
}
 * 
 */
 include_once('site/404.php');
exit;
?>
