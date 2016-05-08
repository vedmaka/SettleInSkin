/**
 * Created by vedmaka on 06.09.2015.
 */
$(function () {

    $('#country-select').select2({
        placeholder: mw.msg('settlein-skin-header-select-country-placeholder')
    });

    $('#bottom-footer .bottom-footer-badge').click(function () {
        if ($('#bottom-footer').hasClass('footer-opened')) {
            $('#bottom-footer').removeClass('footer-opened');
            $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        } else {
            $('#bottom-footer').addClass('footer-opened');
            $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }
    });

    $('#login-popup-wrapper').click(function () {
        $(this).fadeOut();
        $('.login-popup-form').fadeOut();
        $('.comments-popup-form').fadeOut();
        $('.why-sign-up-popup').fadeOut();
        $('[data-dismiss]').click();
    });

    $('#login-selector').click(function () {
        $('#login-popup-wrapper').fadeIn();
        $('.login-popup-form').fadeIn();
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#show-comments-link').click(function () {
        $('.comments-popup-form').fadeIn();
        $('#login-popup-wrapper').fadeIn();
    });

    $('#faq-menu').click(function(){
        $('#login-popup-wrapper').fadeIn();
    });

    if( $('#why_signup').length ) {
        $('#why_signup').click(function () {
            $('#login-popup-wrapper').fadeIn();
            $('.why-sign-up-popup').fadeIn();
        });
    }

    $('#top-search a.search-submit').click(function(){
        $('#form-top-search').submit();
    });

});