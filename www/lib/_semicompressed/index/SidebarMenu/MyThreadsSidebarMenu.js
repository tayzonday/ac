/* MyThreadsSidebarMenu class */

/**
 * @constructor
 */
function MyThreadsSidebarMenu() {

	this.title        = 'My Threads';
	this.itemIdPrefix = 'menu-my-thread-';

	/* DOM */

	this.populate = function(items) {
	
		for (var n in items) {
		
			var item = new SidebarMenuItem(this);

			item.id     = items[n].id;
			item.href   = items[n].href;
			item.title  = items[n].title;
			item.icon   = items[n].icon;
			item.num    = items[n].num;
			item.hidden = false;
			
			this.items.push(item);

		}
	}
	




	return true;

}

MyThreadsSidebarMenu.prototype = new SidebarMenu;
