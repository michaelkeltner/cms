<?php
/**
 * Class Render acs as a wrapper for the front end to get site content 
 */
class Data{
    
    public $iId;
    public $aContent = array();
    public $oAssociation;

    function __construct($oItem, $aFields) {    
        $this->_setValues($oItem, $aFields);         
    }

    function __destruct() {
        unset($this);
    }
    
    public function __get($sName) {
        return $this->{$sName};
    }

    public function __set($sName, $mValue) {
        $this->{$sName} = $mValue;
    }
    

    private function _setValues($oItem, $aFields){
        $oAssociation = new Association();
        $this->__set('iId',$oItem->id);
        foreach($aFields as $oPropery){
            $sFieldName = $oPropery->name;
            $sValue = isset($oItem->{$sFieldName})?$oItem->{$sFieldName}:'';
            $this->aContent[$sFieldName]['content'] = $sValue;
            if ($oPropery->type == 'association'){
                $aOptions = unserialize($oPropery->options);
                $iModuleId = $aOptions['module_id'];
               // prePrint($iModuleId, $sFieldName, $oItem->id);
                $aReturn = $oAssociation->getAssocationValues($oPropery->module_id, $sFieldName, $oItem->id);
                if (!count($aReturn)){
                    $this->aContent[$sFieldName]['association'] = null;
                    continue;
                }
                foreach($aReturn as $oAssociationData){
                    $aPieces = explode('__', $oPropery->name);
                    $oAssociationRender = new Render($aPieces[1]);
                    $oAData = $oAssociationRender->getData($oAssociationData->id);
                    $this->aContent[$sFieldName]['association'][] = $oAData;
                    foreach ($oAData as $oStoreThis){
                            $aStoreMe[] = $oStoreThis->aContent[$aPieces[2]]['content'];
                    }
                    $this->aContent[$sFieldName]['content'] = $aStoreMe;
                }
            }
            
        }
    }
    
    public function hasAssociation($sField){
        return $this->aContent[$sField]['association'] != null;
        
    }
    
    public function showAll($sField, $sSeperator = ''){
        if ($this->hasAssociation($sField)){
            foreach ($this->aContent[$sField]['association'] as $aData){
                foreach($aData as $oData){
                    $oData->get('name') . $sSeperator;
                }
            }
        }
        
    }
    
    public function returnAllAssociations($sField){
         if (!$this->hasAssociation($sField)){return array();}
         return $this->aContent[$sField]['association'];
    }
    
    public function show($sField, $sSeperator = ''){
        $sOutput = '';
        if (is_array($this->aContent[$sField]['content'])){
            foreach ($this->aContent[$sField]['content'] as $sShowMe){
                $sOutput .= $sShowMe . $sSeperator;
            }
            //strip of the trailing seperator
            $sOutput = substr($sOutput, 0, (strlen($sSeperator)) * -1);
        }else{
            $sOutput = $this->aContent[$sField]['content'];
        }
        echo $sOutput;
    }
    
    public function get($sField){
        return $this->aContent[$sField]['content'];
    }
    
    public function cleanData(){
        if($this->sType == 'link'){
            $aLinkComponents = unserialize($this->sContent);
            //Thank you IE for not understanding the convention of 
            //target ='_self' means to load in the same page, not an actual
            //frame with the name of "_self".
            $sTarget = ($aLinkComponents['target'] == '_self')?'':' target="' . $aLinkComponents['target'] .'"';
            $this->sContent = '<a href="' . $aLinkComponents['url'] . '"' . $sTarget .'>' .$aLinkComponents['display'] .'</a>';

        }elseif($this->sType == 'image'){
            $oClass = new Asset();
            $oItem = $oClass->getWithId($this->sContent);
            $this->sContent = '<img src="' . $oClass->getAssetItemPath($oItem->sName, $this->sType) . '" alt="' . $oItem->sDisplayName . '"/>';
        }elseif($this->sType == 'doc'){
            $oClass = new Asset();
            $oItem = $oClass->getWithId($this->sContent);
            $this->sContent = '<a href="http://' . BASE_URL . $oClass->getAssetItemPath($oItem->sName, $this->sType) . '" class="embed" alt="' . $oItem->sDisplayName . '"/>' . $oItem->sDisplayName . '</a>';
        }elseif($this->sType == 'header'){
            $this->sContent = '<h2 class="header">' .$this->sContent . '</h2>';
        }else{
            $this->sContent = str_replace("\n", '<br/>', $this->sContent);
        }
    }
    
    

}

?>