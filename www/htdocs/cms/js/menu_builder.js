$(document).ready(function() {
    deleteItem();
    setupDragable();
    setupDropable();
    setupAddMenuItem();
});
function setupAddMenuItem(){
    $('.add_module').click(function(){
        addHere = $('#used_menu_modules');
        me = $(this);
        moduleId = me.attr('id');
        moduleName = me.parent().text().trim();
        addThis = '<div class="menu_module ui-droppable">'; 
        addThis += '<img src="/cms/images/delete-small.png" class="delete_item"/>';
        addThis += '<input type="text" name="menu[name][]" value="' + moduleName +'"/>'; 
        addThis += '<input type="hidden" name="menu[id][]" value="0"/>';
        addThis += '<input type="hidden" name="menu[module_id][]" value="' + moduleId +'"/>';
        addThis += '<div class="menu_image">';
        addThis += '<img src="/cms/images/menu/no-choice.png" width="47" height="47"/>';
        addThis += '<input type="hidden" name="menu[icon][]" value="no-choice.png"/>';
        addThis +='</div>';
        addThis +='</div>';
        addHere.append(addThis);
        
        //setup the dropable events on the new item
        setupDropable();
        //bind the n delete action for the new menu item
        removeFormItem();
    }).live();
        
}
function setupDropable(){
   

    $(".menu_module").droppable({
        accept: ".image_option",
        drop: function(event,ui){
            //remove the previous image
            $(this).find('.menu_image').remove();
            //add the new image
            newImage = $(ui.draggable).clone();
            newImage.removeClass('image_option').removeClass('ui-draggable').addClass('menu_image');
            $(this).append(newImage);
        }
    });
    
    $("#trash").droppable({
        accept: ".menu_module",
        drop: function(event,ui){
            console.log("Item was Dropped");
            //remove the menu
            $(ui.draggable).remove();
           
        }
    });
    
    
}

function setupDragable(){
    $("#menu_option_list").draggable();
     $(".image_option").draggable({
        helper:'clone'
    });  
}
function cleanLoadedFields(){
    $('#used_field_list').find('div').each(function(){
        $(this).attr('id', '');
        if (!$(this).hasClass('field_item')){
            $(this).addClass('module_field');
        }
    })
}

function sortable(){
    $(function() {
        $( '.sortable' ).sortable();
        $( '.sortable' ).disableSelection();
    });
    
}

function toggleComponent(){
    $('.component_toggle').click(function(e){
        e.preventDefault();
        
        $(this).parent().children('p').each(function(){
            if (!$(this).hasClass('show')){
                $(this).toggle('500');
            }
        }
        );
        if ($(this).hasClass('showing_details')){
            $(this).removeClass('showing_details').addClass('hiding_details');
        }else{
            $(this).removeClass('hiding_details').addClass('showing_details');
        }
    })
}

function disableEnterKeyFormSubmit(){
    $('.noEnterSubmit').keypress(function(e){
        if ( e.which == 13){
            e.preventDefault();
        }
    });
}

function fadeResultsMessage(){
    
    setTimeout(function() {
        $("#results_message").hide('fade', {}, 500)
    }, 4000);
}

function removeColumnContent(){
    $('div#column_content').children('div.column_item').remove()
}

function hideColumnContent(){
    $('div.section_content').removeClass('active_content').hide();
}

function showColumnContent(section_id){
    $('div#'+section_id).addClass('active_content').fadeIn(250);
}

function addField(){
    $('.add_field').click(function(e){
        e.preventDefault();
        divPlaceHere = $('#used_field_list');
        sFieldType = $(this).attr('id').substring(5);
        newField = $('#'+sFieldType).clone(true);
        newField.attr('id', '');
        newField.removeClass('cloneable');
        newField.addClass('module_field');
        divPlaceHere.append(newField);
    }).live();
}
	
function removeFormItem(){
    $('.delete_item').click(function(e){
        if (confirmDelete()){
            $(this).parent('div').fadeOut('500').delay('1000').remove();
        }
    }).live();
    
}

function confirmDelete(){
    var answer = confirm("Are you sure you want to delete this?  If you confirm then you waive all rights to ask for it back!")
    if (answer){
        return true;
    }else{
        return false;
    }
}