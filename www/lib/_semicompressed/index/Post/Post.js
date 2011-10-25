/* Post class */

/**
 * @constructor
 */
function Post() {

	var self = this;
	
	this.parent = null;
	
	// Regular members
	this.id                   = 0;
	this.typeId               = 0;
	this.userId               = 0;
	this.threadId             = 0;
	this.threadPostId         = 0;
	this.parentPostId         = 0;
	this.body                 = '';
	this.imageUrl             = '';
	this.ip                   = '';
	this.numReplies           = '';
	this.numRepliesWithImages = '';
	this.timestampCreated     = 0;
	this.timestampUpdated     = 0;

	// Object members
	this.thread     = null;
	this.timeAgo    = '';
	this.timeString = '';
	
	// Extra members


	// DOM
	this.DOM           = {};
	this.DOM.root      = null; // article
	this.DOM.inner     = null; //
	this.DOM.header    = null; // <header>
	this.DOM.timestamp = null; // a
	
	this.buildForListing = function() {

		this.DOM.root = document.createElement('article');
		this.DOM.root.className = 'post';
		
		this.DOM.inner = document.createElement('div');
		this.DOM.inner.className = 'inner';
		
		this.DOM.header = document.createElement('header');
		
		var p = document.createElement('p');
		
		var input = document.createElement('input');
		input.id = 'post-' + this.id + '-checkbox';
		input.type = 'checkbox';
		p.appendChild(input);
		
		p.appendChild(document.createTextNode(' '));
		
		var label = document.createElement('label');
		label.setAttribute('for', 'post-' + this.id + '-checkbox');
		label.innerHTML = 'Anonymous';
		p.appendChild(label);
		
		this.DOM.timestamp = document.createElement('a');
		this.DOM.timestamp.className = 'grey';
		this.DOM.timestamp.href = 'javascript:;';

		this.formatTimeAgo();
		this.formatTimeString();

		this.DOM.timestamp.setAttribute('data-time-ago', this.timeAgo);
		this.DOM.timestamp.setAttribute('data-time-string', this.timeString);
		this.DOM.timestamp.setAttribute('data-mode', 0);

		this.DOM.timestamp.innerHTML = this.timeAgo;
		p.appendChild(this.DOM.timestamp);
		
		addEvent(this.DOM.timestamp, 'click', this.toggleTimestamp, false);
		
		var a = document.createElement('a');
		a.href = '/' + this.thread.topic.slug + '/' + this.thread.postId + '/' + this.id;
		a.innerHTML = '#' + this.id;
		p.appendChild(a);
		
		// image goes here later
		// image goes here later
		// image goes here later
		// image goes here later

		this.DOM.header.appendChild(p);		

		this.DOM.inner.appendChild(this.DOM.header);

		this.DOM.text = document.createElement('p');
		this.DOM.text.innerHTML = this.text;
		this.DOM.inner.appendChild(this.DOM.text);

		this.DOM.root.appendChild(this.DOM.inner);
		
	}
	
	
	
	this.formatTimeAgo = function() {

		var now = new Date;
		this.timeAgo = formatTimeAgo(timeAgo(Math.floor(now.getTime() / 1000) - this.timestampCreated)) + ' ago';
	
	}
	
	
	this.formatTimeString = function() {

		var date = new Date(this.timestampCreated * 1000);
		var hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
		var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
		var seconds = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
		var day = date.getDate();
		var day_x = day < 10 ? '0' + day : day;
		var weekday = date.getDay();
		var weekday = config.shortWeekdays[weekday];
		var month = (parseInt(date.getMonth() + 1)) < 10 ? '0' + parseInt(date.getMonth() + 1) : parseInt(date.getMonth() + 1);
		var year = date.getFullYear();
		
		this.timeString = weekday + ' ' + day_x + '/' +  month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;
	
	}
	
	
	this.toggleTimestamp = function() {
	
		// use self
		
		if(this.getAttribute('data-mode') == '0') {
			this.innerHTML = this.getAttribute('data-time-string');
			this.setAttribute('data-mode', 1);
		} else {
			this.innerHTML = this.getAttribute('data-time-ago');
			this.setAttribute('data-mode', 0);
		}
	
	}
	
	
	
	
	
	
	return true;

}



