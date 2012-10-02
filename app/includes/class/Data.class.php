<?php

/**
 * Class Render acs as a wrapper for the front end to get site content 
 */
class Data {

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

    private function _setValues($oItem, $aFields) {
        $this->__set('iId', $oItem->id);
        if (!count($aFields)) {
            return false;
        }
        foreach ($aFields as $oPropery) {
            $sFieldName = $oPropery->name;
            $sValue = isset($oItem->{$sFieldName}) ? $oItem->{$sFieldName} : '';
            $this->aContent[$sFieldName]['content'] = $sValue;
            $this->aContent[$sFieldName]['type'] = $oPropery->type;
            if ($oPropery->type == 'association') {
                //get the options needed to get the assocaition value
                $aOptions = unserialize($oPropery->options);
                $oAssociation = new Association();

                unset($aReturn);
                $aReturn = $oAssociation->getAssocationValues($oPropery->module_id, $sFieldName, $oItem->id);

                if (!count($aReturn)) {
                    
                    $this->aContent[$sFieldName]['association'] = null;
                    $this->aContent[$sFieldName]['content'] = '';
                    continue;
                }
                foreach ($aReturn as $oAssociationData) {
                    $oModuleGeneric = new ModuleGeneric((int) $aOptions['module_id']);
                    $sAssociationField = $oModuleGeneric->aFields[$aOptions['field_id']]->name;
                    $this->aContent[$sFieldName]['association'][] = $oAssociationData;
                    $this->aContent[$sFieldName]['content'][] = $oAssociationData->{$sAssociationField};
                }
            }
        }
    }

    public function hasAssociation($sField) {
        return $this->aContent[$sField]['association'] != null;
    }

    public function showAll($sField, $sSeperator = '') {
        if ($this->hasAssociation($sField)) {
            foreach ($this->aContent[$sField]['association'] as $aData) {
                foreach ($aData as $oData) {
                    $oData->get('name') . $sSeperator;
                }
            }
        }
    }

    public function returnAllAssociations($sField) {
        if (!$this->hasAssociation($sField)) {
            return array();
        }
        return $this->aContent[$sField]['association'];
    }

    /**
     * 
     * @param type $sField - the module field to echo
     * @param type $sSeperator - the character to place between multiple values
     * @param type $sPrefix - anything to display before the content
     * @param type $sSuffix - anything to display after the content
     * @param type $sHTMLWrapper - HTML tags to place around the content.  The 
     *  method wil place the value in opening <{param}> and closing </{param}> 
     *  (i.e. b, li, div...)
     * @param type $bHTMLWrapAll - boolean true indicates the entire output has 
     *  the html tags wrapped around, false indicates only the module field 
     *  content.  Default is set to false.
     * 
     * @example $oData->show('account_manager', ',', 'Account Manager: ', '', 'li', true);
     * this will echo the value of "account_manager", placing a "," between each
     * value.  The text "Account Manager: " will show before the value and it 
     * will all be wrapped in <li></li> tag
     */
    public function show($sField, $sSeperator = '', $sPrefix = '', $sSuffix = '', $aHTMLWrapper = array(), $bHTMLWrapAll = false) {
        $sOutput = '';
        if ($sField == 'id') {
            echo  $this->iId;
            return;
        } 
        $sType = $this->aContent[$sField]['type'];
        switch($sType){
            case 'file':
                $aFileId = unserialize($this->aContent[$sField]['content']);
                if (count($aFileId) == 1 && $aFileId[0] == 0){
                    echo '';
                    return;
                }
                $oAsset = new Asset();
                foreach ($aFileId as $iFileId){
                    $oItem = $oAsset->getWithId($iFileId);
                    $sOutput .= '<a href="http://' . BASE_URL . $oAsset->getAssetItemPath($oItem->name, 'doc') . '" class="embed" alt="' . $oItem->display_name . '"/>' . $oItem->display_name . '</a>';
                    $sOutput .= '<br/>';
                }
                $sOutput = $this->_formatOutput( $sOutput, $sPrefix, $sSuffix, $aHTMLWrapper, $bHTMLWrapAll);
                 echo $sOutput;
                 return;
                break;
            case 'image';
                $aFileId = unserialize($this->aContent[$sField]['content']);
                $oAsset = new Asset();
                foreach ($aFileId as $iFileId){
                    $oItem = $oAsset->getWithId($iFileId);
                    $sOutput .= '<img src="http://' . BASE_URL . $oAsset->getAssetItemPath($oItem->name, 'image') . '"/>';
                }
                $sOutput = $this->_formatOutput( $sOutput, $sPrefix, $sSuffix, $aHTMLWrapper, $bHTMLWrapAll);
                 echo $sOutput;
                 return;
                break;
             case 'select':
                 if ($this->aContent[$sField]['content'] == ''){
                     return;
                 }
                 $aOutput = @unserialize($this->aContent[$sField]['content']);
                 foreach ($aOutput as $sShowMe) {
                    $sOutput .= $sShowMe . $sSeperator;
                }
                if ($sSeperator != ''){
                    $sOutput = substr($sOutput, 0, (strlen($sSeperator)) * -1);
                }
                echo $this->_formatOutput($sOutput, $sPrefix, $sSuffix, $aHTMLWrapper, $bHTMLWrapAll);
                return;
            default:
                break;
        }
 
        
        if (is_array($this->aContent[$sField]['content'])) {
            foreach ($this->aContent[$sField]['content'] as $sShowMe) {
                $sOutput .= $sShowMe . $sSeperator;
            }
            //strip of the trailing seperator
            if ($sSeperator != ''){
                $sOutput = substr($sOutput, 0, (strlen($sSeperator)) * -1);
            }
        } else {
            $sOutput = @unserialize($this->aContent[$sField]['content']);          
            if ($sOutput === false) {
                $sOutput = $this->aContent[$sField]['content'];
            }                  
        }
        if ($sOutput == ''){
            return;
        }
        if (!count($aHTMLWrapper)){
            echo $sPrefix . $sOutput . $sSuffix;
            return;
        }
        echo $this->_formatOutput($sOutput, $sPrefix, $sSuffix, $aHTMLWrapper, $bHTMLWrapAll);
        return;
    }
    
  
    
