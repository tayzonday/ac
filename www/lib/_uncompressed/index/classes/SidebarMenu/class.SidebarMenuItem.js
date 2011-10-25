// SidebarMenuItem class

/**
 * @constructor
 */
function SidebarMenuItem() {

	// Properties
	this.id    = 0;
	this.href  = '';
	this.title = '';
	this.icon  = '';
	this.num   = 0;
	
	this.hidden = false;
	
	this.listClassName = '';
	this.linkClassName = '';
	
	// DOM
	this.DOM = {};
	this.DOM.root = false;
	this.DOM.a    = false;
	this.DOM.num  = false;

	// Methods
	this.build = function (_append_to) {

		console.log('SidebarMenuItem.build(' + _append_to + ')');

		this.DOM.root = new DOMElement('li', _append_to);
		if(this.selected === true) {
			this.DOM.root.addClass('selected');
		}
		if(this.hidden === true) {
			this.DOM.root.addClass('hidden');
		}

		this.DOM.a = new DOMElement('a', this.DOM.root, {'href':'/' + this.href, 'html':this.title, 'style':'background-image:url(\'' + this.icon + '\');'});

		this.DOM.a.convertToPushStateLink();

		this.DOM.num = new DOMElement('span', this.DOM.root);
		if(this.num > 0) {
			this.DOM.num.innerHTML = this.num;
		} else {
			this.DOM.num.addClass('hidden');
		}

	}

	return true;

}