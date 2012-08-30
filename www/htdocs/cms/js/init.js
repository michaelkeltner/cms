$(document).ready(function() {
    sortable();
    setupContentForm();
    addFormItem();
    formImageSelect();
    removeFormItem();
    toggleComponent();
    deleteItem();
    validateSlug();
    fadeResultsMessage();
    copyContentMenu();
    copyContent();
    //do not disable enter key on form for now
    //disableEnterKeyFormSubmit();
    toggleContentSection();
    closeSite();
    toggleAllChecks();
    validateForm();
    setupGenericModuleForm();
    setTableheaderWidth();
});

function setTableheaderWidth(){
    $('#listings th').each(function() {
        var headerWidth = $(this).width(); 
        thisId = $(this).attr('id');
        $('#fixed_'+thisId).attr('width',headerWidth);
        setupGenericModuleForm();
    });
}

function setupGenericModuleForm(){
    
    $('.add').qtip({
        content: 'Add an item',
        position: {
                    my: 'bottom left',  // Position my top left...
                    at: 'top right' // at the bottom right of...
                    
        }
    });
    
    $('.edit').qtip({
        content: 'Edit this',
        position: {
                    my: 'center right',  // Position my top left...
                    at: 'center left' // at the bottom right of...
        }
    });
    
    $('.delete').qtip({
        content: 'Delete this',
        position: {
                    my: 'center right',  // Position my top left...
                    at: 'center left' // at the bottom right of...
                    
        }
    });
    
    $('.header_description').mouseover(function(){
        inputId = 'description_' + (this.id).substring(13,(this.id).length);
        content = $('input#'+ inputId).val();
        if (content != undefined){
            $(this).qtip({
                content: content,
                position: {
                    my: 'bottom left',  // Position my top left...
                    at: 'top left', // at the bottom right of...
                    target: $(this) // my target
                }
            }); 
        }
    });
   

    $('.field_wysiwyg').markItUp(mySettings);
    var WYSIWYGitems = $("form .field_wysiwyg").map(function(index, elm) {
        return {name: elm.name};
    });
    item_id = $('#item_id').val();
    module_name = $('#module_name').val();
    for(i=0; i<WYSIWYGitems.length; i++) {
        field_name = WYSIWYGitems[i].name;
        $.post('/cms/ajax.php', {
                action: 'load_wysiwyg_content',
                module_name: module_name,
                item_id: item_id,
                field_name: field_name
            }, function (data){
                if (data != undefined){

                    $('textarea#' + field_name).html(data);

                }
            }, 'JSON');

    }
    /*
    $('textarea.field_wysiwyg').htmlarea({
    toolbar: [
        "p",
        "|",
        "bold", "italic", "underline",
        "|",
        "h1", "h2", "h3", "h4", "h5", "h6",
        "|",
        "link", "unlink",
        "|",
         "orderedList", "unorderedList","horizontalrule",
    ],
    loaded: function () {
       
    }
});

*/
    $('.form_datetime').datetimepicker({ampm: true,hourGrid: 4,minuteGrid: 15, timeFormat: 'hh:mm TT'});
    $('.form_date').datepicker();
    $('.form_time').timepicker({ampm: true, hourGrid: 4,minuteGrid: 15, timeFormat: 'hh:mm TT'});   
    //Fix to make sure the loaded values are not default values of 
    $('.datetime_value_fix').each(function(){
       field_name = $(this).attr('id');
       field_value = $(this).val();
       $(' :input').each(function(){
           if ($(this).attr('name') == field_name){
               if ($(this).val() != field_value){
                   $(this).val(field_value);
               }
           }
       });
   });
}

function validateForm(){
    $('#btn_login').click(function(e){
        $('span.email').html('');
        $('span.password').html('');
        $('#email').removeClass('error');
        $('#password').removeClass('error');
        
        if ($('#email').val().length < 1){
            $('span.email').html('<h4>Who are you?</h4>')
            $('#email').addClass('error').focus();
            e.preventDefault();
        }else if ($('#password').val().length < 1){
            $('span.password').html('<h4>How do we know you are who you say you are?</h4>')
            $('#password').addClass('error').focus();
            e.preventDefault();
        }else{
           
        } 
    })
    
     $('#btn_resetPassword').click(function(e){
        $('span.email').html('');
        $('span.password').html('');
        $('#email').removeClass('error');
        $('#password').removeClass('error');
        
        if ($('#email').val().length < 1){
            $('span.email').html('<h4>Where do we send the email to?</h4>')
            $('#email').addClass('error').focus();
            e.preventDefault();
        }
    })
}

