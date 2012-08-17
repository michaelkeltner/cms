<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <script type="text/javascript" language="javascript" src="/cms/js/<?php echo JQUERYFILE ?>" ></script>
        <script type="text/javascript" language="javascript" src="/cms/js/<?php echo JQUERYUIJSFILE ?>" ></script>
        <script type="text/javascript" language="javascript" src="/cms/js/init.js?<?php echo FILE_DECACHER?>"  ></script>
        <?php if ($sActiveLink == 'module'):?>
        <script type="text/javascript" language="javascript" src="/cms/js/module_builder.js?<?php echo FILE_DECACHER?>"  ></script>
        <?php endif?>
        <link href="/cms/css/style.css?<?php echo FILE_DECACHER?>" rel="stylesheet" type="text/css" media="screen" ></script>
        <link href="/cms/css/menu.css?<?php echo FILE_DECACHER?>" rel="stylesheet" type="text/css" media="screen" ></script>
        <link href="/cms/css/<?php echo JQUERYUICSSFILE ?>" rel="stylesheet" type="text/css" media="screen" ></script>   
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title></title>
    </head>
    <body>
        <div id="main">
<?php require_once ('menu.php'); ?>
            <div id="wrapper" class="rounded-corners">