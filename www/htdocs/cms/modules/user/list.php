<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = getParam(2);
require_once (CMS_INCLUDES . 'header.php');
$oUser = new User();

$aItems = $oUser->getAll(' ORDER BY `name` ASC');

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
            <thead>
            <tr class="header">
            <th id="header_name" class="header_description">Name<input type="hidden" id="description_name" value="The User's display name"/>
            <th id="header_email" class="header_description">Email<input type="hidden" id="description_email" value="User's email"/>
            <th id="header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/>
            </tr>
            </thead>
        <?php $i = 0;?>
        <?php foreach ($aItems as $oItem):?> 
            <?php $sAltClass = (++$i % 2 == 0)?'class="alt"':'' ?>
            <tr  <?php echo $sAltClass?> id="item_<?php echo $oItem->id ?>">
                <td><?php echo $oItem->name ?></td>
                <td><?php echo $oItem->email ?></td>
                <td class="actions">
                    <?php if ($oUser->canAccess('update')):?>
                    <a href="/cms/user/edit/<?php echo $oItem->id ?>" target="_self" alt="edit user"><img src="/cms/images/edit.png" alt="edit" class="edit"></a>&nbsp;&nbsp;&nbsp;
                    <?php endif;?>
                    <?php if ($oUser->canAccess('delete') && $oItem->id != 1):?>
                    <a href="" target="" alt="delete user" class="delete user" id="<?php echo $oItem->id ?>"><img src="/cms/images/delete.png" alt="delete"></a>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div id="table_header">
            <table id="listing_header">
                <thead>
                    <tr class="header">
                        <th id="fixed_header_name" class="header_description">Name<input type="hidden" id="description_name" value="Asset's display name"/></th>
                        <th id="fixed_header_email" class="header_description">Email<input type="hidden" id="description_preview" value="Users email"/></th>
                        <th id="fixed_header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/></th>
                    </tr>
                </thead>
            </table>
        </div>
    
    <?php
else:
    ?>
    <div class="message">No  Users available to list.</div>

<?php
endif;
?>
    
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>
