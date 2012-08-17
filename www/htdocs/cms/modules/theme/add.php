<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'theme';
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
if (formSubmit()) {
    $oClass = new Theme();
    $oClass->upload(postVar('display_name'));
    if ($oClass->hasErrors()) {
        foreach ($oClass->getErrors() as $sError) {
            $sMessage .= $sError . '<br/>';
        }
        $sMessageClass = ' error';
    } else {//re-direct to the listing view and they will see the asset
        $_SESSION['sMessage'] = 'Theme added';
        $_SESSION['sMessageClass'] = 'added';
        gotoURL('/cms/theme/list');
    }
}

?>

<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
</div>


    <form class="form" action="" method="post" enctype="multipart/form-data">
         <p class="name">
            <input type="file" name="file" id="file" />
            <label for="name"></label>
        </p>
        <p class="name">
            <input type="text" name="display_name" id="display_name" />
            <label for="name">Display Name</label>
        </p>
        <p class="submit">
            <input type="submit" value="add" />
        </p>
    </form>
</body>
</html>