<?php

class Carrier extends Action {
    
    function __construct() {
        parent::__construct('carrier');
    }

    function __destruct() {
        unset($this);
    }

    public function addItem($aProperty, $aValues){
       return parent::prepareToAdd($aProperty, $aValues);
    }
    
    public function updateItem($aProperty, $aValues){
        return parent::prepareToUpdate($aProperty, $aValues);
    }
    
    

}

?>