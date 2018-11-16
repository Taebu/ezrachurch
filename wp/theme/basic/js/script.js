/**
 * @function      Include
 * @description   Includes an external scripts to the page
 * @param         {string} scriptUrl
 */
function include(scriptUrl) {
    document.write('<script src="' + scriptUrl + '"></script>');
}


/**
 * @function      isIE
 * @description   checks if browser is an IE
 * @returns       {number} IE Version
 */
function isIE() {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
};


/**
 * @module       Copyright
 * @description  Evaluates the copyright year
 */
;
(function ($) {
    var currentYear = (new Date).getFullYear();
    $(document).ready(function () {
        $("#copyright-year").text((new Date).getFullYear());
    });
})($);


/**
 * @module       IE Fall&Polyfill
 * @description  Adds some loosing functionality to old IE browsers
 */
;
(function ($) {
    if (isIE() && isIE() < 11) {
        include('js/pointer-events.min.js');
        $('html').addClass('lt-ie11');
        $(document).ready(function () {
            PointerEventsPolyfill.initialize({});
        });
    }

    if (isIE() && isIE() < 10) {
        $('html').addClass('lt-ie10');
    }
})($);


/**
 * @module       WOW Animation
 * @description  Enables scroll animation on the page
 */
;
(function ($) {
    var o = $('html');
    if (o.hasClass('desktop') && o.hasClass("wow-animation") && $(".wow").length) {
        include('js/wow.min.js');

        $(document).ready(function () {
            new WOW().init();
        });
    }
})($);


/**
 * @module       Smoothscroll
 * @description  Enables smooth scrolling on the page
 */
;
(function ($) {
    if ($("html").hasClass("smoothscroll")) {
        include('js/smoothscroll.min.js');
    }
})($);

/**
 * @module       RD Smoothscroll
 * @description  Enables smooth scrolling on the page for all platforms
 */
;
(function ($) {
    if ($("html").hasClass("smoothscroll-all")) {
        include('js/rd-smoothscroll.min.js');
    }
})($);


/**
 * @module       ToTop
 * @description  Enables ToTop Plugin
 */
;
(function ($) {
    var o = $('html');
    if (o.hasClass('desktop')) {
        include('js/jquery.ui.totop.min.js');

        $(document).ready(function () {
            $().UItoTop({
                easingType: 'easeOutQuart',
                containerClass: 'ui-to-top fa fa-angle-up'
            });
        });
    }
})($);

/**
 * @module       Responsive Tabs
 * @description  Enables Easy Responsive Tabs Plugin
 */
;
(function ($) {
    var o = $('.responsive-tabs');
    if (o.length > 0) {
        include('js/jquery.easy-responsive-tabs.min.js');

        $(document).ready(function () {
            o.each(function () {
                var $this = $(this);
                $this.easyResponsiveTabs({
                    type: $this.attr("data-type") === "accordion" ? "accordion" : "default"
                });
            })
        });
    }
})($);


/**
 * @module       RD Google Map
 * @description  Enables RD Google Map Plugin
 */
;
(function ($) {
    var o = document.getElementById("google-map");
    if (o) {
        include('//maps.google.com/maps/api/js?sensor=false');
        include('js/jquery.rd-google-map.js');

        $(document).ready(function () {
            var o = $('#google-map');
            if (o.length > 0) {
                o.googleMap({
                    styles: [{
                        "featureType": "landscape",
                        "stylers": [{"hue": "#FFBB00"}, {"saturation": 43.400000000000006}, {"lightness": 37.599999999999994}, {"gamma": 1}]
                    }, {
                        "featureType": "road.highway",
                        "stylers": [{"hue": "#FFC200"}, {"saturation": -61.8}, {"lightness": 45.599999999999994}, {"gamma": 1}]
                    }, {
                        "featureType": "road.arterial",
                        "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 51.19999999999999}, {"gamma": 1}]
                    }, {
                        "featureType": "road.local",
                        "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 52}, {"gamma": 1}]
                    }, {
                        "featureType": "water",
                        "stylers": [{"hue": "#0078FF"}, {"saturation": -13.200000000000003}, {"lightness": 2.4000000000000057}, {"gamma": 1}]
                    }, {
                        "featureType": "poi",
                        "stylers": [{"hue": "#00FF6A"}, {"saturation": -1.0989010989011234}, {"lightness": 11.200000000000017}, {"gamma": 1}]
                    }]
                });
            }
        });
    }
})
($);


