<?php
/**
 * Class Render acs as a wrapper for the front end to get site content 
 */
class Render extends ModuleGeneric{

    public $aOrder = array();
    public $iLimit;
    public $aWhere = array();
    
    function __construct($sModule) {
        parent::__construct($sModule);
    }

    function __destruct() {
        unset($this);
    }
    
    public function order(){
        if (!func_num_args()){return false;}
        $this->aOrder = func_get_args();
        return true;
    }
    
    public function limit($iLimit){
        $this->iLimit = $iLimit;
        return true;
    }
    
    public function where(){
        if (!func_num_args()){return false;}
        $this->aWhere = func_get_args();
        return true;
    }


    public function isValidURL(){
        $oContent = new Content();
        return $oContent->hasContent(getParam(1), getParam(2));
    }
    
    public function docExists($sFileName){
        $sFile = '/assets/docs/' . $sFileName;
        return (file_exists($sFile));
    }
    
    public function imageExists($sFileName){
        $sFile = '/assets/images/' . $sFileName;
        return (file_exists($sFile));
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
    
    public function getData($iId=null){
        return ($iId)?$this->_getSingleData($iId):$this->_getAllData();
    }
    
    private function _getSingleData($iId){
        $aData = array();
        $oItem = $this->getWithId($iId);
        $aFields = $this->__get('aFields');
        $oData = new Data($oItem, $aFields);
        $aData[] = $oData;
        return $aData;
    }  
    
    private function _getAllData(){
        $aData = array();
        $sSortOrder ='';
        $sLimit = '';
        $sWhere = '';
        if ($this->aOrder){
            $sSortOrder = ' ORDER BY ';
            foreach($this->aOrder as $sSort){
                $sSortOrder .= $sSort . ', ';
            }
           //strip off trailing ', '
            $sSortOrder = substr($sSortOrder, 0, -2);
        }
        if ($this->iLimit){
            $sLimit = ' LIMIT ' . $this->iLimit;
        }
        if (count($this->aWhere)){
            $sWhere = ' WHERE ';
            foreach ($this->aWhere as $sSearch){
                $sWhere .= $sSearch . ' AND ';
            }
            $sWhere = substr($sWhere, 0, -5);
        }
        $aItemData = $this->getAll($sWhere . $sSortOrder . $sLimit);
        $aFields = $this->__get('aFields');
        
        //loop through each item
        if (!$aItemData){return null;}
        foreach ($aItemData as $oItem){
            //loop through each property and set an instance of Data
            $oData = new Data($oItem, $aFields);
            $aData[] = $oData;
           
        }
        return $aData;
    }
    
}

?>