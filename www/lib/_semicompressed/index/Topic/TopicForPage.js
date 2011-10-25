/* TopicForPage class */

/**
 * @constructor
 */
function TopicForPage(parent) {

	this.parent = parent;

	this.threadListing     = false; /* new ThreadListing */
	this.threadForCreation = false; /* new ThreadForCreation */

	this.DOM = {
		root:              false,
		createThreadButton:false,
		rightSidebar:      false,
		followButton:      false,
		numFollowers:      false
	};


	this.build = function() {

		this.DOM.root = new DOMElement('article', {'class':'topic', 'data-context-id':1});

		this.threadListing.build(); // change to buildTo
		this.DOM.root.appendChild(this.threadListing.DOM.root);
		
		this.buildRightSidebar();
		this.DOM.root.appendChild(this.DOM.rightSidebar);

	}
	
	
	this.buildRightSidebar = function() {

		this.DOM.rightSidebar = new DOMElement('div', {'id':'right-sidebar'});

		var div = new DOMElement('div', {'class':'center', 'append-to':this.DOM.rightSidebar});

		this.DOM.createThreadButton = new DOMElement('button', {'class':'', 'data-href':'/' + this.slug + '/create', 'html':'Create Thread', 'append-to':div,
			'events':{'click':clickLinkPushState}}
		);

		var p = new DOMElement('p', {'html':this.description, 'append-to':this.DOM.rightSidebar});

		var div = new DOMElement('div', {'class':'follow', 'append-to':this.DOM.rightSidebar});

		// follow topic id not needed?
		if(this.userFollows === true) {
			this.DOM.followButton = new DOMElement('button', {'html':'Unfollow Topic', 'class':'red', 'append-to':div,
				'events':{'click':this.unfollow}
			});
		} else {
			this.DOM.followButton = new DOMElement('button', {'html':'Follow Topic', 'class':'green', 'append-to':div,
				'events':{'click':this.follow}
			});
		}

		this.DOM.numFollowers = new DOMElement('p', {'html':this.numFollowers.numberFormat() + ' followers', 'append-to':div});

		// id needed?
		var div = new DOMElement('div', {'class':'stats', 'append-to':this.DOM.rightSidebar});

		var p = new DOMElement('p', {'html':this.numThreads.numberFormat() + ' active threads', 'append-to':div});
		var p = new DOMElement('p', {'html':this.numPosts.numberFormat() + ' active posts', 'append-to':div});
		var p = new DOMElement('p', {'html':this.numThreadsAllTime.numberFormat() + ' threads all time', 'append-to':div});
		var p = new DOMElement('p', {'html':this.numPostsAllTime.numberFormat() + ' posts all time', 'append-to':div});

	}
	








	/* Events */

	this.follow = (function() {
	
		var ajax = new AjaxRequest(5);
		
		ajax.params = {
			'topic-id':this.id
		};

		ajax.callbacks.success = (function(response) {

			/* Populate any changed data from the ajax repsonse */
			this.numFollowers = response.topic.num_followers;
		
			console.log('success for ajax follow');
		
			this.DOM.followButton.disabled = true;

			this.DOM.followButton.innerHTML = 'Unfollow Topic';
			this.DOM.followButton.replaceClass('green', 'red');
			this.DOM.followButton.disabled = false;
			
			this.DOM.followButton.replaceEvent('click', this.follow, this.unfollow, false);

			this.DOM.numFollowers.innerHTML = this.numFollowers + ' followers';

			// Add to menu
			var item = new SidebarMenuItem(sidebar.followedTopics);

			item.id     = this.id;
			item.href   = '/' + this.slug;
			item.title  = this.name;
			item.icon   = this.iconSmall;
			item.num    = 0;
			item.hidden = false;
			
			sidebar.followedTopics.addItem(item);
			
			sidebar.followedTopics.selectItem(item.id);

		}).bind(this);
	
		ajax.callbacks.error = (function(response) {
			console.log('Error in TopicForPage[Topic]->follow()');
		}).bind(this);

		ajax.makeRequest();

	}).bind(this);



	this.unfollow = (function() {

		this.DOM.followButton.disabled = true;
	
		var ajax = new AjaxRequest(6);

		ajax.params = {
			'topic-id':this.id
		};

		ajax.callbacks.success = (function(response) {

			/* Populate any changed data from the ajax repsonse */
			this.numFollowers = response.topic.num_followers;

			console.log('success for ajax unfollow');
	
			this.DOM.followButton.innerHTML = 'Follow Topics';
			this.DOM.followButton.replaceClass('red', 'green');
			this.DOM.followButton.disabled = false;

			this.DOM.followButton.replaceEvent('click', this.unfollow, this.follow, false);
			
			this.DOM.numFollowers.innerHTML = this.numFollowers + ' followers';

			sidebar.followedTopics.removeItem(this.id);		

		}).bind(this);

	
		ajax.callbacks.error = (function(response) {
			console.log('Error in TopicForPage[Topic]->unfollow()');
		}).bind(this);

		ajax.makeRequest();

	}).bind(this);
	






























































/*
	
	this.createThreadSuccess = function(topic_object) {

		this.createThreadModal.form.DOM.submitButton.disabled = false;

		this.createThreadModal.close();

		var thread = new Thread;

		thread.id                    = response.thread.id;
		thread.type_id               = response.thread.type_id;
		thread.user_id               = response.thread.user_id;
		thread.topic_id              = response.thread.topic_Id;
		thread.post_id               = response.thread.post_id;
		thread.subject               = response.thread.subject;
		thread.text                  = response.thread.text;
		thread.image_url             = response.thread.image_url;
		thread.num_posts             = response.thread.num_posts;
		thread.num_posts_with_images = response.thread.num_posts_with_image;
		thread.timestamp_created     = response.thread.timestamp_created;
		thread.timestamp_updated     = response.thread.timestamp_updated;

		thread.build();

		if(response.thread.goto_after_create) {
			alert('Going to thread');
		} else {
			alert('Staying here just adding to top');
		}

	}
	
*/
	


	
	
	
	
	
	
	









































	
	
	
	
	
/*
	
	this.showCreateThreadForm = function() {
			
		self.createThreadModal.open();
		self.createThreadModal.loading();

		self.createThreadModal.getHtmlAjaxRequest.successCallback = function(response) {
		
			self.createThreadModal.setHeading(response.modal.heading);
			self.createThreadModal.setHtml(response.modal.html);
			self.createThreadModal.setFooterButtons('Cancel', 'create-thread-form-cancel', 'Create Thread', 'create-thread-form-submit');
			self.createThreadModal.form.setup();

			addEvent(self.createThreadModal.DOM.cancelButton, 'click', self.createThreadModal.form.cancel, false);
			addEvent(self.createThreadModal.DOM.submitButton, 'click', self.createThreadModal.form.submit, false);


		}
	
		self.createThreadModal.getHtmlAjaxRequest.errorCallback = function(response) {
			alert('Error');
		}

		self.createThreadModal.getHtmlAjaxRequest.params = {
			"topic-id":self.topic.object.id
		};

		self.createThreadModal.getHtmlAjaxRequest.setup(10, 'POST', self.createThreadModal.getHtmlAjaxRequest.successCallback, self.createThreadModal.getHtmlAjaxRequest.errorCallback);
		self.createThreadModal.getHtmlAjaxRequest.makeRequest();

	}
*/
	
	
	return true;

}
TopicForPage.prototype = new Topic;



