<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'content';


require_once (CMS_INCLUDES . 'header.php');

$sSchoolSlug = getParam(4);
$sPeriodSlug = getParam(5);

$oSchool = new School();
$oPeriod = new Period();

$oCurrentSchool = $oSchool->getWithSlug($sSchoolSlug);
$oCurrentPeriod = $oPeriod->getWithSlug($sPeriodSlug);
if (!( $oCurrentSchool && $oCurrentPeriod)) {
    prePrint($oCurrentSchool);
    prePrint($oCurrentPeriod);exit;
    //not a valid school or period
    gotoURL('/cms/content/list/');
}
$oSchoolPeriod = new SchoolPeriod();
$oSection = new Section();
$oContent = new Content();
$oAsset = new Asset();
$oData = new stdClass();
$iSchoolId = $oCurrentSchool->id;
$iPeriodId = $oCurrentPeriod->id;
$oData->content = $oContent->getAllBySchoolPeriod($iSchoolId, $iPeriodId);
$aImageOptions = array();
$aDocOptions = array();
$aImageOptions = $oAsset->getImagesForSchool($iSchoolId);
$aDocOptions = $oAsset->getDocsForSchool($iSchoolId);
$aSections = $oSection->getAll();
$sMessage = '';
$sMessageClass = '';
$bDeleteResults = false;
if (formSubmit()) {
    
    //$iSectionId = postVar('section_id');
    $sStartDate = date("Y-m-d", strtotime(postVar('period_start')));
    $sEndDate = date("Y-m-d", strtotime(postVar('period_end')));
    if (postVar('start_end_id') > 0) {
        $oSchoolPeriod->updateSchoolPeriodCoverage(postVar('start_end_id'), $sStartDate, $sEndDate);
    } else {
        $oSchoolPeriod->addItem($iSchoolId, $iPeriodId, $sStartDate, $sEndDate);
    }
    $aContentType = postVar('type');
    $aAllContent = postVar('content');

    if (count($aContentType) == 0){
         foreach ($aSections as $oSection){//$aContentType as $iSectionId => $aTypes) {
            $iSectionId = $oSection->id;
            //there is no content for thise section so we will delete all
            $oContent->deleteSchoolPeriodSection($iSchoolId, $iPeriodId, $iSectionId);
        }
        $sMessage = 'content updated.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/content/list/');
        exit;
    }else{
        
        foreach ($aSections as $oSection){//$aContentType as $iSectionId => $aTypes) {
            $iSectionId = $oSection->id;
            if (!isset($aContentType[$iSectionId])){
                //there is no content for thise section so we will delete all
                //items that may be in the DB for this section
                $oContent->deleteSchoolPeriodSection($iSchoolId, $iPeriodId, $iSectionId);
                //go to the next section
                continue;
            }
            $aTypes = $aContentType[$iSectionId];
            $iIdArray = array();
            $aContent = $aAllContent[$iSectionId];
            $iTextCounter = 0;
            $iLinkCounter = 0;
            $iAllCounter = 0;
            $iImageCounter = 0;
            $iDocCounter = 0;
            foreach ($aTypes as $iSortOrder => $sType) {

                if ($sType == 'link') {
                    $sDisplay = $aContent['display'][$iLinkCounter];
                    $sURL = $aContent['url'][$iLinkCounter];
                    if (substr($sURL, 0, 4) != 'http') {
                        $sURL = 'http://' . $sURL;
                    }
                    $sTarget = $aContent['target'][$iLinkCounter++];
                    $sContent = serialize(array('display' => $sDisplay, 'url' => $sURL, 'target' => $sTarget));
                
                }else {
                    $sContent = $aContent[$iTextCounter++];
                    
                }
                //concat the dates and times to create the sql datetime formatted sting
                $sStartDate = date("Y-m-d", strtotime($aContent['component_start_date'][$iAllCounter])) . ' ' . date("H:i:s", strtotime($aContent['component_start_time'][$iAllCounter]));
                $sEndDate =  date("Y-m-d", strtotime($aContent['component_end_date'][$iAllCounter])) . ' ' . date("H:i:s", strtotime($aContent['component_end_time'][$iAllCounter++]));
                $iIdArray[] = $oContent->addItem($iSectionId, $sContent, $iSortOrder, $iPeriodId, $iSchoolId, $sType, $sStartDate, $sEndDate);
            }
            //if we were able to load entries the delte the previous ones
            if (count($iIdArray)){
               $bDeleteResults = $oContent->deleteSchoolPeriodSection($iSchoolId, $iPeriodId, $iSectionId, $iIdArray);
            }
        }
    }
    if (!isset($iId)) {
        if ($bDeleteResults) {
            $sMessage = 'content updated.';
            $sMessageClass = ' added';
            $_SESSION['sMessage'] = $sMessage;
            $_SESSION['sMessageClass'] = $sMessageClass;
            gotoURL('/cms/content/list/');
            exit;
        }
    } else {
        if ($iId > 0) {
            $sMessage = 'content updated.';
            $sMessageClass = ' added';
            $_SESSION['sMessage'] = $sMessage;
            $_SESSION['sMessageClass'] = $sMessageClass;
            gotoURL('/cms/content/list/');
            exit;
        } else {
            $sMessage = 'content was not updated.';
            $sMessageClass = ' error';
        }
    }
}

?>

