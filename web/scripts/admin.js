//TABS TEXTAREA

$('.out-modal ul.nav-tabs li a').on('click', function(){
    $('ul.nav-tabs li ').removeClass('active');
    $(this).parent('li').addClass('active');
    var tabContent = $(this).data('target');
    $('.tab-pane').removeClass('active');
    $(tabContent).addClass('active');
});
$('.on-modal ul.nav-tabs li a').on('click', function(){
    $('.on-modal ul.nav-tabs li ').removeClass('active');
    $(this).parent('li').addClass('active');
    var tabContent = $(this).data('target');
    $('.on-modal .tab-pane').removeClass('active');
    $(tabContent).addClass('active');
});
//MENU DROPDOWN

$('.wrapper-dropdown').on('click', function(event){
    $(this).toggleClass('active');
    event.stopPropagation();
}); 

//MODAL SETUP

$.modal.defaults = {
    overlay: "#000",
    opacity: 0.75,
    zIndex: 1,
    escapeClose: true,
    clickClose: true,
    closeText: 'Close',
    closeClass: '',
    showClose: false,
    modalClass: "modal",
    spinnerHtml: null,
    showSpinner: true,
    fadeDuration: null,
    fadeDelay: 1.0
};
