<?php
require_once('../../app/includes/config.php');
require_once(APP_INCLUDES . 'init.php');
require_once(APP_INCLUDES . 'functions.php');

//are we at the cms main page
if (getParam(2) == 'login'){
    $sFile = CMS_ROOT . 'login.php';
}elseif(getParam(2) == 'logout'){
    $sFile = CMS_ROOT . 'logout.php';
}elseif(getParam(2) == 'reset'){
    $sFile = CMS_ROOT . 'reset.php';
}else{
    $oUser = new User();
    $oUser->checkLogin();
    if (isAjax()){
        $sFile = SITE_ROOT . $_SERVER["REQUEST_URI"];
    }else{
        $sFile = MODULES_ROOT . getParam(2) .'/' . getParam(3) . '.php';
    }
}

if (file_exists($sFile)){
    //load the file
    include_once($sFile);
}elseif (file_exists(MODULES_ROOT . 'generic/' . getParam(3) . '.php')){
    //load the generic file
    include_once(MODULES_ROOT . 'generic/' . getParam(3) . '.php');
}else{
    //nothing found, load the dashboard
    include_once(MODULES_ROOT . 'home/index.php');
}
 exit;
?>





