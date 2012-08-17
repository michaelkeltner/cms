$(document).ready(function() {
    setTimeout("textNumber()", 5000);
    setupEmbed();
});



function intNumber(){
    $('#thenumber2').fadeOut('2000', function(){
        //$('#needAssistance').animate({width: '-=15'}, 700, function() {});
        //$('#thenumber1').animate({width: '-=15'}, 700, function(){});
        $('#thenumber1').fadeIn('2000', function(){
            setTimeout("textNumber()", 5000);
        });
    });
}
function textNumber(){
    //$('#needAssistance').animate({width: '+=15'}, 432, function(){});
    //$('#thenumber1').animate({width: '+=15'}, 432, function(){});
    $('#thenumber1').fadeOut('2000', function(){
        $('#thenumber2').fadeIn('1000', function(){
            setTimeout("intNumber()", 5000);
        });
    });
}
setTimeout("textNumber()", 5000);

function setupEmbed(){
    $('a.embed').live('click', function(e){
       e.preventDefault();
       sBackHTML = '<a href="" class="close_embed">Back</a>';
       sHTML = '<object data="' + $(this).attr('href') + '" type="application/pdf" width="100%" height="100%"> alt : <a href="' + $(this).attr('href') + '">' + $(this).attr('href') + '</a> </object>' + sBackHTML;
      $('div#embed_content').html(sHTML).css('z-index', '999');
    });
    
     $('a.close_embed').live('click', function(e){
       e.preventDefault();
       $('div#embed_content').html('').css('z-index', '-1');
     });
    
}




