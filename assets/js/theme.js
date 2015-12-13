/**
 * Created by vedmaka on 31.07.2015.
 */
$(function(){

    $('#menu-hiw').click(function(e){
        $('#megamenu').toggleClass('megamenu-opened');
        e.preventDefault();
    });

    $(document).on('click', function(e){
        if( $(e.target).attr('id') != 'menu-hiw' ) {
            if ( $('#megamenu').hasClass('megamenu-opened') ) {
                $('#megamenu').removeClass('megamenu-opened');
            }
        }
    });

    $('.jumbo-country select').select2({
        placeholder: "Select country"
    });

    $('#login-popup-wrapper').click(function () {
        $(this).fadeOut();
        $('.login-popup-form').fadeOut();
        $('[data-dismiss]').click();
    });

    $('#login-selector').click(function (e) {
        $('#login-popup-wrapper').fadeIn();
        $('.login-popup-form').fadeIn();
        e.preventDefault();
    });

});