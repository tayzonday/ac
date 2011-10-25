/* Testing */

var pageId = 0;

function init() {

  /* FIXME - May not actually be needed since there is no HTML by default, everything is built dynamically with javascript */
  document.convertChildrenToPushStates();

  if(navigator.userAgent.indexOf('Firefox') != -1) { // Firefox
    revertToState({state:null});
  }
	
  if((navigator.userAgent.indexOf('Safari') != -1) && (navigator.userAgent.indexOf('Chrome') == -1)) { // Safari
    revertToState({state:null});
  }
	
  // Setup Page Object
  // Outer shit should be known as Template (currently Page)
  // Inner shit should be known as Page (currently Page too)
  
  
  template = new Template;
  template.setup();

  template.leftSidebar.followedTopics = new FollowedTopicsSidebarMenu;
  template.leftSidebar.followedTopics.populate(tS.fTo);
  template.leftSidebar.followedTopics.build(template.DOM.leftSidebar);
	
// Set event handlers on the mentions icons
//	var thread_replies = document.getElementById('thread-replies');
//	var post_mentions = document.getElementById('post-mentions');
	
//	thread_replies.addEvent('click', toggleThreadRepliesPopup, false);
//	post_mentions.addEvent('click', togglePostMentionsPopup, false);

//	sidebar = new Sidebar;

//	sidebar.followedTopics  = new FollowedTopicsSidebarMenu;
//	sidebar.myThreads       = new MyThreadsSidebarMenu;
//	sidebar.followedThreads = new FollowedThreadsSidebarMenu;

//	sidebar.followedTopics.populate(tS.fTo);
	//sidebar.myThreads.populate(tS.mTh);
	//sidebar.followedThreads.populate(tS.fTh);

//	sidebar.build();
//	document.getElementById('main').appendChild(sidebar.DOM.root);

	
//	breadcrumb = new Breadcrumb;

		
	// Investigate how to handle onblur by clicking anywhere else on the page.
	// this should hide both popups, if open
	
	// addEvent(document.getElementById('thread-replies-popup'), 'blur', function() { alert('g'); }, false);

//	var thread_replies_num = document.getElementById('thread-replies-num');
//	if(thread_replies_num.innerHTML == '0') {
//		thread_replies_num.style.display = 'none';
//	}

//	var post_mentions_num = document.getElementById('post-mentions-num');
//	if(post_mentions_num.innerHTML == '0') {
//		post_mentions_num.style.display = 'none';
//	}
	
}


function createPageObject(response) {

	template.DOM.contentInner.removeClass('invisible');

	template.setTitle(response.page.title);
	template.setHeading(response.page.heading);

//	sidebar.followedTopics.resetItems();
//	sidebar.myThreads.resetItems();
//	sidebar.followedThreads.resetItems();
	
	switch(response.page.id) {
		case 1: // Home

			console.log('response.page.id = 1 (Home)');

// var page = new HomePage;
//			page.id = response.page.id;

			break;

		case 2: // View Topic

			page = new ViewTopicPage;

			page.topic = new Topic;

			page.setFavicon(response.topic.icon_small);
			
			page.populate(response);
		
			sidebar.followedTopics.selectItem(response.topic.id);
			
			page.build();
						
			break;

		case 3: break;
		case 4: break;


		case 5: // /topics - Topics
		
			page = new TopicListingPage;

			page.populate(response);

			page.build();
			break;
			
		case 10: /* Create thread */
		
			page = new CreateThreadPage;
			
			page.populate(response);

			sidebar.followedTopics.selectItem(response.topic.id);
			
			page.build();
		
			break;

				
	}
	
	/* convert all hrefs involving the page to push state HERE. Nowhere else 
	   Only apply push states elsewhere if they come in dynamically (like a link
	   that is part of a form error message
	*/
	template.DOM.contentInner.convertChildrenToPushStates();
		
}




















function toggleThreadRepliesPopup() {

	var thread_replies_icon = this;
	var post_mentions_icon = document.getElementById('post-mentions');

	var thread_replies_popup = document.getElementById('thread-replies-popup');
	var post_mentions_popup  = document.getElementById('post-mentions-popup');

	if((thread_replies_popup.style.display == 'none') || (thread_replies_popup.style.display == '')) {
		thread_replies_icon.addClass('selected');
		thread_replies_popup.style.display = 'block';
		post_mentions_icon.removeClass('selected');
		post_mentions_popup.style.display = 'none';
	} else {
		thread_replies_icon.removeClass('selected');
		thread_replies_popup.style.display = 'none';
	}

}

