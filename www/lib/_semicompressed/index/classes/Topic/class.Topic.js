/* Topic class */

/**
 * @constructor
 */
function Topic() {

	this.setup = function () {

		// Data members
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

		// Extra members
		this.userFollows = false;

		// DOM
		this.DOM              = {};
		this.DOM.root         = null;
		this.DOM.followButton = null;
		this.DOM.numFollowers = null;
		
		// Language Strings
		this.strings = {};
		
	}

	return true;

}