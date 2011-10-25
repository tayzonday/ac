/* TopicListing class */

/**
 * @constructor
 */
function TopicListing() {

	this.topics = [];

	// Extra DOM elements

	this.build = function(_append_to) {

		this.DOM.root = new DOMElement('section', _append_to);

		if(this.topics.length > 0) {

			for(var a in this.topics) {
				this.topics[a].build(this.DOM.root);
			}

		}

	}

	// Call setup() on parent (Listing) class. This populates the DOM and DOM.root
	this.setup();

	return true;

}

TopicListing.prototype = new Listing;