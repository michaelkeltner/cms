$(document).ready(function() {
    
    linksSearch();
    
});

function linksSearch(){

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
    
    
    
    //we are adding a subject to the call information page
    $("#subject").live('keyup', function () {
        var value=$("#subject").val();
        setTimeout(function(){
            if ($("#subject").val()  == value)
            {
                $.post('/ajax.php',{
                    action:'search_subject',
                    value:$("#subject").val() 
                }, function(data) {
                    if (data.length > 0){
                        newList = '<ul>';
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
        },250);
    });
    
    
    //we are adding a subject to the call information page
    $("#department").live('keyup', function () {
        var value=$("#department").val();
        setTimeout(function(){
            if ($("#department").val()  == value)
            {
                $.post('/ajax.php',{
                    action:'search_department',
                    value:$("#department").val() 
                }, function(data) {
                    if (data.length > 0){
                        newList = '<ul>';
                        for (i = 0; i < data.length; i++) {
                            oData = data[i];
                            newList += ' <li><a href="" class="department_select" rel="' + oData.department +'">' + oData.department +'</a></li>';

                        }
                        newList += '</ul>';
                    }else{
                        newList = '';
                    }
                    
                    $('#department_list').html(newList);
                    LiveResultsClick();
                },'json');            
            }
        },250);
    });
    
    
    //search on query typing
    $("#search_faq").live('keyup', FAQAJAXSearch );
    //search when a school is selected
    $("#school").live('change', FAQAJAXSearch );
    //search when a checkbox is selected
    $('#categories :checkbox').live('click', FAQAJAXSearch );
    

}

function LiveResultsClick(){
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
                newList = '<ul>';
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
                newList = '<ul>';
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
