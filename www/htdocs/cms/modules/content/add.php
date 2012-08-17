<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'content';
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';
$oSchool = new School();
$oSchoolPeriod = new SchoolPeriod();
$oPeriod = new Period();
$oSection = new Section();
$oContent = new Content();

if (formSubmit()) {
    
    //$iSectionId, $sContent, $iSortOrder, $iPeriodId, $iSchoolId
    $iSchoolId = postVar('school_id');
    $iPeriodId = postVar('period_id');
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
    
    if (count($aContentType)) {
        foreach ($aContentType as $iSection_id => $aTypes) {
            $bDeleteResults = $oContent->deleteSchoolPeriodSection($iSchoolId, $iPeriodId, $iSection_id);
            $aContent = $aAllContent[$iSection_id];
            $iTextCounter = 0;
            $iLinkCounter = 0;
            $iAllCounter = 0;
            $iImageCounter = 0;
            $iDocCounter = 0;

            foreach ($aTypes as $iSortOrder => $sType) {
                //concat the dates and times to create the sql datetime formatted sting
                $sStartDate = date("Y-m-d", strtotime($aContent['component_start_date'][$iAllCounter])) . ' ' . date("H:i:s", strtotime($aContent['component_start_time'][$iAllCounter]));
                $sEndDate =  date("Y-m-d", strtotime($aContent['component_end_date'][$iAllCounter])) . ' ' . date("H:i:s", strtotime($aContent['component_end_time'][$iAllCounter++]));
                if ($sType == 'link') {
                    $sDisplay = $aContent['display'][$iLinkCounter];
                    $sURL = $aContent['url'][$iLinkCounter];
                    if (substr($sURL, 0, 4) != 'http') {
                        $sURL = 'http://' . $sURL;
                    }
                    $sTarget = $aContent['target'][$iLinkCounter++];
                    $sContent = serialize(array('display' => $sDisplay, 'url' => $sURL, 'target' => $sTarget));
                    $iId = $oContent->addItem($iSection_id, $sContent, $iSortOrder, postVar('period_id'), postVar('school_id'), $sType, $sStartDate, $sEndDate);
                } else {
                    $sContent = $aContent[$iTextCounter++];
                    $iId = $oContent->addItem($iSection_id, $sContent, $iSortOrder, postVar('period_id'), postVar('school_id'), $sType, $sStartDate, $sEndDate);
                }
            }
        }
    }
    if (!isset($iId)) {
        if ($bDeleteResults) {
            $sMessage = 'content added.';
            $sMessageClass = ' added';
            $_SESSION['sMessage'] = $sMessage;
            $_SESSION['sMessageClass'] = $sMessageClass;
            gotoURL('/cms/content/list/');
            exit;
        }
    } else {
        if ($iId > 0) {
            $sMessage = 'content added.';
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

$aSchools = $oSchool->getAll();
$aPeriods = $oPeriod->getAll();
$aSections = $oSection->getAll();
?>

<?php //do not reload this section on the ajax call   ?>

<div class="form">
    <form class="add_data noEnterSubmit" id="add_content" method="post" action="">

        <p class="school_id period_id">
            <select name="school_id" class="school_select">
                <?php echo populateSelectOptions($aSchools); ?>
            </select>
            <label for="school_id">School</label>

            <select name="period_id" class="period_select">
                <?php echo populateSelectOptions($aPeriods); ?>
            </select>
            <label for="period_id">Period</label>
        </p>
        <div class="show_hide_control">
            <p class="period_start">
                <input class="date_picker" type="text" name="period_start" id="period_start" />
                <label for="period_start">Start Date</label>
            </p>
            <p class="period_end">
                <input class="date_picker" type="text" name="period_end" id="period_end" />
                <label for="period_end">End Date</label>
            </p>
            <input type="hidden" id="start_end_id" name="start_end_id" value=""/>
        </div>
        <br/>
        <?php if (count($aSections)): ?>
            <?php foreach ($aSections as $oSection): ?>
                <div id="<?php echo $oSection->id ?>" class="sortable section_content"></div>
            <?php endforeach; ?>
        <?php endif; ?>
        <p class="submit show_hide_control">
            <input type="submit" value="Submit" />
        </p>
    </form>
    <div class="add_buttons show_hide_control">
        <span class="add_text show_hide_control"><img src="/cms/images/add-text.png" alt="add more content"/></span>
        <span class="add_link show_hide_control"><img src="/cms/images/add-link.png" alt="add more content"/></span>
        <span class="add_link show_hide_control"><img src="/cms/images/add-header.png" alt="add a header"/></span>
        <span class="add_doc show_hide_control"><img src="/cms/images/add-document.png" alt="add more content"/></span>
        <span class="add_image show_hide_control"><img src="/cms/images/add-image.png" alt="add more content"/></span>
    </div>
    <div id="middle_left" class="sortable show_hide_control visible_div">
        <?php if (count($aSections)): ?>
            <ul id="section_listing">
                <?php foreach ($aSections as $oSection): ?>
                    <button type="button" class="btn_section btn_section_inactive" name="section[]" value="<?php echo $oSection->id ?>"><?php echo $oSection->name ?></button>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
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
    $sStartDate = date("m/d/Y", strtotime("today"));
    $sEndDate = date("m/d/Y", strtotime("+60 days"));
    $sEndTime = '';
    $sStartTime = '';
    $sPreview = '';
    foreach (scandir(CMS_INCLUDES . 'components') as $sFile) {
        if ($sFile == '.' || $sFile == '..' || $sFile == 'start_end_date.php' || $sFile == 'action_buttons.php') {
            continue;
        }

        include(CMS_INCLUDES . 'components/' . $sFile);
    }
    ?>




</div>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>



<?php require_once (CMS_INCLUDES . 'footer.php'); ?>