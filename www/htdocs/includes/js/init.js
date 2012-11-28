$(document).ready(function() {
    
    FAQSearch();
    schoolSearch();
    staffSearch();
    callSearch();
    ChangeSearch();
    
});

function callSearch(){
    
    //we are adding a subject to the call information page
    $("#subject").live('keyup', function () {
        var value=$("#subject").val();
        setTimeout(function(){
            if ($("#subject").val()  == value )
            {
                if (value == ""){
                    $('#subject_list').html('');
                }else{
                    $.post('/ajax.php',{
                        action:'search_subject',
                        value:$("#subject").val() 
                    }, function(data) {
                        if (data.length > 0){
                            closeList = '<a href="#" class="close_dynamic_listing"><span class="close_button">X</span></a>';
                            newList = closeList + '<ul>';
                            for (i = 0; i < data.length; i++) {
                                oSubject = data[i];
                                newList += ' <li><a href="" class="subject_select" rel="' + oSubject.subject +'">' + oSubject.subject +'</a></li>';

                            }
                            newList += '</ul>';
                        }else{
                            newList = '';
                        }

                        $('#subject_list').html(newList);
                        LiveResultsClick();
                    },'json');    
                }
            }
        },250);
    });
     
}

function staffSearch(){
     $("#search_staff").live('keyup', function () {
        
        var value=$("#search_staff").val();
        setTimeout(function(){
            if ($("#search_staff").val()  == value)
            {
                $.post('/ajax.php',{
                    action:'search_staff',
                    value:$("#search_staff").val() 
                }, function(data) {
                    if (data.length > 0){
                        newList = '';
                        for (i = 0; i < data.length; i++) {
                            oStaff = data[i];
                            newList += '<div class="listing"><ul>' +
                                '<li>' + oStaff.first_name +' ' + oStaff.last_name +'</li>' + 
                                oStaff.department + 
                                oStaff.title +
                                oStaff.phone + 
                                oStaff.email +
                                '</ul></div>';
                        }
                    }else{
                        newList = '<p>No staff found with the query "' + value + '".</p>'
                    }
                    
                    $('#button').html(newList);
                },'json');            
            }
        },250);
    });
}

function schoolSearch(){
 $("#search_school").live('keyup', function () {
        var value=$("#search_school").val();
        setTimeout(function(){
            if ($("#search_school").val()  == value)
            {
                $.post('/ajax.php',{
                    action:'search_school',
                    value:$("#search_school").val() 
                }, function(data) {
                    if (data.length > 0){
                        newList = '<ul>';
                        for (i = 0; i < data.length; i++) {
                            oSchool = data[i];
                            newList += ' <li><a href="' + document.URL + '/details/' + oSchool.slug +' " class="information_alert"><img src="includes/images/menu-information.png"/></a><a href="http://ahpcare.com/' + oSchool.slug + '/" target="_blank">' + oSchool.name + '</a></li>';

                        }
                        newList += '</ul>';
                    }else{
                        newList = '<p>No schools found with the query "' + value + '".</p>'
                    }
                    
                    $('#button').html(newList);
                },'json');            
            }
        },250);
    });
}

function FAQSearch(){

    //search on query typing
    $("#search_faq").live('keyup', FAQAJAXSearch );
    //search when a school is selected
    $("#school").live('change', FAQAJAXSearch );
    //search when a checkbox is selected
    $('#categories :checkbox').live('click', FAQAJAXSearch );
    
}

function ChangeSearch(){

    //search on query typing
    $("#search_change_log").live('keyup', ChangeAJAXSearch );
    //search when a school is selected
    $("#system").live('change', ChangeAJAXSearch );
    //search when a checkbox is selected
    $('#system_categories :checkbox').live('click', ChangeAJAXSearch );
    
}