/**
 * @module       RD Navbar
 * @description  Enables RD Navbar Plugin
 */
;
(function ($) {
    var o = $('.rd-navbar');
    if (o.length > 0) {
        include('js/jquery.rd-navbar.min.js');

        $(document).ready(function () {
            var responsive = {};

            var aliaces = ["-xs-", "-sm-", "-md-", "-lg-"],
                values = [480, 768, 992, 1200],
                i, j, val;

            responsive[0] = {
                layout: o.attr("data-layout") || "rd-navbar-fixed",
                focusOnHover: o.attr("data-hover-on") === "true",
                stickUp: o.attr("data-stick-up") === "true"
            };

            for (i = 0; i < values.length; i++) {

                //for (j = i; j >= -1; j--) {
                val = '';
                if (o.attr("data" + aliaces[i] + "layout")) {
                    if (!responsive[values[i]]) responsive[values[i]] = {};
                    if (!responsive[values[i]]["layout"]) {
                        responsive[values[i]]["layout"] = o.attr("data" + aliaces[i] + "layout");
                    }
                }

                if (o.attr("data" + aliaces[i] + "hover-on")) {
                    if (!responsive[values[i]]) responsive[values[i]] = {};
                    if (!responsive[values[i]]["focusOnHover"]) {
                        val = o.attr("data" + aliaces[i] + "hover-on") === 'true';
                        responsive[values[i]]["focusOnHover"] = val;
                    }
                }

                if (o.attr("data" + aliaces[i] + "stick-up")) {
                    if (!responsive[values[i]]) responsive[values[i]] = {};
                    if (!responsive[values[i]]["stickUp"] && responsive[values[i]]["stickUp"] !== 0) {
                        val = o.attr("data" + aliaces[i] + "stickUp") === 'true';
                        responsive[values[i]]["stickUp"] = val;
                    }
                }
                //}
            }

            // console.log(responsive);

            o.RDNavbar({
                responsive: responsive
            });
        });
    }
})($);


/**
 * @module       Swiper Slider
 * @description  Enables Swiper Plugin
 */
