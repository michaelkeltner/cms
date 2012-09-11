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
<div id="banner">
    <h1>Academic HealthPlans CMS</h1>
</div>
