/* CreateThreadForm class */

/**
 * @constructor
 */
function CreateThreadForm(parent) {
	
	this.parent = parent;
	
	this.topicId        = 0;
	this.text           = '';
	this.goToThread     = true;
	this.addToMyThreads = true;
	
	this.hasErrors = false;
	

	this.populate = function() {
	
		this.topicId        = this.parent.thread.topic.id;
		this.text           = this.parent.thread.DOM.text.value;
		this.goToThread     = this.parent.DOM.goToThread.checked ? 1 : 0;
		this.addToMyThreads = this.parent.DOM.addToMyThreads.checked ? 1 : 0;
	
	}

	this.validate = (function() {
	
		this.populate();
	
		this.parent.DOM.formStatus.innerHTML = '';
		this.parent.DOM.formStatus.addClass('hidden');
	
		if(!is_numeric(this.topicId)) return false;
		
		if((this.text == '') || (this.text == '&nbsp;')) {
			this.displayStatus(0, 'Empty Text', 'You can not create an empty thread.');
			return false;
		}
		
		if(this.text.length > config.threadTextMaxLength) {
			this.displayStatus(0, 'Text Too Long', 'Your Text is too long. Keep it under ' + config.threadTextMaxLength + ' characters.');
			return false;
		}
		
		// image validation

		this.submit();
	
	}).bind(this);
	
	
	this.displayStatus = function(type, title, text) {
	
		// type 0 = error
		// type 1 = success
	
		this.hasErrors = type == 0 ? true: false;
		
		this.parent.DOM.formStatus.removeClass('hidden');
		
		if(type == 0) {
			this.parent.DOM.formStatus.replaceClass('win', 'fail');
		} else {
			this.parent.DOM.formStatus.replaceClass('fail', 'win');
		}

		var h3 = new DOMElement('h3', {'append-to':this.parent.DOM.formStatus});
		h3.innerHTML = title;

		var p = new DOMElement('p', {'append-to':this.parent.DOM.formStatus});
		p.innerHTML = text;

	}



	this.submit = function() {
	
		var ajax = new AjaxRequest(11);
		
		ajax.params = {
			'topic-id':this.topicId,
			'text':this.text,
			'go-to-thread':this.goToThread,
			'add-to-my-threads':this.addToMyThreads
		};

		ajax.callbacks.success = (function(response) {

			console.log('create thread success');
			
			if(response.go_to_thread == 1) {
				handlePathInclude('/' + response.thread.topic.name + '/' + response.thread.post_id);
			} else {
				this.displayStatus(1, 'Thread Created', 'Your thread has been created.<br /><br />Click <a href="#">here</a> to see it.');
				
				this.parent.thread.DOM.text.value = '';
				
				
				// If MyThreads menu exists...
				
				// Add to MyThreads Menu
				// 
				//
				//
				//
				
			}
			

		}).bind(this);
	
		ajax.callbacks.error = (function(response) {
			console.log('Error in CreateThreadForm[Form]->submit()');
			
			for (var n in response.errors) {
				this.displayStatus(0, response.errors[n].title, response.errors[n].text)
			}
			
			
		}).bind(this);


		ajax.makeRequest();

	}




}

