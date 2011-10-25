/* ThreadForListing class */

/**
 * @constructor
 */
function ThreadForListing(parent) {

	/* DOM */
	this.DOM = {
		root:        false,
		header:      false,
		heading:     false,
		timestamp:   false,
		menu:        false,
		followButton:false,
		replyButton: false,
		reportButton:false,
		text:        false,
		omitted:     false
	};
	
	
	this.build = function() {


		this.DOM.root = new DOMElement('article', {'class':'thread', 'data-context-id':2});

		this.DOM.header = new DOMElement('header', {'append-to':this.DOM.root});

		var div = new DOMElement('div', {'append-to':this.DOM.header});
		
		var a = new DOMElement('a', {'href':'/' + this.topic.slug + '/' + this.postId, 'append-to':div});
		
		var img = new DOMElement('img', {'src':'/assets/thread/example-image.jpg', 'append-to':a});

		var p = new DOMElement('p', {'append-to':this.DOM.header});

		var input = new DOMElement('input', {'id':'thread-' + this.id + '-checkbox', 'type':'checkbox', 'append-to':p});

		p.appendText(' ');
		
		var label = new DOMElement('label', {'for':'thread-' + this.id + '-checkbox', 'html':'Anonymous', 'append-to':p});

		this.formatTimeAgo();
		this.formatTimeString();
		
		this.DOM.timestamp = new DOMElement('a', {'class':'grey', 'href':'javascript:;', 'html':this.timeAgo, 'append-to':p,
			'events':{'click':this.toggleTimestamp}
		} );
		
		p.appendText(' in');
		
		var a = new DOMElement('a', {'href':'/' + this.topic.slug, 'html':this.topic.name, 'append-to':p} );
		
		var a = new DOMElement('a', {'href':'/' + this.topic.slug + '/' + this.postId, 'html':'#' + this.postId, 'append-to':p} );
		
		/*



		this.DOM.menu = document.createElement('menu');

		this.DOM.followButton = document.createElement('button');
		this.DOM.followButton.className = 'small';
		if(this.userFollows === true) {
			this.DOM.followButton.innerHTML = 'Unfollow';
			this.DOM.followButton.addEvent('click', this.unfollow, false);
		} else {
			this.DOM.followButton.innerHTML = 'Follow';
			this.DOM.followButton.addEvent('click', this.follow, false);
		}
		this.DOM.menu.appendChild(this.DOM.followButton);

		this.DOM.replyButton = document.createElement('button');
		this.DOM.replyButton.className = 'small';
		this.DOM.replyButton.innerHTML = 'Reply';
		this.DOM.menu.appendChild(this.DOM.replyButton);

		this.DOM.reportButton = document.createElement('button');
		this.DOM.reportButton.className = 'small right';
		this.DOM.reportButton.innerHTML = 'Report';
		this.DOM.menu.appendChild(this.DOM.reportButton);

		this.DOM.root.appendChild(this.DOM.menu);
		
		this.DOM.text = document.createElement('p');
		this.DOM.text.innerHTML = this.text;
		
		this.DOM.root.appendChild(this.DOM.text);

		if((this.numPostsOmitted > 0) || (this.numPostsWithImagesOmitted > 0)) {

			this.DOM.omitted = document.createElement('p');
			this.DOM.omitted.className = 'omitted';

			var span = document.createElement('span');
			span.innerHTML = this.numPostsOmitted + ' posts and ' + this.numPostsWithImagesOmitted + ' images omitted.';
			this.DOM.omitted.appendChild(span);

			var _ = document.createTextNode(' ');
			this.DOM.omitted.appendChild(_);
		
			var a = document.createElement('a');
			a.href = '/' + this.topic.slug + '/' + this.postId;
			a.innerHTML = 'Click here to view.';
			this.DOM.omitted.appendChild(a);
		
			this.DOM.root.appendChild(this.DOM.omitted);
		}


		/* PostListing */
		
		//this.postListing.build();
		//this.DOM.root.appendChild(this.postListing.DOM.root);
		
		//var clear = document.createElement('div');
		//clear.className = 'clear';
		//this.DOM.root.appendChild(clear);
		
	}
	
	
	
	
	/* Event */
	
	this._toggleTimestamp = function() {
	
		if(this.timestampToggleMode == 0) {
			this.DOM.timestamp.innerHTML = this.timeString;
			this.timestampToggleMode = 1;
		} else {
			this.DOM.timestamp.innerHTML = this.timeAgo;
			this.timestampToggleMode = 0;
		}

	}
	this.toggleTimestamp = this._toggleTimestamp.bind(this);

	
	
	
	
	
	return true;

}

ThreadForListing.prototype = new Thread;
