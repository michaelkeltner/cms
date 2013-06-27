<!DOCTYPE html>
<?php
$oRender = new Render('tips');
$oRender->order('`sort_order` ASC');
$aData = $oRender->getData(null,true);

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
            <div id="title">Tips</br>
                <input type="text" id="search_tip" placeholder='Search' class="search"/><br/>
            </div>
            <div id="button">
                <ul>
                    <?php if (count($aData)): ?>
                        <?php foreach ($aData as $oData): ?>
                        <li class="question"><?php $oData->show('title')?></li>
                        <li class="answer"><?php $oData->show('content') ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No Tips available</p>
                    <?php endif; ?>
                </ul>
            </div>
</div>
            <div id="footer" class="rounded-corners">
                &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
            </div>
        
    </div>
</body>
</html>

