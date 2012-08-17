<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'content';
require_once (CMS_INCLUDES . 'header.php');
$oSchool = new School();
$aItems = $oSchool->getAll();
$oContent = new Content();
$aItems = $oContent->getAllSchoolsWithContent();
if (isset($_SESSION['sMessage'])) {
    $sMessage = $_SESSION['sMessage'];
    $sMessageClass = $_SESSION['sMessageClass'];
    unset($_SESSION['sMessageClass']);
    unset($_SESSION['sMessage']);
} else {
    $sMessage = '';
    $sMessageClass = '';
}
?>
<?php $oUser = new User()?>
<?php if ($oUser->canAccess('create')):?>
<div  class="add_item">
    <a href="/cms/content/add/" alt="add Content"><image src="/cms/images/add-item.png" alt="Add <?php echo $sModule ?>"/></a>
</div>
<?php endif;?>
<?php if (count($aItems)): ?>
    <div id="listing_div">
        <?php if ($sMessage != ''): ?>
            <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
        <?php endif; ?>
        <ul>
            <?php $i = 0; ?>
            <?php foreach ($aItems as $sSchoolname=>$aItem): ?> 
                <?php $sAltClass = (++$i % 2 == 0) ? 'class="alt"' : '' ?>
                <li  <?php echo $sAltClass ?>>
                    
                    <div class="item_listing" id="item_<?php echo $i ?>">
                        <div class="listing_text"><?php echo $sSchoolname ?></div>
                         <ul class="sub_list">
                        <?php foreach ($aItem as $oItem):?>
                                    <li   <?php echo $sAltClass ?>>
                                        <?php if ($oUser->canAccess('update')):?>
                                            <a href="/cms/content/edit/<?php echo $oItem->school_slug ?>/<?php echo $oItem->period_slug ?>/"><?php echo $oItem->period_name ?></a>
                                        <?php else: ?>
                                            <?php echo $oItem->period_name ?>
                                        <?php endif;?>
                                        <div class="listing_actions">
                                            <?php if ($oUser->canAccess('update')):?>
                                            <a href="/cms/content/edit/<?php echo $oItem->school_slug ?>/<?php echo $oItem->period_slug ?>/" alt="edit content"><img src="/cms/images/edit.png" alt="edit"></a>
                                            <?php endif;?>
                                            <?php if ($oUser->canAccess('create')):?>
                                            <a href="" target="" alt="copy content" class="copy_content" id="<?php echo $oItem->school_slug . '~~' .  $oItem->period_slug . '~~' . $oItem->period_name ?>"><img src="/cms/images/copy.png" alt="copy"></a>
                                            <?php endif;?>
                                            <div class="copy_menu_options behind"></div>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="message">No Schools available for content.</div>
<?php endif; ?>



<?php require_once (CMS_INCLUDES . 'footer.php'); ?>