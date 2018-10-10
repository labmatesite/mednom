/***************************************************************************************************************
============================        CUSTOM SCRIPT FOR BITCOIN            =======================
****************************************************************************************************************
======================              TABLE OF CONTENT                  =====================
****************************************************************************************************************
****************************************************************************************************************

1 galleryMasonaryLayout
2 LightBox / Fancybox
3 accrodion
4 teamCarosule
5 testiCarosule
6 clientsCarosule
7 CounterNumberChanger
8 stickyHeader
9 Update Header Style + Scroll to Top
10 Scroll to top
11 contactFormValidation
12 Common CssJs
13 selectInput
14 gMap
15 mobileMenu

****************************************************************************************************************
==================            End TABLE OF CONTENT                ========================
****************************************************************************************************************/
// Dom Ready Function
jQuery(document).on('ready', function () {
	"use strict";
	(function ($) {
		// add your functions
		galleryMasonaryLayout();
		accrodion();
		teamCarosule();
		testiCarosule();
		clientsCarosule();	
		CounterNumberChanger();
		contactFormValidation();
		selectInput();
		gMap();
		mobileMenu();
	})(jQuery);
	// window on load functino
	jQuery(window).on('load', function () {
		(function ($) {
			// add your functions	
		})(jQuery);
	});
	// window on scroll functino
	jQuery(window).on('scroll', function () {
		(function ($) {
			// add your functions
			stickyHeader();
			scrollToTop();
		})(jQuery);
	});

});


// 1 galleryMasonaryLayout
function galleryMasonaryLayout () {
	if ($('.img-masonary').length) {
		$('.img-masonary').isotope({
			layoutMode:'masonry'
		});
	}
}

// 2 LightBox / Fancybox
if($('.lightbox-image').length) {
	$('.lightbox-image').fancybox({
		openEffect  : 'elastic',
		closeEffect : 'elastic',
		helpers : {
			media : {}
		}
	});
}

// 3 accrodion
function accrodion () {
	if ($('.accrodion-grp').length) {
		
		$('.accrodion-grp').each(function () {
			var accrodionName = $(this).data('grp-name');
			var Self = $(this);
			Self.addClass(accrodionName);
			Self.find('.accrodion .accrodion-content').hide();
			Self.find('.accrodion.active').find('.accrodion-content').show();
			Self.find('.accrodion').each(function() {
				$(this).find('.accrodion-title').on('click', function () {
					if ($(this).parent().hasClass('active') === false ) {					
						$('.accrodion-grp.'+accrodionName).find('.accrodion').removeClass('active');
						$('.accrodion-grp.'+accrodionName).find('.accrodion').find('.accrodion-content').slideUp();
						$(this).parent().addClass('active');					
						$(this).parent().find('.accrodion-content').slideDown();	
					};
				});
			});
		});
		
	};
}

// 4 teamCarosule
function teamCarosule () {
	if ($('.team-carousel').length) {
		$('.team-carousel').owlCarousel({
		    loop: true,
		    margin: 30,
		    nav: true,
		    dots: false,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
		    autoplay: true,
		    autoplayTimeout: 3000,
		    autoplayHoverPause: true,
		    responsive: {
		        0:{
		            items:1
		        },
		        480:{
		            items:1
		        },
		        600:{
		            items:2
		        },
		        1000:{
		            items:3
		        },
		        1200:{
		            items:4
		        }
		    }
		});
	}
}

// 5 testiCarosule
function testiCarosule () {
	if ($('.testimonaials-carousel').length) {
		$('.testimonaials-carousel').owlCarousel({
		    loop: true,
		    margin: 50,
		    nav: false,
		    navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
		    dots: true,
		    autoplay: true,
		    autoplayTimeout: 3000,
		    autoplayHoverPause: true,
		    responsive: {
		        0:{
		            items:1,
		            nav: true,
		            dots: false
		        },
		        480:{
		            items:1,
		            nav: true,
		            dots: false
		        },
		        600:{
		            items:1,
		            nav: true,
		            dots: false
		        },
		        1000:{
		            items:2
		        },
		        1200:{
		            items:3
		        }
		    }
		});
	}
}

// 6 clientsCarosule
function clientsCarosule () {
	if ($('.clients-carousel').length) {
		$('.clients-carousel').owlCarousel({
		    loop: true,
		    margin: 50,
		    nav: false,
		    dots: false,
		    autoplay: true,
		    autoplayTimeout: 3000,
		    autoplayHoverPause: true,
		    responsive: {
		        0:{
		            items:2
		        },
		        480:{
		            items:3
		        },
		        600:{
		            items:4
		        },
		        1000:{
		            items:5
		        },
		        1200:{
		            items:5
		        }
		    }
		}); 
	}
}

// 7 CounterNumberChanger
function CounterNumberChanger () {
	var timer = $('.timer');
	if(timer.length) {
		timer.appear(function () {
			timer.countTo();
		})
	}
}

