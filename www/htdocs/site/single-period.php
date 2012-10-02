<?php
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
                
                <?php
                
                ?>
                
            </div>
            <div id="content">
                <div class="school_content patch">
                <?php
                $aImages = $oData->get('banner');
                $sBannerImage = '<img src="http://' . BASE_URL . '/assets/images/' . $aImages[0]->name . '" class="banner"/>';
                echo $sBannerImage;
                $oData->show('school', '', '', '', array('h2'));
                $oData->show('content');
                ?>
                </div>
                
                 
                <?php
                $aSections = array('main', 'enrollment', 'benefit', 'claim');
                $aImages = $oData->get('section_image');
                foreach ($aSections as $sSection) :
                    $aDocs = $oData->get($sSection . '_files');
                    $aLinks = $oData->get($sSection . '_links');
                    if ($sSection == 'main'){
                    $sTitle = 'General Information';
                    $sDivClass = 'sidebar_links patch';
                    $oImage = null;
                    }else{
                        $sDivClass = 'section patch';
                        $sTitle = ucfirst($sSection);
                        $oImage = array_shift($aImages);
                    }
                    if (count($aDocs) || count($aLinks)):
                    ?>
                        <div class="<?php echo $sDivClass ?>">
                            <?php if($oImage):?>
                            <img src="http://<?php echo BASE_URL?>/assets/images/<?php echo $oImage->name?>" class="section_banner"/>
                            <?php endif?>
                            <h3><?php echo $sTitle?></h3>
                            <?php if (count($aDocs)):?>
                                <h4>Documents</h4>
                                <ul class="section_listing">
                                <?php foreach ($aDocs as $oDoc):?>
                                    <li><a href="http://<?php echo BASE_URL?>/assets/docs/<?php echo $oDoc->name?>" class="embed" alt="<?php echo $oDoc->display_name ?>"/><?php echo $oDoc->display_name ?></a></li>
                                 <?php endforeach;?>
                                 </ul>
                             <?php endif;?>
                             <?php if (count($aLinks)):?>
                                <h4> Useful Links</h4>
                                <ul class="section_listing">
                                <?php foreach ($aLinks['url'] as $iIndex=>$sURL):?>
                                    <li><a href="<?php echo $sURL?>" alt="<?php echo $aLinks['display'][$iIndex]?>" <?php if ($aLinks['target'][$iIndex] != '_self'):?>target="<?php echo $aLinks['target'][$iIndex]?>"<?php endif;?>/><?php echo $aLinks['display'][$iIndex]?></a></li>
                                 <?php endforeach;?>
                                 </ul>
                             <?php endif;?>
                                
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
                <div class="clear_both"></div>
            </div>
            <?php
            include_once('includes/footer.php');
            exit;
            ?>

