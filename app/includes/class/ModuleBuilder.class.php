<?php

class ModuleBuilder extends Action {

    function __construct() {
        parent::__construct('module');
    }

    function __destruct() {
        unset($this);
    }
    
    public function delete($iId, $sIdColumn = 'id'){
        $oModule = $this->getWithId($iId);
        //remove the entry from the module table
        if (!parent::delete($iId, $sIdColumn)){
            $this->__set('bError', true);
            $this->addArrayItem('aMessage', 'Could not remove the module from the module list');
            return false;
        }
        //drop the table from the DB
        if (!$this->_dropTable($oModule->name)){
            $this->__set('bError', true);
            $this->addArrayItem('aMessage', 'Could not remove module table');
            return false;
        }
        //no errors
        return true;
    }

    private function _deleteAllFields($iId){
        $oDb = $this->__get('oDb');
        $sSql = 'DELETE FROM `module_field` WHERE `module_id` = ' . $iId;
        return $oDb->ExecuteQuery($iId);
    }
    
    private function _getDeleteFields($aModuleFields, $aFormFieldIds){
        $aReturn['delete'] = array();
        $aReturn['unknown'] = array();
        foreach ($aModuleFields as $oExistingField) {
            if (!in_array($oExistingField->id, $aFormFieldIds)) {
                //they removed the field from the module
                $aReturn['delete'][] = $oExistingField;
            } else {
                //this may be a new field or an existing field
                $aReturn['unknown'][$oExistingField->id] = $oExistingField;
            }
        }
        return $aReturn;
    }
    
    private function _getNewEditFields($aFormFieldIds, $aSearchMe, $aFieldProperties, $iModuleId){
        $aReturn = array();
        $i = 0;
        $aReturn['new'] = array();
        $aReturn['edit'] = array();
        //find the new fields
        foreach($aFormFieldIds as $iFormFieldId){
                //store the data into an object
                unset($aStoreMe);
                $aStoreMe = array();
                $oField = new stdClass();
                $oField->type = $aFieldProperties['type'][$i];
                $oField->id = isset($aFieldProperties['id'][$i])?$aFieldProperties['id'][$i]:0;
                $oField->module_id = $iModuleId;
                $oField->field_id = $aFieldProperties['field_id'][$i];
                $oField->sort_order = $i;
                $oField->name = $aFieldProperties['name'][$i];
                $oField->orig_name = $aFieldProperties['orig_name'][$i];
                $oField->display_name = $aFieldProperties['display_name'][$i];
                $oField->description = $aFieldProperties['description'][$i];
                //get all the options available for this array
                foreach ($aFieldProperties['options'] as $sKey => $sValue){
                    $aStoreMe[$sKey] = isset($aFieldProperties['options'][$sKey][$i])?$aFieldProperties['options'][$sKey][$i]:'';
                }
                $oField->options = serialize($aStoreMe);
                $oField->active = 1;
            if (!isset($aSearchMe[$iFormFieldId])) {
                //new field
                $aReturn['new'][] = $oField;
            } else {
                $aReturn['edit'][] = $oField;
            }
            $i++;
             unset($oField);
        }
        return $aReturn;
    }
    
    private function _actOnFields($aField, $sModuleName, $sAction){
        $oDb = $this->__get('oDb');
        $this->__set('sTable', 'module_field');
        $sMethod = '_' . $sAction . 'Field';
        $aIgnoreFields = array(5,2);
        foreach($aField as $oField){
            $oField->name = $this->_cleanDBStringName($oField->name);
            if(!$this->{$sMethod}($oField)){
                $this->__set('bError', true);
                $this->__set('aMessage', 'Could not ' .$sAction . ' the field ' . $oField->name);
                return false;
            }
            //Headers do not exist in the table
            if (in_array($oField->field_id, $aIgnoreFields)){continue;}
            $sSql = $this->_getColumnAlterStatement($oField, $sModuleName, $sAction);
            if(!$oDb->executeQuery($sSql)){
                $this->__set('bError', true);
                $this->__set('aMessage', 'Could not ' .$sAction . ' the database column ' . $oField->name . ' for table ' . $sModuleName);
                return false;
            }
        } 
        return true;
    }
    
