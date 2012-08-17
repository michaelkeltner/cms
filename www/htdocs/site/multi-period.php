

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<?php
require_once('../../app/includes/config.php');
require_once('../../app/includes/init.php');
require_once('../../app/includes/functions.php');

$oRender = new Render();

$sSchoolSlug = Render::getSchoolSlug();
$aPeriods = $oRender->getActivePeriodCoverage($sSchoolSlug);
?>
<html>
<head>

<style type="text/css">
.alart_message{
	font-family: Arial;
	font-size: 13px;
	width: 660px;
	margin: 20px 5px 0 245px;
	height: px;
	padding: 10px 10px 10px 10px;
	border-bottom: 1px solid #f00;
	color: #000;
	background-color: #fdd;
}
</style>

<title><?php echo $oRender->getSchoolNameFromSlug($sSchoolSlug) ?> Student Health Insurance | Academic HealthPlans, Inc.</title>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta name="description" content="Academic HealthPlans, Inc. Affordable Student Health Insurance. Health Plans for students attending Oklahoma Christian University." />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="en-us" />
<link rel="stylesheet" type="text/css" href="/site/includes/themes/<?php echo $oRender->getThemeFile($sSchoolSlug)?>" />
<style type="text/css">
.ahpplus-link{
	color:#333333;
	font-size:13px;
	font-variant:small-caps;
	font-weight:bold;
	text-decoration:none;
}
a.ahpplus-link:hover{
	color:#111111;
	text-decoration:underline;
}
#thenumber2{
	display:none;
}
#needAssistance{padding-left:3px;}
</style>
<!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/styles/ahp-ie.css" /><![endif]-->
<script src="/includes/js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
function intNumber(){
	$('#thenumber2').fadeOut('2000', function(){
		//$('#needAssistance').animate({width: '-=15'}, 700, function() {});
		//$('#thenumber1').animate({width: '-=15'}, 700, function(){});
		$('#thenumber1').fadeIn('2000', function(){
			setTimeout("textNumber()", 5000);
		});
	});
}
function textNumber(){
	//$('#needAssistance').animate({width: '+=15'}, 432, function(){});
	//$('#thenumber1').animate({width: '+=15'}, 432, function(){});
	$('#thenumber1').fadeOut('2000', function(){
		$('#thenumber2').fadeIn('1000', function(){
			setTimeout("intNumber()", 5000);
		});
	});
}
setTimeout("textNumber()", 5000);
</script>
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
<body id="pageYearSelect" class="twoColumn">
<div id="container">
	<div id="header"><div class="placeholderLeft"></div><div class="placeholderRight"></div><a href="/" id="Logo" title="Academic HealthPlans"><img src="/site/includes/images/AHP-Logo.jpg" alt="Academic HealthPlans" /></a><div id="needAssistance" style="width:290px; text-align: right;"><div class="placeholderLeft"></div><div>Need Assistance? <span id="thenumber1">&nbsp;(855) 247-2273&nbsp;&nbsp;</span><span id="thenumber2">(855) AHP-CARE</span></div></div>
<div id="globalLinks"><a href="/login_member.asp">Student Login</a>|<a href="/universityAdministrator/">University Administrator Login</a></div>
</div>

<div id="footer">
<div style="position:absolute;text-align:right;margin-right:400px;right:0px;margin-top:30px;height:60px;">
	<a href="http://www.adobe.com/products/acrobat/readstep2.html" target="_blank" onClick="javascript: pageTracker._trackPageview('/outbound/www.adobe.com/products/acrobat/readstep2.html');"><img border="0px" src="/site/includes/images/get_adobe_reader8.gif" /></a>
	<a href="http://www.facebook.com/pages/Academic-HealthPlans-Student-Health-Insurance/21359709899" target="_blank" onClick="javascript: pageTracker._trackPageview('/facebook/');"><img border="0px" src="/site/includes/images/facebook.gif" /></a>
</div>
<div class="placeholderLeft"></div><div class="placeholderRight"></div><div id="footerLinks"><a href="/<?php echo getParam(1)?>/">Home</a>|<a href="<?php echo getParam(1)?>/contact/">Contact Us</a>|<a href="<?php echo getParam(1)?>/hipaa/">HIPAA</a><!--|<a href="/">Sitemap</a>--></div><div id="copyright">&copy; <?php echo date("Y") ?> Academic HealthPlans, Inc.  |  All Rights Reserved</div></div>
<div id="defineMinWidth"></div>
<div id="content">
<img src="/site/includes/images/px.gif" id="defineMinHeight" />

<h1 id="schoolName" style="width: 75%; margin: 0; padding: 0; top: 7px; left: 7px; position: relative; font-family: 'Times New Roman';">Oklahoma Christian University</h1>

<div id="column0" style="$column0_height|height:425px"><img src="/site/includes/images/school.jpg" style="margin: 0; padding: 0;" />
<ul class="sidebar_links">
<li class="formatFix"><div>&nbsp;</div></li>
<?php $aMultiContent = $oRender->getColumnContent($sSchoolSlug, $aPeriods[0]->period_slug, 'Multi Periods Main');?>
<?php if (count($aMultiContent)):?>
    <?php foreach ($aMultiContent as $oMultiContent):?>
        <li><?php echo $oMultiContent->content?></li>
    <?php endforeach;?>
<?php endif;?>
</ul>
<br/>
</div>
<?php $i = 1; ?>
<?php foreach($aPeriods as $oPeriod): ?>
<div id="column<?php echo $i++?>">
    <?php $aMultiContent = $oRender->getColumnContent($sSchoolSlug, $oPeriod->period_slug, 'Multi Period Description');?>
    <?php if (count($aMultiContent)):?>
    <?php foreach ($aMultiContent as $oMultiContent):?>
    <span style="color: #000;"><?php echo $oMultiContent->content?></span><br/>
    <?php endforeach;?>
    <?php endif;?>
</div>
<?php endforeach;?>

<br style="clear: left;" />
</div>		
</div></body>
</html><!--73-->