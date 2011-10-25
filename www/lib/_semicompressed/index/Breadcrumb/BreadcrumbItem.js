/* BreadcrumbItem class */

/**
 * @constructor
 */
function BreadcrumbItem(parent) {

	this.parent = parent;
	
	this.title = '';
	this.href  = '';

	/* DOM */
	this.DOM = {
		root   :false,
		divider:false,
		link   :false
	};

	this.build = function(options) {

		this.DOM.root = new DOMElement('li');
		
		this.DOM.divider = new DOMElement('img', {'src':'/assets/breadcrumb/breadcrumb-divider.gif'}, this.DOM.root);

		this.DOM.link = new DOMElement('a', {'href':this.href, 'html':this.title}, this.DOM.root);
		
		if(options.appendTo) {
			options.appendTo.appendChild(this.DOM.root);
		}

	}

	return true;

}