function LiveResultsClick(){
    
    $('a.close_dynamic_listing').live('click', function(e){
        e.preventDefault();
        $(this).parent().html('');
    })
    //they selected a subject from the dropdown
    $('a.subject_select').live('click', function(e){
        e.preventDefault();
        subject = $(this).attr('rel');
        $('#subject').val(subject);
        $('#subject_list').html('');
        populateDescriptionOptions(subject);
        setTimeout(function(){
            populateResolutionOptions(subject);
        },750)
        
        
    });
    
    //they selected a description from the dropdown
    $('a.description_select').live('click', function(e){
        e.preventDefault();
        $('#description').val($(this).attr('rel'));
        $('#description_list').html('');
    });
     //they selected a resolution from the dropdown
    $('a.resolution_select').live('click', function(e){
        e.preventDefault();
        $('#resolution').val($(this).attr('rel'));
        $('#resolution_list').html('');
    });
     //they selected a department from the dropdown
    $('a.department_select').live('click', function(e){
        e.preventDefault();
        $('#department').val($(this).attr('rel'));
        $('#department_list').html('');
    });

}

function populateDescriptionOptions(subject){

        $.post('/ajax.php',{
            action:'search_description',
            value:subject 
        }, function(data) {
            if (data.length > 0){
                closeList = '<a href="#" class="close_dynamic_listing"><span class="close_button">X</span></a>';
                newList = closeList + '<ul>';
                for (i = 0; i < data.length; i++) {
                    oData = data[i];
                    newList += ' <li><a href="" class="description_select" rel="' + oData.description +'">' + oData.description +'</a></li>';

                }
                newList += '</ul>';
            }else{
                newList = '';
            }

            $('#description_list').html(newList);
            LiveResultsClick();
        },'json');            
}

function populateResolutionOptions(subject){
   $.post('/ajax.php',{
            action:'search_resolution',
            value:subject 
        }, function(data) {
            if (data.length > 0){
                closeList = '<a href="#" class="close_dynamic_listing"><span class="close_button">X</span></a>';
                newList = closeList + '<ul>';
                for (i = 0; i < data.length; i++) {
                    oData = data[i];
                    newList += ' <li><a href="" class="resolution_select" rel="' + oData.resolution +'">' + oData.resolution +'</a></li>';

                }
                newList += '</ul>';
            }else{
                newList = '';
            }

            $('#resolution_list').html(newList);
            LiveResultsClick();
        },'json');         

}

function ChangeAJAXSearch(){
    

        var value=$("#search_change_log").val();
        var system = $('#system :selected').val();

        setTimeout(function(){
            if ($("#search_change_log").val()  == value)
            {
                var allVals = [];
                $('#system_categories :checked').each(function() {
                  allVals.push($(this).val());
                });
                $.post('/ajax.php',{
                    action:'search_change_log',
                    value:$("#search_change_log").val(),
                    system:system, 
                    category:allVals
                    
                }, function(data) {
                    if (data.length > 0){
                        newList = '';
                        for (i = 0; i < data.length; i++) {
                            oData = data[i];
                            newList += '<div class="item_group">';
                            newList +='<p>';
                            newList +='<h3>' + oData.system + '</h3>';
                            newList +='<h3>' + oData.title + ' - ' + oData.change_date + '</h3>';
                            newList +='<h4>Change</h4>' + oData.changes;
                            newList +='<h4>Reason</h4>' + oData.reason;
                            newList +='</p>';
                            newList +='</div>';
                        }
                    }else{
                        newList = '<p>No Changes found with the search criteria.</p>'
                    }
                    $('#button').html(newList);   
                },'json');     
            }
        },250);
    

}

function FAQAJAXSearch(){
    
    
        var value=$("#search_faq").val();
        var school = $('#school :selected').val();

        setTimeout(function(){
            if ($("#search_faq").val()  == value)
            {
                var allVals = [];
                $('#categories :checked').each(function() {
                  allVals.push($(this).val());
                });
                $.post('/ajax.php',{
                    action:'search_faq',
                    value:$("#search_faq").val(),
                    school:school, 
                    category:allVals
                    
                }, function(data) {
                    if (data.length > 0){
                        newList = '<ul>';
                        for (i = 0; i < data.length; i++) {
                            oData = data[i];
                            newList += ' <li  class="question"><span class="marker question_marker">Q</span>' + oData.question + '</li>';
                            newList += ' <li  class="answer"><span class="marker answer_marker">A</span>' + oData.answer + '</li>';
                        }
                        newList += '</ul>';
                    }else{
                        newList = '<p>No FAQs found with the search criteria.</p>'
                    }
                    $('#button').html(newList);   
                },'json');     
            }
        },250);
    

}
