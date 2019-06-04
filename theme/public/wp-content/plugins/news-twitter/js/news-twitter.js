jQuery(document).ready(function($){
	$('.bxslider').each(function() {
		
		var options = {
				mode: $(this).data("mode"),
				auto: Boolean($(this).data('auto')),
				minSlides: parseInt($(this).data('minslides')),
				maxSlides: parseInt($(this).data('maxslides')),
				ticker: Boolean($(this).data('ticker')),
				speed: parseInt($(this).data('speed')),
				slideWidth: parseInt($(this).data('slidewidth')),
				controls: Boolean($(this).data('controls')),
				pager: Boolean($(this).data('pager')),
				tickerHover: true,
				slideSelector:'.news-twitter-item'
		};

		var slider = $(this).bxSlider(options);
		$( window ).resize(function() {
			slider.reloadSlider();
		});
	})
});