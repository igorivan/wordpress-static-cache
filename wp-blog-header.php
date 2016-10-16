<?php
/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 * @author Igor Ivanov
 */

//save page output in a file
function savePage($buffer){
	global $file_name, $user_logged_in;
	
	//if cache directory not exist, try to create it, if this script doens't have privilege to change create the directory, it has to be created manually
	if(!is_dir(dirname(__FILE__).'/tmp/'))
		mkdir(dirname(__FILE__).'/tmp/', 0777);
	
	//save only if not logged in (to avoid saving the admin header in the cache file ...
	if(!$user_logged_in && strlen($buffer) > 1000) 
	{
		@file_put_contents(dirname(__FILE__).'/tmp/'.$file_name, $buffer);
	}
	
	//return the page output
	return $buffer;
}

//check if user is logged without using any wordpress api functions (it may not work on all wordpress versions)
$user_logged_in = false;
if(isset($_SERVER['HTTP_COOKIE']))
	$user_logged_in = strpos($_SERVER['HTTP_COOKIE'], 'wordpress_logged_in_') !== false;

//create filename from the page uri
$file_name = str_replace(array('/','?','&','=','.'), '_', $_SERVER['REQUEST_URI']);
$file_name = strtolower($file_name).'.tmp';

//ignore caching sitemap, or similar page
if(strpos($file_name, 'sitemap_xml') !== false) $user_logged_in = true;

//use for delete cache for particular page
if(isset($_GET['DELETE_ALL_CACHE_FILES']))
{	
	$dir = dirname(__FILE__).'/tmp/';
	foreach(glob($dir.'*.*') as $v)
	{
		@unlink($v);
	}
	$user_logged_in = true;
}

//if user is not logged in and cache file exists, output html from cache
if(!$user_logged_in && is_file(dirname(__FILE__).'/tmp/'.$file_name)){
	die(file_get_contents(dirname(__FILE__).'/tmp/'.$file_name));
}

//start getting the page html content, call callback when done...
ob_start('savePage');

if ( !isset($wp_did_header) ) {
	
	$wp_did_header = true;
	
	require_once( dirname(__FILE__) . '/wp-load.php' );
	
	wp();
	
	require_once( ABSPATH . WPINC . '/template-loader.php' );
}

//end getting the page content
ob_get_flush();