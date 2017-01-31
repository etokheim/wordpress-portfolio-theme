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

var feature, header, featureBackground, featureInstance;
var ViewModel = function() {
	var that = this;

	header = {
		height: $('#header').outerHeight(),
	};

	featureBackground = $('.feature_background_container').eq(0);
	featureContainer = $('.feature_container').eq(0);
	featureInstance = $('.feature_instance').eq(0);

	this.getClosestSlideIndex = function() {
		var allFeaturedOffsetTop = [];

		// Store all feature instances offset.top position
		for(var i = 0; i < feature.slide.slideCount; i++) {
			allFeaturedOffsetTop.push( Math.abs(scroll.y + screen.availHeight/2 - ($('.feature_instance').eq(i).offset().top + $('.feature_instance').eq(i).innerHeight() / 2)) );
		}
		var lowestIndex = allFeaturedOffsetTop.indexOf(Math.min.apply(null, allFeaturedOffsetTop));
		console.log("lowest index = " + lowestIndex);

		return lowestIndex;
	};

	feature = {

		slide: {
			settings: {
				speed: 600, // ms
				threshold: 100, // px
				// Travel distance from 100% to 0% opacity
				opacityThreshold: $('.feature_instance').eq(0).outerHeight() / 4,
				easing: "easeOutExpo",
			},

			difference: 0,
			visiting: false,
			currentSlide: ko.observable(0),
			previousSlide: false,
			zeroValue: 0,
			// Max value is the max offset from the zero value where the heading should be visible
			computerScrolling: false,
			slideCount: $('.feature_instance').length,
			slides: [],
			targetOffsetTop: 0,
			backgrounds: ko.observableArray([]),

			goTo: function(index) {
				// If the computer isn't already scrolling; scroll.
				if(!feature.slide.computerScrolling) {
					disableScroll();
					feature.slide.computerScrolling = true;
					feature.slide.currentSlide(index);

					// Calculate new scroll position
					feature.slide.targetOffsetTop = feature.trueOffset.top + index * feature.instance.height;

					$('html, body').animate({
						scrollTop: feature.slide.targetOffsetTop
					}, feature.slide.settings.speed, feature.slide.settings.easing, function() {
						// function to be triggered after the scroll is finished
						// setTimeout(function() {
							enableScroll();
							feature.slide.computerScrolling = false;

							console.log("Finished scrolling");
						// }, 20);
					});

					console.log(index + ", " + feature.slide.currentSlide());
					// $('.feature_instance').eq(feature.slide.currentSlide()).addClass('feature_instance_hidden');
					// $('.feature_instance').eq(index).removeClass('feature_instance_hidden');
				}
			},

			next: function() {
				feature.slide.goTo(feature.slide.currentSlide() + 1);
			},

			previous: function() {
				feature.slide.goTo(feature.slide.currentSlide() - 1);
			},

			showBackground: function(index) {
				feature.slide.backgrounds()[index].visible(true);
				if(feature.slide.previousSlide) {
					feature.slide.backgrounds()[feature.slide.previousSlide].visible(false);
				}

				feature.slide.previousSlide = index;
			}
		},

		updateTextSizes: function() {
			for (var i = 0; i < feature.slide.slideCount; i++) {
				var instance = $('.feature_instance').eq(i);

				// Set heights of headings and paragraphs
				var headingContainer = instance.find('.feature_heading_container');
				var heading = headingContainer.find('h1');
				var headingHeight = heading.outerHeight();
				var headingWidth = heading.outerWidth();

				var paragraphContainer = instance.find('.feature_paragraph_container');
				var paragraph = paragraphContainer.find('p');
				var paragraphHeight = paragraph.outerHeight();
				var paragraphWidth = paragraph.outerWidth();

				headingContainer.css({ 'height': headingHeight, 'width': headingWidth });
				paragraphContainer.css({ 'height': paragraphHeight, 'width': paragraphWidth });
			}
		},

		updateValues: function() {
			feature.offset = {
				top: featureContainer.offset().top,
			};

			feature.margin = {
				top: Number($('.featured_posts .contain').eq(0).css('margin-top').replace('px', '')),
			};

			// When scrolled to featuredContainer, trueOffset.top === scroll.y
			feature.trueOffset = {
				top: featureInstance.offset().top - parseInt($('.feature_instance').eq(0).css('margin-top')) - Number($('.featured_posts .contain').eq(0).css('margin-top').replace('px', '')) - header.height,
			};

			feature.height = featureBackground.outerHeight();

			feature.totalHeight = featureContainer.outerHeight();

			feature.padding = {
				top: [],
			};

			feature.instance = {
				height: $('.feature_instance').eq(0).outerHeight()
			};

			$(window).load(function() {
				feature.updateTextSizes();
			});
		}
	};

	// Set current slide
	feature.slide.currentSlide(this.getClosestSlideIndex());
	feature.updateValues();
	setup.onResizeHook.push(feature.updateValues);

	setup.onLoadHook.push(function() {
		// Get closest slide
		var closestSlide = that.getClosestSlideIndex();
		// Make current slide visible
		$('.feature_instance').eq(closestSlide).css({ 'opacity': 1 });
		feature.slide.showBackground(closestSlide);
	});


	// Change img visibility on feature.slide.currentSlide change
	feature.slide.currentSlide.subscribe(function() {
		feature.slide.showBackground(feature.slide.currentSlide());
	});


	for (var i = 0; i < feature.slide.slideCount; i++) {
		var instance = $('.feature_instance').eq(i);

		// Set the slides
		feature.slide.slides.push(instance);

		// Set the backgrounds and their visibility
		if(featureBackgrounds.length > 0) {
			feature.slide.backgrounds.push({ img: featureBackgrounds[i], visible: ko.observable(false) })
		}
	}

	$(window).on('scroll', function(event) {
		var featureCenterPoint = featureBackground.offset().top + featureBackground.outerHeight()/2;
		// console.log( featureCenterPoint );

		// If scrolled to feature and not passed; fix the background ++
		if (scroll.y > feature.trueOffset.top &&
			// The scroll.y value when scrolled to the last feature slide
			scroll.y < feature.trueOffset.top + (feature.slide.slideCount - 1) * feature.instance.height) {

			feature.visiting = true;

			// Fix the background
			featureBackground.addClass('feature_background_container_fixed');
			featureBackground.css({ 'margin-top': 0 });

			// Zero value is the scroll.y position where the text is centered
			feature.slide.zeroValue = feature.trueOffset.top + feature.slide.currentSlide() * feature.instance.height;
			feature.slide.difference = feature.slide.zeroValue - scroll.y;

			// Calculate opacity of feature instances based on how far they are
			// from the center of featureBackground
			for (var i = 0; i < feature.slide.slideCount; i++) {
				var instance = $('.feature_instance').eq(i);
				var instanceCenterPoint = instance.offset().top + instance.outerHeight() / 2;
				var instanceFromFeatureCenterPoint = Math.abs(featureCenterPoint - instanceCenterPoint);
				var instanceOpacity = 1 - (1 / feature.slide.settings.opacityThreshold * instanceFromFeatureCenterPoint);
				// console.log( featureCenterPoint + " - " + instanceCenterPoint + " = " + instanceFromFeatureCenterPoint + ", opacity = " + instanceOpacity + "%");
				// console.log( 100 / feature.slide.settings.opacityThreshold * instanceFromFeatureCenterPoint );
				// A fallback for when the value goes over 1 or under 0
				if (instanceOpacity < 0 && instanceOpacity > 1) {
					instanceOpacity = 0;
				}

				// instance.find('h1').css({ 'margin-top': (1 - instanceOpacity) * -25 });
				instance.css({ 'opacity': instanceOpacity });
			}

			if(Math.abs(feature.slide.difference) > feature.slide.settings.threshold) {
				if(scroll.direction === "up") {
					feature.slide.previous();
				} else {
					feature.slide.next();
				}
			}

		// Else if scrolled past; remove fixed class and set margin-top
		// The scroll.y value when scrolled to the last feature slide
		} else if(scroll.y > feature.trueOffset.top + (feature.slide.slideCount - 1) * feature.instance.height) {
			console.log("Passed");
			feature.visiting = false;

			featureBackground.removeClass('feature_background_container_fixed');
			featureBackground.css({ 'margin-top': feature.totalHeight - feature.height });
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

			feature.slide.goTo(feature.slide.currentSlide());
		}
	}, 100);
};
ko.applyBindings(new ViewModel());



/*--------------------------------------------------------------
# Intro slideshow
--------------------------------------------------------------*/
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
//
function other_projects_hover(item) {
	$(item.find(".other_projects_img_overlay")).toggleClass("other_projects_img_overlay_toggled");
	$(item).first().toggleClass('other_pojects_hover');
}




/*--------------------------------------------------------------
# Notifications
--------------------------------------------------------------*/
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


