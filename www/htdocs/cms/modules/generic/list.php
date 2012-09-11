<?php
//used to determine the menu link that should have the class "active" on it
$sActiveLink = getParam(2);
require_once (CMS_INCLUDES . 'header.php');
$oField = new Field();
$oModuleGeneric = new ModuleGeneric(getParam(2));
$oProperties = $oModuleGeneric->__get('oProperties');
$aFields = $oModuleGeneric->__get('aFields');
$sModule = $oProperties->name;
//order the results based on any field clicking action
$sOrderField = (postVar('form_sort_field') && !stristr(postVar('form_sort_field'), '__'))?postVar('form_sort_field'):'create_date';
$sOrderDirection = postVar('form_sort_direction')?postVar('form_sort_direction'):'DESC';
$aItems = $oModuleGeneric->getAll(" ORDER BY `$sOrderField` $sOrderDirection");

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
<div  class="add_item">
    <a href="/cms/<?php echo $sModule ?>/add/" alt="add <?php echo $sModule ?>"><image src="/cms/images/add-item.png" alt="Add <?php echo $sModule ?>" class="add"/></a>
</div>
<?php endif; ?>
<div id="listing_div">
<?php if (count($aItems)):?>

        <?php if ($sMessage != ''):?>
        <div id="results_message" class="message<?php echo $sMessageClass ?>"><?php echo $sMessage ?></div>
        <?php endif; ?>
        
        <table id="listings">
            <thead>
                <tr class="header">
                    <?php $i = 0; ?>
                    <?php $iColumnCount = 0; ?>
                    <?php //Show the table header
                    foreach ($aFields as $oFieldItem):
                        $aOptions = unserialize($oFieldItem->options);
                        if (!$aOptions['list']){continue;}
                        $iColumnCount++;
                     ?>
                                <th id="header_<?php echo $oFieldItem->name?>" class="header_description"><?php echo $oFieldItem->display_name ?>
                                    <input type="hidden" id="description_<?php echo $oFieldItem->name?>" value="<?php echo $oFieldItem->description?>"/>
                                    <form id="form_sort_field_<?php echo $oFieldItem->name?>" name="form_sort_field_<?php echo $oFieldItem->name?>" method="POST" action="<?php echo currentURL()?>"/>
                                        <input type="hidden" name="form_sort_field" value="<?php echo $oFieldItem->name?>"/>
                                        <?php $sNewSortOrder = ($sOrderDirection == 'DESC')?'ASC':'DESC'; ?>
                                        <input type="hidden" name="form_sort_direction" value="<?php echo $sNewSortOrder ?>"/>
                                    </form>
                                </th>
                     <?php endforeach; ?>
                                <?php $iColumnCount++;?>
                                <th id="header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/></th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($aItems as $oItem):?> 
            <?php $sAltClass = (++$i % 2 == 0)?' alt':'' ?>
            <tr  class="listing_row<?php echo $sAltClass?>" id="item_<?php echo $oItem->id ?>">
               <?php 
                    foreach ($aFields as $oFieldItem):
                        $aOptions = unserialize($oFieldItem->options);
                        if (!$aOptions['list']){continue;}
                        $sFieldName = $oFieldItem->name
               ?>
                <td ><?php echo $oField->listValue($oFieldItem, $oItem, $sFieldName) ?></td>
                    <?php endforeach; ?>
                <td class="actions">
                    <?php if ($oUser->canAccess('update')):?>
                    <a href="/cms/<?php echo $sModule ?>/edit/<?php echo $oItem->id ?>" target="_self" alt="edit <?php echo $sModule ?>"><img src="/cms/images/edit.png" alt="edit" class="edit"></a>&nbsp;&nbsp;&nbsp;
                    <?php endif;?>
                    <?php if ($oUser->canAccess('delete')):?>
                    <a href="" target="" alt="delete <?php echo $sModule ?>" class="delete <?php echo $sModule ?>" id="<?php echo $oItem->id ?>"><img src="/cms/images/delete.png" alt="delete"></a>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <div id="table_header">
            <table id="listing_header">
                <thead>
                    <tr class="header">
                        <?php //Show the table header
                        foreach ($aFields as $oFieldItem):
                            $aOptions = unserialize($oFieldItem->options);
                            if (!$aOptions['list']){continue;}
                        ?>
                                    <th id="fixed_header_<?php echo $oFieldItem->name?>" class="header_description" ><?php echo $oFieldItem->display_name ?><input type="hidden" id="description_<?php echo $oFieldItem->name?>" value="<?php echo $oFieldItem->description?>"/></th>
                        <?php endforeach; ?>
                                    <th id="fixed_header_actions" class="header_description">Actions<input type="hidden" id="description_actions" value="Click the icons to take action on the items"/></th>
                    </tr>
                </thead>
            </table>
        </div>
    
    <?php
else:
    ?>
    <div class="message">No  <?php echo $oProperties->display_name ?> available to list.</div>

<?php
endif;
?>
    
</div>

<?php require_once (CMS_INCLUDES . 'footer.php'); ?>