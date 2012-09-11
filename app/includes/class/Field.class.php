<?php

class Field extends Action {

    function __construct() {
        parent::__construct('field');
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
        $sQueryModification  = ($sQueryModification)?$sQueryModification:' ORDER BY `sort_order` ASC';
        return parent::getAll($sQueryModification);
    }
    
     public function getAllActive($sQueryModification = null){
        $sQueryModification  = ($sQueryModification)?$sQueryModification:' ORDER BY `sort_order` ASC';
        return parent::getAllActive($sQueryModification);
    }
    
    public function listValue($oFieldItem, $oItem, $sFieldName){
        $sType = $oFieldItem->type;
        if ($sType == 'active'){
            return ($oItem->active)?'Yes':'No';
        }elseif ($sType == 'association'){
            $sReturn = '';
            $aOptions = unserialize($oFieldItem->options);
            $oModuleBuilder = new ModuleBuilder();
            $aLinkToThisField = $oModuleBuilder->getModuleField($aOptions['module_id'], $aOptions['field_id']);
            $oLinkTothisField = $aLinkToThisField[0];
            $oAssociation = new Association();
            $aData = $oAssociation->getAssocationValues($oFieldItem->module_id, $sFieldName, $oItem->id);             
            if (!$aData){
                return $sReturn;
            }
            foreach ($aData as $oValue){
                $sReturn .= $oValue->{$oLinkTothisField->name} . ', ';
            }
            return substr($sReturn, 0, -2);
        }elseif ($sType == 'file'){
            $sReturn = '';
            $oAsset = new Asset();
            $aData = unserialize($oItem->{$sFieldName});
            $aAsset = $oAsset->getAll(' WHERE `id` in (' . implode (',', $aData). ')');
            if (count($aAsset)){
                foreach ($aAsset as $oAssetItem){
                    $sReturn .= $oAssetItem->display_name . '<br/>';
                }
            }
            return $sReturn;
        }elseif (is_array($oItem->{$sFieldName})){
            $aData = unserialize($oItem->{$sFieldName});
            $sReturn = implode('<br/>', $aData);
            return $sReturn;
        }else{
            return $oItem->{$sFieldName};
        }
    }
    
}

?>