function toggleAllChecks(){
     $('.toggle_all_checkbox').click(function (e) {
         e.preventDefault();
        $('.perm_checkbox').each(function(){
             $(this).attr('checked', !$(this).attr('checked'))
         }
        );
    });
    $('.toggle_create_checkbox').click(function (e) {
         e.preventDefault();
        $('.checkbox_create').each(function(){
             $(this).attr('checked', !$(this).attr('checked'))
         }
        );
    });
    $('.toggle_delete_checkbox').click(function (e) {
         e.preventDefault();
        $('.checkbox_delete').each(function(){
             $(this).attr('checked', !$(this).attr('checked'))
         }
        );
    });
    $('.toggle_read_checkbox').click(function (e) {
         e.preventDefault();
        $('.checkbox_read').each(function(){
             $(this).attr('checked', !$(this).attr('checked'))
         }
        );
    });
    $('.toggle_update_checkbox').click(function (e) {
         e.preventDefault();
        $('.checkbox_update').each(function(){
             $(this).attr('checked', !$(this).attr('checked'))
         }
        );
    });
}

function closeSite(){
    
    $(window).unload(function() {
    });
}
function copyContent(){
    $(document).on("click", "li.copy_content_item", (function(e){
        e.preventDefault();
        aPieces = $(this).attr('id').split('~');
        sSchoolSlug = aPieces[0]
        sCopyFromPeriodSlug = aPieces[1];
        sCopyToPeriodSlug = aPieces[2];
        $.post('/cms/ajax.php', {
            action: 'copy_school_period',
            school_slug: sSchoolSlug,
            copy_from_slug: sCopyFromPeriodSlug,
            copy_to_slug: sCopyToPeriodSlug
        }, function (data){
            if (data != undefined){
               sURL = 'http://' + location.host + '/cms/content/edit/' + sSchoolSlug + '/' + sCopyToPeriodSlug + '/';
               window.location.replace(sURL);
            }
        }, 'JSON');
    }));
    
}

