// Template class

/**
 * @constructor
 */
function Template() {

	this.leftSidebar  = {};
	this.rightSidebar = {};

	// DOM
	this.DOM                    = {};
	this.DOM.root               = false;
	this.DOM.head               = false;
	this.DOM.favicon            = false;
	this.DOM.body               = false;
	this.DOM.header             = false;
	this.DOM.topBar             = false;
	this.DOM.topBarInner        = false;
	this.DOM.topBarLeft         = false;
	this.DOM.threadReplies      = false;
	this.DOM.threadRepliesNum   = false;
	this.DOM.threadRepliesModal = false;
	this.DOM.postMentions       = false;
	this.DOM.postMentionsNum    = false;
	this.DOM.postMentionsModal  = false;
	this.DOM.topBarRight        = false;
	this.DOM.subBar             = false;
	this.DOM.main               = false;
	this.DOM.mainInner          = false;
	this.DOM.leftSidebar        = false;
	this.DOM.content            = false;
	this.DOM.heading            = false;
	this.DOM.contentInner       = false;
	this.DOM.rightSidebar       = false;

	// The setup() method should only ever be called once to setup the initial template.
	this.setup = function () {

		console.log('Template.setup()');

		this.DOM.root = document.getElementsByTagName('html')[0];

		this.DOM.head = document.getElementsByTagName('head')[0];

		this.DOM.favicon = document.querySelector('link[rel="shortcut icon"]');

		this.DOM.body = document.getElementsByTagName('body')[0];

		this.DOM.header      = new DOMElement('header', this.DOM.body);
		this.DOM.topBar      = new DOMElement('div', this.DOM.header);
		this.DOM.topBarInner = new DOMElement('div', this.DOM.topBar);
		this.DOM.topBarLeft  = new DOMElement('div', this.DOM.topBarInner);

		this.DOM.threadReplies       = new DOMElement('a', this.DOM.topBarLeft);
		this.DOM.threadReplies.href  = 'javascript:;';
		this.DOM.threadReplies.title = '0 thread replies';

		this.DOM.threadRepliesNum = new DOMElement('span', this.DOM.threadReplies);
		if(0 == 0) { // FIXME - Add checking for tS numThreadReplies
			this.DOM.threadRepliesNum.addClass('hidden');
		}
		this.DOM.threadRepliesModal = new DOMElement('div', this.DOM.topBarLeft);

		this.logo = new DOMElement('a', this.DOM.topBarLeft);
		this.logo.href = '/';

		this.DOM.postMentions       = new DOMElement('a', this.DOM.topBarLeft);
		this.DOM.postMentions.href  = 'javascript:;';
		this.DOM.postMentions.title = '0 post mentions';
		this.DOM.postMentionsNum = new DOMElement('span', this.DOM.postMentions);
		if(0 == 0) { // FIXME - Add checking for tS.numPostMentions
			this.DOM.postMentionsNum.addClass('hidden');
		}
		this.DOM.postMentionsModal = new DOMElement('div', this.DOM.topBarLeft);

		this.DOM.topBarRight = new DOMElement('div', this.DOM.topBarInner);
		var ul = new DOMElement('ul', this.DOM.topBarRight);
		if(Wirah.config.template.userLoggedIn == 1) {
			var li = new DOMElement('li', ul);	
			var a  = new DOMElement('a', li);
			a.href = '/logout';
			a.innerHTML = 'Logout';
		} else {
			var li = new DOMElement('li', ul);
			var a  = new DOMElement('a', li);
			a.href = '/login';
			a.innerHTML = 'Login';
			var li = new DOMElement('li', ul);	
			var a  = new DOMElement('a', li);
			a.href = '/register';
			a.innerHTML = 'Register';
		}

		this.DOM.subBar    = new DOMElement('div', this.DOM.header);
		this.DOM.main      = new DOMElement('div', this.DOM.body);
		this.DOM.mainInner = new DOMElement('div', this.DOM.main);

		this.DOM.leftSidebar = new DOMElement('aside', this.DOM.mainInner);
		this.DOM.leftSidebar.addClass('left');

		this.DOM.content      = new DOMElement('div', this.DOM.mainInner);
		this.DOM.heading      = new DOMElement('h1', this.DOM.content);
		this.DOM.heading.innerHTML = ''; // Normally says Home by default
		this.DOM.contentInner = new DOMElement('div', this.DOM.content);

		this.DOM.rightSidebar = new DOMElement('aside', this.DOM.mainInner);
		this.DOM.rightSidebar.addClass('right');

		this.DOM.root.convertChildrenToPushStateLinks();

		this.setFavicon(Wirah.config.general.defaultFavicon);
    
	}

	this.setFavicon = function (path) {

		console.log('Template.setFavicon(\'' + path + '\')');

		this.DOM.favicon.href = path + '?' + Wirah.config.general.assetReleaseId;

	}

	this.resetContent = function () {

		console.log('Template.resetContent()');

		this.DOM.contentInner.addClass('invisible');
		this.DOM.contentInner.innerHTML = '';

	}

	this.setTitle = function (text) {

		console.log('Template.setTitle(\'' + text + '\')');

		document.title = text + Wirah.config.general.documentTitleSuffix;

	}

	this.setHeading = function (text) {

		console.log('Template.setHeading(\'' + text + '\')');

		this.DOM.heading.innerHTML = text;

	}

	return true;

}
