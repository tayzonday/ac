/* AjaxRequest class */

/**
 * @constructor
 */
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
    
        console.log('AjaxRequest.init()');
        
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
    
        console.log('AjaxRequest.readyStateChange()');

        if(this.request.readyState == 4) {

            if(this.request.status == 200) {

                var response = this.request.responseText;
                var json = eval("(" + response + ")");

                switch(json.type) {

                case 0: // Error

                    if(json.response.errors[0].code == -1) { // If session was reset before this, reload the page.
                        window.location.reload();
                    }

                    this.callbacks.error(json.response);
                    
                    break;

                case 1: // Success

                    this.callbacks.success(json.response);
                
                }
            }
        }
    }).bind(this);


    this.makeRequest = function () {

        console.log('AjaxRequest.makeRequest()');

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
