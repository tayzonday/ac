/* DOMElement class */

/**
 * @constructor
 */
window['DOMElement'] = DOMElement;
function DOMElement(tag, append_to) {
	
	this.element = document.createElement(tag);

	if(append_to) {
		append_to.appendChild(this.element);
	}

	return this.element;

}
