// SidebarMenu class

/**
 * @constructor
 */
function SidebarMenu() {

	// Properties
	this.title         = '';
	this.itemIdPrefix  = '';
	this.maxItemsShown = 9;
	
	this.items = [];
	
	// DOM
	this.DOM      = {};
	this.DOM.root = false;
	this.DOM.ul   = false;

	
	// Add a new item to the items array.
	this.addItem = function (_item) {
	
		console.log('SidebarMenu.addItem(' + _item + ')');
	
		if(!this.hasItem(item.id)) {
			item.build(this.DOM.ul);
			this.items.push(item);
		}

	}

	// Remove an item from the items array.
	this.removeItem = function (_item_id) {

		console.log('SidebarMenu.removeItem(' + _item_id + ')');

		for(var a in this.items) {
			if(this.items[a].id == _item_id) {
				this.items[a].DOM.root.parentNode.removeChild(this.items[a].DOM.root);
				this.items.splice(a, 1);
				return true;
			}
		}

	}

	// Check if this menu contains a particular item. Return the item if so.
	this.hasItem = function (_item_id) {

		console.log('SidebarMenu.hasItem(' + _item_id + ')');

		for(var a in this.items) {
			if(this.items[a].id == _item_id) {
				return this.items[a];
			}
		}

		return false;
	}

	// Reset items, select an item if it exists.
	this.selectItem = function (_item_id) {

		console.log('SidebarMenu.selectItem(' + _item_id + ')');

		this.resetItems();

		var item = false;

		if(item = this.hasItem(_item_id)) {
			item.DOM.root.addClass('selected');
		}
	}

	// Unselect any selected items in this menu
	this.resetItems = function () {

		console.log('SidebarMenu.resetItems()');
	
		for(var a in this.items) {
			this.items[a].DOM.root.removeClass('selected');
		}
		return true;
	}		

	// Build the DOM
	this.build = function (_append_to) {
	
		console.log('SidebarMenu.build()');

		this.DOM.root = new DOMElement('menu', _append_to);

		var h4 = new DOMElement('h4', this.DOM.root, {'html':this.title});

		this.DOM.ul = new DOMElement('ul', this.DOM.root);

		if(this.items.length > 0) {

			for(var a in this.items) {
			
				if(a > this.maxItemsShown) {
					this.items[a].hidden = true;
				}

				this.items[a].build(this.DOM.ul);
		
			}
		
		}

	}

	return true;

}