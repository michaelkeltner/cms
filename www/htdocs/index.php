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
    $bInternal3 = (substr($sIP, 0, 8) == '172.16.0')?true:false;
    $bInternal4 = (substr($sIP, 0, 9) == '127.0.0.1')?true:false;
    
    if ($bLocal || $bInternal || $bInternal2 || $bInternal3 || $bInternal4){
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
?>