function copyContentMenu(){
    $('.copy_content').hover(function(e){
        e.preventDefault();
        $('div.copy_menu_options').addClass('behind').html("");
        aPieces = $(this).attr('id').split("~~");
        copyMenuDiv = $(this).next('div.copy_menu_options')
        $.post('/cms/ajax.php',{
                action:'get_unused_periods',
                school_slug:aPieces[0],
                period_slug:aPieces[1],
                period_name:aPieces[2]
            }, function(data) {
                if (data != undefined){
                    copyMenuDiv.removeClass('behind').html(data.menuOptions);
                    copyMenuDiv.slideDown(250);
                }
            },
            'JSON');
    }).live();
    
    $(document).on("mouseleave", "div.copy_menu_options", function(){
       $(this).slideUp(333);
        $(this).addClass('behind');
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
        $(this).parent().children('div.preview_image').each(function(){
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

function formImageSelect(){
    $('.image_select').change(function(){
        asset_id = $(this).find(":selected").val();
        previewDiv = $(this).parent().next('div.preview_image');
        if (asset_id > 0){
            $.post('/cms/ajax.php',{
                action:'get_image_src',
                asset_id:asset_id 
            }, function(data) {
                
                if (data != undefined){
                    previewDiv.html($("<img/>", {src:data.src}));
                }
            },
            'JSON');
        }else{
            previewDiv.html('');
        }
    }).live();
}

function fadeResultsMessage(){
    
    setTimeout(function() {
        $("#results_message").hide('fade', {}, 500)
    }, 4000);
}


function setupContentForm(){
    $('.show_hide_control').hide();
    $('.date_picker').datepicker();
    $('.school_select').change(function(){
        var $bIsPeriodSelected = $('.period_select').val() != 0;
        var $bIsSchoolSelected  = $(this).val() != 0;
        if ($bIsSchoolSelected && $bIsPeriodSelected){
            $('#results_message').hide();
            loadStartEndDate($('.school_select').val(), $('.period_select').val());
            loadAllSectionData(('.school_select').val(), $('.period_select').val());
            $('.show_hide_control').fadeIn(500).show();
        }
       
    });

    $('.period_select').change(function(){
        var $bIsPeriodSelected = $(this).val() != 0;
        var $bIsSchoolSelected  = $('.school_select').val() != 0;
        if ($bIsSchoolSelected && $bIsPeriodSelected){
            $('#results_message').hide();
            loadStartEndDate($('.school_select').val(), $('.period_select').val());
            loadAllSectionData($('.school_select').val(), $('.period_select').val());
            $('.show_hide_control').fadeIn(500).show();
        }
    });
    
}


function loadAllSectionData(){
    $('.section_content').each(function(){
        loadSectionData($(this).attr('id'), $('.period_select').val(), $('.school_select').val());
        $(this).hide();
    })
}


function validateSlug(){
    $('#slug').live('keyup', function () {
        var value=$("#slug").val();
        setTimeout(function(){
            if ($("#slug").val()  == value) {
                $.post('/cms/ajax.php',{
                    action:'check_slug',
                    slug:$("#slug").val(),
                    item:$("#item").val()
                },function (data){
                    },'JSON');
            }
        },250);
    });
}


function loadStartEndDate(school_id, school_period){
    
    //get the start and end date of this period
    $.post('/cms/ajax.php',{
        action:'get_school_period_coverage',
        school_id:school_id, 
        period_id:school_period
    }, function(data) {
         if (data[0] != undefined){
            if (data[0].start_date  != undefined){
                $('#period_start').val(formatDate(data[0].start_date));
            }
            if (data[0].end_date != undefined){
                $('#period_end').val(formatDate(data[0].end_date));
            }
            if (data[0].id != undefined){
                $('#start_end_id').val(data[0].id)
            }
         }
    },'JSON');
}


function formatDate (sDate) {
    var datePart = sDate.match(/\d+/g),
    year = datePart[0], // get only two digits
    month = datePart[1], day = datePart[2];

    return month+'/'+day+'/'+year;
}


function sectionListingSelect(){
    $('ul#section_listing button').click(function(e){
        var $bIsPeriodSelected = $('.period_select').val() != 0;
        var $bIsSchoolSelected  = $('.school_select').val() != 0;
        if ($bIsPeriodSelected && $bIsSchoolSelected){
            removeColumnContent();
            $('ul#section_listing button').removeClass('btn_section_active').addClass('btn_section_inactive');
            $(this).removeClass('btn_section_inactive').addClass('btn_section_active');
        }
    }).live();
}


function removeColumnContent(){
    $('div#column_content').children('div.column_item').remove()
}


function toggleContentSection(){
    $('ul#section_listing button').click(function(e){
        var $bIsPeriodSelected = $('.period_select').val() != 0;
        var $bIsSchoolSelected  = $('.school_select').val() != 0;
        if ($bIsPeriodSelected && $bIsSchoolSelected){
            hideColumnContent();
            showColumnContent($(this).val());
            $('ul#section_listing button').removeClass('btn_section_active').addClass('btn_section_inactive');
            $(this).removeClass('btn_section_inactive').addClass('btn_section_active');
        }
    }).live();
}


function hideColumnContent(){
    $('div.section_content').removeClass('active_content').hide();
}


function showColumnContent(section_id){
    $('div#'+section_id).addClass('active_content').fadeIn(250);
}


function loadSectionData(section_id, school_period, school_id){
    $.post('/cms/ajax.php',{
        action:'edit_content',
        school_id:school_id, 
        period_id:school_period,
        section_id: section_id
    }, function(data) {
        var aContent = data.content;
        var aAssetImages = data.assetImages;
        var aAssetDocs = data.assetDocs;
        var i = 0;
        var cloneTextDiv = $('div#clone_item_text').children().last();
        var cloneURLDiv = $('div#clone_item_link').children().last();
        var cloneImageDiv = $('div#clone_item_image').children().last();
        var cloneDocDiv = $('div#clone_item_doc').children().last();
        
        
        //populate the available assets select options based on the school
        //image assets
        var mySelect = cloneImageDiv.find('select');
        
        
        if (aAssetImages.length > 0){
            $.each(aAssetImages, function(imageAsset) {
                if (imageAsset.id > 0){
                    mySelect.append($('<option></option>').val(imageAsset.id).html(imageAsset.display_name));
                }
            });
        }else{
            $('.add_image').remove();
        }
    
        //doc assets
        if (aAssetDocs.length>0){
            mySelect = cloneDocDiv.find('select');
            $.each(aAssetImages, function(aAssetDocs) {
                if (aAssetDocs.id > 0){
                    mySelect.append(
                        $('<option></option>').val(aAssetDocs.id).html(aAssetDocs.display_name)
                        );
                }
            });
        }else{
            $('.add_doc').remove();
        }

        //add the content for the secton requested
        if (aContent.length > 0){
            thisDiv = $('div#' + section_id);
            for (i = 0; i < aContent.length; i++) {
                oContent = aContent[i];
                lastChild = thisDiv.children().last();
                if (oContent.type == 'link'){
                    cloneURLDiv.clone(true).insertAfter(lastChild);
                    editThis = thisDiv.children().last().find('.link_display');
                    editThis.attr('name', 'content[' + oContent.section_id + '][display][]');
                    editThis.val(oContent.display);
                    editThis = thisDiv.children().last().find('.link_url');
                    editThis.attr('name', 'content[' + oContent.section_id + '][url][]');
                    editThis.val(oContent.url);
                    editThis = thisDiv.children().last().find('.link_target');
                    editThis.attr('name', 'content[' + oContent.section_id + '][target][]');
                    editThis.val(oContent.target);
                }else if(oContent.type == 'image'){
                    cloneImageDiv.clone(true).insertAfter(lastChild);
                    editThis = thisDiv.children().last().find('#content');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]');
                    editThis.val(oContent.content);
                }else if(oContent.type == 'doc'){
                    cloneDocDiv.clone(true).insertAfter(lastChild);
                    editThis = thisDiv.children().last().find('#content');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]');
                    editThis.val(oContent.content);
                }else{         
                    cloneTextDiv.clone(true).insertAfter(lastChild);
                    editThis = thisDiv.children().last().find('#content');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]');
                    editThis.val(oContent.content); 
                }
                editThis =  thisDiv.children().last().find('input.hidden_type');
                //update the component type name
                editThis.attr('name', 'type[' + section_id + '][]');
            }
        }
        //store the current section id
        $('input#section_id').val(section_id);
    },'JSON');
}


function contentSetup(){
    $('#column_content').hide();

    $('.school_select').change(function(){
        var $bIsPeriodSelected = $('.period_select').val() != 0;
        var $bIsSchoolSelected  = $(this).val() != 0;
        if ($bIsSchoolSelected && $bIsPeriodSelected){
            $('#section_listing').fadeIn(500).show();
        }else{
            $('#section_listing').fadeIn(500).show();
            $('#column_content').fadeOut(250);
        }
       
    });
    
    
    $('.period_select').change(function(){
        var $bIsPeriodSelected = $(this).val() != 0;
        var $bIsSchoolSelected  = $('.school_select').val() != 0;
        if ($bIsSchoolSelected && $bIsPeriodSelected){
            $('#section_listing').fadeIn(500).show();
        }else{
            $('#section_listing').fadeIn(500).show();
            $('#column_content').fadeOut(250);
        }
    });
  
}


function clearSchoolPeriodContentForm(){
    
    $('#alert').html('');
    $('#column_main').html('');
    $('#column_enrolment').html('');
    $('#column_benefits').html('');
    $('#column_claims').html('');
}


function loadSchoolPeriodContent(iSchoolId, iPeriodId){
    $.post('/cms/ajax.php',{
        action:'edit_content',
        school_id:iSchoolId, 
        period_id:iPeriodId
    }, function(data) {
        var aAlert = data.alert;
        var aMain = data.main;
        var aEnrolment = data.enrolment;
        var aBenefits = data.benefits;
        var aClaims = data.claims;
        var aAssetImages = data.assetImages;
        var aAssetDocs = data.assetDocs;
        var i = 0;
        var cloneTextDiv = $('div#clone_item_text').children().last();
        var cloneURLDiv = $('div#clone_item_link').children().last();
        var cloneImageDiv = $('div#clone_item_image').children().last();
        var cloneDocDiv = $('div#clone_item_doc').children().last();
        
        //populate the available assets select options based on the school
        //image assets
        var mySelect = cloneImageDiv.find('select');
        $.each(aAssetImages, function(imageAsset) {
            mySelect.append(
                $('<option></option>').val(imageAsset.id).html(imageAsset.display_name)
                );
        });

        //doc assets
        mySelect = cloneDocDiv.find('select');
        $.each(aAssetImages, function(aAssetDocs) {
            mySelect.append(
                $('<option></option>').val(aAssetDocs.id).html(aAssetDocs.display_name)
                );
        });
        
        
        //add the alerts
        if (aAlert.length > 0){
            for (i = 0; i < aAlert.length; i++) {
                $('#alert').append(aAlert[i].content);
            }
        }
        //add the main section
        iColumnCount = 1;
        if (aMain.length > 0){
            //sHTML = '';
            for (i = 0; i < aMain.length; i++) {
                oContent = aMain[i];
                lastChild = $('div#column_main').children().last();
                if (oContent.type == 'link'){
                    cloneURLDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_main').children().last().find('.link_display');
                    editThis.attr('name', 'content[' + oContent.section_id + '][display][]');
                    editThis.val(oContent.display);
                    editThis =  $('div#column_main').children().last().find('.link_url');
                    editThis.attr('name', 'content[' + oContent.section_id + '][url][]');
                    editThis.val(oContent.url);
                    editThis =  $('div#column_main').children().last().find('.link_target');
                    editThis.attr('name', 'content[' + oContent.section_id + '][target][]');
                }else if(oContent.type == 'image'){
                    cloneImageDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_main').children().last().find('select');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]');
                    editThis.val(oContent.content);
                }else if(oContent.type == 'doc'){
                    cloneDocDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_main').children().last().find('select');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]');
                    editThis.val(oContent.content);
                }else{
                    cloneTextDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_main').children().last().find('textarea');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]');
                    editThis.val(oContent.content); 
                    
                }
                editThis =  $('div#column_main').children().last().find('input.hidden_type');
                //update the component type name
                editThis.attr('name', 'type[' + oContent.section_id + '][]');
            }
            //get rid of the initial blank box
            $('div#column_main').children().first().remove();
        }
        //add the enrollment
        iColumnCount++;
        if (aEnrolment.length > 0){
            for (i = 0; i < aEnrolment.length; i++) {
                oContent = aEnrolment[i];
                lastChild = $('div#column_enrolment').children().last()
                if (oContent.type == 'link'){
                    cloneURLDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_enrolment').children().last().find('.link_display');
                    editThis.attr('name', 'content[' + oContent.section_id + '][display][]');
                    editThis.val(oContent.display);
                    editThis =  $('div#column_enrolment').children().last().find('.link_url');
                    editThis.attr('name', 'content[' + oContent.section_id + '][url][]');
                    editThis.val(oContent.url);
                    editThis =  $('div#column_enrolment').children().last().find('.link_target');
                    editThis.attr('name', 'content[' + oContent.section_id + '][target][]');
                    editThis.val(oContent.target);
                }else{
                    cloneTextDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_enrolment').children().last().find('textarea');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]')
                    editThis.val(aEnrolment[i].content);
                }
                editThis =  $('div#column_enrolment').children().last().find('input.hidden_type');
                //update the component type name
                editThis.attr('name', 'type[' + oContent.section_id + '][]');
            }
            //get rid of the initial blank box
            $('div#column_enrolment').children().first().remove();
        }
        //add the benefits
        iColumnCount++;
        if (aBenefits.length > 0){
            for (i = 0; i < aBenefits.length; i++) {
                oContent = aBenefits[i];
                lastChild = $('div#column_benefits').children().last()
                if (oContent.type == 'link'){
                    cloneURLDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_benefits').children().last().find('.link_display');
                    editThis.attr('name', 'content[' + oContent.section_id + '][display][]');
                    editThis.val(oContent.display);
                    editThis =  $('div#column_benefits').children().last().find('.link_url');
                    editThis.attr('name', 'content[' + oContent.section_id + '][url][]');
                    editThis.val(oContent.url);
                    editThis =  $('div#column_benefits').children().last().find('.link_target');
                    editThis.attr('name', 'content[' + oContent.section_id + '][target][]');
                    editThis.val(oContent.target);  
                }else{
                    cloneTextDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_benefits').children().last().find('textarea');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]')
                    editThis.val(aBenefits[i].content);
                }
                editThis =  $('div#column_benefits').children().last().find('input.hidden_type');
                //update the component type name
                editThis.attr('name', 'type[' + oContent.section_id + '][]');
            }
            //get rid of the initial blank box
            $('div#column_benefits').children().first().remove()
        }
        //add the claims
        iColumnCount++;
        if (aClaims.length > 0){
            for (i = 0; i < aClaims.length; i++) {
                oContent = aClaims[i];
                lastChild = $('div#column_claims').children().last()
                if (oContent.type == 'link'){
                    cloneURLDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_claims').children().last().find('.link_display');
                    editThis.attr('name', 'content[' + oContent.section_id + '][display][]');
                    editThis.val(oContent.display);
                    editThis =  $('div#column_claims').children().last().find('.link_url');
                    editThis.attr('name', 'content[' + oContent.section_id + '][url][]');
                    editThis.val(oContent.url);
                    editThis =  $('div#column_claims').children().last().find('.link_target');
                    editThis.attr('name', 'content[' + oContent.section_id + '][target][]');
                    editThis.val(oContent.target);  
                }else{
                    cloneTextDiv.clone(true).insertAfter(lastChild);
                    editThis =  $('div#column_claims').children().last().find('textarea');
                    editThis.attr('name', 'content[' + oContent.section_id + '][]')
                    editThis.val(aClaims[i].content);
                }
                editThis =  $('div#column_claims').children().last().find('input.hidden_type');
                //update the component type name
                editThis.attr('name', 'type[' + oContent.section_id + '][]');
            }
            //get rid of the initial blank box
            $('div#column_claims').children().first().remove(); 
        }
    },'JSON');
}


