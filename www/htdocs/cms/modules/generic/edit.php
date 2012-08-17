<?php
//used to determine the menu link that should have the class "active" on it
$iItemId = getParam(4);
$oClass = new $sClass();
$oItem = $oClass->getWithId($iItemId);
if (!$oItem){
    gotoURL(BASE_URL . '/cms/'.$sModule.'/list/');
    exit;
}
$aDBSchema = $oClass->getTableInfo();

require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';

if (formSubmit()) {
    $bResults = $oClass->updateItem($aDBSchema, $_POST);
    if ($bResults > 0) {
        $sMessage = $sModule . ' updated.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/'.$sModule.'/list');
    } else {
        $sMessage = 'The entry was not updated.';
        $sMessageClass = ' error';
    }
}

//load the item




?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_<?echo $sModule?>" method="post" action="">
         <input type="hidden" name="item"  value="<?echo $sModule?>" />
        <?php foreach($aDBSchema as $oPropery):?>
        <?php if ($oPropery->Field == 'id'):?>
            <input type="hidden" name="id"  value="<?php echo $iItemId ?>" />
            <?php elseif($oPropery->Field == 'create_date' || $oPropery->Field == 'modify_date'):?>
            <?php //do nothing for the create and modify dates ?>
            <?php else:?>
            <?php $sProperty = $oPropery->Field ?>
            <p class="name">
            <input type="text" name="<?php echo $sProperty?>" id="<?php echo $sProperty?>" value="<?php echo $oItem->{$sProperty}?>"/>
            <label for="name"><?php echo str_replace('_', ' ', ucwords($sProperty))?></label>
        </p>
            <?php endif;?>
        <?php endforeach; ?>
        <p class="submit">
            <input type="submit" value="update" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>