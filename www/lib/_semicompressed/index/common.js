
// returns the ClassName of a given object. Havent used this anywhere yet, might not be needed
function getObjectClass(obj) {
	if (obj && obj.constructor && obj.constructor.toString) {
		var arr = obj.constructor.toString().match(/function\s*(\w+)/);
		if (arr && arr.length == 2) {
			return arr[1];
		}
	}
	return undefined;
}





function stripTags(str, allowed_tags) {
    var key = '', allowed = false;
    var matches = [];
    var allowed_array = [];
    var allowed_tag = '';
    var i = 0;
    var k = '';
    var html = '';
 
    var replacer = function (search, replace, str) {
        return str.split(search).join(replace);
    };
 
    // Build allowes tags associative array
    if (allowed_tags) {
        allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi);
    }
 
    str += '';
 
    // Match tags
    matches = str.match(/(<\/?[\S][^>]*>)/gi);
 
    // Go through all HTML tags
    for (key in matches) {
        if (isNaN(key)) {
            // IE7 Hack
            continue;
        }
 
        // Save HTML tag
        html = matches[key].toString();
 
        // Is tag not in allowed list? Remove from str!
        allowed = false;
 
        // Go through all allowed tags
        for (k in allowed_array) {
            // Init
            allowed_tag = allowed_array[k];
            i = -1;
 
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+'>');}
            if (i != 0) { i = html.toLowerCase().indexOf('<'+allowed_tag+' ');}
            if (i != 0) { i = html.toLowerCase().indexOf('</'+allowed_tag)   ;}
 
            // Determine
            if (i == 0) {
                allowed = true;
                break;
            }
        }
 
        if (!allowed) {
            str = replacer(html, "", str); // Custom replace. No regexing
        }
    }
 
    return str;
}



