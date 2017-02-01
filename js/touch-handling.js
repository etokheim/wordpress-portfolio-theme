// Watches swipes on assigned element
function getSwipeDirection(element, callback) {
	var callbackFunction = callback || function() {console.log("No callback. Result = " + swipe.direction);};

	var touch = {
		object: {},

		start: {
			x: 0,
			y: 0
		},

		end: {
			x: 0,
			y: 0
		},
	};

	var swipe = {
		threshold: 25,
		angleThreshold: 100,
		distance: {
			x: 0,
			y: 0
		}
	};

	element.addEventListener("touchstart", function() {
		touch.object = event.changedTouches[0];
		touch.start.x = touch.object.pageX;
		touch.start.y = touch.object.pageY;
	}, false);

	element.addEventListener("touchend", function() {
		touch.object = event.changedTouches[0];
		touch.end.x = touch.object.pageX;
		touch.end.y = touch.object.pageY;

		swipe.distance.x = touch.start.x - touch.end.x;
		swipe.distance.y = touch.start.y - touch.end.y;

		// If swiping horizontally
		if(Math.abs(swipe.distance.x) >= swipe.threshold && Math.abs(swipe.distance.y) < swipe.angleThreshold) {
			if(swipe.distance.x > 0) {
				swipe.direction = "left";
			} else {
				swipe.direction = "right";
			}

		// Else if swiping vertically
		} else if(Math.abs(swipe.distance.y) >= swipe.threshold && Math.abs(swipe.distance.x) < swipe.angleThreshold) {
			if(swipe.distance.y > 0) {
				swipe.direction = "up";
			} else {
				swipe.direction = "down";
			}

		// Else if swipe distance is less than swipe threshold, handle touch input as a click
		} else if(Math.abs(swipe.distance.y) < swipe.threshold && Math.abs(swipe.distance.x) < swipe.threshold) {
			swipe.direction = "click";
		} else {
			swipe.direction = false;
		}

		callbackFunction(swipe.direction);
		console.log(swipe);

	}, false);

	element.addEventListener("touchcancel", function() {
		swipe.direction = false;
	}, false);

	// Prevents scrolling
	element.addEventListener("touchmove", function() {
		event.preventDefault();
	}, false);
}


// Listens for dragging on element
function getMove(element, callback, condition) {
	var callbackFunction = callback || function() {console.log("No callback. Result = " + swipe.direction);};
	condition = condition || function() { return true; };

	var touch = {
		object: {},

		start: {
			x: 0,
			y: 0
		},

		end: {
			x: 0,
			y: 0
		},
	};

	var swipe = {
		threshold: 25,
		angleThreshold: 100,
		distance: {
			x: 0,
			y: 0
		}
	};

	element.addEventListener("touchstart", function() {
		touch.object = event.changedTouches[0];
		touch.start.x = touch.object.pageX;
		touch.start.y = touch.object.pageY;
	}, false);

	// Prevents scrolling
	element.addEventListener("touchmove", function() {
		if(condition()) {
			touch.object = event.changedTouches[0];
			touch.difference = touch.start.y - touch.object.pageY;

			callbackFunction(touch.difference);

			event.preventDefault();
		}
	}, false);
}