    private function _deleteField($oField){
        return $this->delete($oField->id);
    }
    
    private function _addField($oField){ 
        $sColumns = '`module_id` , `field_id` , `sort_order` , `name` , `display_name` , `description` , `options` , `active`, `create_date`';
        $sValues = getParam(4) . ', ' . $oField->field_id . ', ' . $oField->sort_order . ', \'' . $oField->name . '\', \'' . $oField->display_name . '\', \''. $oField->description . '\', \''. $oField->options . '\', 1, CURRENT_TIMESTAMP';
        $this->__set('sColumns', $sColumns);
        $this->__set('sValues', $sValues);
        return $this->add();
    }
    
    private function _editField($oField){

        $sValues = '`sort_order` = ' . $oField->sort_order . ', `name` =  \'' . $oField->name . '\', `display_name` =\'' . $oField->display_name . '\' , `description`=\''. $oField->description . '\', `options`=\''. $oField->options . '\'';
        $this->__set('sValues', $sValues);
        return $this->update($oField->id);
        
    }

    private function _getColumnAlterStatement($oField, $sModuleName, $sAction){
        $sSql = 'ALTER TABLE `' . $sModuleName . '` ';
        if ($sAction == 'add'){
            $sSql .= ' ADD `' . $oField->name . '` ' . $this->_getDBColumnProperties($oField->type) . ' NULL AFTER  `id`';
        }elseif ($sAction == 'delete'){
            $sSql .= ' DROP `' . $oField->name . '`';
        }elseif ($sAction == 'edit'){
            $sSql .= ' CHANGE `' . $oField->orig_name . '` `' . $oField->name . '` ' . $this->_getDBColumnProperties($oField->type) . ' NULL';
            //does the query end in a ','
            if (substr($sSql, -1) == ','){
                //strip it off if it does
                $sSql = substr($sSql, 0, -1);
            }
        }
        return $sSql;
        
    }
    private function _updateModuleDetails($aData){
        $oDb = $this->__get('oDb');
        $sModuleName = $this->_cleanDBStringName($aData['module_details']['name']);
        $sOrigName = $this->_cleanDBStringName($aData['module_details']['orig_name']);
        $sDescription = $aData['module_details']['description'];
        $sDisplayName = $aData['module_details']['display_name'];
        $iActive = $aData['module_details']['active'];
        //do we need to change the module name
        if ($sModuleName != $sOrigName){
            //is the requested name available
            if (!$this->isModuleAvailable($sModuleName)){
                //it is not if we are here so we error out
                $this->__set('bError', true);
                $this->__set('aMessage', 'module name '. $sModuleName . ' is already in use');
                return false;
            }else{
                //the name is not in use so we rename the table
                if (!$oDb->renameTable($sOrigName, $sModuleName)){
                    //if we are here then we could not rename the table
                    $this->__set('bError', true);
                    $this->__set('aMessage', 'could not rename the module');
                    return false;
                }
            }
        }
        //update the record in the module table with the module details
        $sSql = "UPDATE `module` SET `name` = '$sModuleName', 
                                     `display_name` = '$sDisplayName',
                                     `description` = '$sDescription', 
                                     `active` = $iActive
                WHERE `name`= '$sOrigName'";
        //can we execute this query
        if (!$oDb->executeQuery($sSql)){
            //no, so we error out
            $this->__set('bError', true);
            $this->__set('aMessage', 'could not update the module data');
            return false;
        }
        //all went well so we return true
        return true;
        
    }
    