;
(function ($, undefined) {

    var o = $(".swiper-slider");
    if (o.length) {
        include('js/jquery.swiper.min.js');



        function getSwiperHeight(object, attr) {
            var val = object.attr("data-" + attr),
                dim;

            if (!val) {
                return undefined;
            }

            dim = val.match(/(px)|(%)|(vh)$/i);

            if (dim.length) {
                switch (dim[0]) {
                    case "px":
                        return parseFloat(val);
                    case "vh":
                        return $(window).height() * (parseFloat(val) / 100);
                    case "%":
                        return object.width() * (parseFloat(val) / 100);
                }
            } else {
                return undefined;
            }
        }

        function toggleSwiperInnerVideos(swiper) {
            var prevSlide = $(swiper.slides[swiper.previousIndex]),
                nextSlide = $(swiper.slides[swiper.activeIndex]),
                videos;

            prevSlide.find("video").each(function () {
                this.pause();
            });

            videos = nextSlide.find("video");
            if (videos.length) {
                videos.get(0).play();
            }
        }

        function toggleSwiperCaptionAnimation(swiper) {
            var prevSlide = $(swiper.container),
                nextSlide = $(swiper.slides[swiper.activeIndex]);

            prevSlide
                .find("[data-caption-animate]")
                .each(function () {
                    var $this = $(this);
                    $this
                        .removeClass("animated")
                        .removeClass($this.attr("data-caption-animate"))
                        .addClass("not-animated");
                });

            nextSlide
                .find("[data-caption-animate]")
                .each(function () {
                    var $this = $(this),
                        delay = $this.attr("data-caption-delay");

                    setTimeout(function () {
                        $this
                            .removeClass("not-animated")
                            .addClass($this.attr("data-caption-animate"))
                            .addClass("animated");
                    }, delay ? parseInt(delay) : 0);
                });
        }

        $(document).ready(function () {
            o.each(function () {
                var s = $(this);

                var pag = s.find(".swiper-pagination"),
                    next = s.find(".swiper-button-next"),
                    prev = s.find(".swiper-button-prev"),
                    bar = s.find(".swiper-scrollbar"),
                    h = getSwiperHeight(o, "height"), mh = getSwiperHeight(o, "min-height");
                s.find(".swiper-slide")
                    .each(function () {
                        var $this = $(this),
                            url;
                        if (url = $this.attr("data-slide-bg")) {
                            $this.css({
                                "background-image": "url(" + url + ")",
                                "background-size": "cover"
                            })
                        }
                    })
                    .end()
                    .find("[data-caption-animate]")
                    .addClass("not-animated")
                    .end()
                    .swiper({
                        autoplay: s.attr('data-autoplay') ? s.attr('data-autoplay') === "false" ? undefined : s.attr('data-autoplay') : 5000,
                        direction: s.attr('data-direction') ? s.attr('data-direction') : "horizontal",
                        effect: s.attr('data-slide-effect') ? s.attr('data-slide-effect') : "slide",
                        speed: s.attr('data-slide-speed') ? s.attr('data-slide-speed') : 600,
                        keyboardControl: s.attr('data-keyboard') === "true",
                        mousewheelControl: s.attr('data-mousewheel') === "true",
                        mousewheelReleaseOnEdges: s.attr('data-mousewheel-release') === "true",
                        nextButton: next.length ? next.get(0) : null,
                        prevButton: prev.length ? prev.get(0) : null,
                        pagination: pag.length ? pag.get(0) : null,
                        //allowSwipeToNext: false,
                        //allowSwipeToPrev: false,
                        paginationClickable: pag.length ? pag.attr("data-clickable") !== "false" : false,
                        paginationBulletRender: pag.length ? pag.attr("data-index-bullet") === "true" ? function (index, className) {
                            return '<span class="' + className + '">' + (index + 1) + '</span>';
                        } : null : null,
                        scrollbar: bar.length ? bar.get(0) : null,
                        scrollbarDraggable: bar.length ? bar.attr("data-draggable") !== "false" : true,
                        scrollbarHide: bar.length ? bar.attr("data-draggable") === "false" : false,
                        loop: s.attr('data-loop') !== "false",
                        simulateTouch: false,
                        threshold: 2000,
                        onTransitionStart: function (swiper) {
                            toggleSwiperInnerVideos(swiper);
                        },
                        onTransitionEnd: function (swiper) {
                            toggleSwiperCaptionAnimation(swiper);
                        },
                        onInit: function (swiper) {
                            toggleSwiperInnerVideos(swiper);
                            toggleSwiperCaptionAnimation(swiper);
                        }
                    });

                $(window)
                    .on("resize", function () {
                        var mh = getSwiperHeight(s, "min-height"),
                            h = getSwiperHeight(s, "height");
                        if (h) {
                            s.css("height", mh ? mh > h ? mh : h : h);
                        }
                    })
                    .trigger("resize");
            });
        });
    }

    // Gallery init
    var gallery = $('.swiper-container');
    if (gallery.length) {
        $(document).ready(function () {
            var galleryTop = new Swiper('.gallery-top', {
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 10
            });

            var galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 10,
                centeredSlides: true,
                slidesPerView: 'auto',
                touchRatio: 0.2,
                slideToClickedSlide: true
            });

            galleryTop.params.control = galleryThumbs;
            galleryThumbs.params.control = galleryTop;
            //galleryThumbs.slideTo( $('.first-el').index(),1000,false );
            $(".first-el").click(function(){
                var v = $(this).index();
                galleryThumbs.slideTo(v, 1000,false);
            });$('.first-el').click();
        });
    }
// End Gallery init

})($);


/**
 * @module       Progress Bar custom
 * @description  Enables Progress Bar Plugin
 */