    private function _formatOutput($sOutput, $sPrefix, $sSuffix, $aHTMLWrapper, $bHTMLWrapAll){
        if ($sOutput == ''){ 
            return '';  
        }
        if (!count($aHTMLWrapper)){
            return  $sPrefix . $sOutput . $sSuffix; 
        }
        
        $sHTMLStart = '';
        $sHTMLEnd = '';
        
        foreach($aHTMLWrapper as $sHTMLWrapper ){
            $sHTMLStart .= "<$sHTMLWrapper>";
        }
        foreach (array_reverse($aHTMLWrapper) as $sHTMLWrapper ){
            $sHTMLEnd .= "</$sHTMLWrapper>";
        }
        
        
        if ($bHTMLWrapAll){
            return $sHTMLStart . $sPrefix . $sOutput . $sSuffix . $sHTMLEnd;
        }else{
            return $sPrefix . $sHTMLStart . $sOutput  .$sHTMLEnd . $sSuffix;
        } 
    }

    public function get($sField) {
         if ($sField == 'id') {
            return $this->iId;
        } 
        $sFieldIndex = (stristr($sField, '|'))?substr($sField, 0, strpos($sField, '|')):$sField;
        $sType = $this->aContent[$sFieldIndex]['type'];
        switch($sType){
            case 'file':
            case 'image';
                $aFileId = unserialize($this->aContent[$sField]['content']);
                $oAsset = new Asset();
                $sOutput = '';
                $aReturn = array();
                foreach ($aFileId as $iFileId){
                    $oItem = $oAsset->getWithId($iFileId);
                    if (!$oItem){
                        continue;
                    }
                    $aReturn[] = $oItem;
                }
                return $aReturn;
                break;
             case 'link':
                  return unserialize($this->aContent[$sField]['content']);
             case 'association':
                 $aPices = explode('|', $sField);
                 //are they requesting a field off the association object
                 if (count($aPices) > 1){
                     return $this->aContent[$sFieldIndex]['association'][0]->{$aPices[1]};
                 }else{//no, then return the default setup in on module
                     return $this->aContent[$sFieldIndex]['content'];
                 }
                 break;
            default:
                break;
        }
        return $this->aContent[$sField]['content'];
    }

    public function cleanData() {
        if ($this->sType == 'link') {
            $aLinkComponents = unserialize($this->sContent);
            //Thank you IE for not understanding the convention of 
            //target ='_self' means to load in the same page, not an actual
            //frame with the name of "_self".
            $sTarget = ($aLinkComponents['target'] == '_self') ? '' : ' target="' . $aLinkComponents['target'] . '"';
            $this->sContent = '<a href="' . $aLinkComponents['url'] . '"' . $sTarget . '>' . $aLinkComponents['display'] . '</a>';
        } elseif ($this->sType == 'image') {
            $oClass = new Asset();
            $oItem = $oClass->getWithId($this->sContent);
            $this->sContent = '<img src="' . $oClass->getAssetItemPath($oItem->sName, $this->sType) . '" alt="' . $oItem->sDisplayName . '"/>';
        } elseif ($this->sType == 'doc') {
            $oClass = new Asset();
            $oItem = $oClass->getWithId($this->sContent);
            $this->sContent = '<a href="http://' . BASE_URL . $oClass->getAssetItemPath($oItem->sName, $this->sType) . '" class="embed" alt="' . $oItem->sDisplayName . '"/>' . $oItem->sDisplayName . '</a>';
        } elseif ($this->sType == 'header') {
            $this->sContent = '<h2 class="header">' . $this->sContent . '</h2>';
        } else {
            $this->sContent = str_replace("\n", '<br/>', $this->sContent);
        }
    }

}

?>