    public function editModule($aData){
        $this->__set('bError', false);
        if (!$this->_updateModuleDetails($aData)){
            $this->__set('bError', true);
            return false;
        }
        $sModuleName = $aData['module_details']['name'];
        $iModuleId = getParam(4);
        $aModuleFields = $this->getModuleFields($iModuleId);
        $aFieldProperties = $aData['module_field'];
        $aFormFieldIds = $aFieldProperties['id'];
        //detrrmine the fields to remove from the module
        $aData = $this->_getDeleteFields($aModuleFields, $aFormFieldIds);
        $aDeleteField = $aData['delete'];
        $aSearchMe = $aData['unknown'];
        $aData = $this->_getNewEditFields($aFormFieldIds, $aSearchMe, $aFieldProperties, $iModuleId);
        $aNewField = $aData['new'];
        $aEditField = $aData['edit'];
        //Update the module fields and the table
        if (count($aDeleteField)){
            if (!$this->_actOnFields($aDeleteField, $sModuleName, 'delete')){
                $this->__set('bError', true);
                $this->__set('aMessage', 'could not remove fields');
                return false;
            } 
        }
        if (count($aNewField)){
            if (!$this->_actOnFields($aNewField, $sModuleName, 'add')){
                $this->__set('bError', true);
                $this->__set('aMessage', 'could not add fields');
                return false;
            } 
        }
        if (count($aEditField)){
            if (!$this->_actOnFields($aEditField, $sModuleName, 'edit')){
                $this->__set('bError', true);
                $this->__set('aMessage', 'could not edit fields');
                return false;
            }
        }
        $this->__set('sTable', 'module');
      
        return !$this->__get('bError');
        
    }
    
