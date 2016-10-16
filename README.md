# Caching wordpress pages in static files!

This is extremely simple and efficient way to implement cache on your wordpress blog by simple changing one single file from original wordpress php pages. You need to have some programming experience (PHP) in order to implement this.

## Simple installation

You need to have writing privileges to your filesystem in order to implement this. 
1. Simple open the root folder of your wordpress site and locate the following file:
wp-blog-header.php

2. make backup of this file

3. Replace the file with the version provided here in this git repository

4. Open the page code in text editor and do the following:

* make sure that the page can create a "tmp" folder, if not create manually this folder and make sure it has writing privileges.

if(!is_dir(dirname(__FILE__).'/tmp/'))
   mkdir(dirname(__FILE__).'/tmp/', 0777);

* check if your wordpress site is using this cookie keyword for saving logged in user session key: wordpress_logged_in_*
in case if is different string, manually replace the new name in the code:

$user_logged_in = strpos($_SERVER['HTTP_COOKIE'], 'wordpress_logged_in_') !== false;

* if you have sitemap.xml or other page that you don't want to be cached by the system, make sure it is ignored from this script by simple adding lines like this one in your code:

if(strpos($file_name, 'sitemap_xml') !== false) $user_logged_in = true;

* Replace this query string param name "DELETE_ALL_CACHE_FILES" with your name, and use it when you want to delete all cached files. This in only way to remove the cached files. The script is not automatically doing this. Any time when you will publish a new post, you have to remove cached files, in order to see your new blog posts.



