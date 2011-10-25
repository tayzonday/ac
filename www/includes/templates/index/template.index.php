<?php

global $tpl, $my, $session;

$o = '';
$o .= '<!DOCTYPE html>';
$o .= '<html>';
$o .= '<head>';
$o .= '<meta charset="UTF-8" />';
$o .= '<meta name="description" content="' . $tpl->meta_description . '" />';
$o .= '<meta name="verify-v1" content="' . _GOOGLE_ANALYTICS_VERIFY_KEY . '" />';
$o .= '<title>';
if($tpl->getVar('page_title')) {
	$o .= $tpl->getVar('page_title') . ' - ';
}
$o .= _SITE_TITLE . '</title>';
$o .= $tpl->displayCssIncludes();
$o .= '<link id="favicon" rel="shortcut icon" href="/assets/favicon/default.ico?' . _ASSET_RELEASE_TIMESTAMP . '" type="image/x-icon" />';
$o .= '</head>';

//$my->num_thread_replies = 4;
//$my->num_post_mentions  = 8;

$o .= '<body>';
			
				/*
				$o .= '<nav>';
				
					$followed_topics_listing = new FollowedTopicListing;
					$followed_topics_listing->addWhere(FALSE, 'user_id', '=', $my->id);
					$followed_topics_listing->order_by = 'followed_topic_id';
					$followed_topics_listing->order_by_direction = 'ASC';
					$followed_topics_listing->select(1);
					
					if(sizeof($followed_topics_listing->rows) > 0) {
					
						$o .= '<menu id="menu-followed-topics">';

						$o .= '<h4>Followed Topics</h4>';
						$o .= '<a href="/topics" class="menu-inline-link">edit</a>';

						$o .= '<ul>';

						$n = 1;
						foreach($followed_topics_listing->rows as $_followed_topic) {

							$o .= '<li id="menu-followed-topic-' . $_followed_topic->topic_id . '"';
							
							if($n > 10) {
								$o .= ' class="hidden"';
							}
							
							$o .= '><a href="/' . $_followed_topic->topic_slug . '"';
							if(!empty($_followed_topic->topic_icon_small)) {
								$o .= ' style="background-image:url(\'' . $_followed_topic->topic_icon_small . '\');"';
							}
							$o .= '>' . $_followed_topic->topic_name . '</a><span';
//							if($item->num == 0) {
								$o .= ' class="hidden"';
//							}
							$o .= '>0</span></li>';

							$n++;
						}

						if(sizeof($followed_topics_listing->rows) > 10) {
							$o .= '<li id="menu-followed-topics-find-more" class="hidden"><a href="/topics" class="menu-link-color">Find more topics ...</a></li>';
							$o .= '<li id="menu-followed-topics-more"><a href="javascript:;" class="menu-link-color">More ...</a></li>';
						} else {
							$o .= '<li id="menu-followed-topics-find-more"><a href="/topics" class="menu-link-color">Find more topics ...</a></li>';
						}


//						$followed_topics_sidebar->addItem('find-more', '/topics', 'Find more topics...', false, 0, 'menu-link-color');

						//	$followed_topics_sidebar->addItem('more', '#', 'More...', false, 12, 'menu-link-color');
//						}


						//$o .= $followed_topics_sidebar->display();
						
						$o .= '</menu>';
					
					}

					$followed_thread_listing = new FollowedThreadListing;
					$followed_thread_listing->addWhere(FALSE, 'user_id', '=', $my->id);
					$followed_thread_listing->order_by = 'followed_thread_timestamp_created';
					$followed_thread_listing->order_by_direction = 'ASC';
					$followed_thread_listing->select(1);
					
					if(sizeof($followed_thread_listing->rows) > 0) {
					
						$followed_threads_sidebar = new Sidebar('Followed Threads');

						$o .= '<menu id="menu-followed-threads">';

						foreach($followed_thread_listing->rows as $followed_thread) {

							$followed_thread_update = new FollowedThreadUpdate;
							$followed_thread_update->select_count_field = 'followed_thread_update_id';
							$followed_thread_update->addWhere(FALSE, 'followed_thread_id', '=', $followed_thread->id);
							$num = $followed_thread_update->select(FALSE);
						
							if($num > 0) {
								$followed_threads_sidebar->addItem($followed_thread->thread_id, '/' . $followed_thread->topic_slug . '/' . $followed_thread->post_id . '/unread', $followed_thread->thread_subject, $followed_thread->topic_icon, $num, FALSE);
							} else {
								$followed_threads_sidebar->addItem($followed_thread->thread_id, '/' . $followed_thread->topic_slug . '/' . $followed_thread->post_id, $followed_thread->thread_subject, $followed_thread->topic_icon, 0, FALSE);
							}
						
						}
				
						$o .= $followed_threads_sidebar->display();
		
						$o .= '</menu>';
					
					}
					
					
					$o .= '<menu id="menu-theme">';

					$o .= '<h4>Theme</h4>';

					$o .= '<p>';
					
					$o .= '<select>
					<optgroup label="Wirah">
						<option>Light</option>
						<option>Dark</option>
					</optgroup>
					<optgroup label="Imageboards">
						<option>Yotsuba</option>
						<option>Yotsuba B</option>
						<option>Futaba</option>
						<option>Burichan</option>
					</optgroup>
					<optgroup label="Sites">
						<option>reddit</option>
					</optgroup>
					</select>

					';
					
					$o .= '</p>';
					
					$o .= '</menu>';
					
					
					

			$o .= '</nav>';
			
			*/
		
			$o .= '
	
';

//Test' . $tpl->displayContent('sidebar') . '
//		' . $tpl->displayContent('main') . '</div>

//$o .= $tpl->displayPreInlineJavascript();
$o .= $tpl->displayJavascriptIncludes();
//$o .= $tpl->displayPostInlineJavascript();

$o .= '</body>';
$o .= '</html>';

if(_COMPRESSED_JS_FILES) {
	$o = strip_whitespace($o);
}

die($o);

