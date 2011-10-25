/* CreateThreadPage class */

/**
 * @constructor
 */
function CreateThreadPage() {

	this.id = 10;

	/* Object members */
	this.thread = false; /* new Thread */
	this.form = false; /* new CreateThreadForm */
	
	/* DOM */
	this.DOM.formStatus     = false;
	this.DOM.goToThread     = false;
	this.DOM.addToMyThreads = false;
	this.DOM.submitButton   = false; 
	
	
	this.populate = function(response) {
	
		this.thread = new ThreadForCreation(this);
		
		this.thread.topic = new Topic;
		
		this.thread.topic.id = response.topic.id;
		this.thread.topic.name = response.topic.name;
		this.thread.topic.slug = response.topic.slug;
		
		this.form = new CreateThreadForm(this);

	}			

	
	this.build = function() {
	
		this.buildRightSidebar();
		this.DOM.content.appendChild(this.DOM.rightSidebar);

		var p = new DOMElement('p', {
			'html':'Please build your thread below:',
			'append-to':this.DOM.content,
		});
		
		this.thread.build();
		this.DOM.content.appendChild(this.thread.DOM.root);

	}
	

	this.buildRightSidebar = function() {

		this.DOM.rightSidebar = new DOMElement('div', {'id':'right-sidebar'} );
		
		var h4 = new DOMElement('h4', {'html':'Thread Options', 'append-to':this.DOM.rightSidebar} );
		
		var p = new DOMElement('p', {'append-to':this.DOM.rightSidebar} );
		
		this.DOM.goToThread = new DOMElement('input', {'type':'checkbox', 'id':'go-to-thread', 'checked':'checked', 'append-to':p} );
		
		p.appendText(' ');
		
		var label = new DOMElement('label', {'for':'go-to-thread', 'html':'Go to the thread', 'append-to':p} );

		var p = new DOMElement('p', {'append-to':this.DOM.rightSidebar} );

		this.DOM.addToMyThreads = new DOMElement('input', {'type':'checkbox', 'id':'add-to-my-threads', 'checked':'checked', 'append-to':p} );
		
		p.appendText(' ');
		
		var label = new DOMElement('label', {'for':'add-to-my-threads', 'html':'Add to My Threads', 'append-to':p} );

		var div = new DOMElement('div', {'id':'submit-button-wrap', 'append-to':this.DOM.rightSidebar }); // CHANGE ME
		
		this.DOM.submitButton = new DOMElement('button', {'html':'Create Thread', 'class':'green', 'append-to':div,
			'events':{'click':this.form.validate}
		});

		this.DOM.formStatus = new DOMElement('div', {'class':'form-status', 'append-to':this.DOM.rightSidebar} );

	}

	
	
	
	
	
	
	
	
	this.setup();

	return true;

}

CreateThreadPage.prototype = new Page;
