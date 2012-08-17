<?php

class Module extends Action {

    function __construct() {
        parent::__construct('module');
    }

    function __destruct() {
        unset($this);
    }

    /**
     * Method is used to add a role to the system
     * 
     * @param string $sName - the name of the role
     * @return int - the id of the newly created record
     */
    public function addItem($sName, $sDisplayName){
        parent::__set('sColumns', '`name`, `display_name`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sDisplayName . '\' CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function updateItem($sName, $sDisplayName, $iId){
        $sValues = ' `name` = "' . $sName. '", display_`name` = "' . $sDisplayName. '", `modify_date` = CURRENT_TIMESTAMP';
        parent::__set('sValues', $sValues);
        return $this->update($iId);
    }
    
    public function getAll($sQueryModification = null){
        $sQueryModification  = ($sQueryModification)?$sQueryModification:' ORDER BY `name` ASC';
        return parent::getAll($sQueryModification);
    }
    
     public function getAllActive($sQueryModification = null){
        $sQueryModification  = ($sQueryModification)?$sQueryModification:' ORDER BY `name` ASC';
        return parent::getAllActive($sQueryModification);
    }
   
}

?>