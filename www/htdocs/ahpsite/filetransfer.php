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
        <script type="text/javascript" language="javascript" src="/includes/js/init.js" ></script>
        <link href="/includes/themes/ahpsite.css" rel="stylesheet" type="text/css" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
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
                            <th>Schedule</th>
                            <th>Notes</th>
                        </tr>
                        <?php foreach ($aFileTransfers as $oData): ?>
                        <tr>
                            <?php 
                            
                            //get the carrier/other text
                                $sContent =  ($oData->get('__carrier__name')!= '')?$oData->get('__carrier__name'):$oData->get('other');
                                $sCompanyOutput = (is_array($sContent))?$sContent[0]:$sContent;
                            //get the school
                               $sContent = ($oData->get('__school__name') !='')?'<br/>(' . $oData->get('__school__name') .')':'';
                               if ($oData->get('__school__name')){
                                   $sContent = $oData->get('__school__name');
                                   $sSchool = (is_array($sContent))?$sContent[0]:$sContent;
                                   $sCompanyOutput .= '<br/>(' . $sSchool .')';
                               }   
                            ?>
                            <td><?php echo $sCompanyOutput; ?></td>
                            <td><?php $oData->show('time') ?></td>
                            <td><?php $oData->show('notes') ?></td>
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

