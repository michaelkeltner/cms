<?php
$oUser = new User();
$theUser = $oUser->getActiveUser();
if (!$oUser->canAccess() && $theUser->id != 1){
    gotoURL('/cms/home/');
    exit;
}
$sActiveLink = (isset($sActiveLink))?$sActiveLink:'';
$oUser = new User();

$oLoggedInUser = $oUser->getActiveUser();
$oModule = new Module();
$aModules = $oModule->getAll();
$oMenuBuilder = new MenuBuilder();
$aMenu = $oMenuBuilder->getMenu();
?>

<div class="menu">
    <ul>
        <li>
            <a href="/cms/home/" target="_self"<?php if ($sActiveLink == 'home'):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-home.png" alt="home"/><br/>Home</a>
        </li>
        <?php foreach($aMenu as $oMenuItem):?>
            <?php if (!isset($oLoggedInUser->permissions[$oMenuItem->module])){continue;}?>
            <li>
                <a href="/cms/<?php echo $oMenuItem->module?>/list/" target="_self"<?php if ($sActiveLink == $oMenuItem->module):?> class="active"<?php endif; ?>><img src="/cms/images/menu/<?php echo $oMenuItem->icon?>" alt="<?php echo $oMenuItem->display_name?>"/><br/><?php echo $oMenuItem->display_name?></a>
            </li>
        <?php endforeach; ?>
        <li>
            <a href="/cms/logout/" target="_self"<?php if ($sActiveLink == 'logout'):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-logout.png" alt="logout"/><br/>Logout</a>
        </li>
    </ul>
    <br style="clear:both"/>
</div>
