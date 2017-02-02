/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
#
#
# Intro slideshow
## Lvl two TOC
--------------------------------------------------------------*/



/*--------------------------------------------------------------
# Setup, decalrations, etc.
--------------------------------------------------------------*/
// Description:
// Initialize whatever is needed.
var setup = {
	debugging: true,

	// Debug levels:
	// 0 = Errors
	// 1 = Warnings
	// 2 = Debug
	debugLvl: 2,

	// Size of one rem
	rem: 16,

	determineRemSize: function() {
		// If there is a p, then get font-size from that element, else set
		// 1 rem to 16.
		setup.rem = $('p').css('font-size') !== undefined ? Number($('p').css('font-size').replace('px', '')) : 16;
	},

	log: function(message, messageLvl) {
		if(setup.debugging && setup.debugLvl >= messageLvl) {
			console.log(message);
		}
	},


	onScrollHook: [],
	onLoadHook: [],
	onReadyHook: [],
	onResizeHook: [],

	onScrollFunction: function() {
		$(window).scroll(function() {
			// Runs the scroll hooked functions.
			for (var i = 0; i < setup.onScrollHook.length; i++) {
				scroll.y = $(window).scrollTop(); // Has to be set before determineScrollDirection() runs!
				setup.onScrollHook[i]();
			}
		})
	},

	onLoadFunction: function() {
		$(window).load(function() {
			setup.determineRemSize();

			// Runs the load hooked functions.
			for (var i = 0; i < setup.onLoadHook.length; i++) {
				setup.onLoadHook[i]();
			}
		});
	},

	onReadyFunction: function() {
		$(window).ready(function() {
			// Runs the ready hooked functions.
			for (var i = 0; i < setup.onReadyHook.length; i++) {
				setup.onReadyHook[i]();
			}
		});
	},

	onResizeFunction: function() {
		$(window).resize(function() {
			setup.determineRemSize();

			// Runs the load hooked functions.
			for (var i = 0; i < setup.onResizeHook.length; i++) {
				setup.onResizeHook[i]();
			}
		});
	}
};
setup.onScrollFunction();
setup.onLoadFunction();
setup.onResizeFunction();

// start image loading (I assume you need this for tracking?)

var page = {
	isScrolled: false,
	ckeckIfIsScrolled: function() {
		if(scroll.y > 1) {
			page.isScrolled = true;
		} else {
			page.isScrolled = false;
		}
	}
};
setup.onScrollHook.push(page.ckeckIfIsScrolled);

var scroll = {
	y: $(this).scrollTop(),
	prevScrollPos: $(this).scrollTop(),
	computerIsScrolling: false,
	direction: "static",
	// Say you want to add a negative margin-top while scrolling up
	// and a positive when scrolling down, use the multiplier property.
	multiplier: 1,
	stopScrollingDate: Date.now(),
	staticDuration: 0, // value in ms
};

// Must run first!
function declareVariables() {
	scroll.y = $(window).scrollTop(); // Has to be set before determineScrollDirection() runs!
}
setup.onScrollHook.push(declareVariables);


var scrollDetection;
function determineScrollDirection() {
	clearTimeout(scrollDetection); // Doesn't error as long as var is created.

	// downscroll code
	if (scroll.y > scroll.prevScrollPos) {
		scroll.direction = "down";
		scroll.multiplier = -1;
		scroll.staticDuration = 0;

	// upscroll code
	} else {
		scroll.direction = "up";
		scroll.multiplier = 1;
		scroll.staticDuration = 0;
	}

	// Determine if window is scrolling
	scrollDetection = setTimeout(function() {
		if(scroll.y === scroll.prevScrollPos) {
			scroll.direction = "static";
			scroll.stopScrollingDate = Date.now();
		}
	}, 50)

	scroll.prevScrollPos = scroll.y; // Has to be set last
}
setup.onScrollHook.push(determineScrollDirection);

// Runs every 100ms to store how long the scroll has been static
setInterval(function() {
	if(scroll.direction === 'static') {
		scroll.staticDuration = Date.now() - scroll.stopScrollingDate;
	}
}, 100);


function test() {
	$('html, body').animate({
		scrollTop: $(feature_container).offset().top // because of the paralaxing effect on the target div
	}, 800, function() {
		// function to be triggered after the scroll is finished
	});
}

function determineWindowSize() {
	// Use the predefined screen variable to get window sizes
	screen.innerWidth = $(window).innerWidth();
	screen.innerHeight = $(window).innerHeight();
}
determineWindowSize();
setup.onResizeHook.push(determineWindowSize);

// This function is for mobile and tablet devices with address bars which are
// showing and hiding depending on how the user scrolls.
// 		The function sets a new height for the intro element on window resize,
// BUT only if the window has been resized more than 200px. This prevents the
// page from "jumping" when the user changes scroll direction.
var previousScreenHeight = 0;
function setIntroHeight() {
	if(Math.abs(previousScreenHeight - screen.innerHeight) > 200) {
		$('#intro_container').css({ 'height': screen.innerHeight });
		$('#intro').css({ 'height': screen.innerHeight });
		$('.intro_section').css({ 'height': screen.innerHeight });

		previousScreenHeight = screen.innerHeight;
	}


	$('.intro_section').css({ 'margin-bottom': parseInt($('#bottom_box_margin').css('height')) });
	feature.updateValues(); // Quick fix.. don't really know why I need it yet
}
setup.onLoadHook.push(setIntroHeight);
setup.onResizeHook.push(setIntroHeight);




