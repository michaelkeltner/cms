<!DOCTYPE html>
<?php
$oRender = new Render('faq');
$oRender->order('`sort_order` ASC');
$aData = $oRender->getData();






if (formSubmit()){
    $oModule = new ModuleGeneric('call_information');
    //select types in the cms are serialized
    //$_POST['call_end'] = serialize($_POST['call_end']);
    $oModule->addItem($_POST);
    
    //sendEmail($aTo, $aFrom, $sSubject, $sBody);
}
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
            <div id="title">Call Information</br>
                
            </div>
            <form method="post" action="#">
                <p class="name">
                    <label for="subject">Subject</label></br>
                    <input type="text" name="subject" id="subject"/>
                <div id="subject_list" class="dynamic_list"></div>
                </p>
                <p class="name">
                    <label for="description">Description</label></br>
                    <textarea name="description" cols="50" rows="5" id="description"></textarea>
                    <div id="description_list" class="dynamic_list"></div>
                </p>
                <p class="name">
                    <label for="resolution">Resolution</label></br>
                    <textarea name="resolution"  cols="50" rows="5" id="resolution"></textarea>
                    <div id="resolution_list" class="dynamic_list"></div>
                </p>
                <p class="name">
                    <label for="department">Department</label></br>
                    <input type="text" name="department" id="department"/>
                    <div id="department_list" class="dynamic_list"></div>
                </p>
                <p class="name">
                    <label for="call_end">How did the call end?</label><br/>
                    <select name="call_end[]" id="call_end">
                       <option value="resolve">Resolved the issue while on the phone</option>
                       <option value="internal transfer">Internally transfered the call to be resolved</option>
                       <option value="external transfer">Externally transfered the call to be resolved</option>
                       <option value="opened Ticket">opened a ticket to have the issue resolved</option>
                       <option value="other">Other</option>
                    </select>
                </p>
                <p class="name">
                    <input type="submit" name="submit" id="submit"/>
                </p>
            </form>
        </div>
            <div id="footer" class="rounded-corners">
                &copy 2008-<?php echo date('Y'); ?> Academic HealthPlans, Inc. | All Rights Reserved
            </div>
        
    </div>
</body>
</html>

