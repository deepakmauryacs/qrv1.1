$(window).on('load', function() {
    "use strict";

    /*----------------------------------------------------*/
    /*	Modal Window
    /*----------------------------------------------------*/
    setTimeout(function () {
        $(".modal:not(.auto-off)").modal("show");
    }, 4600);
});

$(window).on('scroll', function() {
    "use strict";

    /*----------------------------------------------------*/
    /*	Navigtion Menu Scroll
    /*----------------------------------------------------*/
    var b = $(window).scrollTop();
    if (b > 80) {
        $(".wsmainfull").addClass("scroll");
    } else {
        $(".wsmainfull").removeClass("scroll");
    }
});

$(document).ready(function() {
    "use strict";

    $('#loading').hide();

    /*----------------------------------------------------*/
    /*	Refresh the Screen on Browser Resize
    /*----------------------------------------------------*/
    $(function($) {
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
        $(window).resize(function() {
            if (windowWidth != $(window).width() || windowHeight != $(window).height()) {
                location.reload();
                return;
            }
        });
    });

    /*----------------------------------------------------*/
    /*	Mobile Menu Toggle
    /*----------------------------------------------------*/
    if ($(window).outerWidth() < 992) {
        $('.wsmenu-list li.nl-simple, .wsmegamenu li, .sub-menu li.h-link').on('click', function() {
            $('body').removeClass("wsactive");
            $('.sub-menu').slideUp('slow');
            $('.wsmegamenu').slideUp('slow');
            $('.wsmenu-click').removeClass("ws-activearrow");
            $('.wsmenu-click02 > i').removeClass("wsmenu-rotate");
        });
    }

    if ($(window).outerWidth() < 992) {
        $('.wsanimated-arrow').on('click', function() {
            $('.sub-menu').slideUp('slow');
            $('.wsmegamenu').slideUp('slow');
            $('.wsmenu-click').removeClass("ws-activearrow");
            $('.wsmenu-click02 > i').removeClass("wsmenu-rotate");
        });
    }

    /*----------------------------------------------------*/
    /*	ScrollUp
    /*----------------------------------------------------*/
    $.scrollUp = function(options) {
        var defaults = {
            scrollName: 'scrollUp',
            topDistance: 600,
            topSpeed: 800,
            animation: 'fade',
            animationInSpeed: 200,
            animationOutSpeed: 200,
            scrollText: '',
            scrollImg: false,
            activeOverlay: false
        };

        var o = $.extend({}, defaults, options),
            scrollId = '#' + o.scrollName;

        $('<a/>', {
            id: o.scrollName,
            href: '#top',
            title: o.scrollText
        }).appendTo('body');

        if (!o.scrollImg) {
            $(scrollId).text(o.scrollText);
        }

        $(scrollId).css({ 'display': 'none', 'position': 'fixed', 'z-index': '99999' });

        $(window).on('scroll', function() {
            switch (o.animation) {
                case "fade":
                    $(($(window).scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed));
                    break;
                case "slide":
                    $(($(window).scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed));
                    break;
                default:
                    $(($(window).scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0));
            }
        });
    };

    $.scrollUp();

    /*----------------------------------------------------*/
    /*	Accordion
    /*----------------------------------------------------*/
    $(".accordion > .accordion-item.is-active").children(".accordion-panel").slideDown();

    $(".accordion > .accordion-item").on('click', function() {
        $(this).siblings(".accordion-item").removeClass("is-active").children(".accordion-panel").slideUp();
        $(this).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
    });
    
    
    /*----------------------------------------------------*/
		/*	Testimonials Rotator
	/*----------------------------------------------------*/
	
	var owl = $('.reviews-carousel');
		owl.owlCarousel({
			items: 3,
			loop:true,
			autoplay:true,
			navBy: 1,
			autoplayTimeout: 4500,
			autoplayHoverPause: true,
			smartSpeed: 1500,
			responsive:{
				0:{
					items:1
				},
				767:{
					items:1
				},
				768:{
					items:2
				},
				991:{
					items:3
				},
				1000:{
					items:3
				}
			}
	});


    /*----------------------------------------------------*/
    /*	Show Password
    /*----------------------------------------------------*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function() {
        if (showPass == 0) {
            $(this).next('input').attr('type', 'text');
            $(this).find('span.eye-pass').removeClass('flaticon-visibility');
            $(this).find('span.eye-pass').addClass('flaticon-invisible');
            showPass = 1;
        } else {
            $(this).next('input').attr('type', 'password');
            $(this).find('span.eye-pass').addClass('flaticon-visibility');
            $(this).find('span.eye-pass').removeClass('flaticon-invisible');
            showPass = 0;
        }
    });

});
