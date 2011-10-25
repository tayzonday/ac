



  window['Template'] = function Template() {

    this.leftSidebar  = {};
    this.rightSidebar = {};

    /* DOM */
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

    /* The setup() method should only ever be called once to setup the initial template. */
    this.setup = function() {
  
  	  console.log('template.setup()');

      this.DOM.root = document.getElementsByTagName('html')[0];

      this.DOM.head = document.getElementsByTagName('head')[0];
	
      this.DOM.favicon = document.querySelector('link[rel="shortcut icon"]');
    
      this.DOM.body = document.getElementsByTagName('body')[0];

      this.DOM.header           = new DOMElement('header', {}, this.DOM.body);
      this.DOM.topBar           = new DOMElement('div', {}, this.DOM.header);
      this.DOM.topBarInner      = new DOMElement('div', {}, this.DOM.topBar);
      this.DOM.topBarLeft       = new DOMElement('div', {}, this.DOM.topBarInner);

      this.DOM.threadReplies    = new DOMElement('a', {'href':'javascript:;', 'title':'0 thread replies'}, this.DOM.topBarLeft);
      this.DOM.threadRepliesNum = new DOMElement('span', {}, this.DOM.threadReplies);
      if(0 == 0) { /* FIXME - Add checking for tS numThreadReplies*/
        this.DOM.threadRepliesNum.addClass('hidden');
      }
      this.DOM.threadRepliesModal = new DOMElement('div', {}, this.DOM.topBarLeft);

      this.logo = new DOMElement('a', {'href':'/'}, this.DOM.topBarLeft);

      this.DOM.postMentions = new DOMElement('a', {'href':'javascript:;', 'title':'0 post mentions'}, this.DOM.topBarLeft);
      this.DOM.postMentionsNum = new DOMElement('span', {}, this.DOM.postMentions);
      if(0 == 0) { /* FIXME - Add checking for tS.numPostMentions */
        this.DOM.postMentionsNum.addClass('hidden');
      }
      this.DOM.postMentionsModal = new DOMElement('div', {}, this.DOM.topBarLeft);

      this.DOM.topBarRight = new DOMElement('div', {}, this.DOM.topBarInner);
      var ul = new DOMElement('ul', {}, this.DOM.topBarRight);
      if(tS.uLI == 1) {
        var li = new DOMElement('li', {}, ul);	
        var a  = new DOMElement('a', {'href':'/logout', 'html':'Logout'}, li);
      } else {
        var li = new DOMElement('li', {}, ul);	
        var a  = new DOMElement('a', {'href':'/login', 'html':'Login'}, li);
        var li = new DOMElement('li', {}, ul);	
        var a  = new DOMElement('a', {'href':'/register', 'html':'Register'}, li);
      }

      this.DOM.subBar       = new DOMElement('div', {}, this.DOM.header);
      this.DOM.main         = new DOMElement('div', {}, this.DOM.body);
      this.DOM.mainInner    = new DOMElement('div', {}, this.DOM.main);

      this.DOM.leftSidebar = new DOMElement('aside', {'class':'left'}, this.DOM.mainInner);

      this.DOM.content      = new DOMElement('div', {}, this.DOM.mainInner);
      this.DOM.heading      = new DOMElement('h1', {'html':'Home'}, this.DOM.content);
      this.DOM.contentInner = new DOMElement('div', {}, this.DOM.content);

      this.DOM.rightSidebar = new DOMElement('aside', {'class':'right'}, this.DOM.mainInner);
        
      this.DOM.root.convertChildrenToPushStates();

      this.setFavicon(config.defaultFavicon);
    
    }

    this.setFavicon = function(path) {
    
      console.log('template.setFavicon(\'' + path + '\')');
  
      this.DOM.favicon.href = path + '?' + config.assetReleaseId;

    }

    this.resetContent = function() {

      console.log('template.resetContent()');

      this.DOM.contentInner.addClass('invisible');
      this.DOM.contentInner.innerHTML = '';

    }

    this.setTitle = function(text) {
  
      console.log('template.setTitle(\'' + text + '\')');

      document.title = text + config.documentTitleSuffix;

    }
    
    this.setHeading = function(text) {
  
      console.log('template.setHeading(\'' + text + '\')');
  
      this.DOM.heading.innerHTML = text;

    }

    return true;

  }
  
  
  
  
  
  
  
  /* Helper functions */
  
  
  
  