function togglePostMentionsPopup() {

	var post_mentions_icon = this;
	var thread_replies_icon = document.getElementById('thread-replies');

	var post_mentions_popup  = document.getElementById('post-mentions-popup');
	var thread_replies_popup = document.getElementById('thread-replies-popup');

	if((post_mentions_popup.style.display == 'none') || (post_mentions_popup.style.display == '')) {
		post_mentions_icon.addClass('selected');
		post_mentions_popup.style.display = 'block';
		thread_replies_icon.removeClass('selected');
		thread_replies_popup.style.display = 'none';
	} else {
		post_mentions_icon.removeClass('selected');
		post_mentions_popup.style.display = 'none';
	}

}


function clickLinkPushState(e) {

	if((!e.shiftKey) && (!e.ctrlKey) && (!e.metaKey) && (!e.altKey)) {
		var href = false;
		if(href = this.getAttribute('data-href')) {
			handlePathInclude(href);
		} else if(href = this.getAttribute('href')) {
			handlePathInclude(href);
		}
		e.preventDefault();
	}
	
}

function revertToState(event) {

	if(event.state == null) {
//		alert('cant find shit');
		handlePathInclude(window.location.pathname);
	} else {
//		alert('got an object. cacheing');
		createPageObject(event.state);
	}
}











function toggleThreadCreateReplyForm() {

	var thread_id = this.getAttribute('data-thread-id');

	var section = document.getElementById('thread-' + thread_id + '-create-post-form-section');

	if(section) {

		if(hasClass(section, 'hidden')) {
			section.removeClass('hidden');
			
			var textarea = document.getElementById('thread-' + thread_id + '-create-post-form-body');
			textarea.focus();
			
		} else {
			section.addClass('hidden');
		}
	
	} else {
	
		var article = document.getElementById('thread-' + thread_id);
		
		// Build form dynamically first time
		var section = document.createElement('section');
		section.id = 'thread-' + thread_id + '-create-post-form-section';

		var form = document.createElement('form');
		// add multipart form data shit
		form.id = 'thread-' + thread_id + '-create-post-form';
		form.className = 'create-post-form';
		form.setAttribute('action', 'javascript:;');
		form.setAttribute('data-thread-id', thread_id);
	
		var h2 = document.createElement('h2');
		h2.innerHTML = 'Reply';
		form.appendChild(h2);
	
		var p = document.createElement('p');

		var label = document.createElement('label');
		label.setAttribute('for', 'thread-' + thread_id + '-create-post-form-body');
		label.innerHTML = 'Reply';
		p.appendChild(label);
	
		var textarea = document.createElement('textarea');
		textarea.id = 'thread-' + thread_id + '-create-post-form-body';
		textarea.setAttribute('name', 'body');
		p.appendChild(textarea);
	
		form.appendChild(p);

		var p = document.createElement('p');
	
		var label = document.createElement('label');
		label.setAttribute('for', 'thread-' + thread_id + '-create-post-form-image');
		label.innerHTML = 'Image';
		p.appendChild(label);
	
		var input = document.createElement('input');
		input.id = 'thread-' + thread_id + '-create-post-form-image';
		input.setAttribute('type', 'file');
		input.setAttribute('multiple', 'multiple');
		input.setAttribute('name', 'image');
		p.appendChild(input);
	
		form.appendChild(p);

		var button = document.createElement('button')
		button.id = 'thread-' + thread_id + '-create-post-form-submit';
		button.setAttribute('data-thread-id', thread_id);
		button.innerHTML = 'Reply';
		button.addEvent('click', createThreadPost, false);
	
		form.appendChild(button);
	
		section.appendChild(form);
		
		var p = article.getElementsByTagName('p');
//		alert(p);
//		alert(p.length);
	
		article.insertBefore(section, p[1]);

		var textarea = document.getElementById('thread-' + thread_id + '-create-post-form-body');
		textarea.focus();
	
	}

}





