# Caching wordpress pages in static files!

This is extremely simple and efficient way to implement cache on your wordpress blog by simple changing one single file from original wordpress php pages. You need to have some programming experience (PHP) in order to implement this.

## Simple installation

You need to have writing privileges to your filesystem in order to implement this. 

1. Simple open the root folder of your wordpress site and locate the following file:
> wp-blog-header.php

2. make backup of this file

3. Replace the file with the version provided here in this git repository

4. Open the page code in text editor and do the following:

* make sure that the page can create a "tmp" folder, if not create manually this folder and make sure it has writing privileges.
> if(!is_dir(dirname(__FILE__).'/tmp/'))
>    mkdir(dirname(__FILE__).'/tmp/', 0777);

* check if your wordpress site is using this cookie keyword for saving logged in user session key: wordpress_logged_in_*
in case if is different string, manually replace the new name in the code:
> $user_logged_in = strpos($_SERVER['HTTP_COOKIE'], 'wordpress_logged_in_') !== false;

* if you have sitemap.xml or other page that you don't want to be cached by the system, make sure it is ignored from this script by simple adding lines like this one in your code:
> if(strpos($file_name, 'sitemap_xml') !== false) $user_logged_in = true;`

* Replace this query string param name "DELETE_ALL_CACHE_FILES" with your name, and use it when you want to delete all cached files. This in only way to remove the cached files. The script is not automatically doing this. Any time when you will publish a new post, you have to remove cached files, in order to see your new blog posts.

Below is displayed the testing results with and without cache activated for the home page of the wordpress blog.
**_With cache the same server can process 2000 pages per second, without cache only 1._**

### With cache activated:
> ab -n 500 -c 5 [http://www.alluringworld.com/](http://www.alluringworld.com/)

* Benchmarking [www.alluringworld.com](http://www.alluringworld.com/)
* Finished 500 requests
* Server Hostname:        [www.alluringworld.com](http://www.alluringworld.com/)
* Concurrency Level:      5
* Time taken for tests:   0.229 seconds
* Complete requests:      500
* Failed requests:        0
* Write errors:           0
* Total transferred:      14326000 bytes
* HTML transferred:       14230000 bytes
* **Requests per second:    2186.86 per sec**
* **Time per request:       2.286 ms**
* Time per request:       0.457 ms
* Transfer rate:          61189.45 Kbytes/sec received

### Without cache:
> ab -n 500 -c 5 [http://www.alluringworld.com/](http://www.alluringworld.com/)

* Benchmarking [www.alluringworld.com](http://www.alluringworld.com/)
* Finished 500 requests
* Server Hostname:        [www.alluringworld.com](http://www.alluringworld.com/)
* Concurrency Level:      5
* Time taken for tests:   **961.420 seconds**
* Complete requests:      500
* Failed requests:        0
* Write errors:           0
* Total transferred:      14494500 bytes
* HTML transferred:       14230000 bytes
* **Requests per second:    0.52 per sec**
* **Time per request:       9614.203 ms**
* Time per request:       1922.841 ms
* Transfer rate:          14.72 Kbytes/sec received
