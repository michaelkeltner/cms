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
         <?php include_once('includes/menu.php')?>
        <div id="wrapper" class="rounded-corners">
            <div id="title">AHP Staff</br>
                <input type="text" id="search_staff" placeholder='Search' class="search"/><br/>
            </div>
            <div id="staff_list">
                    <?php if (count($aData)): ?>
                <table class="staff">
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Birthday</th>
                    </tr>
                        <?php foreach ($aData as $oData): ?>
                    <tr class="listing">
                        <td class="table_name"><?php $oData->show('first_name')?> <?php $oData->show('last_name') ?></td>
                        <td class="table_department"><?php $oData->show('department', '/') ?></td>
                        <td class="table_phone"><?php $oData->show('phone') ?></td>
                        <td class="table_email"><a href="mailto:<?php $oData->show('email')?>"><?php $oData->show('email')?></a></td>
                        <?php 
                            $sBirthday = ($oData->get('birthday'))?date('m/d', strtotime($oData->get('birthday'))):'';
                        ?>
                        <td class="table_birthday"><?php echo $sBirthday ?></td>
                    </tr>
                        <?php endforeach; ?>
                </table>
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

