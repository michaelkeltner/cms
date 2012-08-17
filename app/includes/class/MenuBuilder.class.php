<?php

class MenuBuilder extends Action {

    function __construct() {
        parent::__construct('menu');
    }

    function __destruct() {
        unset($this);
    }

    private function _addField($oField){
        $sColumns = '`module_id` , `field_id` , `sort_order` , `name` , `display_name` , `description` , `properties` , `active`, `create_date`';
        $sValues = getParam(4) . ', ' . $oField->field_id . ', ' . $oField->sort_order . ', \'' . $oField->name . '\', \'' . $oField->display_name . '\', \''. $oField->description . '\', \'\', 1, CURRENT_TIMESTAMP';
        $this->__set('sColumns', $sColumns);
        $this->__set('sValues', $sValues);
        return $this->add();
    }
    
    private function _editField($oField){

        $sValues = '`sort_order` = ' . $oField->sort_order . ', `name` =  \'' . $oField->name . '\', `display_name` =\'' . $oField->display_name . '\' , `description`=\''. $oField->description . '\'';
        $this->__set('sValues', $sValues);
        return $this->update($oField->id);
        
    }

    public function addItem($sName, $sDisplayName, $sDescription, $sType, $iActive){
        parent::__set('sColumns', '`name`, `display_name`, `description`, `type`, `active`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sDisplayName . '\', \'' . $sDescription . '\', \'' . $sType . '\',\'' . $iActive . '\',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
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