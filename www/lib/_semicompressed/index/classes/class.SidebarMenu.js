// SidebarMenu class

/**
 * @constructor
 */
function SidebarMenu() {

	this.title        = '';
	this.itemIdPrefix = '';
	
	this.items = [];
	
	// DOM
	this.DOM      = {};
	this.DOM.root = false;
	this.DOM.ul   = false;

	
	// Add a new item to the items array.
	this.addItem = function(item) {
	
		console.log('SidebarMenu.addItem(' + item + ')');
	
		if(!this.containsItem(item.id)) {
			item.build();
			this.items.push(item);
			this.DOM.ul.appendChild(item.DOM.root);
		}

	}

	// Remove an item from the items array.
	this.removeItem = function(item_id) {

		console.log('SidebarMenu.removeItem(' + item_id + ')');

		for(var a in this.items) {
			if(this.items[a].id == item_id) {
				this.items[a].DOM.root.parentNode.removeChild(this.items[a].DOM.root);
				this.items.splice(a, 1);
				return true;
			}
		}

	}

	// Check if this menu contains a particular item. Return the item if so.
	this.containsItem = function(item_id) {

		console.log('SidebarMenu.containsItem(' + item_id + ')');

		for(var a in this.items) {
			if(this.items[a].id == item_id) {
				return this.items[a];
			}
		}

		return false;
	}

	// Reset items, select an item if it exists.
	this.selectItem = function(item_id) {

		console.log('SidebarMenu.selectItem(' + item_id + ')');

		this.resetItems();

		var item = false;

		if(item = this.containsItem(item_id)) {
			item.DOM.root.addClass('selected');
		}
	}

	// Unselect any selected items in this menu
	this.resetItems = function() {

		console.log('SidebarMenu.resetItems()');
	
		for(var a in this.items) {
			this.items[a].DOM.root.removeClass('selected');
		}
		return true;
	}		

	// Build the DOM
	this.build = function(append_to) {
	
		console.log('SidebarMenu.build()');

		if(append_to) {
			append_to.appendChild(this.DOM.root);
		}

		this.DOM.root = new DOMElement('menu');

		var h4 = new DOMElement('h4', this.DOM.root);
		h4.innerHTML = this.title;

		this.DOM.ul = new DOMElement('ul', this.DOM.root);

		if(this.items.length > 0) {

			for(var n in this.items) {
			
				if(n > 9) {
					this.items[n].hidden = true;
				}

				this.items[n].build();

				this.DOM.ul.appendChild(this.items[n].DOM.root);
		
			}
		
		}

	}

	return true;

}







