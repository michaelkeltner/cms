<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'asset';
require_once (CMS_INCLUDES . 'header.php');
$oAsset = new Asset();
$aItems = $oAsset->getAll(' ORDER BY `create_date` DESC');
if (isset($_SESSION['sMessage'])){
    $sMessage = $_SESSION['sMessage'];
    $sMessageClass = $_SESSION['sMessageClass'];
    unset($_SESSION['sMessageClass']);
    unset($_SESSION['sMessage']);
}else{
    $sMessage = '';
    $sMessageClass = '';
}
?>
<?php $oUser = new User()?>
<?php if ($oUser->canAccess('create')):?>
<div class="add_item">
    <a href="/cms/asset/add/" alt="add asset"><image src="/cms/images/add-item.png" alt="Add Asset"/></a>
</div>
<?php endif;?>
 <div id="listing_div">
<?php if (count($aItems)):?>
        <?php if ($sMessage != ''):?>
        <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
        <?php endif; ?>
        <ul>
        <?php $i = 0; ?>
        <?php foreach ($aItems as $oItem):?>    
            <?php $sAltClass = (++$i % 2 == 0)?'class="alt"':'' ?>
                <li <?php echo $sAltClass?>>
                    <div class="item_listing" id="item_<?php echo $oItem->id ?>">
                        <div class="listing_image">
                            <?php if ($oItem->type == 'image'): ?>
                                <img src="/assets/<?php echo $oItem->school_slug ?>/images/<?php echo $oItem->name ?>"/>
                            <?php else: ?>
                                <img src="/cms/images/document.png" width="128" height="128"/>
                            <?php endif; ?>
                        </div>
                        <div class="listing_text"><?php echo $oItem->display_name ?></div>
                        <div class="listing_text"><?php echo $oItem->school_slug ?></div>
                        <div class="listing_actions">
                            <?php if ($oUser->canAccess('delete')):?>
                            <a href="" rel="<?php echo $oItem->school_slug ?>" target="" alt="delete Asset" class="delete asset" id="<?php echo $oItem->id ?>"><img src="/cms/images/delete.png" alt="delte"></a>
                            <?php endif;?>
                       </div>
                       
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

<?php else: ?>
    <div class="message">No Assets available.</div>
<?php endif; ?>
        </div>
<?php require_once (CMS_INCLUDES . 'footer.php'); ?>