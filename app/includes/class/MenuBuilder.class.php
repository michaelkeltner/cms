<?php

class MenuBuilder extends Action {

    function __construct() {
        parent::__construct('menu');
    }

    function __destruct() {
        unset($this);
    }

    public function get($sVar){
        return $this->__get($sVar);
    }
    public function set($sName, $mValue) {
        $this->{$sName} = $mValue;
    }
    
    public function getMenu(){
        $sSql = ' SELECT `mo`.`name` as `module`, `m`.`name` as `display_name`, `m`.`icon` FROM `menu` `m`
                    JOIN `module` `mo` ON `mo`.`id` = `m`.`module_id`
                    ORDER BY `m`.`sort_order` ASC';
        $oDb = $this->__get('oDb');
        return $oDb->getRowsAsObjects($sSql);
    }
    
    public function updateMenu($aData){
        $bReturn = true;
        $aKeepThese = array();
        prePrint($aData);
        foreach($aData['menu']['name'] as $iIndex=>$sName){
            
            $sIcon =$aData['menu']['icon'][$iIndex];
            $iId = $aData['menu']['id'][$iIndex];
            prePrint($sName,$iIndex, $sIcon,$iId );
            if ($iId){
                if (!$this->updateItem($sName, $iIndex, $sIcon, $iId)){
                    $this->addArrayItem('aMessage', 'could not update the menu item ' . $sName);
                    $bReturn = false;
                }else{
                    array_push($aKeepThese, $iId);
                }
            }else{
                $iModuleId = $aData['menu']['module_id'][$iIndex];
                $iId = $this->addItem($iModuleId, $sName, $iIndex, $sIcon);
                if (!$iId){
                    $this->addArrayItem('aMessage', 'could not add the menu item ' . $sName);
                    $bReturn = false;
                }else{
                    array_push($aKeepThese, $iId);
                }
            }
        }
        if ($bReturn){
            //remove the menue items from the DB that were delted from the form
            $sSql = 'DELETE FROM `menu` WHERE `id` NOT IN (' . implode(',', $aKeepThese) .')';
            $oDb = $this->get('oDb');
            if(!$oDb->executeQuery($sSql)){
                $this->addArrayItem('aMessage', 'could not delte the menu item ' . $sName);
                $bReturn = false;
            }
        }
        return $bReturn;
    }

    
    public function addItem($iModuleId, $sName, $iSortOrder, $sIcon){
        parent::__set('sColumns', '`module_id`, `name`, `sort_order`, `icon`, `create_date`, `modify_date`');
        parent::__set('sValues', $iModuleId . ', \'' . $sName . '\',  ' . $iSortOrder . ', \'' . $sIcon . '\',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return parent::add();
    }
    
    public function updateItem($sName, $iSortOrder, $sIcon, $iId){
        $sValues = ' `name` = "' . $sName. '", `sort_order` = ' . $iSortOrder . ', `icon` = "' . $sIcon. '", `modify_date` = CURRENT_TIMESTAMP';
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