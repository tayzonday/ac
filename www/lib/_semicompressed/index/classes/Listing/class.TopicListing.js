/* TopicListing class */

/**
 * @constructor
 */
function TopicListing() {

	this.topics = [];
	
	// Extra DOM elements
	
	this.build = function(append_to) {

		this.DOM.root = new DOMElement('section', append_to);
		this.DOM.root.className = 'topic-listing';

		if(this.topics.length > 0) {

			for(var n in this.topics) {
				this.topics[n].build(this.DOM.root);
			}

		}

	}
	
	// Call setup() on parent (Listing) class. This populates the DOM and DOM.root
	this.setup();
	
	return true;

}

TopicListing.prototype = new Listing;




