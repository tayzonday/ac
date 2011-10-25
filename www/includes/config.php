<?php

define('_CORE_VERSION', '0.0.5');

define('_DOMAIN', 'atum');
define('_SUBDOMAIN', str_replace('.' . _DOMAIN, '', $_SERVER['HTTP_HOST']));

define('_URL', 'http://' . _SUBDOMAIN . '.' . _DOMAIN);
define('_FULL_DOMAIN', _SUBDOMAIN . '.' . _DOMAIN);
define('_SITE_TITLE', 'Wirah (Atum)');

// Update later with $_SERVER['SOMETHING']);
define('_ABSOLUTE_PATH', '/Users/Wirah/Sites/AnonCircle/atum/ac/www');

define('_SERVER_CODE', 'frontend1');
define('_SITE_IS_LIVE', FALSE);

define('_ASSET_RELEASE_TIMESTAMP', time());

switch(_SUBDOMAIN) {
	case 'www':
	case 'dev':
	case 'core':
		define('_APPLICATION_ID', 1);
		break;
	default:
		define('_APPLICATION_ID', 1);
		break;
}

define('_MEMCACHED_SERVER_POOL', serialize(array(
	'ec2-50-16-50-140.compute-1.amazonaws.com'    // Dev Frontend
)));

define('_MEMCACHED_KEY_PREFIX', 'w_');

define('_COMPRESSED_CSS_FILES', 0); // 0 - uncompressed, 1 - compressed
define('_COMPRESSED_JS_FILES', 0);  // 0 - uncompressed, 1 - semi-compressed, 2 - compressed


if(!_SITE_IS_LIVE) {
	define('_ALLOWED_IPS', serialize(array(
		'127.0.0.1',
		'77.99.137.5',
		'192.168.1.67',
		'94.193.132.190',
		'192.168.1.66',
	)));
	
	define('_ALLOWED_SESSIONS', serialize(array(
		'm1y6v7cc2k7dqoyhz2qgp6468qj3lu',
		'ydn5s73opxuq59gsqdony6jdfkmsgr',
		'xrngczpt2q3ak3zomsjubdjol3qk6zer',
	)));
	
	define('_CAN_ACCESS_PROTECTED_SITE_BY_IP', (in_array($_SERVER['REMOTE_ADDR'], unserialize(_ALLOWED_IPS))) ? TRUE : FALSE);
	define('_PROTECTED_BASIC_AUTH_DOMAINS', serialize(array(
		'www.wirah.com', // Remove from live site
	)));
	define('_PROTECTED_BASIC_AUTH_REALM', 'w');
	define('_PROTECTED_BASIC_AUTH_USERNAME', 'david');
	define('_PROTECTED_BASIC_AUTH_PASSWORD', 'mudkips');
} else {
	define('_CAN_ACCESS_PROTECTED_SITE_BY_IP', TRUE);
}

define('_REDIRECT_EXCEPTIONS', serialize(array()));

define('_AMAZON_S3_BUCKET_HOSTNAME', 'img.wirah.com');

define('_REGEX_INTERNAL_REFERER', '/^http:\/\/' . _SUBDOMAIN . '\.' . str_replace('.', '\.', _DOMAIN) . '/i');

define('_DB_HOST', '127.0.0.1');
define('_DB_USER', 'root');
define('_DB_PASS', 'hehhehheh');
define('_DB_NAME', 'wirah_atum');

define('_DB_SHOW_HTML_ERRORS', TRUE);
define('_DB_DEBUG_SHOW_ALL_QUERIES', FALSE);

define('_PATH_ROOT', $root);
define('_PATH_INCLUDES', $root . 'includes/');
define('_PATH_CLASSES', _PATH_INCLUDES . 'classes/');
define('_PATH_INTERFACES', _PATH_INCLUDES . 'interfaces/');
define('_PATH_CORE', _PATH_INCLUDES . 'core/');
define('_PATH_TEMPLATES', _PATH_INCLUDES . 'templates/');
define('_PATH_LIB', _PATH_INCLUDES . 'lib/');

define('_URL_PATH_CSS', '/css/');
define('_URL_PATH_CSS_UNCOMPRESSED', '/css-uncompressed/');
define('_URL_PATH_LIB',  '/lib/');
define('_URL_PATH_LIB_UNCOMPRESSED', '/lib-uncompressed/');

define('_REGEX_STRIP_BRS', '/(<br \/>(\r)?\n){3,999}/i');
define('_REGEX_STRIP_NEWLINES', '/((\r)?\n){3,999}/i');
define('_REGEX_URL', '/(?:https?:\/\/(?:[-\w\.]+)+(?:\d+)?(?:\/(?:[\w\/_\.\-]*(?:\?\S+)?)?)?)/im');
define('_REGEX_LINK', '/<a href=\"(.*)\" target=\"_blank\">(.*)<\/a>$/i');
define('_REGEX_FILE_EXTENSION', '/\.([a-z0-9]{2,4})$/i');
define('_REGEX_PAGE_NUMBER', '/^page([0-9]+)$/i');
define('_REGEX_EMAIL', '/^[A-Z0-9\._%\-\+]+@[A-Z0-9\.\-]+\.[A-Z]{2,4}$/i');
define('_REGEX_NUMBER', '/[0-9]+/');
define('_REGEX_WHITESPACE', '/\s+/');
define('_REGEX_STRIP_WHITESPACE', '/([\t\r\n]|\s{2,})/');
define('_REGEX_IMAGE_EXTENSION', '/\.(jpg|jpeg|gif|png)$/im');
define('_REGEX_CARD_KEY', '/^(?:[0-9]\s?){16}$/');

/* Wirah Markup Language */
define('_REGEX_WML_LINK', '/\[(.+)\]\((.+)\)/');
		
define('_NOTIFY_EMAILS', serialize(array('samstr@gmail.com')));

define('_GOOGLE_ANALYTICS_VERIFY_KEY', 'abc');

define('_AMAZON_S3_ACCESS_KEY', 'AKIAJE67F5IROY3KFCKQ');
define('_AMAZON_S3_SECRET_KEY', '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');
define('_AMAZON_S3_ASSETS_BUCKET', 'img.wirah.com');

define('_PASSWORD_MIN_LENGTH', 3);
define('_PASSWORD_MAX_LENGTH', 24);
//define('_THREAD_SUBJECT_MAX_LENGTH', 128); // Maybe change later. Also, not needed
define('_THREAD_TEXT_MAX_LENGTH', 5000); // Maybe change later


define('_CREATE_THREAD_SAME_TOPIC_FLOOD_DETECTION_SECS', 300); // 5 minutes
define('_CREATE_THREAD_ANY_TOPIC_FLOOD_DETECTION_SECS', 60); // 1 minute
define('_CREATE_THREAD_DUPLICATE_SAME_TOPIC_FLOOD_DETECTION_SECS', 1800); // 30 minutes

