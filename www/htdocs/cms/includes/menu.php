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
$aAdminMenu = array('user',  'role', 'module', 'menu');
?>
<div class="site_menu">
    <ul>
        <li <?php if ($sActiveLink == 'home'):?> class="active"<?php endif; ?>>
            <a href="/cms/home/" target="_self"<?php if ($sActiveLink == 'home'):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-home.png" alt="home"  class="menu_icon"/>Home</a>
        </li>
        <?php foreach($aMenu as $oMenuItem):?>
            <?php if (!isset($oLoggedInUser->permissions[$oMenuItem->module]) ||  in_array($oMenuItem->module, $aAdminMenu)){continue;}?>
            <li <?php if ($sActiveLink == $oMenuItem->module):?> class="active"<?php endif; ?>>
                <a href="/cms/<?php echo $oMenuItem->module?>/list/" target="_self"<?php if ($sActiveLink == $oMenuItem->module):?> class="active"<?php endif; ?>><?php if ($oMenuItem->icon != ''):?><img src="/cms/images/menu/<?php echo $oMenuItem->icon?>" alt="<?php echo $oMenuItem->display_name?>" class="menu_icon"/><?php endif;?><?php echo $oMenuItem->display_name?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <br style="clear:both"/>
</div>

<div id="banner_menu">
    <ul>
        <?php foreach($aMenu as $oMenuItem):?>
            <?php if (!isset($oLoggedInUser->permissions[$oMenuItem->module]) ||  !in_array($oMenuItem->module, $aAdminMenu)){continue;}?>
            <li <?php if ($sActiveLink == $oMenuItem->module):?> class="active"<?php endif; ?>>
                <a href="/cms/<?php echo $oMenuItem->module?>/list/" target="_self"<?php if ($sActiveLink == $oMenuItem->module):?> class="active"<?php endif; ?>><?php if ($oMenuItem->icon != ''):?><img src="/cms/images/menu/<?php echo $oMenuItem->icon?>" alt="<?php echo $oMenuItem->display_name?>" class="menu_icon"/><?php endif;?>
                    <br/><?php echo $oMenuItem->display_name?></a>
            </li>
        <?php endforeach; ?>
        <li>
            <a href="/cms/logout/" target="_self"<?php if ($sActiveLink == 'logout'):?> class="active"<?php endif; ?>><img src="/cms/images/menu/menu-logout.png" alt="logout"  class="menu_icon"/>
                </br>Logout</a>
        </li>
    </ul>
    <br style="clear:both"/>
</div>
