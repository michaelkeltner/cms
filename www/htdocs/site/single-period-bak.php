
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
$aImages = $oData->get('banner');
$sBannerImage = '<img src="http://' . BASE_URL  . '/assets/images/' . $aImages[0]->name . '" class="banner"/>';

$oData->show('school', '', $sBannerImage, '', array('div class="header"'), true);
$oData->show('main_files', '', 'Main Files: <br/>', '', array('div class="main_links"'), true);
$oData->show('enrollment_files', '', 'Enrollment Files: <br/>', '', array('div class="enrollment_links"'), true);
$oData->show('benefit_files', '', 'Benefit links: <br/>', '', array('div class="benefit_links"'), true);
$oData->show('claim_files', '', 'Claim Files: <br/>', '', array('div class="claim_links"'), true);
$oData->show('section_image', '', '', '', array('div class="banner"'));
?>

