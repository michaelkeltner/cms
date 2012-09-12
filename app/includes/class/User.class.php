<?php

class User extends Action {

    function __construct() {
        parent::__construct('user');
    }

    function __destruct() {
        unset($this);
    }

    /**
     * Method is used to add a school to the system
     * 
     * @param string $sName - the name of the user
     * @param string $sEmail - the user's email
     * @param int $sPassord - the password to use
     * @return int - the id of the newly created record
     */
    public function addItem($sName, $sEmail, $sPassword) {
        parent::__set('sColumns', '`name`, `email`, `password`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sEmail . '\',\'' . $sPassword . '\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }

    public function updateItem($sName, $sEmail, $sPassword, $iId) {
        if ($sPassword != '') {
            $sPassword = '`password` = "' . md5($sPassword) . '",';
        }
        $sValues = ' `name` = "' . $sName . '", `email` = "' . $sEmail . '",' . $sPassword . ' `modify_date` = CURRENT_TIMESTAMP';
        parent::__set('sValues', $sValues);
        return $this->update($iId);
    }

    public function login($sEmail, $sPassword) {

        $oResults = $this->validateLogin($sEmail, $sPassword);
        if ($oResults) {
            $this->setPermissions($oResults);
            $oUserStats = new UserStats();
            $oUserStats->logLogin($oResults->id);
            return true;
        } else {
            return false;
        }
    }

    private function validateLogin($sEmail, $sPassword) {
        $oDb = new DB();
        $sSql = 'SELECT *
                FROM `user`
                WHERE `password` = "' . md5($sPassword) . '"
                AND `email` = "' . $sEmail . '"';
        $aUser = $oDb->getRowsAsObjects($sSql);
        if (count($aUser)) {
            return $aUser[0];
        } else {
            return false;
        }
    }

    private function setPermissions($oUser) {
        $oRole = new Role();
        $aRole = $oRole->getRoleForUser($oUser->id);
        $aPerms = array();
        foreach ($aRole as $oRoleItem) {
            $aPerms = array_merge_recursive($aPerms, $oRole->getPermissions($oRoleItem->id));
        }
        $oUser->permissions = $aPerms;
        $_SESSION['ahp_cms_user'] = serialize($oUser);
    }

    public function checkLogin() {
        if (!isset($_SESSION['ahp_cms_user'])) {
            $this->logout();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        session_write_close();
        gotoURL('/cms/login');
        exit;
    }

    public function getActiveUser() {
        return unserialize($_SESSION['ahp_cms_user']);
    }

    public function forgotPassword($sEmail) {
        
        $aUser = $this->getAll(" WHERE `email` = '$sEmail'");
        //if there was no email then we return false
        if (!count($aUser) > 0) { return false; }
        //update the temporary password field
        $iId = $aUser[0]->id;
        $sTempPassword = md5(generateRandomString(10));
        $oDb = $this->__get('oDb');
        $sSql = "UPDATE `user` SET `temp_password` = '$sTempPassword' WHERE id = $iId";
        $oDb->executeQuery($sSql);
        $iMD5Id = md5($iId);
        $iRand = mt_rand(1, 9);
        //second char tells us where the id is
        $sEncodedData = $sTempPassword[0] . $iRand . substr($sTempPassword, 1, $iRand - 1) . $iMD5Id . substr($sTempPassword, $iRand);
        $sBody = "Well, you forgot your password huh?\n\r<br/> <h3>No worries!</h3>";
        $sBody .= "Click the link to reset it: ";
        $sBody .= "<a href=" . SITE_URL ."cms/reset/" . $sEncodedData .">" . SITE_URL ."cms/reset/</a>";

        $bResult = sendEmail(array($sEmail), array('email'=>'noreply@academichealthplans.com', 'name'=>'AHP CMS'), 'You forgot your password', $sBody);
        return $bResult;
        
    }
    
    public function validateEncode($sEncode){
        
        $iIdStartPosition = $sEncode[1];
        $sMD5Id = substr($sEncode, $iIdStartPosition + 1, 32);
        $sMD5Password = $sEncode[0] . substr($sEncode, 2, $iIdStartPosition - 1) . substr($sEncode, $iIdStartPosition + 33);
        $oDb = $this->__get('oDb');
        $sSql = "SELECT 1 FROM `user` WHERE `temp_password` = '$sMD5Password' AND md5(`id`) = '$sMD5Id'";
        $aUser =  $oDb->getRowsAsObjects($sSql);
        if (count($aUser) > 0){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function resetPassword($sPassword, $sEncoded){
        $oDb = $this->__get('oDb');
        //get the user id we are to update
        $iIdStartPosition = $sEncoded[1];
        $sMD5Id = substr($sEncoded, $iIdStartPosition + 1, 32);
        $sSql = "UPDATE `user` SET `password` = md5('$sPassword') WHERE md5(`id`) = '$sMD5Id'";
        return $oDb->executeQuery($sSql);
        
    }

    public function getUserWithEmail($sEmail) {
        
    }

    public function canAccess($permission = null) {
        $module = getParam(2);
        $oUser = $this->getActiveUser();
        if ($oUser->id == 1){return true;}
        //they can always access the home page
        if ($module == 'home') {
            return true;
        }
        //if a specific permission was passed in then check it
        if ($permission) {
            return isset($oUser->permissions[$module][$permission]);
        }
        //otherwise no permission was passed in so we check the current URL

        switch (getParam(3)) {
            case 'list':
            case 'read':
                $perm = 'read';
                break;
            case 'add':
                $perm = 'create';
                break;
            case 'edit':
                $perm = 'update';
                break;
            case 'delete':
                $perm = 'delete';
                break;
            default:
                $perm = 'nothing';
                break;
        }
        return isset($oUser->permissions[$module][$perm]);
    }

}

?>