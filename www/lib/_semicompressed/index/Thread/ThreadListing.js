/* ThreadListing class */

/**
 * @constructor
 */
function ThreadListing(parent) {

	/* Object members */
	this.topPagination = null;
	this.bottomPagination = null;
	
	/* Extra members */
	this.parent  = parent;
	this.threads = [];

	/* DOM */
	this.DOM      = {};
	this.DOM.root = false; /* <section> */
	
	this.build = function() {
	
		this.DOM.root = document.createElement('section');
		this.DOM.root.className = 'thread-listing';
		
		this.topPagination.build();
		this.bottomPagination.build();

		this.DOM.root.appendChild(this.topPagination.DOM.root);
		
		if(this.threads.length == 0) {
	
			this.topPagination.DOM.root.addClass('hidden');
			this.bottomPagination.DOM.root.addClass('hidden');

			var p = document.createElement('p');
			p.className = 'no-threads';
			p.innerHTML = 'There are no threads in this topic yet.';
			this.DOM.root.appendChild(p);
	
		} else {
		
			this.topPagination.DOM.root.removeClass('hidden');
			this.bottomPagination.DOM.root.removeClass('hidden');

			for(var n in this.threads) {
				this.threads[n].build();
				this.DOM.root.appendChild(this.threads[n].DOM.root);
			}
		}

		this.DOM.root.appendChild(this.bottomPagination.DOM.root);

	}
	
	
	
	
	
	
	
	
	
	return true;

}



