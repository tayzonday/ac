/* Pagination class */

/**
 * @constructor
 */
function Pagination() {

	var self = this;
	
	this.parent = null;
	
	// Regular members
	this.currentPage = 0;
	this.maxPages    = 0;

	

	// DOM
	this.DOM = {};
	this.DOM.root = null;
	
	this.build = function() {
	
		this.DOM.root = document.createElement('section');
		this.DOM.root.className = 'pagination';
		
		var ul = document.createElement('ul');
		
		var li = document.createElement('li');
		li.innerHTML = 'Page:';
		ul.appendChild(li);

		// replace current page number from path
		var path = window.location.pathname.replace(/^(\/[^\/]+)(\/page[0-9]+)?$/, '$1');

		if(this.currentPage > 1) {
			var li = document.createElement('li');
			var a = document.createElement('a');
			a.href = path + '/page1';
			a.innerHTML = 'First';
			li.appendChild(a);
			ul.appendChild(li);

			var li = document.createElement('li');
			var a = document.createElement('a');
			a.href = path + '/page' + (this.currentPage - 1);
			a.innerHTML = 'Prev';
			li.appendChild(a);
			ul.appendChild(li);
		}

		// If we're on 10, 20, 30 etc
		if((this.currentPage % 10) == 0) {
			var start = this.currentPage - 9;
			var end = this.currentPage;
		} else {
			var current_page_dec = this.currentPage / 10;
			var start = (Math.floor(current_page_dec) * 10) + 1;
			var end = Math.ceil(current_page_dec) * 10;
		}

		for(var n = start; n <= end; n++) {
	
			if(n > this.maxPages) break;
	
			var li = document.createElement('li');
			if(this.currentPage == n) {
				li.className = 'selected';
			}
			var a = document.createElement('a');
			a.href = path + '/page' + n;
			a.innerHTML = n;
			li.appendChild(a);
			ul.appendChild(li);

		}

		if(this.currentPage < this.maxPages) {
			var li = document.createElement('li');
			var a = document.createElement('a');
			a.href = path + '/page' + (parseInt(this.currentPage) + 1);
			a.innerHTML = 'Next';
			li.appendChild(a);
			ul.appendChild(li);

			var li = document.createElement('li');
			var a = document.createElement('a');
			a.href = path + '/page' + this.maxPages;
			a.innerHTML = 'Last';
			li.appendChild(a);
			ul.appendChild(li);
		}

		this.DOM.root.appendChild(ul);
		
		return true;
		
	}
	
	
	
	
	
	
	
	
	return true;

}



