<?php 
    $aOptions = isset($oPropery->options)?unserialize($oPropery->options):array();
    $bRequiredSelected = (isset($aOptions['required']) && $aOptions['required'])?true:false;
    if ($bRequiredSelected){
        echo " required_input";
    } 
    if (isset($aInputError[$sFieldName])){
        echo " error_input";
    }
?>