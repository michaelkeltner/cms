<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'user';
$sRenderPage = strtolower(getParam(3));
$sMessage = '';
$sMessageClass = '';
$oUser = new User();
$oRole = new Role();
if (formSubmit()) {
    if (postVar('password') != postVar('confirm_password')) {
        $sMessage = 'Passwords do not match.';
        $sMessageClass = ' error';
    } else {
        $bResults = $oUser->updateItem(postVar('name'), postVar('email'), postVar('password'), postVar('id'));
        if ($bResults > 0) {//did we update the user
            $bResults = $oRole->updateUserRole(postVar('id'), postVar('role'));
            if ($bResults > 0) {//did we update the user role
                $sMessage = 'User updated.';
                $sMessageClass = ' added';
                $_SESSION['sMessage'] = $sMessage;
                $_SESSION['sMessageClass'] = $sMessageClass;
                gotoURL('/cms/user/list');
            } else {//user updated but not the user role
                $sMessage = 'User role was not updated but the rest of the user was updated.';
                $sMessageClass = ' error';
            }
        }else{//user was not updated
            $sMessage = 'The entry was not updated.';
            $sMessageClass = ' error';
        }
    }
}

//load the user
$iUserId = getParam(4);
$oUserItem = $oUser->getWithId($iUserId);
if (!$oUserItem) {
    gotoURL(BASE_URL . '/cms/user/list/');
    exit;
}
$aRole = $oRole->getAll();
$aUserRole = array();
$aUserRoleObjects = $oRole->getRoleForUser($oUserItem->id);

if (count($aUserRoleObjects) > 0){
    foreach($aUserRoleObjects as $oUserRoleItem){
        $aUserRole[$oUserRoleItem->id]  = true;
    }
}
require_once (CMS_INCLUDES . 'header.php');
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <?php if ($sRenderPage == 'edit'):?>
    <form class="form" id="edit_user" method="post" action="">
    <?php endif;?>
        <input type="hidden"name="id"  value="<?php echo $iUserId ?>" />
        <p class="name">
            <input type="text" name="name" id="name" value="<?php echo $oUserItem->name ?>"/>
            <label for="name">User</label>
        </p>
        <p class="name">
            <input type="text" name="email" id="email" value="<?php echo $oUserItem->email ?>"/>
            <label for="email">Email</label>
        </p>
        <p class="name">
            <input type="password" name="password" id="password" value=""/>
            <label for="password">Password</label>
        </p>
        <p class="name">
            <input type="password" name="confirm_password" id="password" value=""/>
            <label for="confirm_password">Confirm Password</label>
        </p>
       <?php if (count($aRole)):?>
        <p class="name">
            <h3>Roles</h3> 
        </p>
        <?php foreach($aRole as $oRoleItem):?>
        <p class="name">    
                <input name="role[]" type="checkbox" value="<?echo $oRoleItem->id?>"<?php echo optionChecked(true, isset($aUserRole[$oRoleItem->id])) ?>/>
            <label for="role"><?php echo $oRoleItem->name?></label>
        </p>
        <?php endforeach?>
        <?php endif ?>
        <?php if ($sRenderPage == 'edit'):?>
        <p class="submit">
            <input type="submit" value="update" />
        </p>
    </form>
    <?php endif;?>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>