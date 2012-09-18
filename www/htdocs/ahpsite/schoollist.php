<!DOCTYPE html>
<?php
if (getParam(2) == 'details'){
    include_once('ahpsite/schoollist_details.php');
    exit;
}
$oSchool = new Render('school');
$oSchool->order('`name` ASC');
$oSchool->limit(100);
$aSchools = $oSchool->getData();
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
            <div id="title">AHP Schools</br>
                <input type="text" id="search_school" placeholder='Search' class="search"/>
            </div>
            
            <div id="button">
                <ul>
                    <?php if (count($aSchools)): ?>
                        <?php foreach ($aSchools as $oData): ?>
                        <li><a href="<?php echo currentURL() . 'details/' . $oData->get('slug')?>" class="information_alert"><img src="includes/images/menu-information.png" /></a><a href="http://ahpcare.com/<?php $oData->show('slug') ?>/" target="_blank" class="school_website_url"><?php $oData->show('name') ?></a></li>
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

