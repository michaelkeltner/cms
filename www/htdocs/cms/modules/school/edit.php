<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'school';
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';
 $oClass = new School();
if (formSubmit()) {
    $bResults = $oClass->updateItem(postVar('name'), '', postVar('theme'), postVar('slug'), postVar('id'));
    if ($bResults > 0) {
        $sMessage = postVar('name') . ' updated.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/school/list');
    } else {
        $sMessage = 'The entry was not updated.';
        $sMessageClass = ' error';
    }
}

//load the school
$iSchoolId = getParam(4);
$oItem = $oClass->getWithId($iSchoolId);
if (!$oItem){
    gotoURL(BASE_URL . '/cms/school/list/');
    exit;
}

$oTheme = new Theme();
$aThemes = $oTheme->getAll();
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_school" method="post" action="">
        <input type="hidden" name="id"  value="<?php echo $iSchoolId ?>" />
        <input type="hidden" name="item"  value="school" />
        <p class="name">
            <input type="text" name="name" id="name" value="<?php echo $oItem->name?>"/>
            <label for="name">School Name</label>
        </p>
        <p class="name">
            <input type="text" name="slug" id="slug" value="<?php echo $oItem->slug?>"/>
            <label for="slug">URL</label>
        </p>
        <?php if (count($aThemes)): ?>
            <p class="name">
                <select name="theme" id="theme">
                    <?php foreach ($aThemes as $oThemeOption): ?>
                    <?php $sSelected = ($oItem->theme_id == $oThemeOption->id)?' selected="selected"' :''?>
                        <option value="<?php echo $oThemeOption->id ?>"<?php echo  $sSelected?>><?php echo $oThemeOption->name ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="theme">Page Theme</label>
            </p>
        <?php endif; ?>
        <p class="submit">
            <input type="submit" value="update" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>