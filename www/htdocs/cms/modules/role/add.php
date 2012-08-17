<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'role';
require_once (CMS_INCLUDES . 'header.php');
$sMessage = '';
$sMessageClass = '';
$oModule = new Module();
$oPermission = new Permission();
if (formSubmit()) {
    $oRole = new Role();
    $iId = $oRole->addItem(postVar('name'));
    if ($iId > 0) {
        $oPermission->addModulePermissions($iId, postVar('permissions'));
        $sMessage = postVar('name') . ' added.';
        $sMessageClass = ' added';
        $_SESSION['sMessage'] = $sMessage;
        $_SESSION['sMessageClass'] = $sMessageClass;
        gotoURL('/cms/role/list');
    } else {
        $sMessage = postVar('name') . ' was not added.';
        $sMessageClass = ' error';
    }
}
$aModules = $oModule->getAll();
$aPermissions = $oPermission->getAll();

?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_role" method="post" action="">
        <p class="name">
            <input type="text" name="name" id="name" />
            <label for="name">Name</label>
        </p>
        <?php if (count($aModules) && count($aPermissions)):?>
        <a href="#" class="toggle_all_checkbox">Click All</a>
        <a href="#" class="toggle_create_checkbox">Create All</a>
        <a href="#" class="toggle_delete_checkbox">Delete All</a>
        <a href="#" class="toggle_read_checkbox">Read All</a>
        <a href="#" class="toggle_update_checkbox">Update All</a>
        <table class="listing">
            <th>Module Permissions</th>
            <?php $i=0; ?>
            <?php foreach($aModules as $oModuleItem): ?>
                <tr<?php echo ($i++ % 2 == 0)?' class="alt"':''?>>
                    <td><?php echo $oModuleItem->name ?></td>
                    <?php foreach($aPermissions as $oPermissionItem): ?>
                    <td>
                        <p class="name">
                            <input type="checkbox" class="perm_checkbox checkbox_<?php echo $oPermissionItem->name ?>" name="permissions[<?php echo $oModuleItem->id ?>][]" id="<?php echo $oModuleItem->id . ':' .  $oPermissionItem->id ?>" value="<?php echo $oPermissionItem->id ?>"/>
                            <label for="<?php echo $oModuleItem->id . ':' .  $oPermissionItem->id ?>"><?php echo $oPermissionItem->name ?></label>
                        </p>
                    </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            
            
               
            
        </table>
        <?php endif;?>
        
        
        
        
        <p class="submit">
            <input type="submit" value="add" />
        </p>

    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>