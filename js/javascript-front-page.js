var haveNotifiedOfBeta = false;
function notifyBeta() {
	if(!haveNotifiedOfBeta && !setup.debugging) {
		alert("Denne nettsida er endå ikkje optimaliset for mobil! Jobbar med saken! :)");
		haveNotifiedOfBeta = !haveNotifiedOfBeta;
	}
	return true;
}

// Navigate in featured gallery
var arrayOfFeaturedsOffsetTopPosition = [];

var featured = {

}














// Not yet sorted...............................

// Disable / enable scrolling
// Since scroll events cannot be canceled.
// Credit to galamvalazs (http://stackoverflow.com/questions/4770025/how-to-disable-scrolling-temporarily)
// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}



var feature, header, featureBackground, featureContainer;
$(document).on('ready', function() {

	header = {
		height: $('#header').height(),
	};

	featureBackground = $('.feature_background_container').eq(0);
	featureContainer = $('.feature_container').eq(0);

	feature = {
		slide: {
			settings: {
				speed: 600, // ms
				threshold: 100, // px
				easing: "easeOutExpo",
			},

			difference: 0,
			visiting: false,
			current: 0,
			zeroValue: 0,
			computerScrolling: false,
			slideCount: 3,
			slides: [],
			targetOffsetTop: 0,

			goTo: function(index) {
				// If the computer isn't already scrolling; scroll.
				if(!feature.slide.computerScrolling) {
					disableScroll();
					feature.slide.computerScrolling = true;
					console.log("Start scrolling, computerScrolling = " + feature.slide.computerScrolling);
					feature.slide.current = index;
					feature.slide.targetOffsetTop = $('.feature_instance').eq(index).offset().top - feature.padding.top[index];
					console.log($('.feature_instance').eq(index).offset().top + " - " + feature.padding.top[index] + " targetOffsetTop " + feature.slide.targetOffsetTop);

					$('html, body').animate({
						scrollTop: feature.slide.targetOffsetTop
					}, feature.slide.settings.speed, feature.slide.settings.easing, function() {
						// function to be triggered after the scroll is finished
						setTimeout(function() {
							enableScroll();
							feature.slide.computerScrolling = false;
							feature.slide.current = index;

							console.log("Finished scrolling");
						}, 20);
					});
				}
			},

			next: function() {
				feature.slide.goTo(feature.slide.current + 1);
			},

			previous: function() {
				feature.slide.goTo(feature.slide.current - 1);
			}
		},

		offset: {
			top: featureContainer.offset().top,
		},

		margin: {
			top: Number($('.featured_posts .contain').eq(0).css('margin-top').replace('px', '')),
		},

		// When scrolled to featuredContainer, trueOffset.top === scroll.y
		trueOffset: {
			top: featureContainer.offset().top - Number($('.featured_posts .contain').eq(0).css('margin-top').replace('px', '')) - header.height,
		},

		height: featureBackground.height(),

		totalHeight: featureContainer.height(),

		padding: {
			top: [],
		}
	};


	$(window).on('scroll', function(event) {
		// Set the slides and calculate the slides padding-top, can vary with number of lines
		feature.padding.top = [];
		for (var i = 0; i < feature.slide.slideCount; i++) {
			feature.slide.slides.push($('.feature_instance h1').eq(i));

			// problem with the line height which causes the padding.top to
			// be too small, added 1rem*2 as a quick fix.
			feature.padding.top.push(Math.abs(featureContainer.offset().top + feature.height * i - feature.slide.slides[i].offset().top - setup.rem*2));
		}

		// If scrolled to feature and not passed; fix the background
		if (scroll.y > feature.trueOffset.top &&
			scroll.y < feature.offset.top + feature.totalHeight + feature.margin.top*2) {

			feature.visiting = true;

			featureBackground.addClass('feature_background_container_fixed');
			featureBackground.css({ 'margin-top': 0 });

			feature.slide.zeroValue = feature.trueOffset.top + feature.slide.current * feature.height;
			feature.slide.difference = feature.slide.zeroValue - scroll.y;

			// console.log("on, feature.slide.zeroValue = " + feature.slide.zeroValue + ", difference = " + feature.slide.difference);

			if(Math.abs(feature.slide.difference) > feature.slide.settings.threshold) {
				if(scroll.direction === "up") {
					feature.slide.previous();
				} else {
					feature.slide.next();
				}
			}

		// Else if scrolled past; remove fixed class and set margin-top
		} else if(scroll.y > feature.offset.top + feature.totalHeight + feature.margin.top*2) {
			console.log("Passed");
			feature.visiting = false;

			featureBackground.removeClass('feature_background_container_fixed');
			featureBackground.css({ 'margin-top': feature.totalHeight + feature.height });
		} else {
			console.log("Before");
			feature.visiting = false;

			featureBackground.removeClass('feature_background_container_fixed');
			featureBackground.css({ 'margin-top': 0 });
		}
	});

	setInterval(function() {
		if (feature.visiting &&
			!feature.slide.computerScrolling &&
			// If targetOffsetTop === scroll.y +/- 2px
			// This is needed because the scroll function isn't precise enough.
			// They often had a difference of < 1
			Math.abs(feature.slide.targetOffsetTop - scroll.y) >= 2 &&
			scroll.staticDuration > 250) {

			feature.slide.goTo(feature.slide.current);
		}
	}, 100);
});





