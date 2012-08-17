<?php

class School extends Action {

    function __construct() {
        parent::__construct('school');
    }

    function __destruct() {
        unset($this);
    }

    /**
     * Method is used to add a school to the system
     * 
     * @param string $sName - the name of the school
     * @param string $sImage - the location of the school image
     * @param int $iThemeId - the id in the theme table this school is to use
     * @return int - the id of the newly created record
     */
    public function addItem($sName, $sImage, $iThemeId, $sSlug){
        parent::__set('sColumns', '`name`, `image`, `theme_id`, `slug`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sImage . '\', ' . $iThemeId . ',\'' . $sSlug .'\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function updateItem($sName, $sImage, $iThemeId, $sSlug, $iId){
        $sValues = ' `name` = "' . $sName. '", `image` = "' . $sImage . '", `theme_id` = ' . $iThemeId . ', `slug` = "' . $sSlug . '", `modify_date` = CURRENT_TIMESTAMP';
        parent::__set('sValues', $sValues);
        return $this->update($iId);
    }
    
    public function getTheme($sSchoolSlug){
        $oDb = new DB();
        $sSql = 'SELECT `t`.`css_file` from `theme` `t`
            JOIN `school` `s` ON `s`.`theme_id` = `t`.`id`
            WHERE `s`.`slug` = \'' . $sSchoolSlug. '\'';
      
        $aItem = $oDb->getRowsAsObjects($sSql);
        return $aItem[0];
        
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