<!DOCTYPE html>
<?php
$oRender = new Render('faq');
$oRender->order('`sort_order` ASC');
$aData = $oRender->getData();
?>
<html>
    <head>
        <script type="text/javascript" language="javascript" src="/includes/js/jquery-1.7.1.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/includes/js/init.js" ></script>
        <link href="/includes/themes/ahpsite.css" rel="stylesheet" type="text/css" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <div id="wrapper" class="rounded-corners">
            <div id="title">
                FAQ
            </div>
            <div id="button">
                <ul>
                    <?php if (count($aData)): ?>
                        <?php foreach ($aData as $oData): ?>
                        <li class="question">
                            <a href="#" class="question" rel="<?php $oData->show('id')?>"><?php $oData->show('question') ?></a>
                            <div class="answer" id="<?php $oData->show('id')?>">
                                <?php $oData->show('answer') ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                        <p>No FAQ's available</p>
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

