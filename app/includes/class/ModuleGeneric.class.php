<?php
   
    
class ModuleGeneric extends Action {
    public $oProperties;
    public $aFields = array();
    
    function __construct($mModule) {
        parent::__construct($mModule);
        $this->__set('oProperties', $this->_getProperties($mModule));
        $this->__set('aFields', $this->_getFields());

    }

    function __destruct() {
        unset($this);
    }

    public function addItem($aFormData){
        $aFields = $this->__get('aFields');
        $sValues = '';
        $sColumns = '';
        $aAssociations = array();
        foreach($aFields as $oField){
            if ($oField->type == 'header'){continue;}
            if ($oField->type == 'association'){
                //store the results in the association table
                $aAssociations[$oField->name] = $aFormData[$oField->name];
                continue;
            }
            $sColumns .= '`' . $oField->name .'`, ';
            $sValues .= $this->_formatFormValue($oField, $aFormData) . ', ';
        }
        $sColumns .= '`create_date`, `modify_date`';
        $sValues .= 'CURRENT_TIMESTAMP, CURRENT_TIMESTAMP';
        parent::__set('sColumns', $sColumns);
        parent::__set('sValues', $sValues);
        $iId = $this->add();
        if (!$iId){
            //we failed to add the item so die out
            return false;
        }
        //no Associations so return the results
        if (!count($aAssociations)){
            return $iId;
        }
        
        $oAssociations = new Association();
        //return the results of adding the associations
        return $oAssociations->addAssociations($this->oProperties->id, $iId, $aAssociations);
        
    }
    
    public function updateItem($aFormData){
        $aFields = $this->__get('aFields');
        $iId = $aFormData['id'];
        $sValues = '';
        $aAssociations = array();
        foreach($aFields as $oField){
            if ($oField->type == 'header'){continue;}
            if ($oField->type == 'association'){
                //store the results in the association table
                $aAssociations[$oField->name] = $aFormData[$oField->name];
                continue;
            }
            $sValues .= '`' . $oField->name .'` = ' . $this->_formatFormValue($oField, $aFormData) .', ';
        }
        $sValues .= ' `modify_date` = CURRENT_TIMESTAMP';
        parent::__set('sValues', $sValues);
        $bResult =  $this->update($iId);
        //no Associations so return the results
        if (!$bResult){
            //we failed to add the item so die out
            return false;
        }
        if (!count($aAssociations)){
            return $bResult;
        }
        
        $oAssociations = new Association();
        
        //return the results of adding the associations
        return $oAssociations->updateAssociations($this->oProperties->id, $iId, $aAssociations);
    }
    
    private function _formatFormValue($oField, $aData){
        
        $sType = $oField->type;
        $sFieldName = $oField->name;
        if (!isset($aData[$sFieldName]) && $sType != 'active'){
            return 'NULL';
        }
        switch ($sType){
            case "active":
                $sData = isset($aData[$sFieldName])?$aData[$sFieldName]:0;
                break;
            case "date":
                $sData = "'" .date('Y-m-d', strtotime($aData[$sFieldName])) . "'";
                break;
            case "time":
                $sData = "'" .date('H:i:s', strtotime($aData[$sFieldName])) . "'";
                break;
            case "datetime":
                $sData = "'" . date('Y-m-d H:i:s', strtotime($aData[$sFieldName])). "'";
                break;
            case "number":
            case "sortorder":
              $sData = ($aData[$sFieldName] != '')?(int)$aData[$sFieldName]:'NULL';
                break;
            case "wysiwyg":
                $sData = "'" . serialize($aData[$sFieldName]) ."'";
                break;
            default:
              $sData = (is_array($aData[$sFieldName]))?"'" .serialize($aData[$sFieldName]) . "'":"'" .$aData[$sFieldName] . "'";
                break;
        }
        return $sData;
    }
    
    
    public function getAll($sQueryModification = null){
        $sQueryModification  = ($sQueryModification)?$sQueryModification:' ORDER BY `id` ASC';
        return parent::getAll($sQueryModification);
    }
    
     public function getAllActive($sQueryModification = null){
        $sQueryModification  = ($sQueryModification)?$sQueryModification:' ORDER BY `id` ASC';
        return parent::getAllActive($sQueryModification);
    }
    
    private function _getProperties($sModuleName){
        $oDb = $this->__get('oDb');
        $sSql = "select * from `module` WHERE `name` = '$sModuleName'";
        $aData = $oDb->getRowsAsObjects($sSql); 
        $oReturn = array_shift($aData);
        return $oReturn;
    }
    
    private function _getFields(){
        $oDb = $this->__get('oDb');
        $sSql = 'SELECT `f`.`type`, `mf`.* FROM `module_field` `mf`';
        $sSql .=' JOIN `field` `f` ON `mf`.`field_id` = `f`.`id`';
        $sSql .= 'WHERE `mf`.`module_id` = ' . $this->__get('oProperties')->id . ' ORDER BY `mf`.`sort_order` ASC';
        return $oDb->getRowsAsObjects($sSql); 
    }
    
}

?>