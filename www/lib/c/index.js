
(function(_a) { 

	var b = {

		
		a:{

			a:{

				a             : _a.a,
				b : _a.b,
				c              : _a.c,
				d          : _a.d,
				e          : _a.e,
				f           : _a.f,
				g                : _a.g,
				h          : _a.h
				
			},

			b:{

				a      : 193842,
				b : ' - Wirah',
				c       : ['Sun','Mon','Tues','Weds','Thurs','Fri','Sat'],
				d      : '/assets/favicon/default.ico',
				e   : 3,
				f   : 24,
				g : 5000
      
			}
			
		},

		init: function () {
    
    		
    		
    		b.pageManager = new PageManager;

			
			if(navigator.userAgent.indexOf('Firefox') != -1) { 
				b.pageManager.revertToState({state:null});
			}
	
			if((navigator.userAgent.indexOf('Safari') != -1) && (navigator.userAgent.indexOf('Chrome') == -1)) { 
				b.pageManager.revertToState({state:null});
			}


			addEvent(window, 'popstate', b.pageManager.revertToState, false);

			b.template = new Template;
			b.template.setup();

			b.template.leftSidebar.f = new FollowedTopicsSidebarMenu;
			b.template.leftSidebar.f.populate(b.a.a.f);
			b.template.leftSidebar.f.build(b.template.DOM.leftSidebar);

		}

	};
  
	



function Template() {

	this.leftSidebar  = {};
	this.rightSidebar = {};

	
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

	
	this.setup = function () {

		

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
		if(0 == 0) { 
			this.DOM.threadRepliesNum.b('hidden');
		}
		this.DOM.threadRepliesModal = new DOMElement('div', this.DOM.topBarLeft);

		this.logo = new DOMElement('a', this.DOM.topBarLeft);
		this.logo.href = '/';

		this.DOM.postMentions       = new DOMElement('a', this.DOM.topBarLeft);
		this.DOM.postMentions.href  = 'javascript:;';
		this.DOM.postMentions.title = '0 post mentions';
		this.DOM.postMentionsNum = new DOMElement('span', this.DOM.postMentions);
		if(0 == 0) { 
			this.DOM.postMentionsNum.b('hidden');
		}
		this.DOM.postMentionsModal = new DOMElement('div', this.DOM.topBarLeft);

		this.DOM.topBarRight = new DOMElement('div', this.DOM.topBarInner);
		var ul = new DOMElement('ul', this.DOM.topBarRight);
		if(b.a.a.a == 1) {
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
		this.DOM.leftSidebar.b('left');

		this.DOM.content      = new DOMElement('div', this.DOM.mainInner);
		this.DOM.heading      = new DOMElement('h1', this.DOM.content);
		this.DOM.heading.innerHTML = ''; 
		this.DOM.contentInner = new DOMElement('div', this.DOM.content);

		this.DOM.rightSidebar = new DOMElement('aside', this.DOM.mainInner);
		this.DOM.rightSidebar.b('right');

		this.DOM.root.convertChildrenToPushStateLinks();

		this.setFavicon(b.a.b.d);
    
	}

	this.setFavicon = function (path) {

		

		this.DOM.favicon.href = path + '?' + b.a.b.a;

	}

	this.resetContent = function () {

		

		this.DOM.contentInner.b('invisible');
		this.DOM.contentInner.innerHTML = '';

	}

	this.setTitle = function (text) {

		

		document.title = text + b.a.b.b;

	}

	this.setHeading = function (text) {

		

		this.DOM.heading.innerHTML = text;

	}

	return true;

}



window['DOMElement'] = DOMElement;
function DOMElement(tag, append_to) {
	
	this.element = document.createElement(tag);

	if(append_to) {
		append_to.appendChild(this.element);
	}

	return this.element;

}



function SidebarMenu() {

	this.title        = '';
	this.itemIdPrefix = '';
	
	this.items = [];
	
	
	this.DOM      = {};
	this.DOM.root = false;
	this.DOM.ul   = false;

	
	
	this.addItem = function(item) {
	
		
	
		if(!this.containsItem(item.id)) {
			item.build();
			this.items.push(item);
			this.DOM.ul.appendChild(item.DOM.root);
		}

	}

	
	this.removeItem = function(item_id) {

		

		for(var a in this.items) {
			if(this.items[a].id == item_id) {
				this.items[a].DOM.root.parentNode.removeChild(this.items[a].DOM.root);
				this.items.splice(a, 1);
				return true;
			}
		}

	}

	
	this.containsItem = function(item_id) {

		

		for(var a in this.items) {
			if(this.items[a].id == item_id) {
				return this.items[a];
			}
		}

		return false;
	}

	
	this.selectItem = function(item_id) {

		

		this.resetItems();

		var item = false;

		if(item = this.containsItem(item_id)) {
			item.DOM.root.b('selected');
		}
	}

	
	this.resetItems = function() {

		
	
		for(var a in this.items) {
			this.items[a].DOM.root.c('selected');
		}
		return true;
	}		

	
	this.build = function(append_to) {
	
		

		if(append_to) {
			append_to.appendChild(this.DOM.root);
		}

		this.DOM.root = new DOMElement('menu');

		var h4 = new DOMElement('h4', this.DOM.root);
		h4.innerHTML = this.title;

		this.DOM.ul = new DOMElement('ul', this.DOM.root);

		if(this.items.length > 0) {

			for(var n in this.items) {
			
				if(n > 9) {
					this.items[n].hidden = true;
				}

				this.items[n].build();

				this.DOM.ul.appendChild(this.items[n].DOM.root);
		
			}
		
		}

	}

	return true;

}










function FollowedTopicsSidebarMenu() {

	this.title        = 'Followed Topics';
	this.itemIdPrefix = 'menu-followed-topic-';

	
	this.DOM.findMoreList = false;
	this.DOM.findMoreLink = false;
	this.DOM.showMoreList = false;
	this.DOM.showMoreLink = false;

	this.populate = function(items) {

		
		
		for(var n in items) {

			var item = new SidebarMenuItem();

			item.id     = items[n].id;
			item.href   = items[n].href;
			item.title  = items[n].title;
			item.icon   = items[n].icon;
			item.num    = items[n].num;
			item.hidden = false;
			
			this.items.push(item);

		}
		
		
		for(var n in this.items) {
			if(!(this.items[n] instanceof SidebarMenuItem)) {
				this.items.splice(n, 1);
			}
		}

	}
	
	this.addItem = function(item) {

		
	
		if(!this.containsItem(item.id)) {
			item.build();
			this.items.push(item);
			this.DOM.ul.appendChild(item.DOM.root);
		}

		this.shiftFindMoreList();
		this.shiftShowMoreList();

	}

	this.build = function(append_to) {

		

		this.DOM.root = new DOMElement('menu', append_to);

		var h4 = new DOMElement('h4', this.DOM.root);
		h4.innerHTML = this.title;

		var a = new DOMElement('a', this.DOM.root);
		a.href = '/topics';
		a.innerHTML = 'edit';
		a.b('menu-inline-link');
		a.convertToPushStateLink();

		this.DOM.ul = new DOMElement('ul', this.DOM.root);

		if(this.items.length > 0) {

			for(var a in this.items) {

				if(a > 9) {
					this.items[a].hidden = true;
				}

				this.items[a].build(this.DOM.ul);

			}
		
		}

		this.DOM.findMoreList = new DOMElement('li', this.DOM.ul);
		this.DOM.findMoreList.id = 'menu-followed-topics-find-more';
		this.DOM.findMoreList.b('hidden');
		
		this.DOM.findMoreLink = new DOMElement('a', this.DOM.findMoreList);
		this.DOM.findMoreLink.href = '/topics';
		this.DOM.findMoreLink.b('menu-link-color');
		if(this.items.length == 0) {
			this.DOM.findMoreLink.innerHTML = 'Find topics ...';
		} else {
			this.DOM.findMoreLink.innerHTML = 'Find more topics ...';
		}
		this.DOM.findMoreLink.convertToPushStateLink();

		if(this.items.length > 10) {

			this.DOM.showMoreList = new DOMElement('li', this.DOM.ul);
			this.DOM.showMoreList.id = 'menu-followed-topics-show-more';

			this.DOM.showMoreLink = new DOMElement('a', this.DOM.showMoreList);
			this.DOM.showMoreLink.href = 'javascript:;';
			this.DOM.showMoreLink.innerHTML = 'More...';
			this.DOM.showMoreLink.b('menu-link-color');
			this.DOM.showMoreLink.e('click', this.showMore, false);

		}

	}
	

	this.shiftFindMoreList = function() {
	
		

		var clone = this.DOM.findMoreList.cloneNode(true);
		this.DOM.findMoreList.parentNode.removeChild(this.DOM.findMoreList);

		this.DOM.findMoreList = clone;

		this.DOM.ul.appendChild(this.DOM.findMoreList);
		
		
		
		
		
	
	}

	this.shiftShowMoreList = function() {

		

		if(this.DOM.showMoreList) {

			var clone = this.DOM.showMoreList.cloneNode(true);			
			this.DOM.showMoreList.parentNode.removeChild(this.DOM.showMoreList);

			this.DOM.showMoreList = clone;

			this.DOM.ul.appendChild(this.DOM.showMoreList);

		}

	}


	
	
	this.showMore = (function() {

		
	
		for(var n in this.DOM.ul.childNodes) {		
			if(typeof this.DOM.ul.childNodes[n].id != 'undefined') {
				if(this.DOM.ul.childNodes[n].a('hidden')) {
					this.DOM.ul.childNodes[n].c('hidden');
				}
			}
		}
	
		this.DOM.showMoreLink.innerHTML = 'Less ...';
		this.DOM.showMoreLink.setAttribute('style', 'background-image:url(\'/assets/topic-icons/icon-menu-collapse-16x16.png\');');

		this.DOM.showMoreLink.g('click', this.showMore, this.showLess, false);

	}).bind(this);
	
	
	this.showLess = (function() {
	
		
	
		for(var n in this.DOM.ul.childNodes) {
			if(typeof this.DOM.ul.childNodes[n].id != 'undefined') {
				if((n > 9) && (this.DOM.ul.childNodes[n].id != 'menu-followed-topics-show-more') && (this.DOM.ul.childNodes[n].id != 'menu-followed-topics-find-more')) {
					this.DOM.ul.childNodes[n].b('hidden');
				}
			}
		}

		this.DOM.showMoreLink.innerHTML = 'More ...';
		this.DOM.showMoreLink.setAttribute('style', 'background-image:url(\'/assets/topic-icons/icon-menu-expand-16x16.png\');');

		this.DOM.showMoreLink.g('click', this.showLess, this.showMore, false);
	
	}).bind(this);
	
	return true;

}

FollowedTopicsSidebarMenu.prototype = new SidebarMenu;



function SidebarMenuItem() {

	this.id    = 0;
	this.href  = '';
	this.title = '';
	this.icon  = '';
	this.num   = 0;
	
	this.hidden = false;
	
	this.listClassName = '';
	this.linkClassName = '';
	
	
	this.DOM = {};
	this.DOM.root = false;
	this.DOM.a    = false;
	this.DOM.num  = false;

	
	this.build = function (append_to) {

		

		this.DOM.root = new DOMElement('li', append_to);

		if(this.selected === true) {
			this.DOM.root.b('selected');
		}
		if(this.hidden === true) {
			this.DOM.root.b('hidden');
		}





		this.DOM.a = new DOMElement('a', this.DOM.root);
		this.DOM.a.href = '/' + this.href;
		this.DOM.a.innerHTML = this.title;
		this.DOM.a.setAttribute('style', 'background-image:url(\'' + this.icon + '\');');




		this.DOM.a.convertToPushStateLink();

		this.DOM.num = new DOMElement('span', this.DOM.root);
		if(this.num > 0) {
			this.DOM.num.innerHTML = this.num;
		} else {
			this.DOM.num.b('hidden');
		}
	
	}

	return true;

}


function PageManager() {

	this.page = false;

    this.clickPushStateLink = (function (e) {

		
        
        var element = e.target;

        if((!e.shiftKey) && (!e.ctrlKey) && (!e.metaKey) && (!e.altKey)) {
            var href = false;
            if(href = element.getAttribute('data-href')) {
                this.handlePathInclude(href);
            } else if(href = element.getAttribute('href')) {
                this.handlePathInclude(href);
            }
            e.preventDefault();
        }

    }).bind(this);

    this.revertToState = (function (e) {

        

        if(e.state == null) {
            this.handlePathInclude(window.location.pathname);
        } else {
            this.createPage(e.state);
        }
    }).bind(this);
    
    
    this.handlePathInclude = function (path) {

        

        if(path == '#') return;
        if(path == 'javascript:;') return;
	
        b.template.resetContent();
	
        var ajax = new AjaxRequest(1);

        ajax.params = {
            "path": path
        };

        ajax.callbacks.success = (function (response) {
        
            

            try {
                window.history.pushState(response, response.page.page_title, response.page.path);
            } catch(e) {
                try {
                    history.pushState(response, response.page.page_title, response.page.path);
                } catch(e) {
                    alert(e);
                }
            }
            
            this.createPage(response);

        }).bind(this);

        ajax.callbacks.error = (function (response) {

            

            window.history.pushState('', 'Wirah', '/');

        }).bind(this);

        ajax.makeRequest();
        
    }
    
    
    this.createPage = (function (response) {

        

		b.template.DOM.contentInner.c('invisible');

		b.template.setTitle(response.page.title);
		b.template.setHeading(response.page.heading);
		
		b.template.leftSidebar.f.resetItems();
		
		switch(response.page.id) {
		
		
			case 5: 
			
				this.page = new TopicListingPage;
				this.page.populate(response);
			
				break;
		
		}

		this.page.build(b.template.DOM.contentInner);
		
		
		
		

    
    }).bind(this);

    return true;

}



function AjaxRequest(id) {

    this.id        = id;
    this.url       = '/ajax';
    this.method    = 'POST';
    this.params    = {};
    this.callbacks = {};
    this.request   = false;

    this.callbacks.success = function () {}
    this.callbacks.error   = function () {}

    this.init = function () {
    
        
        
        try {
            this.request = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            try {
                this.request = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (e2) {
                try {
                    this.request = new XMLHttpRequest();
                } catch (e3) {
                    this.request = false;
                }
            }
        }

        addEvent(this.request, 'readystatechange', this.readyStateChange, false);

        return true;
    
    }


    this.readyStateChange = (function () {
    
        

        if(this.request.readyState == 4) {

            if(this.request.status == 200) {

                var response = this.request.responseText;
                var json = eval("(" + response + ")");

                switch(json.type) {

                case 0: 

                    if(json.response.errors[0].code == -1) { 
                        window.location.reload();
                    }

                    this.callbacks.error(json.response);
                    
                    break;

                case 1: 

                    this.callbacks.success(json.response);
                
                }
            }
        }
    }).bind(this);


    this.makeRequest = function () {

        

        this.request.open(this.method, this.url, true); 
        this.request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var data = 'id=' + this.id;

        for(var key in this.params) {

            data = data + '&';
            data = data + key + '=' + this.params[key].urlencode();

        }

        this.request.send(data);

    }

    this.init();

    return true;

}



function Page() {

	return true;

}


function TopicListingPage() {

	this.topicListing = false; 
	
	this.populate = function (response) {

		

		this.topicListing = new TopicListing;

		for(var n in response.topics) {

			var topic = new TopicForListing;

			topic.id                = response.topics[n].id;
			topic.name              = response.topics[n].name;
			topic.slug              = response.topics[n].slug;
			topic.description       = response.topics[n].description;
			topic.iconSmall         = response.topics[n].icon_small;
			topic.iconLarge         = response.topics[n].icon_large;
			topic.numThreads        = response.topics[n].num_threads;
			topic.numPosts          = response.topics[n].num_posts;
			topic.numThreadsAllTime = response.topics[n].num_threads_all_time;
			topic.numPostsAllTime   = response.topics[n].num_posts_all_time;
			topic.numFollowers      = response.topics[n].num_followers;
			topic.timestampCreated  = response.topics[n].timestamp_created;

			topic.userFollows = response.topics[n].user_follows;
			
			topic.strings.numThreadsPosts = response.topics[n].strings.num_threads_posts;
			topic.strings.numFollowers    = response.topics[n].strings.num_followers;

			this.topicListing.topics.push(topic);
			
		}
	}


	this.build = function (append_to) {
	
		

		this.topicListing.build(append_to);

	}

	return true;

}

TopicListingPage.prototype = new Page;



function Listing() {

	
	this.setup = function (response) {
	
		

		this.DOM      = {};
		this.DOM.root = false;

	}

	return true;

}


function TopicListing() {

	this.topics = [];
	
	
	
	this.build = function(append_to) {

		this.DOM.root = new DOMElement('section', append_to);
		this.DOM.root.className = 'topic-listing';

		if(this.topics.length > 0) {

			for(var n in this.topics) {
				this.topics[n].build(this.DOM.root);
			}

		}

	}
	
	
	this.setup();
	
	return true;

}

TopicListing.prototype = new Listing;







function Topic() {

	this.setup = function () {

		
		this.id                = 0;
		this.typeId            = 0;
		this.userId            = 0;
		this.name              = '';
		this.slug              = '';
		this.description       = '';
		this.iconSmall         = '';
		this.iconLarge         = '';
		this.ip                = '';
		this.numThreads        = 0;
		this.numPosts          = 0;
		this.numThreadsAllTime = 0;
		this.numPostsAllTime   = 0;
		this.numFollowers      = 0;
		this.timestampCreated  = 0;
		this.timestampUpdated  = 0;

		
		this.userFollows = false;

		
		this.DOM              = {};
		this.DOM.root         = null;
		this.DOM.followButton = null;
		this.DOM.numFollowers = null;
		
		
		this.strings = {};
		
	}

	return true;

}


function TopicForListing() {

	
	this.setup();

	

	this.build = function (append_to) {

		
		
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
			this.DOM.followButton.e('click', this.events.unfollow, false);
		} else {
			this.DOM.followButton.innerHTML = 'Follow';
			this.DOM.followButton.className = 'green small';
			this.DOM.followButton.e('click', this.events.follow, false);
		}
		
		var clear = new DOMElement('div', this.DOM.root);
		clear.className = 'clear';

	}






	
	
	this.events = {
	
	
	follow:

		(function () {
      
			

			var ajax = new AjaxRequest(5);

			ajax.params = {
				'topic-id':this.id
			};

			ajax.callbacks.success = (function (response) {

				

				
				this.numFollowers = response.topic.num_followers;

				this.DOM.followButton.disabled = true;

				this.DOM.followButton.innerHTML = 'Unfollow';
				this.DOM.followButton.d('green', 'red');
				this.DOM.followButton.disabled = false;

				this.DOM.followButton.g('click', this.follow, this.unfollow, false);

				this.DOM.numFollowers.innerHTML = this.numFollowers + ' followers';

				
				var item = new SidebarMenuItem;

				item.id     = this.id;
				item.href   = '/' + this.slug;
				item.title  = this.name;
				item.icon   = this.iconSmall;
				item.num    = 0;
				item.hidden = false;

				b.template.leftSidebar.f.addItem(item);

				b.template.leftSidebar.f.selectItem(item.id);

			}).bind(this);

			ajax.callbacks.error = (function (response) {

				
        
			}).bind(this);

	        ajax.makeRequest();

		}).bind(this),


	
	unfollow:

		(function () {

			

			this.DOM.followButton.disabled = true;

			var ajax = new AjaxRequest(6);

			ajax.params = {
				'topic-id':this.id
			};

			ajax.callbacks.success = (function (response) {

				
				
				
				this.numFollowers = response.topic.num_followers;

				this.DOM.followButton.innerHTML = 'Follow';
				this.DOM.followButton.d('red', 'green');
				this.DOM.followButton.disabled = false;

				this.DOM.followButton.g('click', this.unfollow, this.follow, false);

				this.DOM.numFollowers.innerHTML = this.numFollowers + ' followers';

				b.template.leftSidebar.f.removeItem(this.id);		

			}).bind(this);

			ajax.callbacks.error = (function (response) {

				

			}).bind(this);

			ajax.makeRequest();

        }).bind(this)
	
	}


	return true;

}

TopicForListing.prototype = new Topic;
window['addEvent'] = addEvent;
function addEvent(element, type, fn, uc) {

    

    if(element.addEventListener) {
        element.addEventListener(type, fn, uc);
        return true;
    } else {
        element['on' + type] = fn;
    }

}


Node.prototype.a = function (_a) {
	return (this.className.match(new RegExp('(\\s|^)' + _a + '(\\s|$)')));
}


Node.prototype.b = function (_a) {
	if(!this.a(_a)) {
		this.className += " " + _a;
	}
}


Node.prototype.c = function (_a) {
	if(this.a(_a)) {
		var regex = new RegExp('(\\s|^)' + _a + '(\\s|$)');
		this.className = this.className.replace(regex, ' ');
		if(this.className.match(/^ *$/)) {
			this.removeAttribute('class');
		}
	}
}


Node.prototype.d = function (_a, _b) {
	this.c(_a);
	this.b(_b);
}


Node.prototype.e = function (_a, _b, _c) {
	if(this.addEventListener) {
		this.addEventListener(_a, _b, _c);
		return true;
	} else {
		this['on' + _a] = _b;
	}
}


Node.prototype.f = function (_a, _b) {
	if(this.detachEvent) {
		this.detachEvent('on' + _a, _b);
		this[_a + _b] = null;
	} else {
		this.removeEventListener(_a, _b, false);
	}
}


Node.prototype.g = function (_a, _b, _c, _d) {
	this.f(_a, _b);
	this.e(_a, _c, _d);
}
  
    
    window['Node.prototype.convertToPushStateLink'] = Node.prototype.convertToPushStateLink = function() {
        if(typeof this != 'object') {
    	    return;
        }
        if(this.getAttribute('target') == '_blank') {
    	    return;
        }
        this.e('click', b.pageManager.clickPushStateLink, false);
    }

    
    window['Node.prototype.convertChildrenToPushStateLinks'] = Node.prototype.convertChildrenToPushStateLinks = function() {

        if(this.childNodes.length == 0) { 
            this.convertToPushStateLink();
        } else {
            var links = this.getElementsByTagName('a');
            for(var n in links) {
                if(typeof links[n] != 'object') {
                    continue;
                }
                if(links[n].getAttribute('target') == '_blank') {
                    continue;
                }
                links[n].convertToPushStateLink();
            }
        }
    }

    
    window['Node.prototype.appendText'] = Node.prototype.appendText = function(text) {
        this.appendChild(document.createTextNode(text));
    }

    
    window['String.prototype.urlencode'] = String.prototype.urlencode = function () {

        var hexStr = function (dec) {
            return '%' + (dec < 16 ? '0' : '') + dec.toString(16).toUpperCase();
        };

        var ret = '', unreserved = /[\w.-]/;
        str = (this + '').toString();

        for (var i = 0, dl = str.length; i < dl; i++) {
      
            var ch = str.charAt(i);
            if (unreserved.test(ch)) {
                ret += ch;
            } else {

                var code = str.charCodeAt(i);
                if (0xD800 <= code && code <= 0xDBFF) {
                    ret += ((code - 0xD800) * 0x400) + (str.charCodeAt(i+1) - 0xDC00) + 0x10000;
                    i++;
                } else if (code === 32) {
                    ret += '+'; 
                } else if (code < 128) { 
                    ret += hexStr(code);
                } else if (code >= 128 && code < 2048) { 
                    ret += hexStr((code >> 6) | 0xC0);
                    ret += hexStr((code & 0x3F) | 0x80);
                } else if (code >= 2048) { 
                    ret += hexStr((code >> 12) | 0xE0);
                    ret += hexStr(((code >> 6) & 0x3F) | 0x80);
                    ret += hexStr((code & 0x3F) | 0x80);
                }
            }
        }
    
        return ret;

    }

  
  
  
  
  
  
  
  


	addEvent(window, 'load', b.init, false);

 	if (window.addEventListener) { 
		window.addEventListener('load', b.init, false);
	} else if (window.attachEvent) { 
		window.attachEvent('onload', b.init); 
	} else {
		elm['onload'] = b.init;
	}

})(a);


