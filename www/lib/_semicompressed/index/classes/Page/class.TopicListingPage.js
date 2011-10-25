/* TopicListingPage class */

/**
 * @constructor
 */
function TopicListingPage() {

	this.topicListing = false; // new TopicListing;
	
	this.populate = function (response) {

		console.log('TopicListingPage.populate(\'' + response + '\')');

		this.topicListing = new TopicListing;

		for(var n in response.topics) {

			var topic = new TopicForListing;

			topic.id                = response.topics[n].id;
			topic.name              = response.topics[n].name;
			topic.slug              = response.topics[n].slug;
			topic.description       = response.topics[n].description;
			topic.iconSmall         = response.topics[n].icon_small;
			topic.iconLarge         = response.topics[n].icon_large;
			topic.numThreads        = response.topics[n].num_threads;
			topic.numPosts          = response.topics[n].num_posts;
			topic.numThreadsAllTime = response.topics[n].num_threads_all_time;
			topic.numPostsAllTime   = response.topics[n].num_posts_all_time;
			topic.numFollowers      = response.topics[n].num_followers;
			topic.timestampCreated  = response.topics[n].timestamp_created;

			topic.userFollows = response.topics[n].user_follows;
			
			topic.strings.numThreadsPosts = response.topics[n].strings.num_threads_posts;
			topic.strings.numFollowers    = response.topics[n].strings.num_followers;

			this.topicListing.topics.push(topic);
			
		}
	}


	this.build = function (append_to) {
	
		console.log('TopicListingPage.build(\'' + append_to + '\')');

		this.topicListing.build(append_to);

	}

	return true;

}

TopicListingPage.prototype = new Page;
