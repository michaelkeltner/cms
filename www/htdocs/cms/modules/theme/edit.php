<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'theme';
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';
 $oClass = new Theme();
if (formSubmit()) {
    $bResults = $oClass->updateItem(postVar('id'), postVar('name') );
    if ($bResults > 0) {
        $sMessage = 'Theme updated.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/theme/list');
    } else {
        $sMessage = 'The entry was not updated.';
        $sMessageClass = ' error';
    }
}

//load the school
$iItemId = getParam(4);
$oItem = $oClass->getWithId($iItemId);
if (!$oItem){
    gotoURL(BASE_URL . '/cms/theme/list/');
    exit;
}

?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="edit_theme" method="post" action="">
        <input type="hidden" name="id"  value="<?php echo $iItemId ?>" />
        <input type="hidden" name="item"  value="theme" />
        <p class="name">
            <input type="text" name="name" id="name" value="<?php echo $oItem->css_file?>" disabled="disabled" class="disabled"/>
            <label for="name">File</label>
        </p>
        <p class="name">
            <input type="text" name="name" id="name" value="<?php echo $oItem->name?>"/>
            <label for="name">Name</label>
        </p>
        <p class="submit">
            <input type="submit" value="update" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>