function deleteItem(){
    $('a.delete').click(function(e){
        e.preventDefault();
        var deleteMe = $(this).closest('tr');
        $(this).removeClass('delete');
        var action = 'delete';
        var module = $(this).attr('class')
        if(module == 'module'){
            action = 'delete_module';
            if (confirmDelete()){
                $.post('/cms/ajax.php',{
                    action:action, 
                    id:this.id
                }, function(data) {
                    deleteMe.fadeOut(500);
                    deleteMe.remove();
                    $('tr').removeClass('alt');
                    $('tr:odd').addClass('alt');
                });
           
            }
            return 0;
        }else if(module == 'asset'){
            action = 'delete_asset';
            school_slug = $(this).attr('rel');
            if (confirmDelete()){
                $.post('/cms/ajax.php',{
                    action:action, 
                    school_slug:school_slug,
                    id:this.id,
                    module:module
                }, function(data) {
                    deleteMe.fadeOut(500);
                    deleteMe.remove();
                    $('tr').removeClass('alt');
                    $('tr:odd').addClass('alt');
                });
           
            }
            return 0;
        }else if(module == 'theme'){
            action = 'delete_theme';
            if (confirmDelete()){
                $.post('/cms/ajax.php',{
                    action:action, 
                    id:this.id,
                    module:module
                }, function(data) {
                    deleteMe.fadeOut(500);
                    deleteMe.remove();
                    $('tr').removeClass('alt');
                    $('tr:odd').addClass('alt');
                });
            }
            return 0;
        }else if (confirmDelete()){
            $.post('/cms/ajax.php',{
                action:action, 
                id:this.id,
                module:module
            }, function(data) {
                deleteMe.fadeOut(500);
                deleteMe.remove();
                $('li').removeClass('alt');
                $('li:odd').addClass('alt');
            });
            deleteMe.remove();
            //need to put the class alt on the on the appropriate li now that an
            //item has been removed
            $('tr').removeClass('alt');
            $('tr:odd').addClass('alt');
            return 0;
        }
    });
}

