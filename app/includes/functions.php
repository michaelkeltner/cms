<?php
function formSubmit($sMethod = 'post') {
    //make sure its not an Ajax request
    if (isAjax()) {
        return false;
    }
    if ($sMethod == 'post') {
        return count($_POST) > 0;
    } else {
        return count($_GET) > 0;
    }
}

function postVar($sVar) {
    return isset($_POST[$sVar]) ? $_POST[$sVar] : null;
}

function getVar($sVar) {
    return isset($_GET[$sVar]) ? $_GET[$sVar] : null;
}

//get the value of the text at a specific location in the URL
function getParam($iIndex) {
    $aPieces = explode('/', $_SERVER['REQUEST_URI']);
    return (count($aPieces) > $iIndex ) ? $aPieces[$iIndex] : null;
}


/**
 *
 * @param type $aItems - array of objects containg 'id' and 'name' properties
 *                     to be used as the options' value and display respectively
 * @return string - the option html code
 */
function populateSelectOptions($aItems, $iDefeaultId = 0) {
    $sOptions = '<option>-select-</option>';
    if (!count($aItems) > 0) {
        return $sOptions;
    }
    foreach ($aItems as $oItem) {
        $sSelected = ($oItem->id == $iDefeaultId) ? ' selected="selected"' : '';
        $sOptions .= '<option value=' . $oItem->id . $sSelected . '>' . $oItem->name . '</option>';
    }
    return $sOptions;
}

//determine if the call being made is ajax
function isAjax() {
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}

//prints out the n parameters passed in wrapped in pre tags for readability
function prePrint() {
    echo '<pre>';
    if (func_num_args()) {
        foreach (func_get_args() as $mPrintMe) {
            var_dump($mPrintMe);
        }
    } else {
        echo 'No parameters passed in to view';
    }

    echo '</pre>';
}
function optionSelect($mCurrentValue, $mSetValue){
    return ($mCurrentValue == $mSetValue)?' selected="selected"':'';
}

function optionChecked($mCurrentValue, $mSetValue){
    return ($mCurrentValue == $mSetValue)?' checked="checked"':'';
}

function generateRandomString($length = 8)
{
    //stolen off the internet for time sake.
    //http://stackoverflow.com/questions/853813/how-to-create-a-random-string-using-php
    // start with an empty random string
    $sReturn = "";
    $sPickList = 'qwertypadfghjkzxbnQWERYTPADFHJKZXBN23456789#%*';
    
    // count the number of chars in the valid chars string so we know how many choices we have
    $iMaxChar = strlen($sPickList);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // take the random character out of the string of valid chars
        // subtract 1 from $iMaxChar because strings are indexed starting at 0
        // and the length count starts at 1
        $sReturn .= $sPickList[mt_rand(0, $iMaxChar - 1)];
    }

    // return our finished random string
    return $sReturn;
}

function gotoURL($sLocation){
    ob_start();
    while (ob_get_status()) 
    {
        ob_end_clean();
    }
    if (!headers_sent()) {
        header('Location:' . $sLocation);
        exit;
    }else{
        echo '<script>
            <!--
            window.location= "http://' . BASE_URL . $sLocation . '/"
            //-->
            </script>';
    }
}

function currentURL(){
    $i = 1;
    $sUrl = SITE_URL;
    while(getParam($i)){
      $sUrl .=   getParam($i++) .'/';
    }
    return $sUrl;
}

function isInUrl($sValue){
    return stristr(currentUrl(), $sValue);
}

function sendEmail($aTo, $aFrom, $sSubject, $sBody, $aBCC = array()) {
  //SMTP details		
  $smtp_host = 'smtp.1and1.com';
  $smtp_user = 'noreply@smintellisofttech.com';
  $smtp_pass = 'noreply12';
  $smtp_port = '25';

  $mailer = new PHPMailer();
  $mailer->Mailer = "smtp";
  $mailer->IsSMTP();
  $mailer->Host = '' . $smtp_host . '';
  $mailer->SMTPAuth = TRUE;
  $mailer->Username = '' . $smtp_user . '';
  $mailer->Password = '' . $smtp_pass . '';
  $mailer->Port = '' . $smtp_port . '';
  $mailer->From = ($aFrom['email'] != '')?$aFrom['email']:'noreply@academichealthplans.com';
  $mailer->FromName = ($aFrom['name'] != '')?$aFrom['name']:'Academic HealthPlan';
  $mailer->Body = '' . $sBody . '';
  $mailer->Subject = '' . $sSubject . '';
  $mailer->IsHTML(true);

  foreach ($aTo as $sEmailAddress){
    $mailer->AddAddress($sEmailAddress);
  }
  if (count($aBCC)){
    foreach ($aBCC as $sEmailAddress){
      $mailer->AddBCC($sEmailAddress);
    }
  }
  $bResults = $mailer->Send();
  return $bResults;
}

function getIP(){
    return $_SERVER['REMOTE_ADDR'];
}
?>