;
(function ($) {
    var o = $(".progress-bar-custom");
    if (o.length) {
        include('js/progressbar.min.js');

        function isScrolledIntoView(elem) {
            var $window = $(window);
            return elem.offset().top + elem.outerHeight() >= $window.scrollTop() && elem.offset().top <= $window.scrollTop() + $window.height();
        }

        $(document).ready(function () {
            o.each(function () {
                var bar, type;
                if (
                    this.className.indexOf("progress-bar-horizontal") > -1
                ) {
                    type = 'Line';
                }

                if (
                    this.className.indexOf("progress-bar-radial") > -1
                ) {
                    type = 'Circle';
                }

                if (this.getAttribute("data-stroke") && this.getAttribute("data-value") && type) {
                    //console.log(this.offsetWidth);
                    //console.log(parseFloat(this.getAttribute("data-stroke")) / this.offsetWidth * 100);
                    bar = new ProgressBar[type](this, {
                        strokeWidth: Math.round(parseFloat(this.getAttribute("data-stroke")) / this.offsetWidth * 100)
                        ,
                        trailWidth: this.getAttribute("data-trail") ? Math.round(parseFloat(this.getAttribute("data-trail")) / this.offsetWidth * 100) : 0
                        ,
                        text: {
                            value: this.getAttribute("data-counter") === "true" ? '0' : null
                            , className: 'progress-bar__body'
                            , style: null
                        }
                    });

                    bar.svg.setAttribute('preserveAspectRatio', "none meet");
                    if (type === 'Line') {
                        bar.svg.setAttributeNS(null, "height", this.getAttribute("data-stroke"));
                    }

                    bar.path.removeAttribute("stroke");
                    bar.path.className.baseVal = "progress-bar__stroke";
                    if (bar.trail) {
                        bar.trail.removeAttribute("stroke");
                        bar.trail.className.baseVal = "progress-bar__trail";
                    }

                    if (this.getAttribute("data-easing") && !isIE()) {
                        $(document)
                            .on("scroll", $.proxy(function () {
                                //console.log(isScrolledIntoView(this));
                                if (isScrolledIntoView($(this)) && this.className.indexOf("progress-bar--animated") === -1) {
                                    console.log(1);
                                    this.className += " progress-bar--animated";
                                    bar.animate(parseInt(this.getAttribute("data-value")) / 100.0, {
                                        easing: this.getAttribute("data-easing")
                                        ,
                                        duration: this.getAttribute("data-duration") ? parseInt(this.getAttribute("data-duration")) : 800
                                        ,
                                        step: function (state, b) {
                                            if (b._container.className.indexOf("progress-bar-horizontal") > -1 ||
                                                b._container.className.indexOf("progress-bar-vertical") > -1) {
                                                b.text.style.width = Math.abs(b.value() * 100).toFixed(0) + "%"
                                            }
                                            b.setText(Math.abs(b.value() * 100).toFixed(0));
                                        }
                                    });
                                }
                            }, this))
                            .trigger("scroll");
                    } else {
                        bar.set(parseInt(this.getAttribute("data-value")) / 100.0);
                        bar.setText(this.getAttribute("data-value"));
                        if (type === 'Line') {
                            bar.text.style.width = parseInt(this.getAttribute("data-value")) + "%";
                        }
                    }
                } else {
                    console.error(this.className + ": progress bar type is not defined");
                }
            });
        });
    }
})($);


/**
 * @module       Count To
 * @description  Enables Count To Plugin
 */
;
(function ($) {
    var o = $('.counter');
    if (o.length > 0) {
        include('js/jquery.countTo.js');
        $(document).ready(function () {
            $(document)
                //$(this).scroll(function () {
                .on("scroll", $.proxy(function () {
                    o.not('.animated').each(function () {
                        var $this = $(this);
                        var position = $this.offset().top;

                        if (($(window).scrollTop() + $(window).height()) > position) {

                            $this.countTo();
                            $this.addClass('animated');
                        }
                    });
                }, $(this)))
                .trigger("scroll");
        });
    }
})($);

/**
 * @module      Progress Horizontal Bootstrap
 * @description  Enables Animation
 */
