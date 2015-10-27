'use strict';
//TABS TEXTAREA

$('.out-modal ul.nav-tabs li a').on('click', function(){
    $('.out-modal ul.nav-tabs li ').removeClass('active');
    $(this).parent('li').addClass('active');
    var tabContent = $(this).data('target');
    $('.out-modal .tab-pane').removeClass('active');
    $('.out-modal').find(tabContent).addClass('active');
});
$('.on-modal ul.nav-tabs li a').on('click', function(){
    $('.on-modal ul.nav-tabs li ').removeClass('active');
    $(this).parent('li').addClass('active');
    var tabContent = $(this).data('target');
    $('.on-modal .tab-pane').removeClass('active');
    $('.on-modal').find(tabContent).addClass('active');
});
//MENU DROPDOWN

$('.wrapper-dropdown').on('click', function(event){
    $(this).toggleClass('active');
    event.stopPropagation();
}); 

//MODAL SETUP

$.modal.defaults = {
    overlay: '#000',
    opacity: 0.75,
    zIndex: 1,
    escapeClose: true,
    clickClose: true,
    closeText: 'Close',
    closeClass: '',
    showClose: false,
    modalClass: 'modal',
    spinnerHtml: null,
    showSpinner: true,
    fadeDuration: null,
    fadeDelay: 1.0
};

// DOCUMENT VALIDATION

var file = document.getElementById('appbundle_document_file');

file.onchange = function(e){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'pdf':
            break;
        default:
            alert('the file must be a .pdf file');
            this.value='';
    }
};