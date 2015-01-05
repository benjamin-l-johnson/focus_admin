<?php


/*
|--------------------------------------------------------------------------
| In our setting there are two apps, think of it as a reader and writer
|--------------------------------------------------------------------------
| We must tell the writer where it can write its images too.
|  Basically, we have to give the foucs_admin app the path to where it can 
|  write images into the focus_app
|
| It can be used like Config::get('otherapp.images_path')
|
*/
return array(
		'images_path' => '/home/benj/programs/focus_app/public',
		'hostname' => 'http://focuskalamazoo.org'
);
