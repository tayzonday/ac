/* PostListing class */

/**
 * @constructor
 */
function PostListing(parent) {

	var self = this;
	
	this.parent = parent;

	this.posts = [];


	// DOM
	this.DOM = {};
	this.DOM.root = null; // <section>
	
	this.build = function() {
	
		this.DOM.root = document.getElementById('thread-' + this.parent.id + '-post-listing');
		if(this.DOM.root == null) {
			this.DOM.root = document.createElement('section');
			this.DOM.root.id = 'thread-' + this.parent.id + '-post-listing';
		}
		
		if(this.posts.length > 0) {

			for(var n in this.posts) {
				this.posts[n].buildForListing();
				this.DOM.root.appendChild(this.posts[n].DOM.root);
			}
		}

	}
	
	
	
	
	
	
	
	
	
	return true;

}



