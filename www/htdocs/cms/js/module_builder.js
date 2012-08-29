$(document).ready(function() {
    cleanLoadedFields();
    sortable();
    toggleComponent();
    disableEnterKeyFormSubmit()
    fadeResultsMessage();
    removeColumnContent()
    hideColumnContent();
    addField();
    removeFormItem();
    setupAssociationActions();
});

function setupAssociationActions(){
    $('.association_module_select').change(function(){
        mySelect = $(this).siblings().next('.association_field_select');
        mySelect.html('');
        mySelect.append($('<option></option>').val('0').html('--Select field value to show--'));
        $.post('/cms/ajax.php', {
            action: 'load_module_fields',
            module_id: $(this).val()
        }, function (data){
            if (data != undefined){
               $.each(data, function(index) {
                   if (data[index].type != 'header'){
                        mySelect.append($('<option></option>').val(data[index].id).html(data[index].display_name));
                    }
                });
                mySelect.removeClass('hide');
            }
        }, 'JSON');
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