function sortable(){
    $(function() {
        $( '.sortable' ).sortable();
        $( '.sortable' ).disableSelection();
    });
    
}

	
function addFormItem(){
    cloneText();
    cloneLink();
    cloneHeader();
    cloneAsset('image');
    cloneAsset('doc');
    
}


function cloneText(){
    
    $('.add_text').click(function(e){
        //get the id of the selected column
        sectionId = $('div.active_content').attr('id');
        //get the div to clone
        cloneDiv = $('div#clone_item_text').children().last();
        //get the place to put the clone
        //If there are children and the first child has sortable thern this 
        //tells us that there are already elements listed in a "sortable div"
        if ($('.active_content').children().length > 0  && $('.active_content').find(">:first-child").hasClass('sortable')){
            parentDiv = $('.active_content').find('div.ui-sortable');
        }else{//else there are no components
             parentDiv = $('.active_content');
        }
        //append the clone div to the sortable div
        parentDiv.append(cloneDiv.clone(true)).fadeIn(750);
        //now we set the cloned textareas name attribute
        //get the last div (the clone we just added)
        lastChild = parentDiv.children().last();
        //get the textarea whos name we need to change
        editThis =  lastChild.find('#content');
        //now set the name attribute of the cloned div
        editThis.attr('name', 'content[' + sectionId + '][]');
        //now edit the type of field we added
        //get the hidden input field
        editType = lastChild.find('input.hidden_type');
        //update the hidden field name
        editType.attr('name', 'type[' + sectionId + '][]');
        //set the start/end input box names
        lastChild.find('input.date_picker').first().attr('name', 'content[' + sectionId + '][component_start_date][]');
        lastChild.find('input.date_picker').last().attr('name', 'content[' + sectionId + '][component_end_date][]');
        lastChild.find('.start_time').first().attr('name', 'content[' + sectionId + '][component_start_time][]');
        lastChild.find('.end_time').last().attr('name', 'content[' + sectionId + '][component_end_time][]');
        //reset the datetime object
        $('.hasDatepicker').attr("id", "").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker();
    }).live();
   
}


