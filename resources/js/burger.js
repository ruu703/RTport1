$(function () {
    $('.js-toggle-sp-menu').on('click', function(){
        $(this).toggleClass('active');
        $('.js-toggle-sp-menu-target').toggleClass('active');
    });

    $('.js-toggle-sp-menu-target').on('click', function () {
        $(this).toggleClass('active'); 
        $('.js-toggle-sp-menu').toggleClass('active');
     });
})