<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div id ="watermark" >
    <h3><?php echo $oCurrentSchool->name ?></h3>
    <h4><?php echo $oCurrentPeriod->name ?></h4>
</div>
<!--  Setup the section tabs !-->


<div class="form">
    <form class="add_data noEnterSubmit" id="add_content" method="post" action="">
        <?php $aSchoolPeriod = $oSchoolPeriod->getAllWithId($iSchoolId, $iPeriodId)?>
        <?php $oThisSchoolPeriod = $aSchoolPeriod[0]; ?>
            <p class="period_start">
                <input class="date_picker" type="text" name="period_start" id="period_start" value="<?php echo date("m/d/Y", strtotime($oThisSchoolPeriod->start_date)) ?>"/>
                <label for="period_start">Start Date</label>
            </p>
            <p class="period_end">
                <input class="date_picker" type="text" name="period_end" id="period_end" value="<?php echo date("m/d/Y", strtotime($oThisSchoolPeriod->end_date)) ?>"/>
                <label for="period_end">End Date</label>
            </p>
            <input type="hidden" id="start_end_id" name="start_end_id" value="<?php echo $oThisSchoolPeriod->id ?>"/>
        <?php foreach ($aSections as $oSectionItem): ?>
        <?php $iSectionId = $oSectionItem->id; ?>
        <?php $aData = $oContent->getSectionContentBySectionId($iSchoolId, $iPeriodId, $oSectionItem->id); ?>
         <div id="<?php echo $iSectionId ?>" class="sortable section_content show_hide_control">
                <?php if (count($aData)): ?>
                    <div id="section_<?php echo $aData[0]->id ?>" class="sortable">
                        <?php
                        foreach ($aData as $oDataItem) {
                            switch ($oDataItem->type) {
                                case "text":
                                    $sValue = $oDataItem->content;
                                    $sFile = 'text.php';
                                    break;
                                case "header":
                                    $sValue = $oDataItem->content;
                                    $sFile = 'header.php';
                                    break;
                                case "link":
                                    $aDataSet = unserialize($oDataItem->content);
                                    $sDisplay = $aDataSet['display'];
                                    $sURL = $aDataSet['url'];
                                    $sTarget = $aDataSet['target'];
                                    $sFile = 'link.php';
                                    break;
                                case "doc":
                                    $sSelected = $oDataItem->content;
                                    $sFile = 'doc.php';
                                    break;
                                case "image":
                                    $sSelected = $oDataItem->content;
                                    $oImage = $oAsset->getWithId($sSelected);
                                    $sPreview = '<img src="/assets/' . $oImage->school_slug . '/images/' . $oImage->name.'"/>';
                                    $sFile = 'image.php';
                                    break;
                            }
                            $sStartDate = date("m/d/Y", strtotime(substr($oDataItem->start_date, 0, 10)));
                            $sStartTime = substr($oDataItem->start_date, 11,8);
                            $sEndDate = date("m/d/Y", strtotime(substr($oDataItem->end_date, 0, 10)));
                            $sEndTime = substr($oDataItem->end_date, 11,8);
                            $sClass = '';
                            include(CMS_INCLUDES . 'components/' . $sFile);
                        }
                        ?>
                    </div>
    <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <p class="submit" style="display: block; ">
            <input type="submit" value="Submit">
        </p>
    </form>
    <div class="add_buttons">
        <span class="add_text"><img src="/cms/images/add-text.png" alt="add content"/></span>
        <span class="add_link"><img src="/cms/images/add-link.png" alt="add a link"/></span>
        <span class="add_header"><img src="/cms/images/add-header.png" alt="add a header"/></span>
        <?php if (count($aDocOptions)):?>
        <span class="add_doc"><img src="/cms/images/add-document.png" alt="add a document"/></span>
        <?php endif;?>
        <?php if (count($aImageOptions)):?>
        <span class="add_image"><img src="/cms/images/add-image.png" alt="add an image"/></span>
        <?php endif;?>
    </div>
    
 <div id="middle_left" class="sortable visible_div">
        <?php if (count($aSections)): ?>
            <ul id="section_listing">
                <?php foreach ($aSections as $oSection): ?>
                    <button type="button" class="btn_section btn_section_inactive" name="section[]" value="<?php echo $oSection->id ?>"><?php echo $oSection->name ?></button>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
    <!-- used for jQuery Cloning !-->
<?php
//reset the values
$iSectionId = '';
$sValue = '';
$sClass = 'hide';
$sDisplay = '';
$sURL = '';
$sTarget = '';
$sSelected = '';
$sPreview = '';
if ($oThisSchoolPeriod->start_date){
    $sStartDate = date("m/d/Y", strtotime($oThisSchoolPeriod->start_date));
}else{
    $sStartDate = date("m/d/Y", strtotime(time()));
}
$sStartTime = '';
if ($oThisSchoolPeriod->end_date){
    $sEndDate = date("m/d/Y", strtotime($oThisSchoolPeriod->end_date));
}else{
    $sEndDate = date("m/d/Y", strtotime(time()));
}
$sEndTime = '';
foreach (scandir(CMS_INCLUDES . 'components') as $sFile) {
    if ($sFile == '.' || $sFile == '..'  || $sFile == 'start_end_date.php' || $sFile == 'action_buttons.php') {
        continue;
    }

    include(CMS_INCLUDES . 'components/' . $sFile);
}
?>
   

    <?php require_once (CMS_INCLUDES . 'footer.php'); ?>