function cloneHeader(){
    
    $('.add_header').click(function(e){
        //get the id of the selected column
        sectionId = $('div.active_content').attr('id');
        //get the div to clone
        cloneDiv = $('div#clone_item_header').children().last();
        //get the place to put the clone
        //If there are children and the first child has sortable thern this 
        //tells us that there are already elements listed in a "sortable div"
        if ($('.active_content').children().length > 0  && $('.active_content').find(">:first-child").hasClass('sortable')){
            parentDiv = $('.active_content').find('div.ui-sortable');
        }else{//else there are no components
             parentDiv = $('.active_content');
        }
        //append the clone div to the parent div
        parentDiv.append(cloneDiv.clone(true)).fadeIn(750);
        //now we set the cloned textareas name attribute
        //get the last div (the clone we just added)
        lastChild = parentDiv.children().last();
        //get the textarea whos name we need to change
        editThis =  lastChild.find('#content');
        //now set the name attribute of the cloned div
        editThis.attr('name', 'content[' + sectionId + '][]');
        //now edit the type of field we added
        //get the hidden input field
        editType = lastChild.find('input.hidden_type');
        //update the hidden field name
        editType.attr('name', 'type[' + sectionId + '][]');
        //set the start/end input box names
        lastChild.find('input.date_picker').first().attr('name', 'content[' + sectionId + '][component_start_date][]');
        lastChild.find('input.date_picker').last().attr('name', 'content[' + sectionId + '][component_end_date][]');
        lastChild.find('.start_time').first().attr('name', 'content[' + sectionId + '][component_start_time][]');
        lastChild.find('.end_time').last().attr('name', 'content[' + sectionId + '][component_end_time][]');
        //reset the datetime object
        $('.hasDatepicker').attr("id", "").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker();
    }).live();
   
}


