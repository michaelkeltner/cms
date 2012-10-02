<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'module';
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
    <a href="/cms/<?php echo $sModule ?>/add/" alt="add <?php echo $sModule ?>"><image src="/cms/images/add-item.png" alt="Add <?php echo $sModule ?>" class="add"/></a>
</div>
<?php endif; ?>
<div id="listing_div">
<?php if (count($aItems)):?>

        <?php if ($sMessage != ''):?>
        <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
        <?php endif; ?>
        <table id="listings">
            <tr class="header">
            <thead>
                <th id="header_name">Name</th>
                <th id="header_description">Description</th>
                <th id="header_type">Type</th>
                <th id="header_actions">Actions</th>
            </tr>
            </thead>

            <?php $i = 0; ?>
        <?php foreach ($aItems as $oItem):?> 
            <?php $sAltClass = (++$i % 2 == 0)?'class="alt"':'' ?>
            <tr  <?php echo $sAltClass?>>
                <td><?php echo $oItem->name ?></td>
                <td><?php echo $oItem->description ?></td>
                <td><?php echo $oItem->type ?></td>
                
                <td class="actions">
                    <?php if ($oItem->type == 'generic'): ?>
                            <?php if ($oUser->canAccess('update')):?>
                                <a href="/cms/<?php echo $sModule ?>/edit/<?php echo $oItem->id ?>" target="_self" alt="edit <?php echo $sModule ?>" class="edit"><img src="/cms/images/edit.png" alt="edit"></a>&nbsp;&nbsp;&nbsp;
                             <?php elseif ($oUser->canAccess('read')):?>
                            <a href="/cms/<?php echo $sModule ?>/read/<?php echo $oItem->id ?>" target="_self" alt="view <?php echo $sModule ?>"><img src="/cms/images/view.png" alt="view" class="view"></a>&nbsp;&nbsp;&nbsp;
                            <?php endif;?>
                            <?php if ($oUser->canAccess('delete')):?>
                                <a href="" target="" alt="delete <?php echo $sModule ?>" class="delete <?php echo $sModule ?>" id="<?php echo $oItem->id ?>"><img src="/cms/images/delete.png" alt="delete"></a>
                            <?php endif;?>
                         <?php endif;?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
                <div id="table_header">
            <table id="listing_header">
                <thead>
                    <tr class="header">
                        <th id="fixed_header_name" class="header_description">Name<input type="hidden" id="description_name" value="modules display name"/></th>
                        <th id="fixed_header_description" class="header_description">Description<input type="hidden" id="description_actions" value="Moduel description"/></th>
                        <th id="fixed_header_type" class="header_description">Type<input type="hidden" id="description_actions" value="type of module"/></th>
                        <th id="fixed_header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/></th>
                    </tr>
                </thead>
            </table>
        </div>
    
    
    <?php
else:
    ?>
    <div class="message">No  <?php echo $sModule ?> available to list.</div>

<?php
endif;
?>

</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>