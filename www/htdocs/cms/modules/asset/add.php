<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'asset';
$sMessage = '';
if (formSubmit()) {
    $oClass = new Asset();
    $oClass->upload(postVar('school_slug'), postVar('display_name'));
    if ($oClass->hasErrors()) {
        foreach ($oClass->getErrors() as $sError) {
            $sMessage .= $sError . '<br/>';
        }
    } else {//re-direct to the listing view and they will see the asset
        $_SESSION['sMessage'] = 'Asset added';
        $_SESSION['sMessageClass'] = ' added';
        gotoURL('/cms/asset/list');
    }
}


require_once (CMS_INCLUDES . 'header.php');
?>
<div id="wrapper">
    <div class="message">
        <?php echo $sMessage; ?>
    </div>
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
</div>
</body>
</html>