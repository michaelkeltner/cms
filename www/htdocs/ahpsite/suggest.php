<!DOCTYPE html>
<?php
$bError = false;
$sMessage = '';
if (formSubmit()){
    $aTo = array('kristin.lemons@ahpcare.com');
    $sender = postVar('email');
    
    $aFrom['name'] = $sender;
    $aFrom['email'] = $sender;
    $sSubject = 'AHP suggestion';
    $sBody = '<h3>Suggestion: ' . postVar('subject') . '</h3></br>';
    $sBody .= '<h3>Current Process</h3>' . postVar('issue') . '</br>';
    $sBody .= '<h3>Suggested Action</h3>' . postVar('suggestion') . '</br>';
    $sBody .= '<h3>Potential Benefits</h3>' . postVar('benefits') . '</br>';
    $aBCC = array($sender);
    if (!$sender){
        $bError = true;
        $sMessage .= 'Please enter your email address</br>';
    }
    if (!postVar('subject')){
        $bError = true;
        $sMessage .= 'Please enter a subject</br>';
    }
    if (!postVar('issue')){
        $bError = true;
        $sMessage .= 'Please enter the current process</br>';
    }
     if (!postVar('suggestion')){
        $bError = true;
        $sMessage .= 'Please enter a suggestion</br>';
    }
    if (!postVar('benefits')){
        $bError = true;
        $sMessage .= 'Please enter the benefits</br>';
    }
    if (!$bError){
        $bResults = sendEmail($aTo, $aFrom, $sSubject, $sBody, $aBCC);
        if ($bResults){
            $bError = false;
            $sMessage = 'Your suggestion has been submitted.  Thank You.';
            $_POST['subject'] = '';
            $_POST['issue'] = '';
            $_POST['suggestion'] = '';
            $_POST['benefits'] = '';
            $_POST['email'] = '';
        }else{
            $bError = true;
            $sMessage = 'An error has occured.  Please try re-submitting your suggestion.';
        }  
    }
}
?>
<html>
    <head>
        <script type="text/javascript" language="javascript" src="/includes/js/jquery-1.7.1.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/includes/js/init.js?<?php echo FILE_DECACHER?>" ></script>
        <link href="/includes/themes/ahpsite.css?<?php echo FILE_DECACHER?>" rel="stylesheet" type="text/css" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php include_once('includes/menu.php')?>
        <div id="wrapper" class="rounded-corners">
            <div id="title">E-Suggest</div>
            
            <div id="button">
                <p>Part of continuous improvement is feedback.  If you have a suggestion on how we can improve, please let us know.</p>
                <br/>
                <div id="message"><?php echo $sMessage?></div>
                <form method="post" action="#">
                    <span>Subject</span></br>
                    <input type="text" name="subject" value="<?php echo postVar('subject')?>"/></br>
                    <span>Current Process</span></br>
                    <textarea name="issue"><?php echo postVar('issue')?></textarea></br>
                    <span>Suggested Action</span></br>
                    <textarea name="suggestion"><?php echo postVar('suggestion')?></textarea></br>
                    <span>Potential Benefits</span></br>
                    <textarea name="benefits"><?php echo postVar('benefits')?></textarea></br>
                    <span>Your email</span></br>
                    <input type="text" name="email" value="<?php echo postVar('email')?>"/></br>
                    </br>
                    <input type="submit" value="Suggest!" id="submit"/>
                </form>
            </div>
        </div>
            <div id="footer" class="rounded-corners">
                &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
            </div>
    </div>
</body>
</html>

