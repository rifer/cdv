//TABS TEXTAREA

$('ul.nav-tabs li a').on('click', function(){
    $('ul.nav-tabs li ').removeClass('active');
    $(this).parent('li').addClass('active');
    var tabContent = $(this).data('target');
    $('.tab-pane').removeClass('active');
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

// Insert media snippet inside textarea

$('.add-media').on('click', function(){
    var mediaInsert = $(this).data("add")
    , areaEn = $('textarea[id*="en_biography"]')
    , areaEs = $('textarea[id*="es_biography"]')
    , cursorPosEs = areaEs.prop('selectionStart')
    , cursorPosEn = areaEn.prop('selectionStart')
    , valEs = areaEs.val()
    , valEn = areaEn.val()
    , textBeforeEs = valEs.substring(0, cursorPosEs)
    , textAfterEs = valEs.substring(cursorPosEs, valEs.length)
    , textBeforeEn = valEn.substring(0, cursorPosEn)
    , textAfterEn = valEn.substring(cursorPosEn, valEn.length);

    if ($('.a2lix_translationsFields-en').hasClass('active')){
        areaEn.val(textBeforeEn+"[["+mediaInsert+"]]"+textAfterEn);
    }
    else if ($('.a2lix_translationsFields-es').hasClass('active')) {
        areaEs.val(textBeforeEs+"[["+mediaInsert+"]]"+textAfterEs);
    }
});
