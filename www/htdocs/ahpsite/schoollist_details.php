<!DOCTYPE html>
<?php
$sSlug = getParam(3);

$oSchool = new Render('school');
$oSchool->where("slug|=|$sSlug");
$aSchools = $oSchool->getData();

unset($oData);
if (count($aSchools)) {
    $oData = $aSchools[0];
    
    $oFileTransfers = new Render('file_transfers');
    $oFileTransfers->where("school|name|=|". $oData->get('name'));
    $aFileTransfers = $oFileTransfers->getData();
    //prePrint($aFileTransfers);
}
?>
<html>
    <head>
        <script type="text/javascript" language="javascript" src="/includes/js/jquery-1.7.1.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/includes/js/init.js?<? echo FILE_DECACHER ?>" ></script>
        <link href="/includes/themes/ahpsite.css?<?php echo FILE_DECACHER?>" rel="stylesheet" type="text/css" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div id="wrapper" class="rounded-corners">
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo SITE_URL . 'schoollist'; ?>" class="menu_link"> School List</a> / Details
            <?php if (isset($oData)): ?>
                <div id="title">Details for <?php $oData->show('name') ?></br></div>
                <div id="details">
                    <p>
                        <ul class="detail_listing">
                            <?php $oData->show('account_manager', ', ', 'Account Manager: ', '', 'li', true) ?>
                            <?php $oData->show('client_service_rep', ', ', 'Client Service Representative: ', '', 'li', true) ?>
                            <?php $oData->show('carrier', ', ', 'Carrier: ', '', 'li', true) ?>
                            <li>Website : <a href="http://ahpcare.com/<?php $oData->show('slug') ?>/" target="_blank">http://ahpcare.com/<?php $oData->show('slug') ?>/</a></li>
                            <?php if ($aFileTransfers):?>
                            <?php foreach($aFileTransfers as $oFileTransferData):?>
                            <?php $oFileTransferData->show('time', ', ', 'File Trasnfer Schedule: ', '', 'li', true) ?>
                            <?php $oFileTransferData->show('notes', ', ', 'File Transfer Notes: ', '', 'li', true) ?>
                            <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </p>
                </div>
        <?php else: ?>
            <div id="title">
                <p>No school details</p>
            </div>
        <?php endif; ?>

    </div>
    <div id="footer" class="rounded-corners">
        &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
    </div>

</div>
</body>
</html>

