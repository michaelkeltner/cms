<!DOCTYPE html>
<?php
$oRender = new Render('change_log');
$oRender->order('`change_date` DESC');
$aData = $oRender->getData(null, true);

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
            <div id="title">System Changes</br>
                <input type="text" id="search_change_log" placeholder='Search' class="search"/><br/>
            </div>
            <div id="filter">
                <div id="system_categories">
                    Category<br/> 
                    <input type="checkbox" name="category[]" value="Cosmetic">Cosmetic</input>
                    <input type="checkbox" name="category[]" value="Technical">Technical</input>
                    <input type="checkbox" name="category[]" value="Process">Process</input>
                    <input type="checkbox" name="category[]" value="Database">Database</input>
                    <input type="checkbox" name="category[]" value="Bug">Bug</input>
                </div>
                System<br/>
                <select name="system" id="system">
                    <option value="none">-- select --</option>
                     <option value="New Waiver">New Waiver</option>
                     <option value="Old Waiver">Old Waiver</option>
                     <option value="Enrollment">Enrollment</option>
                </select>
            </div>

            <div id="button">
                <?php if (count($aData)): ?>
                        <?php foreach ($aData as $oData): ?>
                <div class="item_group">
                    <p>
                        <h3><?php $oData->show('system')?></h3>
                        <h3><?php $oData->show('title')?> - <?php $oData->show('change_date') ?></h3>
                        <h4>Change</h4><?php $oData->show('changes') ?>
                        <h4>Reason</h4><?php $oData->show('reason') ?>
                    </p>
                </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No Changes Available</p>
                    <?php endif; ?>
            </div>
</div>
            <div id="footer" class="rounded-corners">
                &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
            </div>
        
    </div>
</body>
</html>