function toggleThreadQuoteReplyForm() {

	var thread_id = this.getAttribute('data-thread-id');
	var post_id = this.getAttribute('data-post-id');

	var section = document.getElementById('post-' + post_id + '-quote-post-form-section');

	if(section) {

		if(hasClass(section, 'hidden')) {
			section.removeClass('hidden');
			
			var textarea = document.getElementById('post-' + post_id + '-quote-post-form-body');
			textarea.focus();
			
		} else {
			section.addClass('hidden');
		}
	
	} else {
	
		// Build form dynamically first time
		var section = document.createElement('section');
		section.id = 'post-' + post_id + '-quote-post-form-section';

		var form = document.createElement('form');
		// add multipart formdata shit
		form.id = 'post-' + post_id + '-quote-post-form';
		form.className = 'quote-post-form';
		form.setAttribute('action', 'javascript:;');
		form.setAttribute('data-thread-id', thread_id);
		form.setAttribute('data-post-id', post_id);
	
		var h2 = document.createElement('h2');
		h2.innerHTML = 'Quote ' + post_id;
		form.appendChild(h2);
	
		var p = document.createElement('p');

		var label = document.createElement('label');
		label.setAttribute('for', 'post-' + post_id + '-quote-post-form-body');
		label.innerHTML = 'Reply';
		p.appendChild(label);
	
		var textarea = document.createElement('textarea');
		textarea.id = 'post-' + post_id + '-quote-post-form-body';
		textarea.setAttribute('name', 'body');
		p.appendChild(textarea);
	
		form.appendChild(p);

		var p = document.createElement('p');
	
		var label = document.createElement('label');
		label.setAttribute('for', 'post-' + post_id + '-quote-post-form-image');
		label.innerHTML = 'Image';
		p.appendChild(label);
	
		var input = document.createElement('input');
		input.id = 'post-' + post_id + '-quote-post-form-image';
		input.setAttribute('type', 'file');
		input.setAttribute('multiple', 'multiple');
		input.setAttribute('name', 'image');
		p.appendChild(input);
	
		form.appendChild(p);

		var button = document.createElement('button')
		button.id = 'post-' + post_id + '-quote-post-form-submit';
		button.setAttribute('data-thread-id', thread_id);
		button.setAttribute('data-post-id', post_id);
		button.innerHTML = 'Reply';
		button.addEvent('click', createThreadPost, false);
	
		form.appendChild(button);
	
		section.appendChild(form);
		
		var post = document.getElementById('post-' + post_id);
		if(hasClass(post, 'quote')) {
			var post_listing = document.getElementById('post-' + post_id + '-post-listing');
			if(!post_listing) {
				var post_listing = document.createElement('section');
				post_listing.id = 'post-' + post_id + '-post-listing';
				post_listing.className = 'post-listing';
				post.appendChild(post_listing);
			}
			post.insertBefore(section, post_listing);
		} else {
			var post_listing = document.getElementById('post-' + post_id + '-post-listing');
			post.insertBefore(section, post_listing);
		}

		var textarea = document.getElementById('post-' + post_id + '-quote-post-form-body');
		textarea.focus();
	}
}






function buildPostListing(target, posts, thread_id, topic_slug) {

	if(posts.length > 0) {

		for(var a in posts) {

			if(posts[a].parent_post_id == 0) { // Normal post
				var post_listing = document.getElementById('thread-' + thread_id + '-post-listing');
				buildPost(post_listing, 1, posts[a], topic_slug);
			} else { // Quote post 
				// We add it to the parents article
				var post_listing = document.getElementById('post-' + posts[a].parent_post_id + '-post-listing');
				if(!post_listing) {
					var post_listing = document.createElement('section');
					post_listing.id = 'post-' + posts[a].parent_post_id + '-post-listing';
					post_listing.className = 'post-listing';

					var parent_post = document.getElementById('post-' + posts[a].parent_post_id);
					parent_post.appendChild(post_listing);
					
				}
				buildPost(post_listing, 2, posts[a], topic_slug);
				
			}
		}
		
		// Now set the width of the first post to the scrollwidth
		var post = document.getElementById('post-' + posts[0].id);
//		alert('setting ' + post.id + ' the width of ' + document.getElementById('main').scrollWidth);
		if(document.getElementById('main').scrollWidth > window.innerWidth) {
			post.style.width = (document.getElementById('main').scrollWidth) + 'px';
		}

	}
}

