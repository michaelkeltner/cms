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
        $aAssociationFields = array();
        $this->__set('iId',$oItem->id);
        if (!count($aFields)){return false;}
        foreach($aFields as $oPropery){
            $sFieldName = $oPropery->name;
            $sValue = isset($oItem->{$sFieldName})?$oItem->{$sFieldName}:'';
            $this->aContent[$sFieldName]['content'] = $sValue;
            if ($oPropery->type == 'association'){
                //store the  properties needed to get the assocaition value
                unset($oAssociationField);
                $oAssocaitionField = new stdClass();
                $oAssocaitionField->module_id = $oPropery->module_id;
                $oAssocaitionField->field = $sFieldName;
                $oAssocaitionField->propertyName = $oPropery->name;
                $aAssociationFields[] = $oAssocaitionField;
            }
            
        }
        if (count($aAssociationFields)){
            $oAssociation = new Association();
            foreach ($aAssociationFields as $oAssocationField){
                unset($aReturn);
                $aReturn = $oAssociation->getAssocationValues($oAssocationField->module_id, $oAssocationField->field, $oItem->id);
                if (!count($aReturn)){
                    $this->aContent[$oAssocationField->field]['association'] = null;
                    $this->aContent[$oAssocationField->field]['content'] = '';
                    continue;
                }
                foreach($aReturn as $oAssociationData){
                    unset($aStoreMe);
                    $aPieces = explode('__', $oAssocationField->propertyName);
                    $oAssociationRender = new Render($aPieces[1]);
                    $oAData = $oAssociationRender->getData($oAssociationData->id);
                    $this->aContent[$oAssocationField->field]['association'][] = $oAData;
                    foreach ($oAData as $oStoreThis){
                            $aStoreMe[] = $oStoreThis->aContent[$aPieces[2]]['content'];
                    }
                    $this->aContent[$oAssocationField->field]['content'] = $aStoreMe;
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
        if ($sField == 'id'){
          $sOutput = $this->iId;  
        }elseif (is_array($this->aContent[$sField]['content'])){
            foreach ($this->aContent[$sField]['content'] as $sShowMe){
                $sOutput .= $sShowMe . $sSeperator;
            }
            //strip of the trailing seperator
            $sOutput = substr($sOutput, 0, (strlen($sSeperator)) * -1);
        }else{
            $sOutput = @unserialize($this->aContent[$sField]['content']);
            if ($sOutput === false) {
                $sOutput = $this->aContent[$sField]['content'];
            }
        }
        echo $sOutput;
    }
    
    public function get($sField){
        return ($sField == 'id')?$this->iId:$this->aContent[$sField]['content'];
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