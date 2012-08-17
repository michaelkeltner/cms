<?php

class Period extends Action{
    
    function __construct() {
        parent::__construct('period');
    }

    function __destruct() {
        unset($this);
    }

    /**
     * Method is used to add a period to the system
     * 
     * @param string $sName - the name of the school
     * @return int - the id of the newly created record
     */
    
    public function addItem($aProperty, $aValues){
       return parent::prepareToAdd($aProperty, $aValues);
    }
    
    public function updateItem($aProperty, $aValues){
        return parent::prepareToUpdate($aProperty, $aValues);
    }
   
}

?>