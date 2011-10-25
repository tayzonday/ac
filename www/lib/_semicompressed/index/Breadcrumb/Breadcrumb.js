/* Breadcrumb class */

/**
 * @constructor
 */
function Breadcrumb(parent) {

	this.parent = parent;

	/* Extra members */
	this.items = [];

	/* DOM */
	this.DOM = {
		root:false,
		ul  :false,
		home:false
	};


	this.populate = function(response) {
	
		this.items = [];

		for(var n in response.items) {

			var item = new BreadcrumbItem(this);

			item.title = response.items[n].title;
			item.href  = response.items[n].href;
			
			this.items.push(item);

		}

	}

	this.build = function(options) {
	
		options = options || {};

		this.DOM.root = new DOMElement('section', {'id':'breadcrumb'});
		
		this.DOM.ul = new DOMElement('ul', {}, this.DOM.root);

		this.DOM.home = new DOMElement('li', {}, this.DOM.ul);

		var a = new DOMElement('a', {'href':'/'}, this.DOM.home);
		
		var img = new DOMElement('img', {'src':'/assets/favicon/default.ico'}, a);
		
		for(var n in this.items) {

			this.items[n].build({appendTo:this.DOM.ul});

		}
		
		if(options.appendTo) {
			options.appendTo.appendChild(this.DOM.root);
		}
		
	}
	
	
	
	
	
	
	return true;

}