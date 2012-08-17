<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'home';
require_once (CMS_INCLUDES . 'header.php');
$oUser = new User();
$oUserStats = new UserStats();
$oUserItem = $oUser->getActiveUser();
$oUserStatsItem = $oUserStats->getWithUserId($oUserItem->id);

?>
hello <?php echo $oUserItem->name?>!
<div class="stats">
    <ul>
        <li>Last login: <?php echo date("m/d/Y (l) h:i a", strtotime($oUserStatsItem->last_login))?></li>
    </ul>
</div>
<?php require_once (CMS_INCLUDES . 'footer.php'); ?>