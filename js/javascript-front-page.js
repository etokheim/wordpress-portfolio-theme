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









var feature, header;
$(window).on('scroll', function() {
	var featureBackground = $('.feature_background_container').eq(0);
	var featureContainer = $('.feature_container').eq(0);

	feature = {
		offset: {
			top: featureContainer.offset().top,
		},

		margin: {
			top: Number($('.featured_posts .contain').eq(0).css('margin-top').replace('px', '')),
		},

		height: featureBackground.height(),

		totalHeight: featureContainer.height(),
	};

	header = {
		height: $('#header').height(),
	};

	// If scrolled to feature and not passed; fix the background
	if (scroll.y > feature.offset.top - feature.margin.top - header.height &&
		scroll.y < feature.offset.top + feature.totalHeight + feature.margin.top*2) {

		console.log("on");
		featureBackground.addClass('feature_background_container_fixed');
		featureBackground.css({ 'margin-top': 0 });

	// Else if scrolled past; remove fixed class and set margin-top
	} else if(scroll.y > feature.offset.top + feature.totalHeight + feature.margin.top*2) {
		console.log("Passed");
		featureBackground.removeClass('feature_background_container_fixed');
		featureBackground.css({ 'margin-top': feature.totalHeight + feature.height });
	} else {
		console.log("Before");
		featureBackground.removeClass('feature_background_container_fixed');
		featureBackground.css({ 'margin-top': 0 });
	}
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


