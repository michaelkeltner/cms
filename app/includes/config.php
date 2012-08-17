<?php
$sDs = DIRECTORY_SEPARATOR;

$sLocalPath = realpath(dirname(__FILE__).$sDs.'..'.$sDs.'..'.$sDs);

$sLocalPath = str_replace('\\', '\\\\', $sLocalPath);
$sDs = str_replace('\\', '\\\\', $sDs);
if ($_SERVER['HTTP_HOST'] == 'cms.local'){
    define('DB_HOST', 'localhost');
}else{
    define('DB_HOST', '10.8.93.10');
}
define('DB_USER', 'cms_admin');
define('DB_PASSWORD', 'N89pXGdcWPMb6Q9C!');
define('DB_NAME', 'cms');
define('APP_INCLUDES', $sLocalPath . $sDs.'app'.$sDs.'includes'.$sDs);
define('SITE_ROOT', $sLocalPath . $sDs.'www'.$sDs.'htdocs'.$sDs.'');
define('CMS_ROOT', SITE_ROOT. 'cms' . $sDs);
define('SITE_INCLUDES', SITE_ROOT . 'site'.$sDs.'includes'.$sDs);
define('CMS_INCLUDES', CMS_ROOT . 'includes'.$sDs);
define('CMS_CSS', CMS_ROOT . 'css'.$sDs);
define('CMS_JS', CMS_ROOT . 'js'.$sDs);

define('MODULES_ROOT', CMS_ROOT . 'modules'.$sDs);
define('BASE_URL', $_SERVER['HTTP_HOST']);

define ('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define("FILE_DECACHER", "08162012");
define("APIKEY", "MB00ar82S2a027oyN08do0n5");
define("JQUERYFILE", "jquery-1.8.0.min.js");
define("JQUERYUIJSFILE", "jquery-ui-1.8.22.custom.min.js");
define("JQUERYUICSSFILE", "ui-lightness/jquery-ui-1.8.22.custom.css");
?>