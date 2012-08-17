<!DOCTYPE html>
<?php 

    require_once ('includes/header.php'); 
    $oRender = new Render(); 
    $sSchoolSlug = Render::getSchoolSlug();
    $sPeriodSlug = Render::getPeriodSlug();
    
?>

<div id="wrapper">
<!-- Main Banner !-->
    <div class="banner"><?php echo $oRender->getSchoolNameFromSlug($sSchoolSlug)?></div>
    <!-- Sub Banner !-->
    <div class="sub_banner"><?php echo $oRender->getPeriodNameFromSlug($sPeriodSlug)?></div>
    <!-- Warning/Alert (If there are any) !-->
    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Alert'); ?>
    <?php if ($aContent)://then show the alert div?>
    <div class="alert_content">
        <ul class="alert_content_listing">
            <? foreach($aContent as $oContent):?>
            <li><?php echo $oContent->content ?></li>
            <?php endforeach;?>
        </ul>
    </div>
    <?php endif;?>
    
    
    <!-- 1st Column !-->
    <div class="column_content">
    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Main'); ?>
    <?php if (count($aContent)>0):?>
        <ul class="column_content_listing">
            <? foreach($aContent as $oContent):?>
            <li><?php echo $oContent->content ?></li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
    <!-- 2nd Column !-->
    <div class="column_content">
    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Enrolment'); ?>
    <?php if (count($aContent)>0):?>
        <ul class="column_content_listing">
            <? foreach($aContent as $oContent):?>
            <li><?php echo $oContent->content ?></li>
            <?php endforeach;?>
            </ul>
        <?php endif;  //echo $oRender->showSiteContent(5, 1);?>
    </div>
    <!-- 3rd Column !-->
    <div class="column_content">
    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Benefits'); ?>
    <?php if (count($aContent)>0):?>
        <ul class="column_content_listing">
            <? foreach($aContent as $oContent):?>
            <li><?php echo $oContent->content ?></li>
            <?php endforeach;?>
            </ul>
        <?php endif;  //echo $oRender->showSiteContent(5, 1);?>
    </div>
    <!-- 4th Column !-->
    <div class="column_content">
    <?php $aContent = $oRender->getColumnContent($sSchoolSlug, $sPeriodSlug, 'Claims'); ?>
    <?php if (count($aContent)>0):?>
        <ul class="column_content_listing">
            <? foreach($aContent as $oContent):?>
            <li><?php echo $oContent->content ?></li>
            <?php endforeach;?>
            </ul>
        <?php endif;?>
    </div>
    
    
<?php require_once ('includes/footer.php'); ?>

