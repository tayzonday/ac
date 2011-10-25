// FollowedTopicsSidebarMenu class

/**
 * @constructor
 */
function FollowedTopicsSidebarMenu() {

	this.title        = 'Followed Circles';
	this.itemIdPrefix = 'menu-followed-topic-';

	// DOM
	this.DOM.findMoreList = false;
	this.DOM.findMoreLink = false;
	this.DOM.showMoreList = false;
	this.DOM.showMoreLink = false;

	this.populate = function(items) {

		console.log('FollowedTopicsSidebarMenu.populate(' + items + ')');
		
		for(var a in items) {

			var item = new SidebarMenuItem();

			item.id     = items[a].id;
			item.href   = items[a].href;
			item.title  = items[a].title;
			item.icon   = items[a].icon;
			item.num    = items[a].num;
			item.hidden = false;
			
			this.items.push(item);

		}
		
		// Loop through this.items and guarantee that there are no extra prototype functions attached as array elements
		for(var a in this.items) {
			if(!(this.items[a] instanceof SidebarMenuItem)) {
				this.items.splice(a, 1);
			}
		}

	}
	
	this.addItem = function(item) {

		console.log('FollowedTopicsSidebarMenu.addItem(' + item + ')');
	
		if(!this.hasItem(item.id)) {
			item.build();
			this.items.push(item);
			this.DOM.ul.appendChild(item.DOM.root);
		}

		this.shiftFindMoreList();
		this.shiftShowMoreList();

	}

	this.build = function(append_to) {

		console.log('FollowedTopicsSidebarMenu.build(' + append_to + ')');

		this.DOM.root = new DOMElement('menu', append_to);

		var h4 = new DOMElement('h4', this.DOM.root);
		h4.innerHTML = this.title;

		var a = new DOMElement('a', this.DOM.root);
		a.href = '/topics';
		a.innerHTML = 'edit';
		a.addClass('menu-inline-link');
		a.convertToPushStateLink();

		this.DOM.ul = new DOMElement('ul', this.DOM.root);

		if(this.items.length > 0) {

			for(var a in this.items) {

				if(a > 9) {
					this.items[a].hidden = true;
				}

				this.items[a].build(this.DOM.ul);

			}
		
		}

		this.DOM.findMoreList = new DOMElement('li', this.DOM.ul);
		this.DOM.findMoreList.id = 'menu-followed-topics-find-more';
		this.DOM.findMoreList.addClass('hidden');
		
		this.DOM.findMoreLink = new DOMElement('a', this.DOM.findMoreList);
		this.DOM.findMoreLink.href = '/topics';
		this.DOM.findMoreLink.addClass('menu-link-color');
		if(this.items.length == 0) {
			this.DOM.findMoreLink.innerHTML = 'Find topics ...';
		} else {
			this.DOM.findMoreLink.innerHTML = 'Find more topics ...';
		}
		this.DOM.findMoreLink.convertToPushStateLink();

		if(this.items.length > 10) {

			this.DOM.showMoreList = new DOMElement('li', this.DOM.ul);
			this.DOM.showMoreList.id = 'menu-followed-topics-show-more';

			this.DOM.showMoreLink = new DOMElement('a', this.DOM.showMoreList);
			this.DOM.showMoreLink.href = 'javascript:;';
			this.DOM.showMoreLink.innerHTML = 'More...';
			this.DOM.showMoreLink.addClass('menu-link-color');
			this.DOM.showMoreLink.addEvent('click', this.showMore, false);

		}

	}
	

	this.shiftFindMoreList = function() {
	
		console.log('FollowedTopicsSidebarMenu.shiftFindMoreList()');

		var clone = this.DOM.findMoreList.cloneNode(true);
		this.DOM.findMoreList.parentNode.removeChild(this.DOM.findMoreList);

		this.DOM.findMoreList = clone;

		this.DOM.ul.appendChild(this.DOM.findMoreList);
		
		// FIXME - Use this.items.length == 1 (ie. item was just added) perhaps for this if. don't compare strings
		//if(this.items.length >= 1) {
		//	this.DOM.findMoreList.innerHTML = 'Find more topics ...';
		//}
	
	}

	this.shiftShowMoreList = function() {

		console.log('FollowedTopicsSidebarMenu.shiftShowMoreList()');

		if(this.DOM.showMoreList) {

			var clone = this.DOM.showMoreList.cloneNode(true);			
			this.DOM.showMoreList.parentNode.removeChild(this.DOM.showMoreList);

			this.DOM.showMoreList = clone;

			this.DOM.ul.appendChild(this.DOM.showMoreList);

		}

	}


	// Events
	
	this.showMore = (function() {

		console.log('FollowedTopicsSidebarMenu.showMore()');
	
		for(var n in this.DOM.ul.childNodes) {		
			if(typeof this.DOM.ul.childNodes[n].id != 'undefined') {
				if(this.DOM.ul.childNodes[n].hasClass('hidden')) {
					this.DOM.ul.childNodes[n].removeClass('hidden');
				}
			}
		}
	
		this.DOM.showMoreLink.innerHTML = 'Less ...';
		this.DOM.showMoreLink.setAttribute('style', 'background-image:url(\'/assets/topic-icons/icon-menu-collapse-16x16.png\');');

		this.DOM.showMoreLink.replaceEvent('click', this.showMore, this.showLess, false);

	}).bind(this);
	
	
	this.showLess = (function() {
	
		console.log('FollowedTopicsSidebarMenu.showLess()');
	
		for(var a in this.DOM.ul.childNodes) {
			if(typeof this.DOM.ul.childNodes[a].id != 'undefined') {
				if((a > 9) && (this.DOM.ul.childNodes[a].id != 'menu-followed-topics-show-more') && (this.DOM.ul.childNodes[a].id != 'menu-followed-topics-find-more')) {
					this.DOM.ul.childNodes[a].addClass('hidden');
				}
			}
		}

		this.DOM.showMoreLink.innerHTML = 'More ...';
		this.DOM.showMoreLink.setAttribute('style', 'background-image:url(\'/assets/topic-icons/icon-menu-expand-16x16.png\');');

		this.DOM.showMoreLink.replaceEvent('click', this.showLess, this.showMore, false);
	
	}).bind(this);
	
	return true;

}

FollowedTopicsSidebarMenu.prototype = new SidebarMenu;