window['addslashes'] = addslashes;
function addslashes(str) {
	str = str.replace(/\\/g,'\\\\');
	str = str.replace(/\'/g,'\\\'');
	str = str.replace(/\"/g,'\\"');
	str = str.replace(/\0/g,'\\0');
	return str;
}

window['stripslashes'] = stripslashes;
function stripslashes(str) {
	str = str.replace(/\\'/g,'\'');
	str = str.replace(/\\"/g,'"');
	str = str.replace(/\\0/g,'\0');
	str = str.replace(/\\\\/g,'\\');
	return str;
}

window['inArray'] = inArray;
function inArray (needle, haystack) {
	var key = ''; 
	for (key in haystack) {
		if (haystack[key] == needle) {
			return true;
		}
	}
	return false;
}

window['arrayRemoveElementByKey'] = arrayRemoveElementByKey;
function arrayRemoveElementByKey(arrayName, key) {
	for(var i in arrayName) { 
		if(i == key) {
			arrayName.splice(i,1); 
		}
	} 
}

window['arrayRemoveElement'] = arrayRemoveElement;
function arrayRemoveElement(arrayName, arrayElement) {
	for(var i=0; i<arrayName.length;i++ ) { 
		if(arrayName[i]==arrayElement) {
			arrayName.splice(i,1); 
		}
	} 
}

window['fadeIn'] = fadeIn;
function fadeIn(obj, display_type) {
	obj.style.opacity = 0;
	obj.style.filter = 'alpha(opacity=0)';
	switch(display_type) {
		case 1:	obj.style.display = 'block'; break;
		case 2:	obj.style.display = 'inline'; break;
		case 3: obj.style.display = 'inline-block'; break;
		case 3: obj.style.display = 'table-row'; break;
		case 4: obj.style.display = 'table'; break;
	}
	for(var i = 1; i < 11; i++) {
		setTimeout('setOpacity(\'' + obj.id + '\', ' + i + ')',50*i);
	}
}

window['fadeOut'] = fadeOut;
function fadeOut(obj, callback) {
	obj.style.opacity = 1;
	obj.style.filter = 'alpha(opacity=100)';
	for(var i = 10; i >= 0; i--) {
		 setTimeout('setOpacity(\'' + obj.id + '\', ' + i + ', ' + callback + ');',30*(10 - i));
	}
}

window['setOpacity'] = setOpacity;
function setOpacity(id, value, callback) {
	var obj = $(id);
	obj.style.opacity = value / 10;
	obj.style.filter = 'alpha(opacity=' + value * 10 + ')';
	if(value == 0) {
		obj.style.display = 'none';
		callback();
	}
}








window['redirect_to'] = redirect_to;
function redirect_to(path) {
	window.location = path;
}

window['hash_to'] = hash_to;
function hash_to(path) {
	window.location = '/#!' + path;
}




function timeAgo(secs) {

	if(secs < 60) {
		return [secs, 1]; // seconds
	} else {
		var num_mins = Math.floor(secs / 60);
		if(num_mins < 60) {
			return [num_mins, 2]; // minutes
		} else {
			var num_hours = Math.floor(secs / 3600);
			if(num_hours < 24) {
				return [num_hours, 3]; // hours
			} else {
				var num_days = Math.floor(secs / 86400);
				if(num_days < 7) {
					return [num_days, 4]; // days
				}
				var num_weeks = Math.floor(secs / 604800);
				return [num_weeks, 5]; // weeks;
			}
		}
	}
}

function formatTimeAgo(time_ago) {

	switch(time_ago[1]) {
		case 1: units = (time_ago[0] == 1) ? 'sec'  : 'secs';  break;
		case 2: units = (time_ago[0] == 1) ? 'min'  : 'mins';  break;
		case 3: units = (time_ago[0] == 1) ? 'hour' : 'hours'; break;
		case 4: units = (time_ago[0] == 1) ? 'day'  : 'days';  break;
		case 5: units = (time_ago[0] == 1) ? 'week' : 'weeks'; break;
	}

	if((time_ago[0] == 0) && (time_ago[1] == 1)) {
		time_ago[0] = 1;
		var units = 'second';
	}

	return time_ago[0] + ' ' + units;

}


function is_numeric (mixed_var) {
    return (typeof(mixed_var) === 'number' || typeof(mixed_var) === 'string') && mixed_var !== '' && !isNaN(mixed_var);
}



Node.prototype.insertAfter = function(newNode, refNode) {
	if(refNode.nextSibling) {
		return this.insertBefore(newNode, refNode.nextSibling);
	} else {
		return this.appendChild(newNode);
	}
}


String.prototype.numberFormat = function() {
	var num = this.toString();
	if(num.length > 3) {
		num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
	return num;
}

Number.prototype.numberFormat = function() {
	var num = this.toString();
	if(num.length > 3) {
		num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
	}
	return num;
}



Node.prototype.hasClass = function(class_name) {
	if(this.className.match(new RegExp('(\\s|^)' + class_name + '(\\s|$)'))) {
		return true;
	} else {
		return false;
	}
}

Node.prototype.addClass = function(class_name) {
	if(!this.hasClass(class_name)) {
		this.className += " " + class_name;
	}
}

Node.prototype.removeClass = function(class_name) {
	if(this.hasClass(class_name)) {
		var regex = new RegExp('(\\s|^)' + class_name + '(\\s|$)');
		this.className = this.className.replace(regex, ' ');
		if(this.className.match(/^ *$/)) {
			this.removeAttribute('class');
		}
	} else {
	}
}

Node.prototype.replaceClass = function(class_name, replacement_class_name) {
	this.removeClass(class_name);
	this.addClass(replacement_class_name);
}




/* Older eventListeners */
window['addEvent'] = addEvent;
function addEvent(element, type, fn, uc) {
	if(element) {
		if (element.addEventListener) {
			element.addEventListener(type, fn, uc);
			return true;
		} else {
			element['on' + type] = fn;
		}
	}
}

window['removeEvent'] = removeEvent;
function removeEvent(element, type, fn) {
	if(element) {
		if(element.detachEvent) {
			element.detachEvent('on' + type, fn);
			element[type + fn] = null;
		} else {
			element.removeEventListener(type, fn, false);
		}
	}
}

/* Prototype event listeners */
Node.prototype.addEvent = function(type, fn, uc) {
	if(this.addEventListener) {
		this.addEventListener(type, fn, uc);
		return true;
	} else {
		this['on' + type] = fn;
	}
}

Node.prototype.removeEvent = function(type, fn) {
	if(this.detachEvent) {
		this.detachEvent('on' + type, fn);
		this[type + fn] = null;
	} else {
		this.removeEventListener(type, fn, false);
	}
}

Node.prototype.replaceEvent = function(type, fn, replacement_fn, uc) {
	this.removeEvent(type, fn);
	this.addEvent(type, replacement_fn, uc);
}


Node.prototype.convertToPushState = function() {

	if(typeof this != 'object') return;
	if(this.getAttribute('target') == '_blank') return;

	this.addEvent('click', clickLinkPushState, false);

}

Node.prototype.convertChildrenToPushStates = function() {

	if(this.childNodes.length == 0) { /* It is a single link (a or button) */
		this.convertToPushState();
	} else {

		var links = this.getElementsByTagName('a');
		for(var n in links) {
			if(typeof links[n] != 'object') return;
			if(links[n].getAttribute('target') == '_blank') return;

			links[n].convertToPushState();
		}
	}
}


Node.prototype.appendText = function(text) {
	this.appendChild(document.createTextNode(text));
}


