<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'user';
require_once (CMS_INCLUDES . 'header.php');
$oRole = new Role();
$sMessage = '';
$sMessageClass = '';
if (formSubmit()) {
    if (postVar('password') != postVar('confirm_password')) {
        $sMessage = 'Passwords do not match.';
        $sMessageClass = ' error';
    } else {
        $oClass = new User();
        $iId = $oClass->addItem(postVar('name'), postVar('email'), md5(postVar('password')));
        if ($iId > 0) {
            //call update since he is a wrapper for insert
            $bResults = $oRole->updateUserRole($iId, postVar('role'));
            if ($bResults > 0) {//did we insert the user role
                $sMessage = postVar('name') . ' added.';
                $sMessageClass = ' added';
                $_SESSION['sMessage'] = $sMessage;
                $_SESSION['sMessageClass'] = $sMessageClass;
                gotoURL('/cms/user/list');
            } else {//user inserted but not the user role
                $sMessage = 'User role was not updated but the rest of the user was updated.';
                $sMessageClass = ' error';
            }
        } else {//user was not added
            $sMessage = postVar('name') . ' was not added.';
            $sMessageClass = ' error';
        }
    }
}

$aRole = $oRole->getAll();
?>
<?php if ($sMessage != ''): ?>
    <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
<?php endif; ?>
<div class="form">
    <form class="form" id="add_user" method="post" action="">
        <p class="name">
            <input type="text" name="name" id="name" value="<?php echo postVar('name') ?>"/>
            <label for="name">User Name</label>
        </p>
        <p class="name">
            <input type="text" name="email" id="email" value="<?php echo postVar('email') ?>"/>
            <label for="email">Email</label>
        </p>
        <p class="name">
            <input type="password" name="password" id="password" />
            <label for="password">Password</label>
        </p>
        <p class="name">
            <input type="password" name="confirm_password" id="confirm_password" />
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
        <p class="submit">
            <input type="submit" value="add" />
        </p>
    </form>
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>