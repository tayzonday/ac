// a = template_settings
(function(_template_settings) { 

	var Wirah = {

		// Configuration
		config:{

			template:{

				userLoggedIn             : _template_settings.a,
				webSocketValidationToken : _template_settings.b,
				sessionHash              : _template_settings.c,
				numTopicReplies          : _template_settings.d,
				numPostMentions          : _template_settings.e,
				followedTopics           : _template_settings.f,
				myThreads                : _template_settings.g,
				followedThreads          : _template_settings.h
				
			},

			general:{

				assetReleaseId      : 193842,
				documentTitleSuffix : ' - Wirah',
				shortWeekdays       : ['Sun','Mon','Tues','Weds','Thurs','Fri','Sat'],
				defaultFavicon      : '/assets/favicon/default.ico',
				passwordMinLength   : 3,
				passwordMaxLength   : 24,
				threadTextMaxLength : 5000
      
			}
			
		},

		init: function () {
    
    		console.log('Wirah.init()');
    		
    		Wirah.user = new User;
  
    		Wirah.pageManager = new PageManager;

			// Insert an initial state into the history stack if the user is on Firefox or Safari
			if(navigator.userAgent.indexOf('Firefox') != -1) { // Firefox
				Wirah.pageManager.revertToState({state:null});
			}
	
			if((navigator.userAgent.indexOf('Safari') != -1) && (navigator.userAgent.indexOf('Chrome') == -1)) { // Safari
				Wirah.pageManager.revertToState({state:null});
			}

			addEvent(window, 'popstate', Wirah.pageManager.revertToState, false);

			Wirah.template = new Template;
			Wirah.template.setup();

			Wirah.template.leftSidebar.followedTopics = new FollowedTopicsSidebarMenu;
			Wirah.template.leftSidebar.followedTopics.populate(Wirah.config.template.followedTopics);
			Wirah.template.leftSidebar.followedTopics.build(Wirah.template.DOM.leftSidebar);

		}

	};
  
	// Classes
