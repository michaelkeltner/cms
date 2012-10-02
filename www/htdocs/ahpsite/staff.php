<!DOCTYPE html>
<?php
$oRender = new Render('staff');
$oRender->order('`first_name` ASC');
$aData = $oRender->getData();

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
        
        <div id="wrapper" class="rounded-corners">
            <div id="title">Staff</br>
                <input type="text" id="search_staff" placeholder='Search' class="search"/><br/>
            </div>
            <div id="button">
                    <?php if (count($aData)): ?>
                        <?php foreach ($aData as $oData): ?>
                <div class="listing">
                    <ul>
                        <li><?php $oData->show('first_name')?> <?php $oData->show('last_name') ?></li>
                        <?php $oData->show('department', '/', 'Department: ', '', array('li'), true) ?>
                        <?php $oData->show('title', '', 'Title: ', '', array('li'), true) ?>
                        <?php $oData->show('phone', '', 'Phone: ', '', array('li'), true) ?>
                        <li><a href="mailto:<?php $oData->show('email')?>"><?php $oData->show('email')?></a></li>

                    </ul>
                </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No Staff list available</p>
                    <?php endif; ?>
            </div>
</div>
            <div id="footer" class="rounded-corners">
                &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
            </div>
        
    </div>
</body>
</html>

