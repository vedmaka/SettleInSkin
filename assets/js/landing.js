$(function(){

	$('#fullpage').fullpage({
		afterRender: function() {
			$('#nav').addClass('animated');
			$('.jumbotron').addClass('animated');
		},
		afterLoad: function( anchorLink, index ) {
			// var $slide = $('#fullpage .slide-' + index);
			// if ($slide.find('.js-animated').length) {
			// 	$slide.find('.js-animated').each(function(i,v) {
			// 		var animationType = $(v).data('custom-animation');
			// 		$(v).addClass('animated ' + animationType).removeClass('.js-animated');
			// 	});
			// }
		},
		onLeave: function (index, nextIndex, direction) {
			$('main').attr('data-custom-slide-num', nextIndex);
			var $slide = $('#fullpage .slide-' + nextIndex);
			if ($slide.find('.js-animated').length) {
				$slide.find('.js-animated').each(function(i,v) {
					var animationType = $(v).data('custom-animation');
					$(v).addClass('animated ' + animationType).removeClass('.js-animated');
				});
			}
			if( nextIndex == 1 ) {
				$('.slide-1 .vegas-bg').vegas('play');
			}else{
				$('.slide-1 .vegas-bg').vegas('pause');
			}
		}
	});

	// Slideshow
	$('.slide-1 .vegas-bg').vegas({
		slides: [
			//{ src: mw.config.get('stylepath') + '/SettleIn/img/landing/slide_1.jpg' }//,
			//{ src: mw.config.get('stylepath') + '/SettleIn/img/landing/slide_2.jpg' }//,
			{ src: mw.config.get('stylepath') + '/SettleIn/img/landing/slide_3.jpg' }//,
			//{ src: mw.config.get('stylepath') + '/SettleIn/img/landing/slide_4.jpg' }
		],
		//overlay: mw.config.get('stylepath') + '/SettleIn/img/overlays/01.png',
		delay: 3000,
		timer: false
	});

	// Click handlers
	$(document).on('click touch', '#fold-how-it-works', function(){
		$.fn.fullpage.moveSectionDown();
	});

	$(document).on('click touch', '#fold-how-you-can-help', function(){
		$.fn.fullpage.moveSectionDown();
	});

	$(document).on('click touch', '#fold-what-else', function(){
		$.fn.fullpage.moveSectionDown();
	});

	$(document).on('click touch', '#fold-contribute', function(){
		$.fn.fullpage.moveSectionDown();
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

	if( window.rndUsers && window.rndUsers.length ) {
		setInterval( showRandomUser, 3000 );
	}

    function showRandomUser() {
        var $wrapper = $('#rndUserPlaceholder');
        var rndUser = window.rndUsers[ Math.floor( Math.random() * window.rndUsers.length ) ];
        $wrapper.fadeOut(function(){
            $wrapper.html( '<a href="'+ rndUser.url +'">'+ rndUser.name +'</a>' );
            $wrapper.fadeIn('slow');
		});
    }

});