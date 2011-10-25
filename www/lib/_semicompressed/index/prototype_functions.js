// Prototype functions

// Checks if an element has a class
Node.prototype.hasClass = function (_class_name) {
	return (this.className.match(new RegExp('(\\s|^)' + _class_name + '(\\s|$)')));
}

// Adds a class to an element
Node.prototype.addClass = function (_class_name) {
	if(!this.hasClass(_class_name)) {
		this.className += " " + _class_name;
	}
}

// Removes a class from an element
Node.prototype.removeClass = function (_class_name) {
	if(this.hasClass(_class_name)) {
		var regex = new RegExp('(\\s|^)' + _class_name + '(\\s|$)');
		this.className = this.className.replace(regex, ' ');
		if(this.className.match(/^ *$/)) {
			this.removeAttribute('class');
		}
	}
}

// Replaces a class with another
Node.prototype.replaceClass = function (_class_name, _replacement_class_name) {
	this.removeClass(_class_name);
	this.addClass(_replacement_class_name);
}

// Adds en event listener to an element
Node.prototype.addEvent = function (_type, _func, _uc) {
	if(this.addEventListener) {
		this.addEventListener(_type, _func, _uc);
		return true;
	} else {
		this['on' + _type] = _func;
	}
}

// Removes an event listener from an element
Node.prototype.removeEvent = function (_type, _func) {
	if(this.detachEvent) {
		this.detachEvent('on' + _type, _func);
		this[_type + _func] = null;
	} else {
		this.removeEventListener(_type, _func, false);
	}
}

// Replaces an event listener with another
Node.prototype.replaceEvent = function (_type, _func, _replacement_func, _uc) {
	this.removeEvent(_type, _func);
	this.addEvent(_type, _replacement_func, _uc);
}
  
    // Converts an a element into a pushState link rather than a regular link
    window['Node.prototype.convertToPushStateLink'] = Node.prototype.convertToPushStateLink = function() {
        if(typeof this != 'object') {
    	    return;
        }
        if(this.getAttribute('target') == '_blank') {
    	    return;
        }
        this.addEvent('click', Wirah.pageManager.clickPushStateLink, false);
    }

    // Converts all child elements into pushState links */
    window['Node.prototype.convertChildrenToPushStateLinks'] = Node.prototype.convertChildrenToPushStateLinks = function() {

        if(this.childNodes.length == 0) { // Make sure the element is a single link (or a <button>)
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

    // Appends text to an element
    window['Node.prototype.appendText'] = Node.prototype.appendText = function(text) {
        this.appendChild(document.createTextNode(text));
    }

    // Urlencodes a string
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
                    ret += '+'; // %20 in rawurlencode
                } else if (code < 128) { // 1 byte
                    ret += hexStr(code);
                } else if (code >= 128 && code < 2048) { // 2 bytes
                    ret += hexStr((code >> 6) | 0xC0);
                    ret += hexStr((code & 0x3F) | 0x80);
                } else if (code >= 2048) { // 3 bytes (code < 65536)
                    ret += hexStr((code >> 12) | 0xE0);
                    ret += hexStr(((code >> 6) & 0x3F) | 0x80);
                    ret += hexStr((code & 0x3F) | 0x80);
                }
            }
        }
    
        return ret;

    }

  
  
  
  
  
  
  
  
