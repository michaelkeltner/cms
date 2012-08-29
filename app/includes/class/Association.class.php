<?php

class Association extends Action {

    function __construct() {
        parent::__construct('association');
    }

    function __destruct() {
        unset($this);
    }
    public function updateAssociations($iModuleId, $iItemId, $aData){

        if ($this->deleteAssocitaions($iModuleId, $iItemId, $aData))
        return $this->addAssociations($iModuleId, $iItemId, $aData);
    }
    
    
    public function deleteAssocitaions($iModuleId, $iItemId, $aData){
            /*
	module_field_requester_id - the module's assocaition field
	module_item_requester_id - the id of the module item
         
         */
        //get all fields for this module
        $oModuleBuilder = new ModuleBuilder();
        $aFields = $oModuleBuilder->getModuleFields($iModuleId);
        $oDb = $this->__get('oDb');
        //loop through all assocaitions
        foreach($aData as $sField => $aValue){
            //loop through all the module fields to get the field data
            foreach($aFields as $oField){
                //if we are at the same field as on the form
                if ($sField == $oField->name){
                    //store the id
                    $iFieldId = $oField->id;
                    $sSql = "DELETE FROM `" . $this->__get('sTable') . "` WHERE `module_field_requester_id` = $iFieldId AND `module_item_requester_id` = $iItemId";
                    $oDb->executeQuery($sSql);
                    continue;
                }
            }
            
        }
        return true;
        
    }

    public function addAssociations($iModuleId, $iItemId, $aData){
        /*
    module_field_owner_id - the field of the module we used to associate with
	module_item_owner_id - The id of the item we are associating with
	module_field_requester_id - the module's assocaition field
	module_item_requester_id - the id of the module created
         
         */
        //get all fields for this module
        $oModuleBuilder = new ModuleBuilder();
        $aFields = $oModuleBuilder->getModuleFields($iModuleId);
        //loop through all assocaitions
        foreach($aData as $sField => $aValue){
            //loop through all the module fields to get the field data
            foreach($aFields as $oField){
                //if we are at the same field as on the form
                if ($sField == $oField->name){
                    //store the id
                    $iFieldId = $oField->id;
                    //and the field properties
                    $aOptions = unserialize($oField->options);
                    //$aAssociationField = $oModuleBuilder->getModuleField($aProperties['module_id'], $aProperties['field_id']);
                    //store the columns we are adding to
                    $sColumns = '`module_field_owner_id`, `module_item_owner_id`, `module_field_requester_id`, `module_item_requester_id`, `modify_date`, `create_date`';
                     parent::__set('sColumns', $sColumns);
                     //and loop through each value in the array to save
      
                    foreach ($aValue as $iValue){
                        $sValues = $aOptions['field_id'] . ',' . $iValue . ',' . $iFieldId .',' . $iItemId .',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP';
                        parent::__set('sValues', $sValues);
                        $aResults[] = $this->add();
                    }
                    continue;
                }
            }
            
        }
        return true;
        
    }
    
    
    public function getFieldOptions($iModuleId, $sFieldName){
        $oDb = $this->__get('oDb');
        $sSql = "SELECT `options` from `module_field`" . 
                " WHERE `module_id` = $iModuleId AND `name` = '$sFieldName'";
        $aData = $oDb->getRowsAsObjects($sSql);
        $aOptions = unserialize($aData[0]->options);
        $sSql = 'SELECT `mf`.`name` as `column_name`, `m`.`name` as `module_name` from `module_field` `mf`' .
                ' JOIN `module` `m` ON `mf`.`module_id` = `m`.`id`' .
                ' WHERE `mf`.`id` = ' . $aOptions['field_id'] . 
                ' AND `m`.`id` = ' . $aOptions['module_id'];
        $aData = $oDb->getRowsAsObjects($sSql);
        
        $sColumn = $aData[0]->column_name;
        $sModule = $aData[0]->module_name;
        $sSql = "SELECT `$sColumn` as `field_name`, `id` from `$sModule`" . 
                " ORDER BY `$sColumn` ASC";
        $aData = $oDb->getRowsAsObjects($sSql);
        return $aData;
        
        
    }
    /**
     *
     * @param type $iModuleId
     * @param type $sFieldName
     * @param type $iModuleItemId
     * @return null 
     */
   
    public function getAssocationValues($iModuleId, $sFieldName, $iModuleItemId){
        
        $oDb = $this->__get('oDb');
        $sSql = "SELECT * from `module_field`" . 
                " WHERE `module_id` = $iModuleId AND `name` = '$sFieldName'";
        $aData = $oDb->getRowsAsObjects($sSql);
        $iFieldId = $aData[0]->id;
        $aOptions = unserialize($aData[0]->options);
        $sSql = 'SELECT `mf`.`id` as `field_id`, `m`.`name` as `module_name` from `module_field` `mf`' .
                ' JOIN `module` `m` ON `mf`.`module_id` = `m`.`id`' .
                ' WHERE `mf`.`id` = ' . $aOptions['field_id'] . 
                ' AND `m`.`id` = ' . $aOptions['module_id'];
        $aData = $oDb->getRowsAsObjects($sSql);
        $sModule = $aData[0]->module_name;
      
        
        $sWhere = " WHERE `module_item_requester_id` = $iModuleItemId AND `module_field_requester_id` = $iFieldId";
        $aAssociationData = $this->getAll($sWhere);
        $oModuleGeneric = new ModuleGeneric($sModule);
        $aIds = array();
        foreach($aAssociationData as $oData){
            $aIds[] = $oData->module_item_owner_id;
        }
        
        if (!count($aIds)){
            return null;
        }
        
        
        $sWhere = ' WHERE `id` in (' . implode(',',$aIds) . ')';
        return $oModuleGeneric->getAll($sWhere);
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