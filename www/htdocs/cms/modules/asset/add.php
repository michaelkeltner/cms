<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'asset';
require_once (CMS_INCLUDES . 'header.php');
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

$oClass = new School();
$aSchools = $oClass->getAllActive();
?>

<div class="message">
    <?php echo $sMessage; ?>
</div>
</div>
<?php if (count($aSchools)): ?>

    <form class="form" action="" method="post" enctype="multipart/form-data">
         <p class="name">
            <input type="file" name="file" id="file" />
            <label for="name"></label>
        </p>
        <p class="name">
            <input type="text" name="display_name" id="display_name" />
            <label for="name">Display Name</label>
        </p>
        <p class="name">
            <select name="school_slug">
                <option value="ahp-global">All Schools</option>
                <?php foreach ($aSchools as $oItem): ?>
                    <option value="<?php echo $oItem->slug ?>"><?php echo $oItem->name ?></option>
                <?php endforeach; ?>
            </select>
            <label for="school_slug">School</label>
        </p>
       
        <p class="submit">
            <input type="submit" value="add" />
        </p>
    </form>

<?php else: ?>
    There are no schools available to load an asset for
    <div class="add_link">
        <a href="/cms/school/add/" alt="add school"><img src="images/add.png"/>Add School</a>
    </div>
<?php endif; ?>
</body>
</html>