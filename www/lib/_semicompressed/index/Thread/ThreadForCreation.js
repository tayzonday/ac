/* ThreadForCreation class */

/**
 * @constructor
 */
function ThreadForCreation(parent) {

	this.parent = parent;
	
	this.textPlaceholder = 'Write your thread here...';

	/* DOM */
	this.DOM = {
		root:        false,
		header:      false,
		heading:     false,
		timestamp:   false,
		text:        false,
	};


	this.build = function() {

		this.DOM.root = new DOMElement('article', {'class':'thread', 'data-context-id':3});
		
		this.DOM.header = new DOMElement('header', {'append-to':this.DOM.root});
		
		var div = new DOMElement('div', {'append-to':this.DOM.header});
		
		var a = new DOMElement('a', {'href':'javascript:;', 'append-to':div});
		
		var img = new DOMElement('img', {'src':'/assets/thread/thread-placeholder-image.png?482397', 'append-to':a});

		var button = new DOMElement('button', {'html':'Choose Image...', 'class':'small', 'append-to':div} );

		var p = new DOMElement('p', {'append-to':this.DOM.header});

		var label = new DOMElement('label', {'html':'Anonymous', 'append-to':p });
		
		p.appendText(' in');
		
		var a = new DOMElement('a', {'href':'/' + this.topic.slug, 'html':this.topic.name, 'append-to':p });

		var div = new DOMElement('div', {'append-to':this.DOM.root} );

		this.DOM.text = new DOMElement('textarea', {'placeholder':this.textPlaceholder, 'append-to':div,
			'events':{'keyup':this.fixTextareaHeight}
		});
		
		var clear = new DOMElement('div', {'class':'clear', 'append-to':this.DOM.root} );

	}
	
	
	
	
	/* Events */
	this.fixTextareaHeight = (function() {

		if(this.DOM.text.scrollHeight > this.DOM.text.clientHeight && !window.opera) {
			this.DOM.text.rows += 1;
		}

	}).bind(this);
	
	
	

	
	
	return true;

}

ThreadForCreation.prototype = new Thread;