function cloneLink(){
    
    $('.add_link').click(function(e){
        //get the id of the selected column
        sectionId = $('div.active_content').attr('id');
        //get the div to clone
        cloneDiv = $('div#clone_item_link').children().last();
        //get the place to put the clone
        //If there are children and the first child has sortable thern this 
        //tells us that there are already elements listed in a "sortable div"
        if ($('.active_content').children().length > 0  && $('.active_content').find(">:first-child").hasClass('sortable')){
            parentDiv = $('.active_content').find('div.ui-sortable');
        }else{//else there are no components
             parentDiv = $('.active_content');
        }
        //append the clone div to the parent div
        parentDiv.append(cloneDiv.clone(true)).fadeIn(750);
        //now we set the cloned textareas name attribute
        //get the last div (the clone we just added)
        lastChild = parentDiv.children().last();
        //get the link display whos name we need to change
        editThis =  lastChild.find('.link_display');
        //now set the name attribute of the cloned div
        editThis.attr('name', 'content[' + sectionId + '][display][]');
        //get the link url whos name we need to change
        editThis =  lastChild.find('.link_url');
        //now set the name attribute of the cloned div
        editThis.attr('name', 'content[' + sectionId + '][url][]');
        //get the link display whos name we need to change
        editThis =  lastChild.find('.link_target');
        //now set the name attribute of the cloned div
        editThis.attr('name', 'content[' + sectionId + '][target][]');
        //now edit the type of field we added
        //get the hidden input field
        editType = lastChild.find('input.hidden_type');
        //update the hidden field name
        editType.attr('name', 'type[' + sectionId + '][]');
        //set the start/end input box names
        lastChild.find('input.date_picker').first().attr('name', 'content[' + sectionId + '][component_start_date][]');
        lastChild.find('input.date_picker').last().attr('name', 'content[' + sectionId + '][component_end_date][]');
        lastChild.find('.start_time').first().attr('name', 'content[' + sectionId + '][component_start_time][]');
        lastChild.find('.end_time').last().attr('name', 'content[' + sectionId + '][component_end_time][]');
        $('.hasDatepicker').attr("id", "").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker();
    }).live();
}