;
(function ($) {
    var o = $('.progress-bar');
    if (o.length > 0) {
        include('js/jquery.counter.js');
        $(document).ready(function () {
            $(document)
                //$(this).scroll(function () {
                .on("scroll", $.proxy(function () {
                    o.not('.animated').each(function () {

                        var position = $(this).offset().top;

                        if (($(window).scrollTop() + $(window).height()) > position) {
                            var $this = $(this);
                            var start = $this.attr("aria-valuemin");
                            var end = $this.attr("aria-valuenow");
                            $this.css({width: end + '%'});

                            $this.parent().find('span').counter({
                                start: start,
                                end: end,
                                time: 0.4,
                                step: 20
                            });

                            //var span = $this.parent().find('span');
                            //
                            //span.prop('Counter', start).animate({
                            //    Counter: end
                            //}, {
                            //    duration: 1000,
                            //    easing: 'linear',
                            //    step: function (now) {
                            //        $(this).text(Math.ceil(now));
                            //    }
                            //});
                            $this.addClass('animated');
                        }

                    });
                }, $(this)))
                .trigger("scroll");
        });
    }
})($);


/**
 * @module       RD Parallax 3.5.0
 * @description  Enables RD Parallax 3.5.0 Plugin
 */

;
(function ($) {
    var o = $('.rd-parallax');
    if (o.length) {
        include('js/jquery.rd-parallax.min.js');
        $(document).ready(function () {
            o.each(function () {
                if (!$(this).parents(".swiper-slider").length) {
                    $.RDParallax();
                }
            });
        });
    }
})(jQuery);



//
///**
// * @module       magnifierRentgen
// * @description   magnifierRentgen
// */
//


//(function ($) {
//    var o = $('.img_zoom');
//    if (o.length) {
//        include("js/jQuery.MagnifierRentgen.min.js");
//        $(document).ready(function () {
//            o.each(function () {
//                $(this).magnifierRentgen();
//            });
//        });
//    }
//})($);

//
///**
// * @module       ElevateZoom
// * @description   Elevate Web Design
// */
//

//;
//(function ($) {
//    var o = $('.img_zoom');
//    if (o.length) {
//
//        include("js/jquery.elevatezoom.js");
//        include("js/jquery.elevateZoom-3.0.8.min.js");
//
//        add_dataZoom = function(el){
//            var s = el;
//            if(s.parents(".swiper-slide-active").length) {
//
//                //var src = s.attr('src');
//                var res = s.attr("src").match(/([\w\d-\/]+)(.jpg$)/i);
//                console.log(res);
//                s.attr('data-zoom-image',res[1] + "_original" + res[2]);
//
//                s.elevateZoom({
//                    //zoomType : "inner",
//                    zoomType: "lens",
//                    //gallery:'gallery_01',
//                    //cursor: 'pointer',
//                    cursor: "crosshair",
//                    //galleryActiveClass: 'active',
//                    lensShape: "round",
//                    lensSize: 200,
//                    zoomWindowFadeIn: 500,
//                    zoomWindowFadeOut: 500,
//                    //imageCrossfade: true,
//                    //loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
//                });
//            }
//        };
//
//        $(document).ready(function () {
//            o.each(function () {
//                var image = $(this);
//                add_dataZoom(image);
//
//                    $('.gallery-thumbs .swiper-slide').on("click", function(){
//                        $(".zoomContainer").remove();
//                        $("[data-zoom-image]").removeAttr("data-zoom-image");
//                        add_dataZoom(image);
//                });
//            });
//        });
//    }
//})($);


/**
 * @module       tooltip
 * @description  Bootstrap tooltips
 */


$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


/**
 * @module       Tabs
 * @description  Bootstrap tabs
 */


$('#myTabs a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
})

$('#myTabs2 a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
})




/**
 * @module     Owl Carousel
 * @description Enables Owl Carousel Plugin
 */
