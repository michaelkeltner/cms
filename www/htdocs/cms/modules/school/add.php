<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'school';
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';
if (formSubmit()) {
    $oClass = new School();
    $iId = $oClass->addItem(postVar('name'), '', postVar('theme'), postVar('slug'));
    if ($iId > 0) {
        $sMessage = postVar('name') . ' added.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/school/list');
    } else {
        $sMessage = postVar('name') . ' was not added.';
        $sMessageClass = ' error';
    }
}


$oTheme = new Theme();
$aThemes = $oTheme->getAll();
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_school" method="post" action="">
        <p class="name">
            <input type="text" name="name" id="name" />
            <label for="name">School Name</label>
        </p>
        <p class="name">
            <input type="text" name="slug" id="slug" />
            <label for="slug">URL</label>
        </p>
        <?php if (count($aThemes)): ?>
            <p class="name">
                <select name="theme" id="theme">
                    <?php foreach ($aThemes as $oThemeOption): ?>
                        <option value="<?php echo $oThemeOption->id ?>"><?php echo $oThemeOption->name ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="theme">Page Theme</label>
            </p>
        <?php endif; ?>
        <p class="submit">
            <input type="submit" value="add" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>