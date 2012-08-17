<?php
//used to determine the menu link that should have the class "active" on it

require_once (CMS_INCLUDES . 'header.php');
$sModule = 'module';
$oClass = new ModuleBuilder();
$aItems = $oClass->getAll(' ORDER BY `name` ASC');

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
<div  class="add_item">
    <a href="/cms/<?php echo $sModule ?>/add/" alt="add <?php echo $sModule ?>"><image src="/cms/images/add-item.png" alt="Add <?php echo $sModule ?>"/></a>
</div>
<?php endif; ?>
<div id="listing_div">
<?php if (count($aItems)):?>

        <?php if ($sMessage != ''):?>
        <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
        <?php endif; ?>
        <ul>
            <?php $i = 0; ?>
        <?php foreach ($aItems as $oItem):?> 
            <?php $sAltClass = (++$i % 2 == 0)?'class="alt"':'' ?>
            <li  <?php echo $sAltClass?>>
                <div class="item_listing" id="item_<?php echo $oItem->id ?>">
                    <div class="listing_text"><?php echo $oItem->name ?></div>
                    <div class="listing_actions">
                        <?php if ($oUser->canAccess('update')):?>
                        <a href="/cms/<?php echo $sModule ?>/edit/<?php echo $oItem->id ?>" target="_self" alt="edit <?php echo $sModule ?>"><img src="/cms/images/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;
                        <?php endif;?>
                        <?php if ($oUser->canAccess('delete')):?>
                        <a href="" target="" alt="delete <?php echo $sModule ?>" class="delete <?php echo $sModule ?>" id="<?php echo $oItem->id ?>"><img src="/cms/images/delete.png" alt="delte"></a>
                        <?php endif;?>
                    </div>
                </div>
            </li>

            <?php endforeach; ?>
        </ul>
    
    <?php
else:
    ?>
    <div class="message">No  <?php echo $sModule ?> available to list.</div>

<?php
endif;
?>

</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>