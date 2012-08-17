<?php
//used to determine the menu link that should have the class "active" on it
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';
$oClass = new $sClass();
$aDBSchema = $oClass->getTableInfo();

if (formSubmit()) {

    $iId = $oClass->addItem($aDBSchema, $_POST);
    if ($iId > 0) {
        $sMessage = $sModule . ' was added.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/' . $sModule .'/list');
    } else {
        $sMessage = 'Item was not added.';
        $sMessageClass = ' error';
    }
}
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_school" method="post" action="">
        <input type="hidden" name="item"  value="<? echo $sModule ?>" />
        <?php foreach ($aDBSchema as $oPropery): ?>
        <?php $aIgnore = array('id', 'modify_date', 'create_date');?>
            <?php if (!in_array($oPropery->Field, $aIgnore)): ?>
                <?php $sProperty = $oPropery->Field ?>
                <p class="name">
                    <input type="text" name="<?php echo $sProperty ?>" id="<?php echo $sProperty ?>"/>
                    <label for="name"><?php echo str_replace('_', ' ', ucwords($sProperty)) ?></label>
                </p>
            <?php endif; ?>
        <?php endforeach; ?>
        <p class="submit">
            <input type="submit" value="add" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>