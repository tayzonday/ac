// PageManager class

/**
 * @constructor
 */
function PageManager() {

	this.page = false;

    this.clickPushStateLink = (function (_e) {

		console.log('PageManager.clickPushStateLink(' + _e + ')');

        var element = _e.target;

        if((!_e.shiftKey) && (!_e.ctrlKey) && (!_e.metaKey) && (!_e.altKey)) {
            var href = false;
            if(href = element.getAttribute('data-href')) {
                this.handlePathInclude(href);
            } else if(href = element.getAttribute('href')) {
                this.handlePathInclude(href);
            }
            _e.preventDefault();
        }

    }).bind(this);

    this.revertToState = (function (_e) {

        console.log('PageManager.revertToState(' + _e + ')');

        if(_e.state == null) {
            this.handlePathInclude(window.location.pathname);
        } else {
            this.createPage(_e.state);
        }

    }).bind(this);
    
    
    this.handlePathInclude = function (_path) {

        console.log('PageManager.handlePathInclude(' + _path + ')');

        if(_path == '#') return;
        if(_path == 'javascript:;') return;
	
        Wirah.template.resetContent();
	
        var ajax = new AjaxRequest(1);

        ajax.params = {
            "path": _path
        };

        ajax.callbacks.success = (function (_response) {
        
            console.log('PageManager.handlePathInclude().[ajax.callbacks.success]');

            try {
                window.history.pushState(_response, _response.page.page_title, _response.page.path);
            } catch(e) {
                try {
                    history.pushState(_response, _response.page.page_title, _response.page.path);
                } catch(e) {
                    alert(e);
                }
            }
            
            this.createPage(_response);

        }).bind(this);

        ajax.callbacks.error = (function (_response) {

            console.log('PageManager.handlePathInclude().[ajax.callbacks.error]');

            window.history.pushState('', 'Wirah', '/');

        }).bind(this);

        ajax.makeRequest();
        
    }
    
    
    this.createPage = (function (_response) {

        console.log('PageManager.createPage(\'' + _response + '\')');

		Wirah.template.DOM.contentInner.removeClass('invisible');
		
//		Wirah.template.DOM.main.setAttribute('data-page-id', _response.page.id);

		Wirah.template.setTitle(_response.page.title);
		Wirah.template.setHeading(_response.page.heading);
		
		Wirah.template.leftSidebar.followedTopics.resetItems();
		
		switch(_response.page.id) {
		
		
			case 5: // Topic Listing (/topics)
			
				this.page = new TopicListingPage;
				this.page.populate(_response);
			
				break;
				
			case 7: // Logout (/logout)
			
				this.page = new Page;
				this.page.html = _response.html;
				
				Wirah.user.events.logout();
				
				
			case 9: // Login (/login)
			
				this.page = new Page;
				this.page.html = _response.html;
		
		}

		this.page.build(Wirah.template.DOM.contentInner);

    }).bind(this);

    return true;

}