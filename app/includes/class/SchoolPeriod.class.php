<?php

class SchoolPeriod extends Action {

    function __construct() {
        parent::__construct('school_period');
    }

    function __destruct() {
        unset($this);
    }

    /**
     *
     * @param type $iSchoolId - id of the school
     * @param type $iPeriodId - id of the period coverage
     * @param type $sStartDate - when the period coverage is active
     * @param type $sEndDate - when the period coverage is in-active
     * @return type 
     */
    public function addItem($iSchoolId, $iPeriodId, $sStartDate, $sEndDate){
        parent::__set('sColumns', '`school_id`, `period_id`, `start_date`, `end_date`, `create_date`, `modify_date`');
        parent::__set('sValues',  $iSchoolId . ', ' . $iPeriodId . ', \'' . $sStartDate . '\',\'' . $sEndDate .'\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function getAllUnusedSchoolPeriods($sSchoolSlug){
        $oDb = new DB();
        $sSql ='SELECT `p`.`slug`, `p`.`name` 
                FROM  `period` `p`
                WHERE `p`.`id` NOT IN(
                    SELECT `p`.`id` FROM `period` `p`
                    JOIN `school_period` `sp` ON `p`.`id` = `sp`.`period_id`
                    JOIN `school` `s` ON `s`.`id` = `sp`.`school_id`
                    WHERE `s`.`slug` = "' . $sSchoolSlug . '"
                )';
        return $oDb->getRowsAsObjects($sSql);
    }
    
    /**
     * returnas all the school periods in the system
     * @return array of objects
     */
    public function getAllSchoolPeriods(){
        $oDb = new DB();
        $sSql ='SELECT `sp`.*, `s`.`name` as `school_name`, `p`.`name` as `period_name`
                FROM `school_period` `sp`
                JOIN `school` `s` ON `s`.`id` = `sp`.`school_id`
                JOIN `period` `p` ON `p`.`id` = `sp`.`period_id`
                ORDER BY `school_name` ASC';
        return $oDb->getRowsAsObjects($sSql);
    }
    /**
     *
     * @param type $iSchoolId - the id of the school that is to have its periods
     * returned
     * @return array of objects
     */
    public function getSchoolPeriods($iSchoolId){
        $oDb = new DB();
        $sSql ='SELECT `sp`.*, `s`.`name` as `school_name`, `s`.`slug` as `school_slug`, `p`.`slug` as `period_slug`, `p`.`name` as `period_name`
                FROM `school_period` `sp`
                JOIN `school` `s` ON `s`.`id` = `sp`.`school_id`
                JOIN `period` `p` ON `p`.`id` = `sp`.`period_id`
                WHERE `sp`.`school_id` = ' . $iSchoolId;
        return $oDb->getRowsAsObjects($sSql);
    }
    /*
     * 
     */
    public function createSchoolPeriodCoverage($iSchoolId, $iPeriodId, $sStartDate, $sEndDate){
        $oDb = new DB();
        $sSql ='INSERT INTO `school_period` 
                (`school_id`, `period_id`, `start_date`, `end_date`) 
                VALUES 
                ('. $iSchoolId . ', ' . $iPeriodId .',\'' . $sStartDate . '\', \'' . $sEndDate . '\')';
        return $oDb->executeQuery($sSql);
    }
    
    public function updateSchoolPeriodCoverage($iId, $sStartDate, $sEndDate){
        $oDb = new DB();
        $sSql ='UPDATE `school_period` ' . 
               ' SET `start_date` = \'' . $sStartDate .'\', ' .
               ' `end_date`  = \'' . $sEndDate .'\' ' .
               ' WHERE `id` = ' .  $iId;
        return $oDb->executeQuery($sSql);
    }
    
    public function getAllWithId($iSchoolId, $iPeriodId){
        $oDb = new DB();
        $sSql ='SELECT * FROM  `school_period` ' . 
            ' WHERE `school_id` = ' .  $iSchoolId . 
            ' AND  `period_id` = ' . $iPeriodId;
        return $oDb->getRowsAsObjects($sSql);
        
    }
    
    public function getAllActiveWithSlug($sSchoolSlug){
        $oDb = new DB();
        $sSql ='SELECT `sp`.*, `p`.`name` as `period_name`, `p`.`slug` as `period_slug`, `s`.`slug` as `school_slug` FROM  `school_period` `sp`' .
            ' JOIN `school` `s` ON `s`.`id` = `sp`.`school_id`' .
            ' JOIN `period` `p` ON `p`.`id` = `sp`.`period_id`' .
            ' WHERE `s`.`slug` = \'' .  $sSchoolSlug . '\'' . 
            ' AND  `start_date` <= CURRENT_DATE AND `end_date` >= CURRENT_DATE ';
        return $oDb->getRowsAsObjects($sSql);  
    }
    
    public function copyContent($iSchoolId, $iFromPeriodId, $iToPeriodId) {
        $oDb = new DB();
        $aResults = array();
        $aSql = array();
        $aSql[] = 'START TRANSACTION;';
        $aSql[] = 'DROP TEMPORARY TABLE IF EXISTS `tmptable`;';
        $aSql[] = 'CREATE TEMPORARY TABLE tmptable SELECT `school_id`, `period_id`, `start_date`, `end_date` FROM `' . $this->__get('sTable') . '` WHERE `school_id` = ' . $iSchoolId . ' AND `period_id` = ' . $iFromPeriodId . ';';
        $aSql[] = 'UPDATE tmptable SET `period_id` = ' . $iToPeriodId . ' WHERE `period_id` = ' . $iFromPeriodId . ';';
        $aSql[] = 'INSERT INTO `' . $this->__get('sTable') . '` (`school_id`, `period_id`, `start_date`, `end_date`) SELECT * FROM tmptable WHERE `period_id` = ' . $iToPeriodId . ';';
        $aSql[] = 'DROP TEMPORARY TABLE IF EXISTS `tmptable`;';
        $aSql[] = 'COMMIT;';
        foreach ($aSql as $sSql) {
            $aResults[] = $oDb->executeQuery($sSql);
        }
        return $aResults;
    }
 
}

?>