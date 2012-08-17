<?php
$sMessage = '';
$sMessageClass = '';
if (formSubmit()) {
    $bResult = false;
    $oUser = new User();
    if (postVar('action') == 'Login') {
        
        if ($oUser->login(postVar('email'), postVar('password'))) {
            gotoUrl('/cms/home/');
        } else {
            $sMessage = ' Login Failed.';
            $sMessageClass = ' error';
        }
    } elseif (postVar('action') == 'Forgot Password') {
        if (postVar('email')){
            $bResult = $oUser->forgotPassword(postVar('email'));
        }else{
            $sMessage = ' Enter an email.';
            $sMessageClass = ' error';
        }
        if ($bResult){
             $sMessage = 'Sent a password reset email to '. postVar('email');
            $sMessageClass = ' added';
        }else{
            $sMessage = 'Could not send an email to '. postVar('email');
            $sMessageClass = ' error';
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <script type="text/javascript" language="javascript" src="/cms/js/jquery-1.7.2.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/cms/js/jquery-ui-1.8.21.custom.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/cms/js/init.js" ></script>
        <link href="/cms/css/style.css" rel="stylesheet" type="text/css" media="screen">
            <link href="/cms/css/menu.css" rel="stylesheet" type="text/css" media="screen">
                <link href="/cms/css/smoothness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" media="screen">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                        <title></title>
                        </head>
                        <body>
                            <div id="main">
                                <div id="wrapper" class="rounded-corners">
                                    <?php if ($sMessage != ''): ?>
                                        <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
                                    <?php endif; ?>
                                    <div class="form">
                                        <form class="form" id="login" method="post" action="">
                                            <p class="name">
                                                <span class="error email"></span>
                                                <input type="text" name="email" id="email" value="<?php echo postVar('email') ?>"/>
                                                <label for="email">Email</label>
                                                
                                            </p>
                                            <p class="name">
                                                <span class="error password"></span>
                                                <input type="password" name="password" id="password" />
                                                <label for="password">Password</label>
                                                
                                            </p>
                                            <p class="submit">
                                                <input type="submit" id="btn_login" name="action" value="Login" />&nbsp;
                                                <input type="submit" id="btn_resetPassword" name="action" value="Forgot Password" />
                                            </p>
                                        </form>
                                    </div>
                                    <?php require_once (CMS_INCLUDES . 'footer.php'); ?>