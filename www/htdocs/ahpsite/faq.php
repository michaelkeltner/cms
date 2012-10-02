<!DOCTYPE html>
<?php
$oRender = new Render('faq');
$oRender->order('`sort_order` ASC');
$aData = $oRender->getData();

$oRenderSchool = new Render('school');
$oRenderSchool->order('`name` ASC');
$aSchoolData = $oRenderSchool->getData();
?>
<html>
    <head>
        <script type="text/javascript" language="javascript" src="/includes/js/jquery-1.7.1.min.js" ></script>
        <script type="text/javascript" language="javascript" src="/includes/js/init.js?<?php echo FILE_DECACHER?>" ></script>
        <link href="/includes/themes/ahpsite.css?<?php echo FILE_DECACHER?>" rel="stylesheet" type="text/css" media="screen">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <div id="wrapper" class="rounded-corners">
            <div id="title">FAQ</br>
                <input type="text" id="search_faq" placeholder='Search' class="search"/><br/>
            </div>
            <div id="filter">
                <div id="categories">
                    Category<br/> 
                    <input type="checkbox" name="category[]" value="General">General</input>
                    <input type="checkbox" name="category[]" value="RFP">RFP</input>
                    <input type="checkbox" name="category[]" value="Enrollment">Enrollment</input>
                    <input type="checkbox" name="category[]" value="Waiver">Waiver</input>
                    <input type="checkbox" name="category[]" value="IT">IT</input>
                </div>
                School<br/>
                <select name="school" id="school">
                    <option value="none">-- select --</option>
                <?php foreach($aSchoolData as $oSchool):?>
                    <option value="<?php echo $oSchool->show('name')?>"><?php echo $oSchool->show('name')?></option>
                <?php endforeach; ?>
                </select>
                
            </div>

            <div id="button">
                <ul>
                    <?php if (count($aData)): ?>
                        <?php foreach ($aData as $oData): ?>
                        <li class="question"><span class="marker question_marker">Q</span><?php $oData->show('question')?></li>
                        <li class="answer"><span class="marker answer_marker">A</span><?php $oData->show('answer') ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No FAQ's available</p>
                    <?php endif; ?>
                </ul>
            </div>
</div>
            <div id="footer" class="rounded-corners">
                &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
            </div>
        
    </div>
</body>
</html>

