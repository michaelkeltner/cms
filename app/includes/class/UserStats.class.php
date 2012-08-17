<?php

class UserStats {

    private $sTable;
    private $oDb;
    
    public function __construct() {
        $this->__set('sTable', 'user_stats');
        $this->__set('oDb', new DB());
    }

    public function __get($sName) {
        return $this->{$sName};
    }
    
    public function __set($sName, $mValue) {
        $this->{$sName} = $mValue;
    }
    
    function __destruct() {
        unset($this);
    }

    /**
     * Method is used to add to the system
     * 
     */
    public function add(){
        $oDb = $this->__get('oDb');
        $sSql = "INSERT INTO `". $this->__get('sTable'). "`(" . $this->__get('sColumns') .") VALUES (" . $this->__get('sValues') .")";
        return $oDb->insertQuery($sSql);
    }
    
     public function update($iId){
        $oDb = $this->__get('oDb');
        $sSql = "UPDATE `". $this->__get('sTable'). "` SET " . $this->__get('sValues') ." WHERE id = $iId";
        return $oDb->executeQuery($sSql);

    }
    
    public function delete($iId){
        $oDb = $this->__get('oDb');
        $sSql = "DELETE FROM `". $this->__get('sTable'). "` WHERE `id` = $iId";
        return $oDb->executeQuery($sSql);
    }
    /**
     *
     * @param type string - optional query syntax to specify the DB results
     * @return array of objects containg the db columns as the object properties
     */
    public function getAll($sQueryModification = ''){
        $oDb = $this->__get('oDb');
        $sSql = "SELECT `" .  $this->__get('sTable')."`.* FROM `" .  $this->__get('sTable')."` $sQueryModification";
        return $oDb->getRowsAsObjects($sSql);
    }
    
     public function getAllActive($sQueryModification = null){
        return $this->getAll(' WHERE `status` = 1' . $sQueryModification);
    }
    
    public function getNameFromSlug($sSlug){
        $oDb = $this->__get('oDb');
        $sSql = "SELECT `name` FROM `" .  $this->__get('sTable')."` WHERE `slug` = '$sSlug'";
        $aData = $oDb->getRowsAsObjects($sSql);
        if ($aData){
            return $aData[0]->name;
        }else{
            return null;
        }
    }
    
    public function getWithId($iId){
        $oDb = $this->__get('oDb');
        $sSql = "SELECT * FROM `" .  $this->__get('sTable')."` WHERE `id` = " . $iId;
        $aResults = $oDb->getRowsAsObjects($sSql);
        if (count($aResults)){
            return array_shift($aResults);
        }else{
            return null;
        }
    
    }
    
    public function getWithSlug($sSlug){
        $oDb = $this->__get('oDb');
        $sSql = "SELECT * FROM `" .  $this->__get('sTable')."` WHERE `slug` = '$sSlug'";
        $aResults = $oDb->getRowsAsObjects($sSql);
        if (count($aResults)){
            return array_shift($aResults);
        }else{
            return null;
        }
    
    }
    
    public function getTableInfo(){
        $oDb = $this->__get('oDb');
        return $oDb->getTableInfo($this->__get('sTable'));
    }
    
    public function logLogin($iUserId){
        $oDb = $this->__get('oDb');
        $aResults = array();
        $aSql = array();
        $aSql[] = 'START TRANSACTION;';
        $aSql[] = 'INSERT INTO `user_stats` (`user_id`, `login_count`, `current_login`, `create_date`) VALUES (' . $iUserId . ', 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE `last_login` = `current_login`, `login_count` = `login_count` + 1 , `total_pages_viewd` = `total_pages_viewd` + `last_pages_viewed`, `current_login` = CURRENT_TIMESTAMP;';
        $aSql[] = 'COMMIT;';
        foreach($aSql as $sSql){
            $aResults[] = $oDb->executeQuery($sSql);
        }  
    }
    
    public function getWithUserId($iUserId){
         $oDb = $this->__get('oDb');
        $sSql = "SELECT * FROM `" .  $this->__get('sTable')."` WHERE `user_id` = " . $iUserId;
        $aResults = $oDb->getRowsAsObjects($sSql);
        if (count($aResults)){
            return array_shift($aResults);
        }else{
            return null;
        }
    
    }
     
    
   
}

?>