    public function addModule($aData) {
        $aModuleDetails = $aData['module_details'];
        $sModuleName = $this->_cleanDBStringName($aModuleDetails['name']);
        if (!$this->isModuleAvailable($sModuleName)) {
            $this->__set('bError',true);
            $this->addArrayItem('aMessage', $aModuleDetails['name'] . ' is already an existing module');
            return false;
        }
        //create the database table
        if (!$this->createTable($sModuleName, $aData['module_field'])) {
            $this->__set('bError',true);
            $this->addArrayItem('aMessage', 'was not able to create the database table for ' . $sModuleName);
            return false;
        } else {//table created so we add the module entry
            $iModuleId = $this->addItem($sModuleName, $aModuleDetails['display_name'], $aModuleDetails['description'], 'generic', $aModuleDetails['active']);
            if ($iModuleId > 0) {//add the entries into the module field table
                $aFieldProperties = $aData['module_field'];
                $aFieldNames = $aFieldProperties['name'];
                $aFieldDisplayNames = $aFieldProperties['display_name'];
                $aFieldDescription = $aFieldProperties['description'];
                $aFieldId = $aFieldProperties['field_id'];
                $aFieldOptions = $aFieldProperties['options'];
                $aOptions = array('list', 'multiple', 'module_id', 'field_id');
                $aColumns = array('active' => 1);
                foreach ($aFieldNames as $iIndex => $sValue) {
                    unset($aStoreMe);
                    $aStoreMe = array();
                    $aColumns['module_id'] = $iModuleId;
                    $aColumns['field_id'] = $aFieldId[$iIndex];
                    $aColumns['sort_order'] = $iIndex;
                    $aColumns['name'] = $this->_cleanDBStringName($sValue);
                    $aColumns['display_name'] = $aFieldDisplayNames[$iIndex];
                    $aColumns['description'] = $aFieldDescription[$iIndex];
                    foreach ($aOptions as $sKey){
                        $aStoreMe[$sKey] = isset($aFieldOptions[$sKey][$iIndex])?$aFieldOptions[$sKey][$iIndex]:'';
                    }
                    $aColumns['options'] = serialize($aStoreMe);
                    $this->addModuleField($aColumns);
                }
                $this->bResult = true;
                $this->aMessage[] = 'Module ' . $sModuleName . ' was created';
                return true;
            } else {//we could not add the new module to the module table
                $this->__set('bError',true);
                $this->addArrayItem('aMessage', 'was not able to create the database table for ' . $sModuleName);
                return false;
            }
        }
        

    }
    public function addItem($sName, $sDisplayName, $sDescription, $sType, $iActive){
        parent::__set('sColumns', '`name`, `display_name`, `description`, `type`, `active`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sDisplayName . '\', \'' . $sDescription . '\', \'' . $sType . '\',\'' . $iActive . '\',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function updateItem($sName, $sDisplayName, $iId){
        $sValues = ' `name` = "' . $sName. '", `display_name` = "' . $sDisplayName. '", `modify_date` = CURRENT_TIMESTAMP';
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
    
    public function getModuleFields($iModuleId){
        $oDb = $this->__get('oDb');
        $sSql = 'SELECT `f`.`type`, `mf`.* FROM `module_field` `mf` ';
        $sSql .= ' JOIN `field` `f` ON `f`.`id` = `mf`.`field_id`';
        $sSql .= ' WHERE `mf`.`module_id` = ' . $iModuleId;
        $sSql .= ' ORDER BY `mf`.`sort_order` ASC';
        return $oDb->getRowsAsObjects($sSql);

    }
    
    public function getModuleField($iModuleId, $iFieldId){
        $oDb = $this->__get('oDb');
        
        $sSql = 'SELECT `mf`.* from `module_field` `mf`' .
                ' JOIN `module` `m` ON `mf`.`module_id` = `m`.`id`' .
                ' WHERE `mf`.`id` = ' . $iFieldId . 
                ' AND `m`.`id` = ' . $iModuleId;
        return $oDb->getRowsAsObjects($sSql);
    }
    
    public function isModuleAvailable($sName){
        $oDb = $this->__get('oDb');
        $sSql = 'SELECT 1 FROM `module` WHERE `name` = "' . $this->_cleanDBStringName($sName) .'"';
        $aData = $oDb->getRowsAsObjects($sSql);
        return (count($aData) > 0 )?false:true;
        
    }
    
    public function addModuleField($aColumns) {
        $this->__set('sTable', 'module_field');

        $aIgnore = array('id', 'modify_date', 'create_date');
        $sValues = '';
        $sColumns = '';
        foreach ($aColumns as $sColumn => $mValue) {
            if (!in_array($sColumn, $aIgnore)) {
                $sColumns .= '`' . $sColumn . '`, ';
                $sValues .= '\'' . $mValue . '\', ';
            }
        }
        $sColumns .= '`create_date`, `modify_date`';
        $sValues .= ' CURRENT_TIMESTAMP, CURRENT_TIMESTAMP';
        $this->__set('sColumns', $sColumns);
        $this->__set('sValues', $sValues);
        
        $bResult = $this->add();
        $this->__set('sTable', 'module');
        return $bResult;
    }
    
    private function _dropTable($sTableName){
        $oDb = $this->__get('oDb');
        $sSql = 'DROP TABLE `' . $sTableName . '`';
        return $oDb->ExecuteQuery($sSql);
    }
    
    public function createTable($sTableName, $aProperties){
        $aColumns = $aProperties['name'];
        $aType = $aProperties['type'];
        $oDb = $this->__get('oDb');
        $sTableName = $this->_cleanDBStringName($sTableName);
        $sSql = "CREATE TABLE `$sTableName` (
            `id` int(11) NOT NULL AUTO_INCREMENT,";
        if (count($aColumns)){
            foreach($aColumns as $iIndex => $sName){
                $sColumnAttribute = $this->_getDBColumnProperties($aType[$iIndex]);
                if ($sColumnAttribute == null){
                    continue;
                }
                $sName = $this->_cleanDBStringName($sName);
                $sSql .= "`$sName` $sColumnAttribute NULL,";
            }
        }
        $sSql .= "`modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `create_date` datetime NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
  
        return $oDb->ExecuteQuery($sSql);
    }
    
    private function _getDBColumnProperties($sFieldType){

        switch($sFieldType){
            case 'active':
                return 'tinyint(1)';
                break;
            case 'text':
            case 'file':
            case 'image':
            case 'select':
                return 'varchar(255)';
                break;
            case 'date':
                return 'DATE';
                break;
            case 'time':
                return 'TIME';
                break;
            case 'datetime':
                return 'DATETIME';
                break;
            case 'sortorder':
            case 'associative':
                return 'int(11)';
                break;
            case 'wysiwyg':
                return 'text';
                break;
            default:
                return null;
                break;    
        }

        
    }
    
    private function _cleanDBStringName($sName){
        return strip_tags(str_replace(' ', '_', strtolower($sName)));
    }
    
}

?>