;
(function ($) {
    var o = $('.owl-carousel');
    if (o.length) {
        include('js/jquery.owl-carousel.js');

        var isTouch = "ontouchstart" in window;

        function preventScroll(e) {
            e.preventDefault();
        }

        $(document).ready(function () {
            o.each(function () {
                var c = $(this),
                    responsive = {};

                var aliaces = ["-", "-xs-", "-sm-", "-md-", "-lg-"],
                    values = [0, 480, 768, 992, 1200],
                    i, j;

                for (i = 0; i < values.length; i++) {
                    responsive[values[i]] = {};
                    for (j = i; j >= -1; j--) {
                        if (!responsive[values[i]]["items"] && c.attr("data" + aliaces[j] + "items")) {
                            responsive[values[i]]["items"] = j < 0 ? 1 : parseInt(c.attr("data" + aliaces[j] + "items"));
                        }
                        if (!responsive[values[i]]["stagePadding"] && responsive[values[i]]["stagePadding"] !== 0 && c.attr("data" + aliaces[j] + "stage-padding")) {
                            responsive[values[i]]["stagePadding"] = j < 0 ? 0 : parseInt(c.attr("data" + aliaces[j] + "stage-padding"));
                        }
                        if (!responsive[values[i]]["margin"] && responsive[values[i]]["margin"] !== 0 && c.attr("data" + aliaces[j] + "margin")) {
                            responsive[values[i]]["margin"] = j < 0 ? 30 : parseInt(c.attr("data" + aliaces[j] + "margin"));
                        }
                    }
                }
                // console.log('string', c);
                c.owlCarousel({
                    autoplay: c.attr("data-autoplay") === "true",
                    loop: c.attr("data-loop") !== "false",
                    item: 1,
                    mouseDrag: c.attr("data-mouse-drag") !== "false",
                    nav: c.attr("data-nav") === "true",
                    dots: c.attr("data-dots") === "true",
                    dotsEach: c.attr("data-dots-each") ? parseInt(c.attr("data-dots-each")) : false,
                    responsive: responsive,
                    navText: [],
                    onInitialized: function () {
                        if ($.fn.magnificPopup) {
                            var o = this.$element.attr('data-lightbox') !== "gallery",
                                g = this.$element.attr('data-lightbox') === "gallery";

                            if (o) {
                                this.$element.each(function () {
                                    var $this = $(this);
                                    $this.magnificPopup({
                                        type: $this.attr("data-lightbox"),
                                        callbacks: {
                                            open: function () {
                                                if (isTouch) {
                                                    $(document).on("touchmove", preventScroll);
                                                    $(document).swipe({
                                                        swipeDown: function () {
                                                            $.magnificPopup.close();
                                                        }
                                                    });
                                                }
                                            },
                                            close: function () {
                                                if (isTouch) {
                                                    $(document).off("touchmove", preventScroll);
                                                    $(document).swipe("destroy");
                                                }
                                            }
                                        }
                                    });
                                })
                            }

                            if (g) {
                                this.$element.each(function () {
                                    var $gallery = $(this);

                                    $gallery
                                        .find('[data-lightbox]').each(function () {
                                            var $item = $(this);
                                            $item.addClass("mfp-" + $item.attr("data-lightbox"));
                                        })
                                        .end()
                                        .magnificPopup({
                                            delegate: '.owl-item:not(.cloned) .owl-item [data-lightbox]',
                                            type: "image",
                                            gallery: {
                                                enabled: true
                                            },
                                            callbacks: {
                                                open: function () {
                                                    if (isTouch) {
                                                        $(document).on("touchmove", preventScroll);
                                                        $(document).swipe({
                                                            swipeDown: function () {
                                                                $.magnificPopup.close();
                                                            }
                                                        });
                                                    }
                                                },
                                                close: function () {
                                                    if (isTouch) {
                                                        $(document).off("touchmove", preventScroll);
                                                        $(document).swipe("destroy");
                                                    }
                                                }
                                            }
                                        });
                                })
                            }
                        }
                    }
                });
            });
        });
    }
})($);


/**
 * @module       SVG-Animate
 * @description  Enables SVG-Animate *
 */

