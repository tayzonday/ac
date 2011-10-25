/* Listing class 
 * 
 * This class is never instantiated by itself. Subclasses will extend it (TopicListing, ThreadListing)
 * and inherit functionality.
*/

/**
 * @constructor
 */
function Listing() {

	/* The setup method sets up some common properties (DOM). This method is never called in the Listing class,
	 * only in child subclasses when they are instantiated. This is because when you prototype a parent class
	 * the code gets executed during the prototype call, not when the child object is created.
	 */
	this.setup = function (response) {
	
		console.log('Listing.setup(' + response + ')');

		this.DOM      = {};
		this.DOM.root = false;

	}

	return true;

}