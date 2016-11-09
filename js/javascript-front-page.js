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
	visiting: -1,
	isVisiting: false,

	scrollTo: function(newPosition) {
		if(newPosition >= 0 && newPosition <= $('.display_feature_content').length - 1 && featured.isVisiting) {
			scroll.computerIsScrolling = true;

			document.getElementsByClassName("display_feature_video")[newPosition].style.opacity = 1;
			setTimeout(function() {
				document.getElementsByClassName("display_feature_content")[newPosition].style.opacity = 1;
				document.getElementsByClassName("display_feature_content")[newPosition].style.zIndex = 1;
			}, 200);

			if(scroll.direction === "up") {
				// If in order to prevent the script from changing the styles of non existing elements - like div[-1].
				if(featured.visiting + 1 <= $('.display_feature_content').length + 1) {
					document.getElementsByClassName("display_feature_content")[featured.visiting+1].style.opacity = 0;
					document.getElementsByClassName("display_feature_content")[featured.visiting+1].style.zIndex = 0;
					document.getElementsByClassName("display_feature_video")[featured.visiting+1].style.opacity = 0;
				}
			} else if(scroll.direction === "down") {
				// If in order to prevent the script from changing the styles of non existing elements - like div[-1].
				if(featured.visiting - 1 >= 0) {
					document.getElementsByClassName("display_feature_content")[featured.visiting-1].style.opacity = 0;
					document.getElementsByClassName("display_feature_content")[featured.visiting-1].style.zIndex = 0;
					document.getElementsByClassName("display_feature_video")[featured.visiting-1].style.opacity = 0;
				}
			} else {
				setup.log("There is a bug. See featured opacity handling and the scroll.direction (which btw is = " + scroll.direction, 1);
			}
			$('html, body').animate({
				scrollTop: $('.display_feature_content').eq(newPosition).offset().top - ($('.display_feature').offset().top - scroll.y -1) // eq = nth
			}, 600, "easeOutExpo", function() {
				// function to be triggered after the scroll is finished
				setTimeout(function() {
					scroll.computerIsScrolling = false;
					featured.visiting = newPosition;
					if(setup.debugging) {setup.log("scrolling to = " + featured.visiting, 2);}
				}, 20);
			});

			return true;
		} else {
			return false;
		}
	},

	scrollToClosest: function() {
		// When updating the site, scrolls to the closest featured item, if you are in the featured section.
		// If not in the featured section, it makes the closest featured item visible. (Important if you have
		// scrolled past the featured section)
		for(var i = 0; i < $('.display_feature_content').length; i++) {
			arrayOfFeaturedsOffsetTopPosition.push(Math.abs($('.display_feature_content')[i].offsetTop + $('#feature_container').offset().top + 60 - scroll.y));
		}
		for(var i = 0; i < arrayOfFeaturedsOffsetTopPosition.length; i++) {
			if(arrayOfFeaturedsOffsetTopPosition[i] == Math.min.apply(null, arrayOfFeaturedsOffsetTopPosition)) {
				setup.log("The lowest = " + i, 2);
				setup.log("SCROLLING TO = " + i, 2);

				if(featured.scrollTo(i)) {
					// If in featured section, scrolls to the closest item and makes it visible
					featured.scrollTo(i)
				} else {
					// Makes the closest item visible
					document.getElementsByClassName("display_feature_video")[i].style.opacity = 1;
					document.getElementsByClassName("display_feature_content")[i].style.opacity = 1;
					document.getElementsByClassName("display_feature_content")[i].style.zIndex = 1;

					if(i > 0) {
						// If scrolled past featured section, make the last item visible
						document.getElementsByClassName("display_feature")[0].style.position = "absolute";
						document.getElementsByClassName("display_feature")[0].style.top = $('#feature_container').height() - $('.display_feature').height() + "px";
						document.getElementsByClassName("display_feature")[0].style.left = "0px";
					}
				}
				featured.visiting = i;
			}
		}
	}
}
setup.onLoadHook.push(featured.scrollToClosest);














// Not yet sorted...............................










