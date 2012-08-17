<?php

class Content extends Action {

    function __construct() {
        parent::__construct('content');
    }

    function __destruct() {
        unset($this);
    }

   /**
    *
    * @param type $iSectionId - which section this is linked to
    * @param type $sContent - the text to appear
    * @param type $iSortOrder - the order in relation to other content
    * @param type $iPeriodId - which period this is linked to
    * @param type $iSchoolId - which school this is linked to
    * @param typt $sType - indicates the type of content (link, text, image...)
    * @return the results of mysql adding to the database
    */
    public function addItem($iSectionId, $sContent, $iSortOrder, $iPeriodId, $iSchoolId, $sType, $sStartDate, $sEndDate){
        parent::__set('sColumns', '`section_id`, `content`, `sort_order`, `period_id`, `school_id`, `type`, `start_date`, `end_date`, `create_date`, `modify_date`');
        parent::__set('sValues',  $iSectionId . ', \'' . $sContent . '\', ' . $iSortOrder . ', ' . $iPeriodId . ', ' . $iSchoolId. ',\'' . $sType . '\', \'' .$sStartDate. '\', \''. $sEndDate . '\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function hasContent($sSchoolSlug, $sPeriodSlug){
        $oDb = new DB();
        $sSql = 'SELECT sc.name as school, p.name as period, c.* FROM `content` c 
                 JOIN school sc ON sc.id = c.school_id
                 JOIN period p ON p.id = c.period_id
                 WHERE sc.slug = \''. $sSchoolSlug .'\'
                 AND p.slug = \''. $sPeriodSlug . '\'
                 LIMIT 1';
        return (count($oDb->getRowsAsObjects($sSql)) > 0);
        
    }
    
    public function getAllSchoolsWithContent(){
        $aReturn = array();
        $oDb = new DB();
        $sSQL = 'SELECT `s`.`name` as `school_name`,`s`.`slug` as `school_slug`, `p`.`name` as `period_name`,  `p`.`slug` as `period_slug`, CONCAT(`s`.`slug`,  `p`.`slug`) as `contact_school_period` FROM `content` `c`
                    JOIN `school` `s` ON `s`.`id` = `c`.`school_id`
                    JOIN `period` `p` ON `p`.`id` = `c`.`period_id`
                    GROUP BY  `contact_school_period`
                    ORDER BY  `s`.`name` ASC';
        $aItems = $oDb->getRowsAsObjects($sSQL);
        foreach ($aItems as $oItem){
            $aReturn[$oItem->school_name][] = $oItem;
        }
        return $aReturn;
    }
    
   public function getAllBySchoolPeriod($iSchoolId, $iPeriodId){
       $oDb = new DB();
       $sSql =  'SELECT c.*, se.name as section_name, sc.name as school_name FROM `content` c ' . 
                ' JOIN section se ON se.id = c.section_id ' .
                ' JOIN school sc ON sc.id = c.school_id ' .
                ' WHERE `school_id` = '. $iSchoolId .
                ' AND `period_id` = ' . $iPeriodId . 
                ' ORDER BY `section_id` ASC, `sort_order` ASC';
       return $oDb->getRowsAsObjects($sSql);
   }
   
   public function getSectionContent($sSchoolSlug, $sPeriodSlug, $sColumnName, $bIgnoreSchedule = false){
        $oDb = new DB();
        if ($bIgnoreSchedule){
            $sScheduleCondition = '';
        }else{
            $sScheduleCondition = ' AND c.start_date <= CURRENT_TIMESTAMP';
            $sScheduleCondition .= ' AND c.end_date >= CURRENT_TIMESTAMP';
        }
        $sSql = 'SELECT sc.name as school, p.name as period, c.* FROM `content` c 
                 JOIN school sc ON sc.id = c.school_id
                 JOIN period p ON p.id = c.period_id
                 JOIN section se ON se.id = c.section_id
                 WHERE sc.slug = \''. $sSchoolSlug .'\'
                 AND se.name = \''. $sColumnName . '\'
                 AND p.slug = \''. $sPeriodSlug . '\'';
        $sSql .= $sScheduleCondition;
        return $oDb->getRowsAsObjects($sSql);  
    }
    
    public function getSectionContentById($iSchoolId, $iPeriodId, $sColumnName){
        $oDb = new DB();
        $sSql = 'SELECT sc.name as school, p.name as period, c.* FROM `content` c 
                 JOIN school sc ON sc.id = c.school_id
                 JOIN period p ON p.id = c.period_id
                 JOIN section se ON se.id = c.section_id
                 WHERE c.school_id = '. $iSchoolId .'
                 AND se.name = \''. $sColumnName . '\'
                 AND c.period_id = '. $iPeriodId;
        return $oDb->getRowsAsObjects($sSql);  
    }
    
      public function getSectionContentBySectionId($iSchoolId, $iPeriodId, $iSectionId){
        $oDb = new DB();
        $sSql = 'SELECT sc.name as school, p.name as period, c.* FROM `content` c 
                 JOIN school sc ON sc.id = c.school_id
                 JOIN period p ON p.id = c.period_id
                 JOIN section se ON se.id = c.section_id
                 WHERE c.school_id = '. $iSchoolId .'
                 AND se.id = ' . $iSectionId . '
                 AND c.period_id = '. $iPeriodId;
        return $oDb->getRowsAsObjects($sSql);  
    }
    
   public function deleteSchoolPeriod($iSchoolId, $iPeriodId){
       $oDb = new DB();
       $sSql = 'DELETE FROM `content` ' .
               ' WHERE `school_id` = ' . $iSchoolId .
               ' AND `period_id` = ' . $iPeriodId;
       return $oDb->executeQuery($sSql);
   }
   
   public function deleteSchoolPeriodSection($iSchoolId, $iPeriodId, $iSectionId, $aSaveId = array()){
       $oDb = new DB();
       $sSql = 'DELETE FROM `content` ' .
               ' WHERE `school_id` = ' . $iSchoolId .
               ' AND `period_id` = ' . $iPeriodId . 
               ' AND `section_id` = ' . $iSectionId;
       if (count($aSaveId)){
           $sSql .= ' AND `id` NOT IN (' . implode(', ', $aSaveId). ')';
       }
       return $oDb->executeQuery($sSql);
   }
   
   public function copyContent($iSchoolId, $iFromPeriodId, $iToPeriodId) {
        $oDb = new DB();
        $aResults = array();
        $aSql = array();
        $aSql[] = 'START TRANSACTION;';
        $aSql[] = 'DROP TEMPORARY TABLE IF EXISTS `tmptable`;';
        $aSql[] = 'CREATE TEMPORARY TABLE tmptable SELECT `section_id`, `content`, `type`, `sort_order`, `period_id`, `school_id`, `start_date`, `end_date` FROM `' . $this->__get('sTable') . '` WHERE `school_id` = ' . $iSchoolId . ' AND `period_id` = ' . $iFromPeriodId . ';';
        $aSql[] = 'UPDATE tmptable SET `period_id` = ' . $iToPeriodId . ' WHERE `period_id` = ' . $iFromPeriodId . ';';
        $aSql[] = 'INSERT INTO `' . $this->__get('sTable') . '` (`section_id`, `content`, `type`, `sort_order`, `period_id`, `school_id`, `start_date`, `end_date`) SELECT * FROM tmptable WHERE `period_id` = ' . $iToPeriodId . ';';
        $aSql[] = 'DROP TEMPORARY TABLE IF EXISTS `tmptable`;';
        $aSql[] = 'COMMIT;';
        foreach ($aSql as $sSql) {
            $aResults[] = $oDb->executeQuery($sSql);
        }
        return $aResults;
    }
   
}

?>