<?php

class Theme extends Action {

    private $aError = array();

    function __construct() {
        parent::__construct('theme');
    }
    
    function __destruct() {
        unset($this);
    }

    private function addError($sValue) {
        array_push($this->aError, $sValue);
    }

    public function hasErrors(){
        return count($this->aError);
    }
    
    public function getErrors(){
        return $this->aError;
    }


    public function upload($sDisplayName) {
        $sThemePath = SITE_INCLUDES . '/themes/';
        if (!file_exists($sThemePath)) {
            if (!mkdir($sThemePath)) {
                $this->addError('can not create' . $sThemePath);
                return 0;
            }
        }
        $aAllowedDocs = array("text/css");
        if (!in_array($_FILES["file"]["type"], $aAllowedDocs)) {
            $this->addError('Invalid file');
            return 0;
        } 
        if ($_FILES["file"]["error"] > 0) {
            $this->addError($_FILES["file"]["error"]);
            return 0;
        }
        if (file_exists($sThemePath . $_FILES["file"]["name"])) {
            $this->addError($_FILES["file"]["name"] . " already exists. ");
            return 0;
        }
        move_uploaded_file($_FILES["file"]["tmp_name"], $sThemePath . $_FILES["file"]["name"]);
        $this->addItem($sDisplayName, $_FILES["file"]["name"]);
    }
    
    public function deleteAndRemove($iId, $sSchoolSlug){
        $oItem = parent::getWithId($iId);
        //if we removed the entry from the database
        if (parent::delete($iId)){
            //then we remove it from the server
            unlink(SITE_INCLUDES . '/themes/' . $oItem->css_file);
        }
    }
    
    private function addItem($sName, $sFileName) {
        parent::__set('sColumns', '`name`, `css_file`,`create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sFileName . '\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
    public function updateItem($iId, $sName){
        $sValues = ' `name` = \'' . $sName .'\'';
        parent::__set('sValues', $sValues);
        return $this->update($iId);
    }

}

?>