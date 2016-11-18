$(function(){

	console.log('Landing page initiated.');

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
		}
	});

	// Click handlers
	$(document).on('click touch', '#fold-how-it-works', function(){
		$.fn.fullpage.moveSectionDown();
	});

	$(document).on('click touch', '#fold-how-you-can-help', function(){
		$.fn.fullpage.moveSectionDown();
	});

});