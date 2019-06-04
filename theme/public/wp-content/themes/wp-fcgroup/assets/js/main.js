jQuery(document).ready(function($) {
	"use strict";
	
	/* load pages */
	$('.page-loader-wrapper').fadeOut('slow');
	/* window */
	var window_width, window_height, scroll_top;

	/* admin bar */
	var adminbar = $('#wpadminbar');
	var adminbar_height = 0;

	/* header menu */
	var header = $('#cshero-header');
	var header_top = 0;

	/* scroll status */
	var scroll_status = '';

	/*filter phone*/
	var trigger_phone = false;
	
	/* Tool Tip*/
	$('.fcgroup-loop-entry, .fcgroup-single-entry').fitVids();
	cms_image_carousel();
	fcgroup_custom_heading_align();


	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover()
	/*$('.cms-owl-carousel').owlCarousel({'items': 1});*/


	/*Sticky Menu*/
	$("#cshero-header").sticky({topSpacing:0});

	/*scroll top id*/
	 $('#explore').live('click', function(){
	 	var target = $(this).data('target');
		 $('body,html').animate({
				scrollTop: $(target).offset().top
			}, 1000);
		});
	/**
	 * window load event.
	 * 
	 * Bind an event handler to the "load" JavaScript event.
	 * @author Fox
	 */
	$(window).on('load', function() {
		/** current scroll */
		scroll_top = $(window).scrollTop();

		/** current window width */
		window_width = $(window).width();

		/** current window height */
		window_height = $(window).height();

		/* get admin bar height */
		adminbar_height = adminbar.length > 0 ? adminbar.outerHeight(true) : 0 ;

		/* get top header menu */
		header_top = header.length > 0 ? header.offset().top - adminbar_height : 0 ;

		if ( $('.wow').length ) {
		    initWow(); 
		};

		/* check sticky menu. */
		/*cms_stiky_menu();*/
		general_404_page();
		set_height_for_bgimage();
		cms_arrow_down();

		if(trigger_phone == false) {
			portfolio_filter_onphone();
		}
	});

	/**
	 * reload event.
	 * 
	 * Bind an event handler to the "navigate".
	 */
	window.onbeforeunload = function(){
	}
	
	/**
	 * resize event.
	 * 
	 * Bind an event handler to the "resize" JavaScript event, or trigger that event on an element.
	 * @author Fox
	 */
	$(window).on('resize', function(event, ui) {
		/** current window width */
		window_width = $(event.target).width();

		/** current window height */
		window_height = $(window).height();

		/** current scroll */
		scroll_top = $(window).scrollTop();

		/* check sticky menu. */
		/*cms_stiky_menu();*/
		general_404_page();
		set_height_for_bgimage();

		if(trigger_phone == false) {
			portfolio_filter_onphone();
		}
	});
	
	/**
	 * scroll event.
	 * 
	 * Bind an event handler to the "scroll" JavaScript event, or trigger that event on an element.
	 * @author Fox
	 */
	$(window).on('scroll', function() {
		/** current scroll */
		scroll_top = $(window).scrollTop();

		/* check sticky menu. */
		/*cms_stiky_menu();*/
	});

	/**
	 * Init Wow
	 * 
	 * @author DuongTung
	 * @since 1.0.0
	 */
	function initWow(){
		var wow = new WOW( { mobile: false, } );
		wow.init();
	}
	
	//pie char
	$('.vc_pie_chart').each(function() {
		$(this).waypoint(
			function() {
				$(this).circliful();
			}, {
				offset : '95%',
				triggerOnce : true
		});	
	});
	/**
	 * Set height shortcode bgimage
	 * 
	 */
	function set_height_for_bgimage() {
		$('.cms-bgimage-wrap .cms-bgimage-inner').each(function() {
			var wrap = $(this);
			var h = wrap.parents('.vc_row-o-equal-height').height();

			if ( window_width - 992 >= 0 ) {
				wrap.css('height', h);
			} else {
				wrap.css('height', '');
			}
		});
	}

	/**
	 * Custom Owl Carousel
	 * 
	 * @author DuongTung
	 * @since 1.0.0
	 */
	function cms_image_carousel() {
		if ( $('.fcgroup-slider-wrap').length ) {
			var data_margin = '';
			$('.fcgroup-slider-wrap').each(function(index, el) {
				var id_carousel = $(el).attr('id');
				var wrap = $('#' + id_carousel);

				/*console.debug(id_carousel);*/

				var image_carousel_setting = {}, slide_effect = '';
					image_carousel_setting.items = wrap.attr('data-per-view');
					image_carousel_setting.rewind = true;
					slide_effect = wrap.attr('data-effect-slider');

					if (parseInt(wrap.attr('data-margin')) != 0) {
						data_margin = parseInt(wrap.attr('data-margin'));
					} else {
						data_margin = 0;
					}

					image_carousel_setting.items = 1;
					image_carousel_setting.margin = 0;
					image_carousel_setting.mouseDrag = true;
					image_carousel_setting.autoplay = (wrap.attr('data-autoplay') === "true");
					image_carousel_setting.autoplaySpeed = 400;
					image_carousel_setting.smartSpeed = 500;
					image_carousel_setting.dots = (wrap.attr('data-pagination') === "true");
					image_carousel_setting.dots = (wrap.attr('data-dots') === "true");
					image_carousel_setting.loop = (wrap.attr('data-loop') === "true");
					image_carousel_setting.nav = (wrap.attr('data-nav') === "true");
					if (slide_effect == 'fade-in-carousel') {
						image_carousel_setting.animateIn = 'FadeIn';
						image_carousel_setting.animateOut = 'fadeOut';
					}
					image_carousel_setting.responsive = {
				        0:{
							items:1,
							slideBy: 1
				        }
				    }
			        image_carousel_setting.navText = ["<span class='icon-prev'></span>", "<span class='icon-next'></span>"];
				//Play
				wrap.owlCarousel(image_carousel_setting);
			});
		}
	}
	/**
	 * One page
	 *
	 * @author Fox
	 */
	if(typeof(one_page_options) != "undefined"){
		one_page_options.speed = parseInt(one_page_options.speed);
		$('#site-navigation').singlePageNav(one_page_options);
	}
	/**
	 * 
	 */
	function general_404_page() {
		var w_height = $(window).height() - $('#wpadminbar').height();
		
		$('.404-page-wrap, .error-banner-img, .error-box , .main-login , .login-banner-img, .login-box, #main-banner, .banner-img,.banner-text').css('height', w_height);
	}

	/**
	 * Custom Heading Align
	 * 
	 * @author DuongTung
	 * @since 1.0.0
	 */
	function fcgroup_custom_heading_align() {
		var text_align = '';
		if ($('.cmsc-custom-heading').length) {
			$('.cmsc-custom-heading').each(function(i, el) {
				var text_align = $(el).css('text-align');
				$(el).addClass('text-' + text_align);
				$(el).parents('.vc_custom_heading').addClass('text-' + text_align);
			});
		}
	}
	/**
	 * Portfolio Filter on phone
	 * 
	 * @author DuongTung
	 * @since 1.0
	 */
	function portfolio_filter_onphone() {
		trigger_phone = true;
		if ( window_width - 599 <= 0 ) { //On phone
			$('.cms-grid-filter-inphone a').on('click', function(e) {
				var $this = $(this);
				e.preventDefault();
				var wrap = $this.parents('.cms-filter-wrap');
				if ( $('.cms-filter-category', wrap).hasClass('active') ) {
					$('.cms-filter-category', wrap).removeClass('active').slideUp();
				} else {
					$('.cms-filter-category', wrap).addClass('active').slideDown(300);
				}
			});

			$('.cms-filter-category a').on('click', function() {
				var $this = $(this),
					wrap = $this.parents('.cms-filter-wrap');;
				$('.cms-filter-category', wrap).removeClass('active').slideUp();
				$('.cms-grid-filter-inphone a').text($this.text());
			});
		}
	}

	/**
	 * Arrow down
	 * 
	 * @author Duong Tung
	 * @since 1.0.0
	 */
	function cms_arrow_down() {
		var adminbar_height = 0;
		var adminbar = $('body').find('#wpadminbar');
		if(adminbar.length == 1) {
			adminbar_height = parseInt(adminbar.height());
		}

		$('.arrow-in-home a').on('click', function(e) {
			var id_scroll = $(this).attr('href');

			e.preventDefault();	
			$("html, body").animate({ scrollTop: $(id_scroll).offset().top - adminbar_height }, 800);
		});
	}

});