<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<?php
require_once('../../app/includes/config.php');
require_once('../../app/includes/init.php');
require_once('../../app/includes/functions.php');

$oRender = new Render();
$sSchoolSlug = Render::getSchoolSlug();
$sPeriodSlug = Render::getPeriodSlug();
?>
<html>
    <head>
        <title><?php echo $oRender->getSchoolNameFromSlug($sSchoolSlug) ?> Student Health Insurance | Academic HealthPlans, Inc.</title>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta name="description" content="Academic HealthPlans, Inc. Affordable Student Health Insurance. Health Plans for students attending <?php echo $oRender->getSchoolNameFromSlug($sSchoolSlug) ?>." />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="en-us" />
        <link rel="stylesheet" type="text/css" href="/site/includes/themes/ahp.css" />
        <style type="text/css">

        </style>
        <link href="/site/includes/themes/alamo1112.css" type="text/css" rel="stylesheet"><!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/styles/ahp-ie.css" /><![endif]-->
        <script src="/site/includes/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="/site/includes/js/init.js" type="text/javascript"></script>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            var pageTracker = _gat._getTracker("UA-1135227-1");
            pageTracker._initData();
            pageTracker._trackPageview();
        </script>
    </head>
    <body id="pageSchoolHome" class="threeColumn">
        <div id="container">
            <div id="defineMinWidth"></div>
            <div id="content">
                <img src="/site/includes/images/px.gif" id="defineMinHeight" />
                <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Alert'); ?>
                <?php if ($aContent)://then show the alert div?>
                    <div class="MSG_homepage">
                            <? foreach ($aContent as $oContent): ?>
                                <strong><?php echo $oContent->content ?></strong><br/>
                            <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div id="column1" style="height:547px"><img src="/site/includes/images/enrollment.jpg" />
                    <h2 class="sectionTitle">Enrollment</h2>
                    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Enrolment'); ?>
                    <?php if (count($aContent) > 0): ?>
                        <ul>
                            <li class="formatFix"><div>&nbsp;</div></li>
                            <? foreach ($aContent as $oContent): ?>
                                <li><?php echo $oContent->content ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <br />
                    <a href="https://www.academichealthplans.com/login_member.asp">Student Login</a>
                </div>
                <div id="column2" style="height:547px">
                    <img src="/site/includes/images/benefits.jpg" />
                    <h2 class="sectionTitle">Benefits</h2>
                    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Benefits'); ?>
                    <?php if (count($aContent) > 0): ?>
                        <ul>
                            <li class="formatFix"><div>&nbsp;</div></li>
                            <? foreach ($aContent as $oContent): ?>
                                <li><?php echo $oContent->content ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div id="column3" style="height:547px"><img src="/site/includes/images/claims.jpg" />
                    <h2 class="sectionTitle">Claims</h2>
                    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Claims'); ?>
                    <?php if (count($aContent) > 0): ?>
                        <ul>
                            <li class="formatFix"><div>&nbsp;</div></li>
                            <? foreach ($aContent as $oContent): ?>
                                <li><?php echo $oContent->content ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <br style="clear: left;" />
            </div>		
        </div></body>
</html>
