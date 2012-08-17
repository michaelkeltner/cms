
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
            <div id="header"><div class="placeholderLeft"></div><div class="placeholderRight"></div><a href="/" id="Logo" title="Academic HealthPlans"><img src="/site/includes/images/AHP-Logo.jpg" alt="Academic HealthPlans" /></a><div id="needAssistance" style="width:290px; text-align: right;"><div class="placeholderLeft"></div><div>Need Assistance? <span id="thenumber1">&nbsp;(855) 247-2273&nbsp;&nbsp;</span><span id="thenumber2">(855) AHP-CARE</span></div></div>
                <div id="globalLinks"><a href="/login_member.asp">Student Login</a>|<a href="/universityAdministrator/">University Administrator Login</a></div>
            </div>

            <div id="footer">
                <div style="position:absolute;text-align:right;margin-right:400px;right:0px;margin-top:30px;height:60px;">
                    <a href="http://www.adobe.com/products/acrobat/readstep2.html" target="_blank" onClick="javascript: pageTracker._trackPageview('/outbound/www.adobe.com/products/acrobat/readstep2.html');"><img border="0px" src="/site/includes/images/get_adobe_reader8.gif" /></a>
                    <a href="http://www.facebook.com/pages/Academic-HealthPlans-Student-Health-Insurance/21359709899" target="_blank" onClick="javascript: pageTracker._trackPageview('/facebook/');"><img border="0px" src="/site/includes/images/facebook.gif" /></a>
                </div>
                <div class="placeholderLeft"></div><div class="placeholderRight"></div><div id="footerLinks"><a href="/<?php echo getParam(1) ?>/<?php echo getParam(2) ?>/">Home</a>|<a href="/<?php echo getParam(1) ?>/<?php echo getParam(2) ?>/contact/">Contact Us</a>|<a href="/<?php echo getParam(1) ?>/<?php echo getParam(2) ?>/hippa/">HIPAA</a><!--|<a href="/">Sitemap</a>--></div><div id="copyright">&copy; <?php echo date("Y") ?> Academic HealthPlans, Inc.  |  All Rights Reserved</div></div>
            <div id="defineMinWidth"></div>
            <div id="content">
                <img src="/site/includes/images/px.gif" id="defineMinHeight" />
                <h1 id="schoolName" style="width: 75%; margin: 0; padding: 0; top: 7px; left: 7px; position: relative; font-family: 'Times New Roman';"><?php echo $oRender->getSchoolNameFromSlug($sSchoolSlug) ?></h1>

                <div id="column0" style="height:547px"><img src="/site/includes/images/school.jpg" style="margin: 0; padding: 0;" />
                    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Main'); ?>
                    <?php if (count($aContent) > 0): ?>
                        <ul class="sidebar_links">
                            <li class="formatFix"><div>&nbsp;</div></li>
                            <? foreach ($aContent as $oContent): ?>
                                <li><?php echo $oContent->content ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <br/>
                </div>

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