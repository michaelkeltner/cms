<?php

class Section extends Action{

    function __construct() {
        parent::__construct('section');
    }

    function __destruct() {
        unset($this);
    }

     public function addItem($aProperty, $aValues/*$sName, $sAddress, $sAddress2, $sCity, $sState, $sZip, $sPhone, $sTollFree, $sFax, $sWebsite, $sEmail*/){
        $aIgnore = array('id', 'modify_date', 'create_date');
        $sValues = '';
        $sColumns = '';
        foreach ($aProperty as $oProperty){
            if (!in_array($oProperty->Field, $aIgnore)){
                $sColumns .= '`' . $oProperty->Field . '`, ';
                $sValues .= '\'' . $aValues[$oProperty->Field]. '\', ';
            }
        }
        $sColumns .= '`create_date`, `modify_date`';
        $sValues .= ' CURRENT_TIMESTAMP, CURRENT_TIMESTAMP';
        parent::__set('sColumns',$sColumns);
        parent::__set('sValues',$sValues);
        return $this->add();
    }
    
    public function updateItem($aProperty, $aValues){
        $aIgnore = array('id', 'modify_date', 'create_date');
        $sValues = '';
        foreach ($aProperty as $oProperty){
            if (!in_array($oProperty->Field, $aIgnore)){
                $sValues .= '`' . $oProperty->Field . '` = "' . $aValues[$oProperty->Field]. '", ';
            }
        }
        $sValues .= ' `modify_date` = CURRENT_TIMESTAMP';
        parent::__set('sValues', $sValues);
        return $this->update($aValues['id']);
    }

}

?>