/*--------------------------------------------------------------
# Intro slideshow
--------------------------------------------------------------*/
// Description:
// Displays a slideshow in the introduction section. (Top of the page)

// Selects random slide to start with
var introSlideshow = {
	currentSlide: Math.round(Math.random() * ($('.intro_slideshow').length - 1)),

	// Slideshow settings
	slidingSpeed: 12000,
	transitionSpeed: 2000,
	nextSlideEasing: "linear",

	shrinkingTime: 12000 + 2000, // introSlideshow.slidingSpeed + introSlideshow.transitionSpeed,
	defaultSize: "scale(1)",
	startSize: "scale(1.1)",
}

function startIntroSlideshow() {
	$('.intro_slideshow').css({"transition": "opacity 0ms " +  introSlideshow.nextSlideEasing + ", transform 0ms " + introSlideshow.nextSlideEasing});
	$('.intro_slideshow').eq(introSlideshow.currentSlide).css({"opacity": "1", "transform": introSlideshow.startSize});


	setTimeout(function() {
		// Sets transition properties for slideshow
		$('.intro_slideshow').css({"transition": "opacity " + introSlideshow.transitionSpeed + "ms " +  introSlideshow.nextSlideEasing + ", transform " + introSlideshow.shrinkingTime + "ms " + introSlideshow.nextSlideEasing});
		$('.intro_slideshow').eq(introSlideshow.currentSlide).css({"opacity": "1", "transform": introSlideshow.defaultSize});
	}, 10);
}
setup.onLoadHook.push(startIntroSlideshow);

function navigateIntroSlideshow(nextSlide) {
	// If the slideshow is at the end, then restart.
	if(nextSlide > $('.intro_slideshow').length - 1) {
		nextSlide = 0;
	}

	$('.intro_slideshow').eq(introSlideshow.currentSlide).css({"opacity": "0"});

	$('.intro_slideshow').eq(nextSlide).css({"transition": "opacity 0ms " +  introSlideshow.nextSlideEasing + ", transform 0ms " + introSlideshow.nextSlideEasing});
	$('.intro_slideshow').eq(nextSlide).css({"transform": introSlideshow.startSize});

	setTimeout(function() {
		$('.intro_slideshow').eq(nextSlide).css({"opacity": "1", "transform": introSlideshow.startSize});
		$('.intro_slideshow').eq(nextSlide).css({"transition": "opacity " + introSlideshow.transitionSpeed + "ms " +  introSlideshow.nextSlideEasing + ", transform " + introSlideshow.shrinkingTime + "ms " + introSlideshow.nextSlideEasing});
		$('.intro_slideshow').eq(nextSlide).css({"transform": introSlideshow.defaultSize});
	}, 10)

	introSlideshow.currentSlide = nextSlide;
}

setInterval(function() {
	navigateIntroSlideshow(introSlideshow.currentSlide + 1);
}, introSlideshow.slidingSpeed);




/*--------------------------------------------------------------
## Hide intro slideshow
--------------------------------------------------------------*/
// Description:
// Hides the slideshow when user scrolls past it to enhance performance.
// The image has a fixed position and will otherwise stay in the background.

function showIntroSlideshow(boolean) {
	featured.isVisiting = boolean;

	if(boolean) {
		$('#intro').css({"display": "none"});
	} else {
		$('#intro').css({"display": "block"});
	}
}




/*--------------------------------------------------------------
# Hover effects for other projects
--------------------------------------------------------------*/
// Description:
//
function other_projects_hover(thisItem) {
	setup.log(thisItem.find(".other_projects_img_overlay"), 1);

	$(thisItem.find(".other_projects_img_overlay_2")).toggleClass("other_projects_img_overlay_2_toggled");
	$(thisItem.find(".other_projects_img_overlay")).toggleClass("other_projects_img_overlay_toggled");

	// thisItem.find(".other_projects_img_overlay").css({"opacity": "0.5"});
}




/*--------------------------------------------------------------
# Notifications
--------------------------------------------------------------*/
// Description:
// Adds notification support to the site.
var notificationShowing = false;

function toggleBeta() {
	if(!notificationShowing) {
		$(".notification").removeClass("notification_out");
		$(".notification").addClass("notification_in");

		$(".notification_container").css({"pointer-events": "auto"});

		notificationShowing = true;
	} else {
		$(".notification").removeClass("notification_in");
		$(".notification").addClass("notification_out");

		$(".notification_container").css({"pointer-events": "none"});

		notificationShowing = false;
	}
}

function showBetaNotification() {
	setTimeout(function() {
		toggleBeta();
	}, 2000);

	setTimeout(function() {
		if(notificationShowing) {toggleBeta();}
	}, 8000);
}
setup.onLoadHook.push(showBetaNotification);


