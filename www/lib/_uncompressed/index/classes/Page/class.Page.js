/* Page class */

/**
 * @constructor
 */
function Page() {

	this.html = '';

	this.build = function (_append_to) {

		Wirah.template.DOM.contentInner.innerHTML = this.html;
		Wirah.template.DOM.contentInner.convertChildrenToPushStateLinks();

	}

	return true;

}