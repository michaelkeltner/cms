<?php

class Asset extends Action {

    private $aError = array();

    function __construct() {
        parent::__construct('asset');
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

    public function upload($sSchoolSlug, $sDisplayName) {
        $sAssetPath = SITE_ROOT . 'assets/';
        if (!file_exists($sAssetPath)){
            
            if(!mkdir($sAssetPath)){
                $this->addError('can not create' . $sAssetPath);
                return 0;
            }
        }
        $sImagePath = $sAssetPath . 'images/';
        if (!file_exists($sImagePath)){
            if(!mkdir($sImagePath)){
                $this->addError('can not create' . $sImagePath);
                return 0;
            }
        }
        $sDocsPath = $sAssetPath . 'docs/';
        if (!file_exists($sDocsPath)){
             if(!mkdir($sDocsPath)){
                $this->addError('can not create' . $sDocsPath);
                return 0;
            }
        }
        
        $aAllowedImages = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/jpg");
        $aAllowedDocs = array("application/pdf", "text/css");
         if (in_array($_FILES["file"]["type"], $aAllowedImages)) {
            $sType = 'image';
            $sUploadHere = $sImagePath;
         }elseif (in_array($_FILES["file"]["type"], $aAllowedDocs)) {
            $sType = 'doc';
            $sUploadHere = $sDocsPath;
         }else{
             $sType = false;
         }
        if ($sType) {
            if ($_FILES["file"]["error"] > 0) {
                $this->addError($_FILES["file"]["error"]);
                return 0;
            } else {

                if (file_exists($sUploadHere . $_FILES["file"]["name"])) {
                    $this->addError($_FILES["file"]["name"] . " already exists. ");
                    return 0;
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $sUploadHere . $_FILES["file"]["name"]);
                    $this->addItem($sSchoolSlug, $_FILES["file"]["name"], $sDisplayName, $sType, $_FILES["file"]["size"]);
                }
            }
        } else {
            $this->addError('Invalid file');
            return 0;
        }
    }
    
    public function deleteAndRemove($iId, $sSchoolSlug){
        $aFilePath = array('image'=>'assets/' . $sSchoolSlug . '/images/', 'doc'=>'assets/' .$sSchoolSlug . '/docs/');
        $oItem = parent::getWithId($iId);
        //if we removed the entry from the database
        if (parent::delete($iId)){
            //then we remove it from the server
            prePrint(SITE_ROOT . $aFilePath[$oItem->type] . $oItem->name);
            unlink(SITE_ROOT . $aFilePath[$oItem->type] . $oItem->name);
        }
    }

    private function addItem($sSchoolSlug, $sName, $sDisplayName, $sType, $iSize) {
        parent::__set('sColumns', ' `name`, `display_name`, `type`, `size`, `create_date`, `modify_date`');
        parent::__set('sValues', '\'' . $sName . '\', \'' . $sDisplayName . '\', \'' . $sType . '\', ' . $iSize . ', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP');
        return $this->add();
    }
    
     /**
     * Determines the path to the asset with the asset name included.
     * @param type $sFile - the name of the file
     * @param type $sAssetTypeDir - the base directory for the asset type (images or docs)
     * @return type String - the path to the file starting at the assets directory
     */
     public function getAssetItemPath($sFile, $sAssetTypeDir){
        $sFileFullPath = SITE_ROOT . 'assets/' . $sAssetTypeDir .'s/'. $sFile;
        if (file_exists($sFileFullPath)){
            return '/assets/' . $sAssetTypeDir .'s/'. $sFile;
        }else{
            return '';
        }
    }
       
}

?>