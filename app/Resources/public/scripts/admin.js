'use strict';
//TABS TEXTAREA

$('ul.nav-tabs li a').on('click', function(){
    var place = $(this).parents('.admin-form').data('place');
    $('.'+place+' ul.nav-tabs li ').removeClass('active');
    $(this).parent('li').addClass('active');
    var tabContent = $(this).data('target');
    $('.'+place+' .tab-pane').removeClass('active');
    $('.'+place).find(tabContent).addClass('active');
});

//MENU DROPDOWN

$('.wrapper-dropdown').on('click', function(event){
    $(this).toggleClass('active');
    event.stopPropagation();
}); 

// DOCUMENT VALIDATION
$('#appbundle_document_file').on('change', function(){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'pdf':
            $('.file-error').addClass('hide');
            break;
        default:
            $('.file-error').removeClass('hide');
            this.value='';
    }
});