;
(function ($) {
    var o = $('#svg-phone_1'),
        msie = !!navigator.userAgent.match(/Trident\/7\./);
    //(!document.all) - is IE11-
    if ((o.length) && (!msie)) {

        $(document).ready(function () {
            $(this).on("scroll", $.proxy(function () {
                o.not('.active').each(function () {
                    var $this = $(this);
                    var position = $this.offset().top;

                    if (($(window).scrollTop() + $(window).height()) > position) {
                        $this.attr("class", "active");
                        $this.parent().find('.phone_1').addClass('active');
                    }
                });
            }, $(this)))
                .trigger("scroll");
        });
    }
})($);


/**
 * @module       ViewPort Universal
 * @description  Add class in viewport
 */


;
(function ($) {
    var o = $('.view-animate');
    if (o.length) {

        $(document).ready(function () {
            $(this).on("scroll", $.proxy(function () {
                o.not('.active').each(function () {
                    var $this = $(this);
                    var position = $this.offset().top;

                    if (($(window).scrollTop() + $(window).height()) > position) {
                        $this.addClass("active");
                    }
                });
            }, $(this)))
                .trigger("scroll");
        });
    }
})($);


/**
 * @module       Scroll To
 * @description  Enables Scroll To
 */
;
(function ($) {
    var o = $('.questions');
    if (o.length) {
        include('js/scrollTo.js');
        $(document).ready(function () {
            o.scrollTo({});
        });
    }
})($);


/**
 * @module       RD Search
 * @description  Enables RD Search Plugin
 */
;
(function ($) {
    var o = $('.rd-navbar-search');
    if (o.length) {
        include('js/jquery.search.min.js');
        $(document).ready(function () {
            o.RDSearch({});
        });
    }
})($);


/**
 * @module       Countdown
 * @description  Enables RD Search Plugin
 */
;
(function ($) {
    var o = $('#DateCountdown');
    if (o.length) {
        include('js/TimeCircles.js');
        $(document).ready(function () {
            var time = {
                "Days": {
                    "text": "Days",
                    "color": "#FFF",
                    "show": true
                },
                "Hours": {
                    "text": "Hours",
                    "color": "#fff",
                    "show": true
                },
                "Minutes": {
                    "text": "Minutes",
                    "color": "#fff",
                    "show": true
                },
                "Seconds": {
                    "text": "Seconds",
                    "color": "#fff",
                    "show": true
                }
            };
            o.TimeCircles({
                "animation": "smooth",
                "bg_width": 0.4,
                "fg_width": 0.02666666666666667,
                "circle_bg_color": "rgba(0,0,0,.2)",
                "time": time
            });
            $(window).on('load resize orientationchange', function () {
                if ($(window).width() < 479) {
                    o.TimeCircles({
                        time: {
                            //Days: {show: true},
                            //Hours: {show: true},
                            Minutes: {show: true},
                            Seconds: {show: false}
                        }
                    }).rebuild();
                } else if ($(window).width() < 767) {
                    o.TimeCircles({
                        time: {
                            //Minutes: {show: true},
                            Seconds: {show: false}
                        }
                    }).rebuild();
                } else {
                    o.TimeCircles({time: time}).rebuild();
                }
            });
        });

    }
})(jQuery);


/**
 * @module       Magnific Popup
 * @description  Enables Magnific Popup Plugin
 */
;
(function ($) {
    var o = $('[data-lightbox]').not('[data-lightbox="gallery"] [data-lightbox]'),
        g = $('[data-lightbox^="gallery"]');
    if (o.length > 0 || g.length > 0) {
        include('js/jquery.magnific-popup.min.js');

        $(document).ready(function () {
            if (o.length) {
                o.each(function () {
                    var $this = $(this);
                    $this.magnificPopup({
                        type: $this.attr("data-lightbox")
                    });
                })
            }

            if (g.length) {
                g.each(function () {
                    var $gallery = $(this);
                    $gallery
                        .find('[data-lightbox]').each(function () {
                            var $item = $(this);
                            $item.addClass("mfp-" + $item.attr("data-lightbox"));
                        })
                        .end()
                        .magnificPopup({
                            delegate: '[data-lightbox]',
                            type: "image",
                            // Delay in milliseconds before popup is removed
                            removalDelay: 300,
                            // Class that is added to popup wrapper and background
                            // make it unique to apply your CSS animations just to this exact popup
                            mainClass: 'mfp-fade',
                            gallery: {
                                enabled: true
                            }
                        });
                })
            }
        });
    }
})(jQuery);