/*--------------------------------------------------------------
# Toggle frame
--------------------------------------------------------------*/
// Description:
// Makes the white border appear and disappear when its appropriate
var frameToggled = false;

var frame = {
	toggled: false,

	toggle: function() {
		$(".frame_topbot_hidden").toggleClass("header_fill_visible");
		$(".frame_lefrig_hidden").toggleClass("header_fill_visible");

		// Turn off the gradient (to see logo and icons better on light backgrounds)
		$(".header_gradient").toggleClass("header_gradient_off");

		frame.toggled = !frame.toggled;
	},

	showOnScroll: function() {
		setup.log("page.isScrolled = " + page.isScrolled + ", frame.toggled = " + frame.toggled, 3)
		if (page.isScrolled && !frame.toggled) {
			frame.toggle();
		} else if (!page.isScrolled && frame.toggled) {
			frame.toggle();
		}
	}
};
setup.onScrollHook.push(frame.showOnScroll);




/*--------------------------------------------------------------
# Next page animation
--------------------------------------------------------------*/
// Description:
// When clicking a link, wait x seconds, while transitioning, before loading.
var clickedALink = false;
$(function(){
	$("a").click(function(evt){
		evt.preventDefault(); // Prevents load of new page on click
		var link = $(this).attr("href");
		var target = $(this).attr("target");
		setTimeout(function() {
			if(target !== "_blank") {
				window.location.href = link;
			}
		}, 500);

		if(target !== "_blank") {
			setup.log("Next page Transition happening!", 1);
			nextPageTransition();
			clickedALink = true;
		} else if(target == "_blank") {
			window.open(link, "_blank");
		}
	});
});

// Plays the next page animation when refreshing or using back/forward buttons.
// Usually doesnt get the time to finish
window.onbeforeunload = function() {
	if(!clickedALink) {
		nextPageTransition();
	}
}

function nextPageTransition() {
	// $(".next_page_transition").toggleClass("next_page_transition_toggled");
	// $(".site").css({"transition": "all 500ms linear", "margin-top": "-50px"});
	// $("#intro").css({"transition": "all 500ms linear", "margin-top": "-50px"});
}

function thisPageTransition() {
	// $(".this_page_transition").toggleClass("this_page_transition_toggled");
	// console.log("test " + document.getElementsByClassName("site")[0].style.marginTop);
	// $(".site").css({"transition": "all 500ms ease-out", "margin-top": "0px"});
	// $("#intro").css({"transition": "all 500ms ease-out", "margin-top": "0px"});

	// setTimeout(function() {
	// 	$("#iite").css({"transition": "initial"});
	// 	$("#intro").css({"transition": "initial"});
	// }, 500);
}
setup.onLoadHook.push(thisPageTransition);






















var windowHeight = $( window ).height();

$(document).ready(function() {
	// Hide the menu container
	// document.getElementsByClassName("menu_container")[0].style.left = $('.menu_container').outerWidth() * -1 + "px";
});

function expandMenu() {
	$(".menu_container").toggleClass("menu_container2");
}

// Wrap centered images in a new figure element
$("img.aligncenter").wrap("<figure class='centered_image'></figure>");














// FROM FRONT-PAGE


$(document).ready(function() {
	$(window).stellar({
		hideDistantElements: false,
		responsive: true,
		parallaxElements: true,
		horizontalScrolling: false
	});
});





////////////////////////////////
// Animate by scroll function
////////////////////////////////
var animateByScroll = {
	fromTop: 0, //$(".intro_dimmer").offset().top,
	height: 0,
	percentPassed: 0,
	defaultOpacity: 0,
	desiredOpacity: 0.6,
	newOpacity: 0,

	function: function(positionFromTop, heightOfElement) {
		animateByScroll.fromTop = $(".intro_dimmer").offset().top;
		animateByScroll.height = $(".intro_dimmer").height();
		animateByScroll.percentPassed = 100 / animateByScroll.height * animateByScroll.fromTop;
		animateByScroll.newOpacity = animateByScroll.desiredOpacity * (animateByScroll.percentPassed / 100);

		$(".intro_dimmer").css({"opacity": animateByScroll.newOpacity});
	},
}

setup.onScrollHook.push(animateByScroll.function);


/*--------------------------------------------------------------
# Article pagination
--------------------------------------------------------------*/
// Description:
// Creates a table of contents in the right margin.

var toc = {
	fisk: 0,
	contentHolder: "",

	create: function() {
		for (var i = 0; i < $("h1").length; i++) {
			this.contentHolder += '\
				<div style="width: 15px; height: 15px; border-radius: 100%; margin: 0 auto; border: 1px solid #000; position: relative;">\
					<div style="position: absolute; border-radius: 100%; width: 10px; height: 10px; background-color: #000; top: 1.5px; left: 1.5px;">\
						<div style="width: 100vw; position: absolute; left: calc(-100vw - 22px); top: -.5rem; height: 2rem;">\
							<div style="float: right; width: auto; height: 100%; background-color: #fff; border: 1px solid #000; padding: 5px; left: -100px; text-align: right;">\
								' + $("h1")[i].innerHTML + '\
							</div>\
						</div>\
					</div>\
				</div>';

			// Stroke between the entries, if not the last entry
			if(i < $("h1").length - 1) {
				this.contentHolder += '<div style="width: 1px; height: 25px; background-color: #000; margin: 0 auto;"></div>';
			}
		}

		document.getElementById("toc_container").innerHTML = this.contentHolder;
	},
}