function cloneAsset(assetType){
    $('.add_' + assetType).click(function(e){
        //get the id of the selected column
        sectionId = $('div.active_content').attr('id');
        //get the div to clone
        cloneDiv = $('div#clone_item_' + assetType).children().last();
        //get the place to put the clone
        //If there are children and the first child has sortable thern this 
        //tells us that there are already elements listed in a "sortable div"
        if ($('.active_content').children().length > 0  && $('.active_content').find(">:first-child").hasClass('sortable')){
            parentDiv = $('.active_content').find('div.ui-sortable');
        }else{//else there are no components
             parentDiv = $('.active_content');
        }
        //append the clone div to the parent div
        parentDiv.append(cloneDiv.clone(true)).fadeIn(750);
        //now we set the cloned textareas name attribute
        //get the last div (the clone we just added)
        lastChild = parentDiv.children().last();
        //get the textarea whos name we need to change
        editThis =  lastChild.find('select').first();
        //now set the name attribute of the cloned div
        editThis.attr('name', 'content[' + sectionId + '][]');
        //now edit the type of field we added
        //get the hidden input field
        editType = lastChild.find('input.hidden_type');
        //update the hidden field name
        editType.attr('name', 'type[' + sectionId + '][]');
       //set the start/end input box names
        lastChild.find('input.date_picker').first().attr('name', 'content[' + sectionId + '][component_start_date][]');
        lastChild.find('input.date_picker').last().attr('name', 'content[' + sectionId + '][component_end_date][]');
        lastChild.find('.start_time').first().attr('name', 'content[' + sectionId + '][component_start_time][]');
        lastChild.find('.end_time').last().attr('name', 'content[' + sectionId + '][component_end_time][]');
        //populate the select box
        $.post('/cms/ajax.php',{
            action:'populate_asset_options',
            school_id: $('.school_select').val(),
            asset_type:assetType 
        }, function(data) {
            if (data.length){
                for (var i = 0; i < data.length; i++) {
                    $oItem = data[i];
                    editThis.append('<option value="' + $oItem.id + '">'+ $oItem.display_name +'</option>');
                }
            }
        },'JSON'); 
        $('.hasDatepicker').attr("id", "").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker();
    }).live();
}


function removeFormItem(){
    $('.delete_item').click(function(e){
        var answer = confirm("Are you sure you want to delete this?  If you confirm then you waive all rights to ask for it back!")
        if (answer){
            $(this).parent('div').fadeOut('500').delay('1000').remove();
        }
    }).live();
    
}
/**TODO: update all component fields.  Only text working right now
 * 
 */
function sectionChange(){
    $('.section_select').change(function(){
        var $iSectionId = $(this).val();
        var $oDiv = $(this).parent('div');
        //update all content items with the appropriate section id
        $oDiv.find('textarea').each(function () {
            $(this).attr('name', 'content[' + $iSectionId + '][]'); 
        });
        //change all the hidden type fields
        $oDiv.find('input.hidden_type').each(function () {
            $(this).attr('name', 'type[' + $iSectionId + '][]');
        });
        //change all the inputs for the link types
        $oDiv.find('input.link_display').each(function () {
            $(this).attr('name', 'content[' + $iSectionId + '][display][]');
        });
        $oDiv.find('input.link_url').each(function () {
            $(this).attr('name', 'content[' + $iSectionId + '][url][]');
        });
        $oDiv.find('select.link_target').each(function () {
            $(this).attr('name', 'content[' + $iSectionId + '][target][]');
        });
    });
}


function confirmDelete(){
    var answer = confirm("Are you sure you want to delete this?  If you confirm then you waive all rights to ask for it back!")
    if (answer){
        return true;
    }else{
        return false;
    }
}