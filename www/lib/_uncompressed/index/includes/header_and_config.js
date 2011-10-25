(function() {

  window.Circle = {

    config: {

      template:{},

      general:{

        assetReleaseId     : 193842,
        documentTitleSuffix: ' - Circle',
        shortWeekdays      : ['Sun','Mon','Tues','Weds','Thurs','Fri','Sat'],
        defaultFavicon     : '/assets/favicon/default.ico',
        passwordMinLength  : 3,
        passwordMaxLength  : 24,
        threadTextMaxLength: 5000

      }

    },
    
    util: {
    
      randomNumber: function (min, max) {
        return Math.random * (max - min) + min;
      },
      
      addEvent: function (element, type, func, uc) {
        if (element.addEventListener) { 
          element.addEventListener(type, func, uc);
        } else if (element.attachEvent) { 
          element.attachEvent('on' + type, fund); 
        } else {
          element['on' + type] = func;
        }
      }
    
    },
    
    init: function () {
    
      alert('Yo');

    }

  }
  
  Circle.util.addEvent(window, 'load', Circle.init, false);



  // Classes
  
  


    
/*    
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
*/