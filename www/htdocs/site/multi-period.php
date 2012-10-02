<?php


$oData = $aData[0];
$oSchool = new Render('school');
$oSchool->where('slug|=|' . getParam(1));
$aSchoolData = $oSchool->getData();
$oSchoolData = $aSchoolData[0];

        
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php $oData->show('school'); echo ' '; $oData->show('period');?></title>
        <?php
        $aCSSFiles = $oData->get('css');
        //load any CSV Files
        if (count($aCSSFiles)) {
            foreach ($aCSSFiles as $oFile) {
                echo '<link href="http://' . BASE_URL . '/assets/docs/' . $oFile->name . '" rel="stylesheet" type="text/css" />';
            }
        }
        ?>
    </head>
    <body>
        <div id="phone" class="patch">
            <ul class="phone">
                <li>(855) AHP-CARE</li>
                <li>(855) 247-2273</li>
            </ul>
        </div>
        <div id="wrapper">
            <div id="page_logo">
                <img src="http://<?php echo BASE_URL ?>/site/includes/images/AHP-Logo.jpg"/>
            </div>
            <div id="header">
                
                <ul id="header_links">
                    <li><a href="<?php echo currentURL() ?>" title="home">home</a></li>
                    <li><a href="<?php echo currentURL() . '/faq' ?>" title="faq">FAQ</a></li>
                    <li><a href="<?php echo currentURL() . '/contact' ?>" title="contact">contact</a></li>
                </ul>
                <ul id="login_links">
                    <li><a href="https://www.academichealthplans.com/login_member.asp?cookie_check=1" target="_blank">Student Login</a></li>
                    <li><a href="https://www.academichealthplans.com/universityAdministrator/" target="_blank">University Administrator Login</a></li>
                </ul>
            </div>
            <div id="content">
                <div class="multi-banner">
                    <?php $oSchoolData->show('logo'); ?>
                </div>
                <div class="section patch">
                    <h2><?php $oData->show('school');?></h2>
                    <a href="http://<?php echo $oData->get('school|school_url')?>" target="_blank"><?php $oData->show('school');?> website</a></li><br/>
                    <a href="http://<?php echo $oData->get('school|school_health_url')?>" target="_blank"><?php $oData->show('school');?> Health department website</a>
                </div>
                <?php foreach ($aData as $oData) :?>
                    <div class="section patch">
                        <div class="period_list">
                            <h3><a href="<?php echo currentURL() . $oData->get('period|slug') ?>"><?php echo $oData->get('period|name') ?></a></h3>
                            <?php echo $oData->get('period|description')?><br/>
                            <a href="<?php echo currentURL() . $oData->get('period|slug') ?>"><?php echo $oData->get('period|name') ?></a></div>
                        </div>
                <?php endforeach;?>
                <div class="clear_both"></div>
            </div>
            <?php
            include_once('includes/footer.php');
            exit;
            ?>

