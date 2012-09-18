$(document).ready(function() {
    
    linksSearch();
    faqSetup();
    
});

function faqSetup(){
    $('div.answer').toggle();
    $('a.question').click(function(e){
        e.preventDefault();
        iId = $(this).attr('rel');
        if ($('#' + iId).hasClass('showing')){
             $('#' + iId).addClass('hiding').removeClass('showing');
            $('#' + iId).slideUp('250');
        }else{
            $('#' + iId).addClass('showing').removeClass('hiding');
            $('#' + iId).slideDown('250');
           
            
        }
        
        
    })
}

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
                        newList = '<p>No schools found with the query.</p>'
                    }
                    
                    $('#button').html(newList);
                },'json');     
            }
        },250);
    });
    
    
    
    
    
}