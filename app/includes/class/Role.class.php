<?php

class Role extends Action {

    function __construct() {
        parent::__construct('role');
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
        parent::__set('sColumns', '`name`,`create_date`, `modify_date`');
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
    
    
    public function getRoleForUser($iUserId){
        $sQueryModification = //'SELECT `r`.`name`, `r`.`id` FROM `role` 
        ' JOIN `user_role` `ur` ON `role`.`id` = `ur`.`role_id`
            WHERE `ur`.`user_id` = ' . $iUserId;
        $aRole = $this->getAll($sQueryModification);
        return $aRole;
        
    }
    
    public function updateUserRole($iUserId, $aRole){
        $aResult = array();
        //change the table we are to work on
        $this->__set('sTable', 'user_role');
        //delete the user roles
        $this->delete($iUserId, 'user_id');
        //itterate through each role
        foreach ($aRole as $iRoleId){
            //insert a record for this user with this role
           $aResult[] = $this->insertUserRole($iUserId, $iRoleId);
        }
        //set the table back to the default table
        $this->__set('sTable', 'role');
        //if 0 is in the array then something failed so we return false
        //otherwise 0 will not be in the array so we return true
        return !in_array(0, $aResult);
    }
    
    public function insertUserRole($iUserId, $iRoleId){
        //change the table to user_role
        $this->__set('sTable', 'user_role');
        parent::__set('sColumns', '`role_id`,`user_id`, `create_date`, `modify_date`');
            parent::__set('sValues', $iRoleId . ',' . $iUserId . ', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        $bResult =  $this->add();
        //change the table back to role
        $this->__set('sTable', 'role');
        return $bResult;
    }
    
    public function getPermissions($iId){
        $oDb = DB::getDB();
        $sSql = 'SELECT `prm`.*, `m`.`name` as `module_name`, `p`.`name` as `permission_name` From `permission_role_module` `prm`
                    JOIN `module` `m` ON `m`.`id` = `prm`.`module_id`
                    JOIN `permission` `p` ON `prm`.`permission_id` = `p`.`id`
                    WHERE `prm`.`role_id` = ' . $iId;
        
        $aPermissions = $oDb->getRowsAsObjects($sSql);
        return $this->convertPermissionsObjectArrayToArray($aPermissions);
    }
    
    private function convertPermissionsObjectArrayToArray($aPermissions){
        $aReturn = array();
        foreach ($aPermissions as $oPerm){
            $aReturn[$oPerm->module_name][$oPerm->permission_name] = true;
        }
        return $aReturn;
    }

}

?>