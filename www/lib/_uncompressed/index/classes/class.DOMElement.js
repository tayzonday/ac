/* DOMElement class */

/**
 * @constructor
 */
function DOMElement(_tag, _append_to, _attributes) {
	
	this.element = document.createElement(_tag);
	
	for(var a in _attributes) {
		if(a == 'html') {
			this.element.innerHTML = _attributes[a];
			continue;
		}
	
		this.element.setAttribute(a, _attributes[a]);
	}

	if(_append_to) {
		_append_to.appendChild(this.element);
	}

	return this.element;

}
