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
                            newList += ' <li><a href="http://ahpcare.com/' + oSchool.slug + '/" target="_blank">' + oSchool.name + '</a></li>';

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