<?php

class Permission extends Action {

    function __construct() {
        parent::__construct('permission');
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
    public function addItem($sName){
        parent::__set('sColumns', '`name`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function updateItem($sName, $iId){
        $sValues = ' `name` = "' . $sName. '", `modify_date` = CURRENT_TIMESTAMP';
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
    
    public function addModulePermissions($iRoleId, $aModulePermissionMap){
        $this->__set('sTable', 'permission_role_module');
        foreach ($aModulePermissionMap as $iModuleId=>$aPermissions){
            foreach ($aPermissions as $iPermissionId){
                parent::__set('sColumns', '`role_id`, `permission_id`, `module_id`, `create_date`, `modify_date`');
                parent::__set('sValues', $iRoleId . ', '. $iPermissionId .', '. $iModuleId .',  CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
                $this->add();
                
            }
        }
        
    }
    
    public function updateModulePermissions($iId, $aModulePermissionMap){
        $this->deleteModulePermissions($iId);
        $this->addModulePermissions($iId, $aModulePermissionMap);
    }
    
    public function deleteModulePermissions($iId){
        $this->__set('sTable', 'permission_role_module');
        $this->delete($iId, 'role_id');
        $this->__set('sTable', 'permission'); 
    }
   
}

?>