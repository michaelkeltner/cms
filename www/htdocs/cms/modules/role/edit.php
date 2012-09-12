<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'role';

$sMessage = '';
$sMessageClass = '';
$oModule = new Module();
$oPermission = new Permission();
$oRole = new Role();
$iRoleId = getParam(4);
if (formSubmit()) {
    $bResults = $oRole->updateItem(postVar('name'), postVar('id'));
    if ($bResults > 0) {
        $oPermission->updateModulePermissions($iRoleId, postVar('permissions'));
        $sMessage = postVar('name') . ' updated.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/role/list');
    } else {
        $sMessage = 'The entry was not updated.';
        $sMessageClass = ' error';
    }
}


$oRoleItem = $oRole->getWithId($iRoleId);
if (!$oRoleItem){
    gotoURL(BASE_URL . '/cms/role/list/');
    exit;
}

$aModules = $oModule->getAll();
$aPermissions = $oPermission->getAll();
$aRolePermission = $oRole->getPermissions($oRoleItem->id);
require_once (CMS_INCLUDES . 'header.php');
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_role" method="post" action="">
        <input type="hidden" name="id"  value="<?php echo $iRoleId ?>" />
        <input type="hidden" name="item"  value="role" />
        <p class="name">
            <input type="text" name="name" id="name" value="<?php echo $oRoleItem->name?>"/>
            <label for="name">Name</label>
        </p>
        
        <?php if (count($aModules) && count($aPermissions)):?>
        <a href="#" class="toggle_all_checkbox">Click All</a>
        <a href="#" class="toggle_create_checkbox">Create All</a>
        <a href="#" class="toggle_delete_checkbox">Delete All</a>
        <a href="#" class="toggle_read_checkbox">Read All</a>
        <a href="#" class="toggle_update_checkbox">Update All</a>
        <div id="listing_div">
        <table id="listings">
            <?php $i=0; ?>
            <?php foreach($aModules as $oModuleItem): ?>
                <tr<?php echo ($i++ % 2 == 0)?' class="alt"':''?>>
                    <td><?php echo $oModuleItem->name ?></td>
                    <?php foreach($aPermissions as $oPermissionItem): ?>
                    <?php $sChecked = (isset($aRolePermission[$oModuleItem->name][$oPermissionItem->name]))?'checked="checked"':''; ?>
                    <td>
                        <p class="name">
                            <input type="checkbox" class="perm_checkbox checkbox_<?php echo $oPermissionItem->name ?>" name="permissions[<?php echo $oModuleItem->id ?>][]" id="<?php echo $oModuleItem->id . ':' .  $oPermissionItem->id ?>" value="<?php echo $oPermissionItem->id ?>" <?php echo $sChecked?>/>
                            <label for="<?php echo $oModuleItem->id . ':' .  $oPermissionItem->id ?>"><?php echo $oPermissionItem->name ?></label>
                        </p>
                    </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            
            
               
            
        </table>
            </div>
        <?php endif;?>
        
        <p class="submit">
            <input type="submit" value="update" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>