/**
 * @module       Isotope
 * @description  Enables Isotope Plugin
 */
;
(function ($) {
    var o = $(".isotope");
    if (o.length) {
        include('js/isotope.pkgd.min.js');

        $(document).ready(function () {
            o.each(function () {
                var _this = this
                    , iso = new Isotope(_this, {
                        itemSelector: '[class*="col-"], .isotope-item',
                        layoutMode: _this.getAttribute('data-layout') ? _this.getAttribute('data-layout') : 'masonry'
                    });

                $(window).on("resize", function () {
                    iso.layout();
                });

                $(window).load(function () {
                    iso.layout();
                    setTimeout(function () {
                        _this.className += " isotope--loaded";
                        iso.layout();
                    }, 600);
                });
            });

            $(".isotope-filters-trigger").on("click", function () {
                $(this).parents(".isotope-filters").toggleClass("active");
            });

            $('.isotope').magnificPopup({
                delegate: ' > :visible .mfp-image',
                type: "image",
                gallery: {
                    enabled: true
                },
            });

            $("[data-isotope-filter]").on("click", function () {
                $('[data-isotope-filter][data-isotope-group="' + this.getAttribute("data-isotope-group") + '"]').removeClass("active");
                $(this).addClass("active");
                $(this).parents(".isotope-filters").removeClass("active");
                $('.isotope[data-isotope-group="' + this.getAttribute("data-isotope-group") + '"]')
                    .isotope({filter: this.getAttribute("data-isotope-filter") == '*' ? '*' : '[data-filter="' + this.getAttribute("data-isotope-filter") + '"]'});
            })
        });
    }
})(jQuery);



/**
 * @module       Onclick functions
 * @description  Add ... to onclick
 */

;
(function ($) {
    var o = $('.timeline');
    if (o.length) {
        $(document).ready(function () {
            o.find(".timeline-btn").on("click", function(){
                $(this).toggleClass("active");
                // o.find(".timeline-hidden").toggleClass("active");
                if (o.find(".timeline-hidden").is(':hidden')){
                o.find(".timeline-hidden").slideDown(800);
            }else{
                o.find(".timeline-hidden").slideUp(800);
            }
            });
        });
    }
})($);



/**
 * @module     RD Input Label
 * @description Enables RD Input Label Plugin
 */
;
(function ($) {
    var o = $('.form-label');
    if (o.length) {
        include('js/mailform/jquery.rd-input-label.js');

        $(document).ready(function () {
            o.RDInputLabel();
        });
    }
})(jQuery);

/* Mailform
 =============================================*/
;
(function ($) {
    var o = $('.rd-mailform');
    if (o.length > 0) {
        include('js/mailform/jquery.form.min.js');
        include('js/mailform/jquery.rd-mailform.min.js');

        $(document).ready(function () {
            var o = $('.rd-mailform');

            if (o.length) {
                o.rdMailForm({
                    validator: {
                        'constraints': {
                            '@LettersOnly': {
                                message: 'Please use letters only!'
                            },
                            '@NumbersOnly': {
                                message: 'Please use numbers only!'
                            },
                            '@NotEmpty': {
                                message: 'Field should not be empty!'
                            },
                            '@Email': {
                                message: 'Enter valid e-mail address!'
                            },
                            '@Phone': {
                                message: 'Enter valid phone number!'
                            },
                            '@Date': {
                                message: 'Use MM/DD/YYYY format!'
                            },
                            '@SelectRequired': {
                                message: 'Please choose an option!'
                            }
                        }
                    }
                }, {
                    'MF000': 'Sent',
                    'MF001': 'Recipients are not set!',
                    'MF002': 'Form will not work locally!',
                    'MF003': 'Please, define email field in your form!',
                    'MF004': 'Please, define type of your form!',
                    'MF254': 'Something went wrong with PHPMailer!',
                    'MF255': 'There was an error submitting the form!'
                });
            }
        });
    }
})(jQuery);