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
?>

<div class="menu">
    <ul>
        <li>
            <a href="/cms/home/" target="_self"<?php if ($sActiveLink == 'home'):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-home.png" alt="home"/><br/>Home</a>
        </li>
        <?php foreach($aModules as $oModuleItem):?>
            <?php if (($oModuleItem->name == 'modules') || !isset($oLoggedInUser->permissions[$oModuleItem->name])){continue;}?>
            <li>
                <a href="/cms/<?php echo $oModuleItem->name?>/list/" target="_self"<?php if ($sActiveLink == $oModuleItem->name):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-<?php echo $oModuleItem->name?>.png" alt="<?php echo $oModuleItem->name?>"/><br/><?php echo $oModuleItem->display_name?></a>
            </li>
        <?php endforeach; ?>
        <li>
            <a href="/cms/logout/" target="_self"<?php if ($sActiveLink == 'logout'):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-logout.png" alt="logout"/><br/>Logout</a>
        </li>
    </ul>
    <br style="clear:both"/>
</div>
