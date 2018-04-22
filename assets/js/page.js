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

    $('#login-selector, .login-selector').click(function (e) {
        $('#login-popup-wrapper').fadeIn();
        $('.login-popup-form').fadeIn();
        if( window.slideoutMenu && window.slideoutMenu.isOpen() )
        {
            window.slideoutMenu.close();
        }
        e.preventDefault();
        return false;
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#show-comments-link').click(function () {
        $('.comments-popup-form').fadeIn();
        $('#login-popup-wrapper').fadeIn();
    });

    $('#faq-menu, .faq-menu').click(function(){
        //$('#login-popup-wrapper').fadeIn();
        if( window.slideoutMenu && window.slideoutMenu.isOpen() )
        {
            window.slideoutMenu.close();
        }
    });

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

    $('#top-search a.search-submit').click(function(){
        $('#form-top-search').submit();
    });

    // Scroll-spy for dynamic navbar
	$(window).scroll(function(e) {
		var scrollValue = $(window).scrollTop();
		//console.log(scrollValue);
		if (scrollValue > 30) {
			$('#bs-example-navbar-collapse-1').addClass('scrolled-state');
		}else{
			$('#bs-example-navbar-collapse-1').removeClass('scrolled-state');
		}
	});

    //TODO: remove duplications

    var textInput = $(this).find('.selectize-search-appendix');
    var geoInput = $(this).find('.settle-geo-search-input');
    var wrapper = $(this).find('.settle-geo-search-wrapper');

    $('#searchform_smw').submit(function(event){

        if( wrapper.find('.settle-geo-search-input-error').length ) {
            wrapper.find('.settle-geo-search-input-error').remove();
        }

        if( !geoInput.val() ) {
            var error = $('<div/>');
            error.html('Oops, please specify a location!');
            error.addClass('settle-geo-search-input-error');
            wrapper.append(error);
            geoInput.get(0).selectize.focus();
            event.preventDefault();
            return false;
        }

    });

    geoInput.on('change', function(){
        if( $(this).val() ) {
            if( wrapper.find('.settle-geo-search-input-error').length ) {
                wrapper.find('.settle-geo-search-input-error').remove();
            }
        }
    });

	if($('#page-steps-achor').size()) {
		$('#page-steps-achor .left-tabs ul li').click(function(){
			$('#page-steps-achor').find('.tab-content').attr('class', '').addClass('tab-content').addClass( $(this).attr('class') );
		});
	}

});