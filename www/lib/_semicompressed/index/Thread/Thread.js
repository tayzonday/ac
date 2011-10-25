/* Thread class */

/**
 * @constructor
 */
function Thread(parent) {

	this.parent = parent;
	
	/* Data members	*/
	this.id                 = 0;
	this.typeId             = 0;
	this.userId             = 0;
	this.sessionId          = 0;
	this.topicId            = 0;
	this.postId             = 0;
	this.subject            = '';
	this.text               = '';
	this.imageUrl           = '';
	this.ip                 = '';
	this.numPosts           = 0;
	this.numPostsWithImages = 0;
	this.showInMyThreads    = 0;
	this.timestampCreated   = 0;
	this.timestampUpdated   = 0;

	/* Object members */
	this.topic       = null;
	this.postListing = null;

	/* Extra members */
	this.userFollows               = false;
	this.timeAgo                   = '';
	this.timeString                = '';
	this.timestampToggleMode       = 0;
	this.numPostsOmitted           = 0;
	this.numPostsWithImagesOmitted = 0;
	
	
	/* Common methods (shared between TopicForPage and TopicForListing) */

	this.formatTimeAgo = function() {

		var now = new Date;
		this.timeAgo = formatTimeAgo(timeAgo(Math.floor(now.getTime() / 1000) - this.timestampCreated)) + ' ago';

	}
	
	
	this.formatTimeString = function() {

		var date = new Date(this.timestampCreated * 1000);
		var hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
		var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
		var seconds = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
		var day = date.getDate();
		var day_x = day < 10 ? '0' + day : day;
		var weekday = date.getDay();
		var weekday = config.shortWeekdays[weekday];
		var month = (parseInt(date.getMonth() + 1)) < 10 ? '0' + parseInt(date.getMonth() + 1) : parseInt(date.getMonth() + 1);
		var year = date.getFullYear();
		
		this.timeString = weekday + ' ' + day_x + '/' +  month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;

	}
	
	
	
	
	/* Events */


}



