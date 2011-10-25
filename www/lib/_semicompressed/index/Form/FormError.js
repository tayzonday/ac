/* FormError class */

/**
 * @constructor
 */
function FormError(code, title, message) {

	var self = this;
	
	this.code    = code;
	this.title   = title;
	this.message = message;
	
	return true;

}