$(window).scroll(function(event){

	// If visiting site scrolled to featured section and scrolling - go to next, else
	if(scroll.y > $('#feature_container').offset().top - 61) {
		// Scrolls to next if user is scrolling
		if(scroll.direction == "down" && !scroll.computerIsScrolling && featured.visiting + 1 < $('.display_feature_content').length) {
			featured.scrollTo(parseInt(featured.visiting += 1));
			console.log("scrolling to = " + featured.visiting);
		} else if(scroll.direction == "up" && scroll.computerIsScrolling === false && featured.isVisiting) {
			featured.scrollTo(parseInt(featured.visiting -= 1));
			console.log("scrolling to = " + featured.visiting);
		}
	} else {
		featured.visiting = -1;
		document.getElementsByClassName("display_feature_content")[0].style.opacity = 1;
		document.getElementsByClassName("display_feature_video")[0].style.opacity = 1;
	}
});

$(window).scroll(function() {
	// Changes featured styling position. Relative -> fixed
	var feature_container_offsetTop = $('#feature_container').offset().top - 60,
		feature_container_height = $('#feature_container').outerHeight(),
		windowHeight = $(window).height(),
		windowScrolled = $(this).scrollTop();

	// Checks if you are visiting the feature section
	if(windowScrolled > (feature_container_offsetTop) && windowScrolled < $('.display_feature_content').eq($('.display_feature_content').length - 1).offset().top - 60 && windowScrolled < $('.display_feature_content').eq($('.display_feature_content').length - 1).offset().top - 60) {
		// setup.log("You are visiting the featured section", 1);
	}

	if (!featured.isVisiting && windowScrolled > (feature_container_offsetTop) && windowScrolled < $('.display_feature_content').eq($('.display_feature_content').length - 1).offset().top - 60) {
		document.getElementsByClassName("display_feature")[0].style.position = "fixed";

		// This is needed because the honey badger (fixed position version) doesnt care about the 60px margin left/top
		if(windowSize === "small") {
			document.getElementsByClassName("display_feature")[0].style.top = "60px";
			document.getElementsByClassName("display_feature")[0].style.left = "10px";
		} else {
			document.getElementsByClassName("display_feature")[0].style.top = "60px";
			document.getElementsByClassName("display_feature")[0].style.left = "60px";
		}

		showIntroSlideshow(true);

	} else if (featured.isVisiting && windowScrolled < (feature_container_offsetTop) && windowScrolled < $('.display_feature_content').eq($('.display_feature_content').length - 1).offset().top - 60) {
		document.getElementsByClassName("display_feature")[0].style.position = "absolute";
		
		// This is needed because the position absolute cares about the 60px margin left/top
		if(windowSize === "small") {
			document.getElementsByClassName("display_feature")[0].style.top = "0px";
			document.getElementsByClassName("display_feature")[0].style.left = "0px";
		} else {
			document.getElementsByClassName("display_feature")[0].style.top = "0px";
			document.getElementsByClassName("display_feature")[0].style.left = "0px";
		}

		showIntroSlideshow(false);

	}

	if(featured.isVisiting && windowScrolled > $('.display_feature_content').eq($('.display_feature_content').length - 1).offset().top - 60) {
		// Checks if user has scrolled past the featured section and then sets the position from fixed -> absolute
		// console.log("Scrolla utføre!");

		document.getElementsByClassName("display_feature")[0].style.position = "absolute";
		
		// This is needed because the position absolute cares about the 60px margin left/top
		if(windowSize === "small") {
			// document.getElementsByClassName("display_feature")[0].style.top = $('#feature_container').height() - 60 + "px";
			// document.getElementsByClassName("display_feature")[0].style.left = "0px";
			document.getElementsByClassName("display_feature")[0].style.top = $('#feature_container').height() - $('.display_feature').height() + "px";
			document.getElementsByClassName("display_feature")[0].style.left = "0px";
		} else {
			document.getElementsByClassName("display_feature")[0].style.top = $('#feature_container').height() - $('.display_feature').height() + "px";
			document.getElementsByClassName("display_feature")[0].style.left = "0px";
		}

		featured.isVisiting = false;
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


