<!DOCTYPE html>
<?php
$oFileTransfer = new Render('file_transfers');
$oFileTransfer->order('`id` ASC');
$oFileTransfer->limit(100);
$aFileTransfers = $oFileTransfer->getData();
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
            <div id="title">
                Eligibility File Transfers
            </div>
            <div id="button">
                <ul>
                    <?php if (count($aFileTransfers)): ?>
                    <table>
                        <tr>
                            <th>Company</th>
                            <th>School</th>
                            <th>Schedule</th>
                            <th>Notes</th>
                            <th>Transfer to FTP</th>
                        </tr>
                        <?php foreach ($aFileTransfers as $oData): ?>
                        <tr>
                            <td><?php 
                                $sContent =  ($oData->get('carrier')!= '')?$oData->get('carrier'):$oData->get('other');
                                echo (is_array($sContent))?$sContent[0]:$sContent;  
                            ?></td>
                            <td><?php 
                                if ($oData->get('school')){
                                    $sContent = $oData->get('school');
                                    echo (is_array($sContent))?implode(',', $sContent):$sContent;
                                } 
                            ?></td>
                            <td><?php $oData->show('time') ?></td>
                            <td><?php $oData->show('notes') ?></td>
                            <td><?php $oData->show('eligibility_file') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                        <p>No eligibility file transfers data available</p>
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

