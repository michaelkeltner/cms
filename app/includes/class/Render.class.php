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
        $aWhereAssocaiton = array();
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
            
            $sWhere = ' WHERE 1=1 AND ';
            foreach ($this->aWhere as $sSearch){
                $aPieces = explode('|', $sSearch);
                if ($this->aNameFields[$aPieces[0]]->type == 'association'){
                    $oSearchData = new stdClass();
                    $oSearchData->associationField = $aPieces[0];
                    $oSearchData->filterField = $aPieces[1];
                    $oSearchData->condition = $aPieces[2];
                    $oSearchData->value = $aPieces[3];
                    $oSearchData->operator = (isset($aPieces[4]))?$aPieces[4] . ' ':' AND ';
                    $oSearchData->associationOptions = unserialize($this->aNameFields[$aPieces[0]]->options);
                    $aWhereAssocaiton[] = $oSearchData;
                }else{
                    $sWhere .= '`' . $aPieces[0] .'` ' . $aPieces[1] . '"' . $aPieces[2] . '" ';
                    $sWhere .= (isset($aPieces[3]))?$aPieces[3] . ' ':' AND ';
                }
            }
            //strip off trailing condistional key word
            $sWhere = trim($sWhere);
            if (substr(strtoupper($sWhere), -4) == ' AND'){
                $sWhere = substr($sWhere, 0, -4);
            }elseif (substr(strtoupper($sWhere), -3) == ' OR'){
                $sWhere = substr($sWhere, 0, -3);
            } 
        }
       
        $aItemData = $this->getAll($sWhere . $sSortOrder . $sLimit);
        $aFields = $this->__get('aFields');
        
        //loop through each item
        if (!$aItemData){return null;}
        $oAssociation = new Association();
        foreach ($aItemData as $oItem){
            $oPropery = $this->oProperties;
            //assume we can store this value
            $bMatch = true;
            if (count($aWhereAssocaiton)){
                //itterate through the where portion of the association fields
                foreach($aWhereAssocaiton as $oWhere){
                    $sCondition = $oWhere->condition;
                    $sAssociationField = $oWhere->associationField;
                    $sFilterField = $oWhere->filterField;
                    //$oWhere->associationOptions['module_id'];
                    $sDesiredValue = $oWhere->value;

                    $aReturn = $oAssociation->getAssocationValues($oPropery->id, $sAssociationField, $oItem->id);
                    
                    //what do we do if there are no results
                    if (!$aReturn){
                        //check to make sure we did not want to return items
                        //that had no results
                        $bMatch = ($sDesiredValue == "" && $sCondition == '=')?true:false;
                        //then go to the next itteration
                        continue;
                    }
                    //itterate through all the assocaited items returned
                    foreach ($aReturn as $oAssociatedItem){
                        $sValidateMe = $oAssociatedItem->{$sFilterField};
                        //special case for blank values
                        if ($sValidateMe == "" && $sDesiredValue != "" && $sCondition != '!='){
                            echo 'test';
                            $bMatch = false; 
                            continue;
                        }
                        if ($sCondition == '='){
                            if ($sValidateMe != $sDesiredValue){
                               $bMatch = false; 
                               continue;
                            }
                        }elseif($sCondition == '!='){
                            if ($sValidateMe == $sDesiredValue){
                               $bMatch = false; 
                               continue;
                            }
                        }elseif(strtolower($sCondition) == 'like'){
                            if (!stristr($sValidateMe, $sDesiredValue)){
                               $bMatch = false; 
                               continue;
                            }
                        }
                    }
                }
            }
            if ($bMatch){
                
                $oData = new Data($oItem, $aFields);
                $aData[] = $oData;
            }
            //reset our match flag
            $bMatch = true;
        }
        return $aData;
    }
    
}

?>