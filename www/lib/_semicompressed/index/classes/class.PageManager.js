// PageManager class

/**
 * @constructor
 */
function PageManager() {

	this.page = false;

    this.clickPushStateLink = (function (e) {

		console.log('PageManager.clickPushStateLink(' + e + ')');
        
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

        console.log('PageManager.revertToState(' + e + ')');

        if(e.state == null) {
            this.handlePathInclude(window.location.pathname);
        } else {
            this.createPage(e.state);
        }
    }).bind(this);
    
    
    this.handlePathInclude = function (path) {

        console.log('PageManager.handlePathInclude(' + path + ')');

        if(path == '#') return;
        if(path == 'javascript:;') return;
	
        Wirah.template.resetContent();
	
        var ajax = new AjaxRequest(1);

        ajax.params = {
            "path": path
        };

        ajax.callbacks.success = (function (response) {
        
            console.log('PageManager.handlePathInclude().[ajax.callbacks.success]');

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

            console.log('PageManager.handlePathInclude().[ajax.callbacks.error]');

            window.history.pushState('', 'Wirah', '/');

        }).bind(this);

        ajax.makeRequest();
        
    }
    
    
    this.createPage = (function (response) {

        console.log('PageManager.createPage(\'' + response + '\')');

		Wirah.template.DOM.contentInner.removeClass('invisible');

		Wirah.template.setTitle(response.page.title);
		Wirah.template.setHeading(response.page.heading);
		
		Wirah.template.leftSidebar.followedTopics.resetItems();
		
		switch(response.page.id) {
		
		
			case 5: // Topic Listing (/topics)
			
				this.page = new TopicListingPage;
				this.page.populate(response);
			
				break;
		
		}

		this.page.build(Wirah.template.DOM.contentInner);
		
		
		
		

    
    }).bind(this);

    return true;

}
