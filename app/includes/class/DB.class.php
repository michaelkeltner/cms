<?php

class DB {

    public function __construct() {
        $this->ConnectDB();
    }

    public function __destruct() {
        unset($this);
    }

    /**
     * Method connects to the database with the config varaibles set in the config file.
     * If we can not connect then an error message is shown and we die out.
     * @return boolean - indicates that we are able to connect to the database
     */
    private function ConnectDB() {

        if (!mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)) {
            echo "Could not find Database host";
            die();
        }

        if (!mysql_select_db(DB_NAME)) {
            echo "Could not find Database name";
            die();
        }

        return true;
    }

    /**
     * Method executes a provided My Sql
     * @param string $sql - the query to be executed
     * @return boolean - Indicates the success or failure of the query execution
     */
    public function executeQuery($sql) {
        //if no statement is proveded then return false
        if ($sql == "") {
            return false;
        }
        //return true if the query ran, otherwise return false
        return mysql_query($sql) ? true : false;
    }

    /**
     * Method returns the result set based on the query
     * then it will returns the null;
     * @param string $sql - the query to execute.
     * @return Resource - Resource for the query results 
     */
    public function getResultSet($sql) {
        //if no query is passed in then return null
        if ($sql == "") {
            return NULL;
        }
        //return the result of the query
        return mysql_query($sql);
    }

    /**
     * Method is called to execute a query and return the id of the newly created record
     * @param string $sql - the My Sql query to be executed
     * @return int - The id of the new record.  0 is returned if the insert fails.
     */
    public function insertQuery($sql) {
        if (!$this->executeQuery($sql)) {
            return 0;
        }
        //store the id of the new record
        $LastID = mysql_insert_id();
        //Return the new record id or 0 if there was no record id generated
        return ($LastID) ? $LastID : 0;
    }

    /**
     * Method returns an array of record objects
     * @param string $sSql - the query to execute
     * @return array Array populated with objects for the records returned by the DB
     */
    public function getRowsAsObjects($sSql) {

        $rs = $this->getResultSet($sSql);
        if (!$rs) {
            return null;
        }
        $aReturn = array();
        while ($oRow = mysql_fetch_object($rs)) {
            $aReturn[] = $oRow;
        }
        return $aReturn;
    }
    
     /**
     * Method returns an array of records
     * @param string $sSql - the query to execute
     * @return array Array populated with the records returned by the DB
     */
    public function getRowsAsArray($sSql) {

        $rs = $this->getResultSet($sSql);
        if (!$rs) {
            return null;
        }
        $aReturn = array();
        $i = 0;
        while ($aRow =  mysql_fetch_array($rs, MYSQL_NUM)) {
            $aReturn[$i++] = $aRow[0];
        }
        return $aReturn;
        
    }

    public function getTableInfo($sTable) {
        $sSql = 'DESCRIBE ' . $sTable;
        return $this->getRowsAsObjects($sSql);
    }
    
    public function renameTable($sOldTable, $sNewTable){
        $sSql = "RENAME TABLE  `$sOldTable` TO  `$sNewTable`";
        return $this->executeQuery($sSql);
    }

}

?>