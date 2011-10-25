// SidebarMenuItem class

/**
 * @constructor
 */
function SidebarMenuItem() {

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

	
	this.build = function (append_to) {

		console.log('SidebarMenuItem.build(' + append_to + ')');

		this.DOM.root = new DOMElement('li', append_to);
//		this.DOM.root.setAttribute('data-topic-id', this.id);
		if(this.selected === true) {
			this.DOM.root.addClass('selected');
		}
		if(this.hidden === true) {
			this.DOM.root.addClass('hidden');
		}
//		this.DOM.root.id = li_id;
//		if(li_classname != '') {
//			li.className = li_classname;
//		}

		this.DOM.a = new DOMElement('a', this.DOM.root);
		this.DOM.a.href = '/' + this.href;
		this.DOM.a.innerHTML = this.title;
		this.DOM.a.setAttribute('style', 'background-image:url(\'' + this.icon + '\');');
//		if(a_classname) {
//			a.className = a_classname;
//		}

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