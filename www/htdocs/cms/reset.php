<?php
$sMessage = '';
$sMessageClass = '';
//validate the encode key
$sEncoded = getParam(3);
$oUser = new User();
$bValidate = $oUser->validateEncode($sEncoded);
if (!$bValidate) {
    gotoURL('/cms/index.php');
}

if (formSubmit()) {
    if (postVar('action') == 'Cancel') {
        gotoUrl('/cms/login/');
    }
    if (postVar('password') != postVar('confirm_password')) {
        $sMessage = 'Passwords must match ';
        $sMessageClass = ' error';
    } elseif (strlen(postVar('password')) == 0) {
        $sMessage = 'Please enter a password';
        $sMessageClass = ' error';
    } elseif (strlen(postVar('token')) != 65) {
        $sMessage = 'Error resetting your password';
        $sMessageClass = ' error';
    } else {
        if ($oUser->resetPassword(postVar('password'), postVar('token'))) {
            gotoUrl('/cms/login/');
        } else {
            $sMessage = 'Error';
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
                                            <input type="hidden" name="token" value="<?php echo $sEncoded ?>"/>
                                            <p class="name">
                                                <input type="password" name="password" id="password" />
                                                <label for="password">New Password</label>
                                            </p>
                                            <p class="name">
                                                <input type="password" name="confirm_password" id="confirm_password" />
                                                <label for="confirm_password">Confirm Password</label>
                                            </p>
                                            <p class="submit">
                                                <input type="submit" name="action" value="Reset" />&nbsp;
                                                <input type="submit" name="action" value="Cancel" />
                                            </p>
                                        </form>
                                    </div>
<?php require_once (CMS_INCLUDES . 'footer.php'); ?>