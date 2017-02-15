var PostNavigationView = function() {
	this.test = "fisk";

	this.hide = function() {
		this.visible(false);
	}

	this.show = function() {
		this.visible(true);
	}

	this.prev = {
		hasContent: ko.observable(false),
		visible: ko.observable(false),
		title: ko.observable(""),
		excerpt: ko.observable(""),
		permalink: ko.observable(""),
		thumbnail: ko.observable(""),
	}

	this.next = {
		hasContent: ko.observable(false),
		visible: ko.observable(false),
		title: ko.observable(""),
		excerpt: ko.observable(""),
		permalink: ko.observable(""),
		thumbnail: ko.observable(""),
	}
}

var postNavigationView = new PostNavigationView();
ko.applyBindings(postNavigationView, $('.left_box_margin')[0]);
