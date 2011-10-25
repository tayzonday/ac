/* TopicForListing class */

/**
 * @constructor
 */
function TopicForListing() {

	// Constructor 
	this.setup();

	// Extra properties that are not already inherited from the parent

	this.build = function (append_to) {

		console.log('TopicForListing.build(' + append_to + ')');
		
		this.DOM.root = new DOMElement('article');
		this.DOM.root.setAttribute('data-topic-id', this.id);

		if(append_to) {
			append_to.appendChild(this.DOM.root);
		}

		var div = new DOMElement('div', this.DOM.root);
		div.className = 'topic-wrap';

		var a = new DOMElement('a', div);
		a.href = '/' + this.slug;

		var img = new DOMElement('img', a);
		img.src = this.iconLarge;

		var h3 = new DOMElement('h3', div);
	
		var a = new DOMElement('a', h3);
		a.className = 'black';
		a.innerHTML = this.name;
		a.href = '/' + this.slug;
	
		var p = new DOMElement('p', div);
		p.innerHTML = this.strings.numThreadsPosts;

		this.DOM.numFollowers = new DOMElement('p', div);
		this.DOM.numFollowers.innerHTML = this.strings.numFollowers;

		this.DOM.followButton = new DOMElement('button', div);
		this.DOM.followButton.id = 'follow-topic-' + this.id + '-button';
		this.DOM.followButton.setAttribute('data-topic-id', this.id);
		if(this.userFollows === true) {
			this.DOM.followButton.innerHTML = 'Unfollow';
			this.DOM.followButton.className = 'red small';
			this.DOM.followButton.addEvent('click', this.events.unfollow, false);
		} else {
			this.DOM.followButton.innerHTML = 'Follow';
			this.DOM.followButton.className = 'green small';
			this.DOM.followButton.addEvent('click', this.events.follow, false);
		}
		
		var clear = new DOMElement('div', this.DOM.root);
		clear.className = 'clear';

	}






	// Events
	
	this.events = {
	
	// Follow the topic
	follow:

		(function () {
      
			console.log('TopicForListing.events.follow()');

			var ajax = new AjaxRequest(5);

			ajax.params = {
				'topic-id':this.id
			};

			ajax.callbacks.success = (function (response) {

				console.log('TopicForListing.events.follow().[ajax.callbacks.success]');

				// Populate any changed data from the ajax repsonse
				this.numFollowers = response.topic.num_followers;

				this.DOM.followButton.disabled = true;

				this.DOM.followButton.innerHTML = 'Unfollow';
				this.DOM.followButton.replaceClass('green', 'red');
				this.DOM.followButton.disabled = false;

				this.DOM.followButton.replaceEvent('click', this.follow, this.unfollow, false);

				this.DOM.numFollowers.innerHTML = this.numFollowers + ' followers';

				// Add to menu
				var item = new SidebarMenuItem;

				item.id     = this.id;
				item.href   = '/' + this.slug;
				item.title  = this.name;
				item.icon   = this.iconSmall;
				item.num    = 0;
				item.hidden = false;

				Wirah.template.leftSidebar.followedTopics.addItem(item);

				Wirah.template.leftSidebar.followedTopics.selectItem(item.id);

			}).bind(this);

			ajax.callbacks.error = (function (response) {

				console.log('TopicForListing.events.follow().[ajax.callbacks.error]');
        
			}).bind(this);

	        ajax.makeRequest();

		}).bind(this),


	// Unfollow the topic
	unfollow:

		(function () {

			console.log('TopicForListing.events.unfollow()');

			this.DOM.followButton.disabled = true;

			var ajax = new AjaxRequest(6);

			ajax.params = {
				'topic-id':this.id
			};

			ajax.callbacks.success = (function (response) {

				console.log('TopicForListing.events.unfollow().[ajax.callbacks.success]');
				
				// Populate any changed data from the ajax repsonse
				this.numFollowers = response.topic.num_followers;

				this.DOM.followButton.innerHTML = 'Follow';
				this.DOM.followButton.replaceClass('red', 'green');
				this.DOM.followButton.disabled = false;

				this.DOM.followButton.replaceEvent('click', this.unfollow, this.follow, false);

				this.DOM.numFollowers.innerHTML = this.numFollowers + ' followers';

				Wirah.template.leftSidebar.followedTopics.removeItem(this.id);		

			}).bind(this);

			ajax.callbacks.error = (function (response) {

				console.log('TopicForListing.events.unfollow().[ajax.callbacks.error]');

			}).bind(this);

			ajax.makeRequest();

        }).bind(this)
	
	}


	return true;

}

TopicForListing.prototype = new Topic;