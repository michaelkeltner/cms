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
    
    
    $("#search_faq").live('keyup', function () {
        var value=$("#search_faq").val();
        setTimeout(function(){
            if ($("#search_faq").val()  == value)
            {
                $.post('/ajax.php',{
                    action:'search_faq',
                    value:$("#search_faq").val() 
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
                        newList = '<p>No FAQs found with the query "' + value + '".</p>'
                    }
                    $('#button').html(newList);   
                },'json');     
            }
        },250);
    });
    
    
    
    
    
}