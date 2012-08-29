<?php

class Action {

    private $sTable;
    private $sColumns;
    private $sValues;
    private $oDb;
    private $bError;
    public $aMessage = array();

    public function __construct($sTable = null) {
        $this->__set('sTable', $sTable);
        $this->__set('oDb', new DB());
    }

    public function __get($sName) {
        return $this->{$sName};
    }

    public function __set($sName, $mValue) {
        $this->{$sName} = $mValue;
    }
    
    public function addArrayItem($sName, $mValue){
        $aArray = $this->__get($sName);
        array_push($aArray, $mValue);
        $this->__set($sName, $aArray);
    }

    function __destruct() {
        unset($this);
    }

    /**
     * Method is used to add to the system
     * 
     */
    public function add() {
        $oDb = $this->__get('oDb');
        $sSql = "INSERT INTO `" . $this->__get('sTable') . "`(" . $this->__get('sColumns') . ") VALUES (" . $this->__get('sValues') . ")";
        return $oDb->insertQuery($sSql);
    }

    protected function prepareToAdd($aProperty, $aValues, $aIgnore = array('id', 'modify_date', 'create_date')) {
        $sValues = '';
        $sColumns = '';
        foreach ($aProperty as $oProperty) {
            if (!in_array($oProperty->Field, $aIgnore)) {
                $sColumns .= '`' . $oProperty->Field . '`, ';
                $sValues .= '\'' . $aValues[$oProperty->Field] . '\', ';
            }
        }
        $sColumns .= '`create_date`, `modify_date`';
        $sValues .= ' CURRENT_TIMESTAMP, CURRENT_TIMESTAMP';
        $this->__set('sColumns', $sColumns);
        $this->__set('sValues', $sValues);
        return $this->add();
    }

    public function update($iId) {
        $oDb = $this->__get('oDb');
        $sSql = "UPDATE `" . $this->__get('sTable') . "` SET " . $this->__get('sValues') . " WHERE `id` = $iId";
        return $oDb->executeQuery($sSql);
    }

    protected function prepareToUpdate($aProperty, $aValues, $aIgnore = array('id', 'modify_date', 'create_date')) {
        $sValues = '';
        foreach ($aProperty as $oProperty) {
            if (!in_array($oProperty->Field, $aIgnore)) {
                $sValues .= '`' . $oProperty->Field . '` = "' . $aValues[$oProperty->Field] . '", ';
            }
        }
        $sValues .= ' `modify_date` = CURRENT_TIMESTAMP';
        $this->__set('sValues', $sValues);
        return $this->update($aValues['id']);
    }

    public function delete($iId, $sIdColumn = 'id') {
        $oDb = $this->__get('oDb');
        $sSql = "DELETE FROM `" . $this->__get('sTable') . "` WHERE `$sIdColumn` = $iId";
        return $oDb->executeQuery($sSql);
    }

    /**
     *
     * @param type string - optional query syntax to specify the DB results
     * @return array of objects containg the db columns as the object properties
     */
    public function getAll($sQueryModification = '') {
        $oDb = $this->__get('oDb');
        $sSql = "SELECT `" . $this->__get('sTable') . "`.* FROM `" . $this->__get('sTable') . "` $sQueryModification";
        return $oDb->getRowsAsObjects($sSql);
    }

    public function getAllActive($sQueryModification = null) {
        return $this->getAll(' WHERE `active` = 1' . $sQueryModification);
    }

    public function getNameFromSlug($sSlug) {
        $oDb = $this->__get('oDb');
        $sSql = "SELECT `name` FROM `" . $this->__get('sTable') . "` WHERE `slug` = '$sSlug'";
        $aData = $oDb->getRowsAsObjects($sSql);
        if ($aData) {
            return $aData[0]->name;
        } else {
            return null;
        }
    }

    public function getWithId($iId) {
        $oDb = $this->__get('oDb');
        $sSql = "SELECT * FROM `" . $this->__get('sTable') . "` WHERE `id` = " . $iId;
        $aResults = $oDb->getRowsAsObjects($sSql);
        if (count($aResults)) {
            return array_shift($aResults);
        } else {
            return null;
        }
    }

    public function getWithSlug($sSlug) {
        $oDb = $this->__get('oDb');
        $sSql = "SELECT * FROM `" . $this->__get('sTable') . "` WHERE `slug` = '$sSlug'";
        $aResults = $oDb->getRowsAsObjects($sSql);
        if (count($aResults)) {
            return array_shift($aResults);
        } else {
            return null;
        }
    }

    public function getTableInfo() {
        $oDb = $this->__get('oDb');
        return $oDb->getTableInfo($this->__get('sTable'));
    }

}

?>