function buildPost(target, context_id, post, topic_slug) {

//	if(post.parent_post_id > 0) {
//		var parent_post = document.getElementById('post-' + post.parent_post_id);
	//	alert(parent_post.offsetWidth);
//		parent_post.style.width = (parent_post.offsetWidth + 30) + 'px';
//	}


	var article = document.createElement('article');
	article.id = 'post-' + post.id;
	article.className = 'post';
	if(post.parent_post_id > 0) {
		article.className = 'post quote';
	}
	article.setAttribute('data-thread-id', post.thread_id);
	article.setAttribute('data-parent-post-id', post.parent_post_id);
	target.appendChild(article);
	
	var post_inner = document.createElement('div');
	post_inner.className = 'post-inner';

	var header = document.createElement('header');
	
	var a = document.createElement('a');
	a.name = post.id;
	header.appendChild(a);

	var p = document.createElement('p');
	
	var strong = document.createElement('strong');
	strong.innerHTML = 'Anonymous';
	p.appendChild(strong);


	var now = new Date;
	var ago = format_time_ago(time_ago(Math.floor(now.getTime() / 1000) - post.timestamp));
	
	var span = document.createElement('span');
	span.innerHTML = ago + ' ago';
	p.appendChild(span);

	var date = new Date(post.timestamp * 1000);
	var hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
	var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
	var seconds = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
	var day = date.getDate();
	var day_x = day < 10 ? '0' + day : day;
	var weekday = date.getDay();
	var weekday = config.shortWeekdays[weekday];
	var month = (parseInt(date.getMonth() + 1)) < 10 ? '0' + parseInt(date.getMonth() + 1) : parseInt(date.getMonth() + 1);
	var year = date.getFullYear();
	
	var div = document.createElement('div');
	var a = document.createElement('a');
	a.href = '/' + topic_slug + '/' + post.thread_post_id + '/' + post.id;
	a.innerHTML = '#' + post.id;
	div.appendChild(a);

	var timestamp = document.createTextNode(' - ' + weekday + ' ' + day_x + '/' +  month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds);
	div.appendChild(timestamp);

	p.appendChild(div);
	
	header.appendChild(p);
	
	post_inner.appendChild(header);
	
	var p = document.createElement('p');
	p.innerHTML = post.body;
	post_inner.appendChild(p);

	var div = document.createElement('div');

	var menu = document.createElement('menu');
	
	var button = document.createElement('button');
	button.id = 'post-' + post.id + '-quote-button';
	button.innerHTML = 'Quote';
	button.addEvent('click', toggleThreadQuoteReplyForm, false);
	button.className = 'small';
	button.setAttribute('data-thread-id', post.thread_id);
	button.setAttribute('data-post-id', post.id);

	menu.appendChild(button);
	
	div.appendChild(menu);

	post_inner.appendChild(div);
	
//	var div = document.createElement('div');
//	div.className = 'clear';
//	post_inner.appendChild(div);

	article.appendChild(post_inner);


}





/* AJAX requests */

function handlePathInclude(path) {

	console.log('handlePathInclude(\'' + path + '\')');

	if(path == '#') return;
	if(path == 'javascript:;') return;
	
	template.resetContent();
	
	var ajax = new AjaxRequest(1);

	ajax.params = {
		"path":path
	};

	ajax.callbacks.success = function(response) {
	
		try {
			window.history.pushState(response, response.page.page_title, response.page.path);
		} catch(e) {
			try {
//				alert(response);
//				alert(response.page_title);
//				alert(response.path);
				history.pushState(response, response.page.page_title, response.page.path);
			} catch(e) {
//				alert(e);
				//alert('Your browser is too old to view this site correctly');
			}
		}
		
		createPageObject(response);
	
	}
	
	ajax.callbacks.error = function(response) {
		
		console.log('Error in default.js handlePathInclude()');
	
		//window.history.pushState('', 'Wirah', '/');

	}
	
	ajax.makeRequest();

}














function createThreadPost() {

	var thread_id = this.getAttribute('data-thread-id');
	var post_id = this.getAttribute('data-post-id');
	post_id = post_id ? post_id : 0;
	
	this.callbacks.success = function(response) {
	
		var post_listing = document.getElementById('thread-' + response.post.thread_id + '-post-listing');
	
		if(response.post.parent_post_id == 0) {
			buildPost(post_listing, 1, response.post, response.topic.slug);
		} else {
			var post_quote_listing = document.getElementById('post-' + response.post.parent_post_id + '-post-listing');
			if(!post_quote_listing) {
				var post_quote_listing = document.createElement('section');
				post_quote_listing.id = 'post-' + response.post.parent_post_id + '-post-listing';
				var parent_post = document.getElementById('post-' + response.post.parent_post_id);
				post_listing.insertAfter(post_quote_listing, parent_post);
			}
			buildPost(post_quote_listing, 2, response.post, response.topic.slug);
		}

		handlePathInclude('/' + response.topic.slug + '/' + response.post.thread_post_id + '/' + response.post.id);
	
	}
	
	this.callbacks.error = function(response) {
		alert('Error');
	}
	
	var params = new Array(3);
	params['thread_id'] = thread_id;
	params['parent_post_id'] = post_id;
	if(post_id) { // We are quoting a post
		params['body'] = document.getElementById('post-' + post_id + '-quote-post-form-body').value;
	} else { // Normal reply
		params['body'] = document.getElementById('thread-' + thread_id + '-create-post-form-body').value;
	}

	var ajax = new ajaxRequest(3, 'POST', params, createThreadPostSuccess, createThreadPostError);

}



