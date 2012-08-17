<!DOCTYPE html>
<?php
require_once('../../app/includes/config.php');
require_once('../../app/includes/init.php');
require_once('../../app/includes/functions.php');
$oSchool = new School();
$aSchools = $oSchool->getAllActive();
?>
<html>
    <head>
        <script type="text/javascript" language="javascript" src="/includes/js/jquery-1.7.1.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/includes/js/init.js" ></script>
        <link href="/includes/themes/schoollist.css" rel="stylesheet" type="text/css" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <div id="wrapper" class="rounded-corners">
            <div id="title">AHP Schools</br>
                <input type="text" id="search_school" placeholder='Search' class="search"/>
            </div>
            
            <div id="button">
                <ul>
                    <?php if (count($aSchools)): ?>
                        <?php foreach ($aSchools as $oSchool): ?>
                            <li><a href="http://ahpcare.com/<?php echo $oSchool->slug ?>/" target="_blank"><?php echo $oSchool->name ?></a></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No schools available</p>
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

