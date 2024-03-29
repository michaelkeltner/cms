<?php 
$sActiveLink = 'menu';
$oMenuBuilder = new MenuBuilder();
$oModule = new Module();
$aModule = $oModule->getAll();
$aMenuOptions = $oMenuBuilder->getAll('ORDER BY `sort_order` ASC');
$aError = array();
if (formSubmit()){
    if ($oMenuBuilder->updateMenu($_POST)){
        gotoURL('/cms/home/'); 
    }else{
        $aError = $oMenuBuilder->get('aMessage');
    }
}

?>

<?php require_once (CMS_INCLUDES . 'header.php');?>
<?php if (count($aError)):?>
<div id="topsection">
    <div class="innertube">
        <div id="error" class="error">
         <?php foreach ($aError as $sMessage){echo $sMessage . '<br/>';}?>
        </div>
    </div>
</div>
<?php endif;?>


<div id="contentwrapper">
    <div id="contentcolumn">
        <div class="innertube">
            <div class="form">
<form action="<?php echo currentURL() ?>" method="post" class="menu_builder noEnterSubmit">
    <div id="used_menu_modules" class="sortable"> 
        <?php if (count($aMenuOptions)):?>
        <?php foreach ($aMenuOptions as $oItem):?>
        <div class="menu_module">
            <img src="/cms/images/delete-small.png" class="delete_item"/>
            <input type="text" name="menu[name][]" value="<?php echo $oItem->name?>"/>
            <input type="hidden" name="menu[id][]" value="<?php echo $oItem->id?>"/>
            <input type="hidden" name="menu[module_id][]" value="<?php echo $oItem->module_id?>"/>
            <div class="menu_image">
                <?php $sImage = ($oItem->icon != '')?$oItem->icon:'no-choice.png'?>
                <img src="/cms/images/menu/<?php echo $sImage?>" width="48" height="48"/>
                <input type="hidden" name="menu[icon][]" value="<?php echo $oItem->icon?>"/>
            </div>
        </div>
        <?php endforeach ?>
        <?php endif; ?>
    </div>
    <div id="used_menu_modules">
        <p class="submit">
            <input type="submit" value="Save"/>
        </p>
    </div>
   
</form>
</div>
        </div>
    </div>
</div>

<div id="leftcolumn">
    <div class="innertube">
        <div id="module_option_list">
            <?php foreach($aModule as $oItem): ?>
            <div class="module_option">
                <a href="#" id="<?php echo $oItem->id ?>" class="add_module" alt="add <?php echo $oItem->name ?>"><image src="/cms/images/add-item.png" alt="Add <?php echo $oItem->name ?>" width="32" heigth="32"/></a><?php echo $oItem->name?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<div id="rightcolumn">
    <div class="innertube">
        <div id="menu_option_list">
        <?php $i = 0; ?>
        <?php foreach(scandir(CMS_ROOT .'images/menu/') as $sImage): ?>
            <?php if (strlen($sImage) < 4){continue;}?>
            <div class="image_option">
                <img src="/cms/images/menu/<?php echo $sImage?>" width="47" height="47"/>
                <input type="hidden" name="menu[icon][]" value="<?php echo $sImage?>"/>
            </div>

            <?php endforeach; ?>
        </div>    
    </div>
</div>




<div id="clone_field" class="hide">
   
    <?php 
     
    //foreach (scandir(MODULES_ROOT .'module/fields/') as $sFile) {
        foreach ($aField as $oFieldItem){
            $sFieldClass = 'cloneable';
            $oFieldItem->field_id = $oFieldItem->id;
            $oFieldItem->id = '';
            include(MODULES_ROOT .'module/fields/' . $oFieldItem->type . '.php');
        }
    ?>
</div>








<?php require_once (CMS_INCLUDES . 'footer.php'); ?>