$(document).ready(function() {
    cleanLoadedFields();
    sortable();
    toggleModuleFields();
    //disableEnterKeyFormSubmit();
    fadeResultsMessage();
    removeColumnContent()
    hideColumnContent();
    addField();
    removeFormItem();
    setupAssociationActions();
    setupLinkField();
})

function setupLinkField(){
    $('.radio_select_type').click(function(){
        sType = $(this).val();
        oDatabaseDiv = $(this).parent().parent().find('div.database');
        oManualDiv = $(this).parent().parent().find('div.manual');
      
        if (sType == 'database'){
            oDatabaseDiv.show();
            oManualDiv.hide();
        }else{
            oManualDiv.show();
            oDatabaseDiv.hide();
        }
        
    }).live();
    
    $('.db_tables').change(function(){
        mySelect = $(this).next('.table_fields');
        mySelect.html('');
        mySelect.append($('<option></option>').val('0').html('--Select field value to show--'));
        $.post('/cms/ajax.php', {
            action: 'load_database_fields',
            module_name: $(this).val()
        }, function (data){
            if (data != undefined){
               $.each(data, function(index) {
                   if (data[index].type == 'text'){
                        mySelect.append($('<option></option>').val(data[index].name).html(data[index].display_name));
                    }
                });
                mySelect.removeClass('hide');
            }
        }, 'JSON');
         mySelect.show();
    })
}

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

function toggleModuleFields(){
    $('.component_toggle').live('click', function(){
        $(this).parent().find('.field_item').toggle('1000');
        $(this).toggleClass('showing_details');
        $(this).toggleClass('hiding_details');
    });
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