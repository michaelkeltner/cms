<?php
function __autoload($class_name) {
    require_once (APP_INCLUDES . 'class/' . $class_name . '.class.php');
}
?>
