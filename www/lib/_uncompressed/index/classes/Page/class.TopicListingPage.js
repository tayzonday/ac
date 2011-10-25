/* TopicListingPage class */

/**
 * @constructor
 */
function TopicListingPage() {

	this.topicListing = false; // new TopicListing;

	this.populate = function (_response) {

		console.log('TopicListingPage.populate(\'' + _response + '\')');

		this.topicListing = new TopicListing;

		for(var a in _response.topics) {

			var topic = new TopicForListing;

			topic.id                = _response.topics[a].id;
			topic.name              = _response.topics[a].name;
			topic.slug              = _response.topics[a].slug;
			topic.description       = _response.topics[a].description;
			topic.iconSmall         = _response.topics[a].icon_small;
			topic.iconLarge         = _response.topics[a].icon_large;
			topic.numThreads        = _response.topics[a].num_threads;
			topic.numPosts          = _response.topics[a].num_posts;
			topic.numThreadsAllTime = _response.topics[a].num_threads_all_time;
			topic.numPostsAllTime   = _response.topics[a].num_posts_all_time;
			topic.numFollowers      = _response.topics[a].num_followers;
			topic.timestampCreated  = _response.topics[a].timestamp_created;

			topic.userFollows = _response.topics[a].user_follows;

			topic.strings.numThreadsPosts = _response.topics[a].strings.num_threads_posts;
			topic.strings.numFollowers    = _response.topics[a].strings.num_followers;

			this.topicListing.topics.push(topic);

		}
	}

	this.build = function (_append_to) {
	
		console.log('TopicListingPage.build(\'' + _append_to + '\')');

		this.topicListing.build(_append_to);

	}

	return true;

}

TopicListingPage.prototype = new Page;