// 8 stickyHeader
function stickyHeader () {
	if ($('.stricky').length) {
		var strickyScrollPos = $('.stricky').next().offset().top;
		if($(window).scrollTop() > strickyScrollPos) {
			$('.stricky').removeClass('fadeIn animated');
	      	$('.stricky').addClass('stricky-fixed fadeInDown animated');
		}
		else if($(this).scrollTop() <= strickyScrollPos) {
			$('.stricky').removeClass('stricky-fixed fadeInDown animated');
	      	$('.stricky').addClass('slideIn animated');
		}
	};
}

//9 Update Header Style + Scroll to Top
function scrollToTop() {
	if($('.page-wrapper').length){
		var topHeader = $('.top-bar').innerHeight();
		var windowpos = $(window).scrollTop();
		if (windowpos >= topHeader) {
			$('.page-wrapper').addClass('fixed-header');
			$('.scroll-to-top').fadeIn(300);
		} else {
			$('.page-wrapper').removeClass('fixed-header');
			$('.scroll-to-top').fadeOut(300);
		}
	}
}

//10 Scroll to top
if($('.scroll-to-top').length){
	$(".scroll-to-top").on('click', function() {
	   // animate
	   $('html, body').animate({
		   scrollTop: $('html, body').offset().top
		 }, 1000);

	});
}

// 11 contactFormValidation
function contactFormValidation () {

	if($('.contact-form').length){
		$('.contact-form').each(function () {
			
			var cfName = $(this).attr('id');

			$('#'+cfName).validate({ // initialize the plugin
				rules: {
					name: {
						required: true
					},
					email: {
						required: true,
						email: true
					},
					message: {
						required: true
					},
					date: {
						required: true
					},
					category: {
						required: true
					},
					phone: {
						required: true
					},
					gender: {
						required: true
					},
					dateOfBirth: {
						required: true
					},
					subject: {
						required: true
					}
				},
				submitHandler: function (form) { 
					// sending value with ajax request
					$.post($(form).attr('action'), $(form).serialize(), function (response) {
						$(form).parent('div').append(response);
						$(form).find('input[type="text"]').val('');
						$(form).find('input[type="email"]').val('');
						$(form).find('textarea').val('');
					});
					return false;
				}
			});
		});
	}
}



// 12 Common CssJs
	$('[data-bg-color]').each(function() {
        $(this).css("cssText", "background: " + $(this).data("bg-color") + " !important;");
    });
    $('[data-bg-img]').each(function() {
        $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
    });
    $('[data-text-color]').each(function() {
        $(this).css('color', $(this).data("text-color"));
    });
    $('[data-font-size]').each(function() {
        $(this).css('font-size', $(this).data("font-size"));
    });
    $('[data-height]').each(function() {
        $(this).css('height', $(this).data("height"));
    });
    $('[data-border]').each(function() {
        $(this).css('border', $(this).data("border"));
    });
    $('[data-border-left]').each(function() {
        $(this).css('border-left', $(this).data("border-left"));
    });
    $('[data-margin-top]').each(function() {
        $(this).css('margin-top', $(this).data("margin-top"));
    });
    $('[data-margin-left]').each(function() {
        $(this).css('margin-left', $(this).data("margin-left"));
    });
    $('[data-margin-bottom]').each(function() {
        $(this).css('margin-bottom', $(this).data("margin-bottom"));
    });


// 13 selectInput
function selectInput () {
	if ($('.select-input').length) {
		$('.select-input').selectmenu();
	};
}


// 14 gMap
function gMap () {
	if ($('.google-map').length) {
        $('.google-map').each(function () {
        	// getting options from html 
        	var mapName = $(this).attr('id');
        	var mapLat = $(this).data('map-lat');
        	var mapLng = $(this).data('map-lng');
        	var iconPath = $(this).data('icon-path');
        	var mapZoom = $(this).data('map-zoom');
        	var mapTitle = $(this).data('map-title');

        	// if zoom not defined the zoom value will be 15;
        	if (!mapZoom) {
        		var mapZoom = 15;
        	};
        	// init map
        	var map;
            map = new GMaps({
                div: '#'+mapName,
                scrollwheel: false,
                lat: mapLat,
                lng: mapLng,
                zoom: mapZoom
            });
            // if icon path setted then show marker
            if(iconPath) {
        		map.addMarker({
	            	icon: iconPath,
	                lat: mapLat,
	                lng: mapLng,
	                title: mapTitle
	            });
        	}
        });  
	};
}

// 15 mobileMenu
function mobileMenu () {
	if ($('.navigation .nav-footer button').length) {
		$('.navigation .nav-footer button').on('click', function () {
			$('.navigation .nav-header').slideToggle();
			$('.navigation .nav-header').find('.dropdown').children('a').append(function () {
				return '<button><i class="fa fa-bars"></i></button>';
			});
			$('.navigation .nav-header .dropdown a button').on('click', function () {
				$(this).parent().parent().children('ul.submenu').slideToggle();
				return false;
			});
		});
	};
}

