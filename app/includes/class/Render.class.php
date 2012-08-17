<?php
/**
 * Class Render acs as a wrapper for the front end to get site content 
 */
class Render {

    static $sSchoolSlug;
    static $sPeriodSlug;
    function __construct() {
        
    }

    function __destruct() {
        unset($this);
    }
    
    static function setSchoolSlug($sSlug){
        self::$sSchoolSlug = $sSlug;
    }
     static function setPeriodSlug($sSlug){
        self::$sPeriodSlug = $sSlug;
    }
    static function getSchoolSlug(){
        return self::$sSchoolSlug;
    }
    static function getPeriodSlug(){
        return self::$sPeriodSlug;
    }
    
    public function getThemeFile(){
        $oSchool = new School();
        $oItem = $oSchool->getTheme(Render::getSchoolSlug());
        return $oItem->css_file;
        
    }
    
    public function isValidURL(){
        $oContent = new Content();
        return $oContent->hasContent(getParam(1), getParam(2));
    }
    
    public function docExists($sFileName){
        $sFile = '/assets/' . self::getSchoolSlug() . '/docs/' . $sFileName;
        return (file_exists($sFile));
    }
    
    public function imageExists(){
        $sFile = '/assets/' . self::getSchoolSlug() . '/images/' . $sFileName;
        return (file_exists($sFile));
    }
    
    public function showSiteContent($iSchoolId, $iPeriodId) {
        
        $oContent = new Content();
        $aContent = $oContent->getAllBySchoolPeriod($iSchoolId, $iPeriodId);
        if (!count($aContent) > 0) {
            return '<div id="error">No content available</div>';
        }
        $sSchoolName =  $aContent[0]->school_name;
        $sReturn = '<h1 id="header">' . $sSchoolName . '</h1>';
        $aContent = $this->groupBySection($aContent);
        $i = 1;
        foreach ($aContent as $sSectionName => $aItemsBySection) {
            //get the header divs
            if ($i == 1) {
                $sReturn .= '<div id="section1"> <div id="column1">';
            } else if ($i == 2) {
                $sReturn .= '<div id="column1">';
            } elseif ($i == 3) {
                $sReturn .= '<div id="section2"><div id="column3">';
            } else {
                $sReturn .= '<div id="column4">';
            }
            $sReturn .= $sSectionName;
            $sReturn .= '<ul class="site_content_listing">';
            foreach ($aItemsBySection as $oItem) {
                $sReturn .= '<li class="site_content_item">' . $oItem->content . '</li>';
            }
            //close out the list and the column div
            $sReturn .= '</ul></div>';
            //close out the large sections for the css alignment
            if ($i++ % 2 == 0) {
                $sReturn .= '</div>';
            }
        }
        return $sReturn;
        
    }

    private function groupBySection($aContnet) {
        $aReturn = array();
        foreach ($aContnet as $oItem) {
            $aReturn[$oItem->section_name][$oItem->sort_order] = $oItem;
        }
        return $aReturn;
    }

    public function getColumnContent($sSchoolSlug, $sPeriodSlug, $sColumnName, $bIgnoreSchedule = false){
        $oContent = new Content();
        $aData = $oContent->getSectionContent($sSchoolSlug, $sPeriodSlug, $sColumnName, $bIgnoreSchedule);
        if (!count($aData)>0){
            return null;
        }
        
        $aReturn = $this->cleanData($aData);
        
        return $aReturn;
        
    }
    
    public function getAllColumnContent($sSchoolSlug, $sPeriodSlug, $sColumnName){
        return $this->getColumnContent($sSchoolSlug, $sPeriodSlug, $sColumnName, true);
        
    }
    
    private function cleanData($aData){
        $aReturn = array();
        foreach ($aData as $oData){
            if($oData->type == 'link'){
                $aLinkComponents = unserialize($oData->content);
                //Thank you IE for not understanding the convention of 
                //target ='_self' means to load in the same page, not an actual
                //frame with the name of "_self".
                $sTarget = ($aLinkComponents['target'] == '_self')?'':' target="' . $aLinkComponents['target'] .'"';
                $oData->content = '<a href="' . $aLinkComponents['url'] . '"' . $sTarget .'>' .$aLinkComponents['display'] .'</a>';
                
            }elseif($oData->type == 'image'){
                $oClass = new Asset();
                $oItem = $oClass->getWithId($oData->content);
                $oData->content = '<img src="' . $oClass->getAssetItemPath($oItem->name, self::getSchoolSlug(), $oData->type) . '" alt="' . $oItem->display_name . '"/>';
            }elseif($oData->type == 'doc'){
                $oClass = new Asset();
                $oItem = $oClass->getWithId($oData->content);
                $oData->content = '<a href="http://' . BASE_URL . $oClass->getAssetItemPath($oItem->name, self::getSchoolSlug(), $oData->type) . '" class="embed" alt="' . $oItem->display_name . '"/>' . $oItem->display_name . '</a>';
            }elseif($oData->type == 'header'){
                $oData->content = '<h2 class="header">' .$oData->content . '</h2>';
            }else{
                $oData->content = str_replace("\n", '<br/>', $oData->content);
            }
            $aReturn[] = $oData;
        }
        return $aReturn;
    }
    
    public function getSchoolNameFromSlug($sSlug){
        $oSchool = new School();
        return $oSchool->getNameFromSlug($sSlug);
        
    }
    public function getPeriodNameFromSlug($sSlug){
        $oPeriod = new Period();
        return $oPeriod->getNameFromSlug($sSlug);
    }
    
    public function getActivePeriodCoverage($sSchoolSlug){
        $oSchoolPeriod = new SchoolPeriod();
        return $oSchoolPeriod->getAllActiveWithSlug($sSchoolSlug);
        
    }

}

?>