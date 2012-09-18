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
    public function show($sField, $sSeperator = '', $sPrefix = '', $sSuffix = '', $sHTMLWrapper = '', $bHTMLWrapAll = false) {
        $sOutput = '';
        if ($sField == 'id') {
            $sOutput = $this->iId;
        } elseif (is_array($this->aContent[$sField]['content'])) {
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
        if ($sOutput != ''){
            if ($sHTMLWrapper != ''){
                if ($bHTMLWrapAll){
                    echo "<$sHTMLWrapper>" . $sPrefix . $sOutput . $sSuffix ."</$sHTMLWrapper>";
                }else{
                    echo  $sPrefix . "<$sHTMLWrapper>" . $sOutput  ."</$sHTMLWrapper>" . $sSuffix;
                }
            }else{
                echo $sPrefix . $sOutput . $sSuffix;
            }
        }
        
    }

    public function get($sField) {
        return ($sField == 'id') ? $this->iId : $this->aContent[$sField]['content'];
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