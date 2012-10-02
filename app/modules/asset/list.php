<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = 'asset';
require_once (CMS_INCLUDES . 'header.php');
$oAsset = new Asset();
$aItems = $oAsset->getAll(' ORDER BY `create_date` DESC');
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
<?php $oUser = new User()?>
<?php if ($oUser->canAccess('create')):?>
<div class="add_item">
    <a href="/cms/asset/add/" alt="add asset"><image src="/cms/images/add-item.png" alt="Add Asset" class="add"/></a>
</div>
<?php endif;?>
 <div id="listing_div">
<?php if (count($aItems)):?>
        <?php if ($sMessage != ''):?>
        <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
        <?php endif; ?>
            <table id="listings">
                <thead>
                    <tr class="header">
                        <th id="header_name" class="header_description">Name<input type="hidden" id="description_name" value="Asset's display name"/></th>
                        <th id="header_preview" class="header_description">Preview<input type="hidden" id="description_preview" value="Preview of the file (if applicable)"/></th>
                        <th id="header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/></th>
                    </tr>
                </thead>
        <?php $i = 0; ?>
        <?php foreach ($aItems as $oItem):?>    
            <?php $sAltClass = (++$i % 2 == 0)?'class="alt"':'' ?>
                <tr  <?php echo $sAltClass?> id="item_<?php echo $oItem->id ?>">
                    <td class="listing_text"><?php echo $oItem->display_name ?></td>
                        <td class="listing_image">
                            <?php if ($oItem->type == 'image'): ?>
                                <img src="/assets/images/<?php echo $oItem->name ?>"/>
                            <?php else: ?>
                                <img src="/cms/images/document.png" width="128" height="128"/>
                            <?php endif; ?>
                        </td>
                        

                    <td class="actions">
                        <?php if ($oUser->canAccess('delete') && $oItem->id != 1):?>
                        <a href="" target="" alt="delete Asset" class="delete asset" id="<?php echo $oItem->id ?>"><img src="/cms/images/delete.png" alt="delte"></a>
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
                        <th id="fixed_header_preview" class="header_description">Preview<input type="hidden" id="description_preview" value="Preview of the file (if applicable)"/></th>
                        <th id="fixed_header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/></th>
                    </tr>
                </thead>
            </table>
        </div>
<?php else: ?>
    <div class="message">No Assets available.</div>
<?php endif; ?>
        </div>
<?php require_once (CMS_INCLUDES . 'footer.php'); ?>