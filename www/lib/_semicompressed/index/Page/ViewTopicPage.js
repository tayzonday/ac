/* ViewTopicPage class */

/**
 * @constructor
 */
function ViewTopicPage() {

	this.id = 2;
	
	this.topic = false; /* new TopicForPage */
	
	
	this.populate = function(response) {
	
		this.topic = new TopicForPage(this);
		
		this.topic.id                = response.topic.id;
		this.topic.name              = response.topic.name;
		this.topic.slug              = response.topic.slug;
		this.topic.description       = response.topic.description;
		this.topic.iconSmall         = response.topic.icon_small;
		this.topic.iconLarge         = response.topic.icon_large;
		this.topic.numThreads        = response.topic.num_threads;
		this.topic.numPosts          = response.topic.num_posts;
		this.topic.numThreadsAllTime = response.topic.num_threads_all_time;
		this.topic.numPostsAllTime   = response.topic.num_posts_all_time;
		this.topic.numFollowers      = response.topic.num_followers;
		this.topic.userFollows       = response.topic.user_follows;

		this.topic.threadListing = new ThreadListing(this.topic);

		this.topic.threadListing.topPagination             = new Pagination(this.topic.threadListing);
		this.topic.threadListing.topPagination.maxPages    = response.pagination.max_pages;
		this.topic.threadListing.topPagination.currentPage = response.pagination.current_page;

		this.topic.threadListing.bottomPagination             = new Pagination(this.topic.threadListing);
		this.topic.threadListing.bottomPagination.maxPages    = response.pagination.max_pages;
		this.topic.threadListing.bottomPagination.currentPage = response.pagination.current_page;
		
		this.topic.threadForCreation = new ThreadForCreation(this.topic);
		
		for (var n in response.topic.threads) {
		
			var thread = new ThreadForListing(this.topic.threadListing);
			
			thread.id                        = response.topic.threads[n].id;
			thread.topicId                   = response.topic.threads[n].topic_id;
			thread.postId                    = response.topic.threads[n].post_id;
			thread.subject                   = response.topic.threads[n].subject;
			thread.text                      = response.topic.threads[n].text;
			thread.imageUrl                  = response.topic.threads[n].image_url;
			thread.numPosts                  = response.topic.threads[n].num_posts;
			thread.numPostsWithImages        = response.topic.threads[n].num_posts_with_images;
			thread.timestampCreated          = response.topic.threads[n].timestamp_created;
			thread.timestampUpdated          = response.topic.threads[n].timestamp_updated;
			thread.userFollows               = response.topic.threads[n].user_follows;
			thread.numPostsOmitted           = response.topic.threads[n].num_posts_omitted;
			thread.numPostsWithImagesOmitted = response.topic.threads[n].num_posts_with_images_omitted;
			
			thread.topic      = new Topic;
			thread.topic.id   = response.topic.id;
			thread.topic.name = response.topic.name;
			thread.topic.slug = response.topic.slug;
			
				
			thread.postListing = new PostListing(thread);
			
			for(var m in response.topic.threads[n].posts) {
			
				var post = new Post(thread.postListing);
				
				post.id                   = response.topic.threads[n].posts[m].id;
				post.threadId             = response.topic.threads[n].posts[m].thread_id;
				post.threadPostId         = response.topic.threads[n].posts[m].thread_post_id;
				post.parentPostId         = response.topic.threads[n].posts[m].parent_post_id;
				post.text                 = response.topic.threads[n].posts[m].text;
				post.imageUrl             = response.topic.threads[n].posts[m].image_url;
				post.numReplies           = response.topic.threads[n].posts[m].num_replies;
				post.numRepliesWithImages = response.topic.threads[n].posts[m].num_replies_with_images;
				post.timestampCreated     = response.topic.threads[n].posts[m].timestamp_created;
				post.timestampUpdated     = response.topic.threads[n].posts[m].timestamp_updated;

				post.thread = new Thread;
				post.thread.id      = response.topic.threads[n].id;
				post.thread.topicId = response.topic.threads[n].topic_d;
				post.thread.postId  = response.topic.threads[n].post_id;
				
				post.thread.topic      = new Topic;
				post.thread.topic.id   = response.topic.id;
				post.thread.topic.name = response.topic.name;
				post.thread.topic.slug = response.topic.slug;

				thread.postListing.posts.push(post);

			}

			this.topic.threadListing.threads.push(thread);

		}

	}			

	this.build = function() {
	
		this.topic.build();
		this.DOM.content.appendChild(this.topic.DOM.root);

	}


	this.setup();

	return true;

}

ViewTopicPage.prototype = new Page;