// Needs updating
function generateNewKey() {

	this.callbacks.success = function(response) {
		window.location.reload();
	}

	this.callbacks.error = function(response) {
		alert('Error');
	}

	var params = new Array();
	var ajax = new ajaxRequest(7, 'POST', params);

}

// Needs updating
function logout() {

	this.callbacks.success = function(response) {
		redirect_to('/logged-out');
	}

	this.callbacks.error = function(response) {
		alert('Error');
	}

	var params = new Array();
	var ajax = new ajaxRequest(7, 'POST', params);

}



function register() {

	var parent          = this;
	var form            = document.getElementById('register-form');
	var password        = document.getElementById('register-password');
	var verify_password = document.getElementById('register-verify-password');
	var console         = document.getElementById('register-console');
	
	form.style.borderColor = '#d9ead8';
	console.addClass('hidden');
	console.getElementsByTagName('p')[0].innerHTML = '';

	this.disabled = true;
	
	this.displayError = function(message) {
		parent.disabled = false;
		form.style.borderColor = '#c00';
		console.removeClass('hidden');
		console.getElementsByTagName('p')[0].innerHTML = message;
	}

	if(password.value == '') {
		this.displayError('You must choose a password.');
		return;
	}
	
	if(verify_password.value == '') {
		this.displayError('You must verify your password.');
		return;		
	}

	if((password.value.length < config.passwordMinLength) || (verify_password.value.length < config.passwordMinLength)) {
		this.displayError('Your password is too short (' + config.passwordMinLength + ' characters min).');
		return;
	}

	if((password.value.length > config.passwordMaxLength) || (verify_password.value.length > config.passwordMaxLength)) {
		this.displayError('Your password is too long (' + config.passwordMaxLength + ' characters max).');
		return;
	}
	
	if(password.value != verify_password.value) {
		this.displayError('Your passwords do not match.');
		return;
	}

	this.callbacks.success = function(response) {
	
		parent.disabled = false;

		redirect_to('/registered');

	}
	
	this.callbacks.error = function(response) {

		parent.displayError(response.errors[0].message);

	}
	
	var params = new Array(2);
	params['password'] = password.value;
	params['verify_password'] = verify_password.value;

	var ajax = new ajaxRequest(8, 'POST', params);

}



function login() {

	var parent   = this;
	var form     = document.getElementById('login-form');
	var key      = document.getElementById('login-key');
	var password = document.getElementById('login-password');
	var console  = document.getElementById('login-console');
	
	form.style.borderColor = '#d9ead8';
	console.addClass('hidden');
	console.getElementsByTagName('p')[0].innerHTML = '';
	
	this.disabled = true;
	
	this.displayError = function(message) {
		parent.disabled = false;
		form.style.borderColor = '#c00';
		console.removeClass('hidden');
		console.getElementsByTagName('p')[0].innerHTML = message;
	}

	if(key.value == '') {
		this.displayError('You must enter your key.');
		return;
	}
	
	if(!key.value.match(/^(?:[0-9]\s?){16}$/)) {
		this.displayError('Your key is invalid.');
		return;		
	}
	
	if(password.value == '') {
		this.displayError('You must enter your password.');
		return;		
	}

	this.callbacks.success = function(response) {
	
		parent.disabled = false;

		redirect_to('/');

	}
	
	this.callbacks.error = function(response) {

		parent.displayError(response.errors[0].message);

	}
	
	var params = new Array(2);
	params['key']      = key.value;
	params['password'] = password.value;
	
	var ajax = new ajaxRequest(9, 'POST', params);

}





























/* Event Listeners */

addEvent(window, 'load', init, false); //maybe use this later

addEvent(window, 'popstate', revertToState, false);
