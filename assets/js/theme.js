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

    /*$('.jumbo-country select').select2({
        placeholder: mw.msg('settlein-skin-mainpage-jumbotron-country-placeholder')
    });*/

    $('#login-popup-wrapper').click(function () {
        $(this).fadeOut();
        $('.login-popup-form').fadeOut();
        $('[data-dismiss]').click();
        $('.why-sign-up-popup').fadeOut();
    });

    $('#login-selector, .login-selector').click(function (e) {
        $('#login-popup-wrapper').fadeIn();
        $('.login-popup-form').fadeIn();
        e.preventDefault();
        if( window.slideoutMenu && window.slideoutMenu.isOpen() )
        {
            window.slideoutMenu.close();
        }
    });

    /*if( $('#country-select').length ) {
        $('#country-select').select2({
            placeholder: "Select country"
        });
    }*/

    if( $('#why_signup').length ) {
        $('#why_signup').click(function () {
            $('#login-popup-wrapper').fadeIn();
            $('.why-sign-up-popup').fadeIn();
            if( window.slideoutMenu && window.slideoutMenu.isOpen() )
            {
                window.slideoutMenu.close();
            }
        });
    }

    $('[data-dismiss]').click(function(){
        $('.login-popup-form').fadeOut();
    });
    
    if($('.jumbo-slider-backlay').length) {
        mw.loader.using('skins.settlein.slick', function(){
            $('.jumbo-slider-backlay').slick({
                autoplay: true,
                //initialSlide: 2,
				autoplaySpeed: 12000,
                arrows: false,
                dots: false,
                draggable: false,
                fade: true,
                pauseOnFocus: false,
                pauseOnHover: false,
                swipe: false,
                touchMove: false
            });
        });
    }

});