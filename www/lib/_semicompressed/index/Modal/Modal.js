/* Modal class */

/**
 * @constructor
 */
function Modal() {

	var self = this;

	this.DOM = {};

	this.DOM.root         = null;
	this.DOM.inner        = null;
	this.DOM.header       = null;
	this.DOM.html         = null;
	this.DOM.footer       = null;
	this.DOM.cancelButton = null;
	this.DOM.submitButton = null;
	
	this.form = new Form;
	
	this.getHtmlAjaxRequest = new AjaxRequest;
	this.submitAjaxRequest = new AjaxRequest;


	this.open = function() {

		this.DOM.root = document.getElementById('modal');
		if(this.DOM.root != null) {
			this.DOM.root.parentNode.removeChild(this.DOM.root);
		}
		this.DOM.root = document.createElement('div');
		this.DOM.root.id = 'modal';
		document.getElementsByTagName('body')[0].appendChild(this.DOM.root);

		this.DOM.inner = document.createElement('div');
		this.DOM.root.appendChild(this.DOM.inner);
	
		this.DOM.header = document.createElement('header');
		this.DOM.inner.appendChild(this.DOM.header);
		addClass(this.DOM.header, 'hidden');
	
		this.DOM.html = document.createElement('div');
		this.DOM.inner.appendChild(this.DOM.html);
	
		this.DOM.footer = document.createElement('footer');
		this.DOM.inner.appendChild(this.DOM.footer);
		addClass(this.DOM.footer, 'hidden');
	
	}


	this.loading = function() {

		this.setHtml('<p class="loading">Loading...</p>');
		this.setWidth(442);

	}
	

	this.setWidth = function(width) {
	
		this.DOM.root.style.width = width + 'px';

		if(typeof window.innerWidth != 'undefined') {
			var viewportWidthX = window.innerWidth;
			var viewportOffsetY = window.pageYOffset;
		} else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
			var viewportWidthX = document.documentElement.clientWidth;
			var viewportOffsetY = document.body.scrollTop;
		} else {
			var viewportWidthX = document.getElementsByTagName('body')[0].clientWidth;
			var viewportOffsetY = document.documentElement.scrollTop;
		}

		this.DOM.root.style.left = ((viewportWidthX / 2) - (width / 2)) + 'px';
		this.DOM.root.style.top = (viewportOffsetY + 59) + 'px';

	
	}

	this.setHeading = function(heading) {
	
		removeClass(this.DOM.header, 'hidden');
		removeClass(this.DOM.footer, 'hidden');

		this.DOM.heading = this.DOM.header.getElementsByTagName('h3')[0];
		if(this.DOM.heading == null) {
			this.DOM.heading = document.createElement('h3');
			this.DOM.header.appendChild(this.DOM.heading);
		}
	
		this.DOM.heading.innerHTML = heading;
	
	}


	this.setHtml = function(html) {

		this.DOM.html.innerHTML = html;

	}


	this.setFooterButtons = function(cancel_text, cancel_id, submit_text, submit_id) {

		removeClass(this.DOM.footer, 'hidden');
	
		cancel_buttons = this.DOM.footer.getElementsByClassName('cancel');
		if(cancel_buttons.length > 0) {
			cancel_buttons[0].parentNode.removeChild(cancel_buttons[0]);
		}
	
		this.DOM.cancelButton = document.createElement('button');
		this.DOM.cancelButton.id = cancel_id;
		this.DOM.cancelButton.className = 'cancel small';
		this.DOM.cancelButton.innerHTML = cancel_text;	
		this.DOM.footer.appendChild(this.DOM.cancelButton);

		submit_buttons = this.DOM.footer.getElementsByClassName('submit');
		if(submit_buttons.length > 0) {
			submit_buttons[0].parentNode.removeChild(submit_buttons[0]);
		}
	
		this.DOM.submitButton = document.createElement('button');
		this.DOM.submitButton.id = submit_id;
		this.DOM.submitButton.className = 'submit green small';
		this.DOM.submitButton.innerHTML = submit_text;
		this.DOM.footer.appendChild(this.DOM.submitButton);
	
		var clear = document.createElement('div');
		clear.className = 'clear';
		this.DOM.footer.appendChild(clear);

	}


	this.close = function() {
		this.DOM.root.parentNode.removeChild(this.DOM.root);
	}

	
	return true;

}
