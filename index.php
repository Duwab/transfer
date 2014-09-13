<?php

$application = 'application';
define('EXT', '.php');
error_reporting(E_ALL | E_STRICT);
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
// Make the application relative to the docroot, for symlink'd index.php
if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
	$application = DOCROOT.$application;

// Define the absolute paths for configured directories
define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);

// Clean up the configuration vars
unset($application);

if($_SERVER['REQUEST_URI'] == "" || $_SERVER['REQUEST_URI'] == "/")
	include('application/list.php');
else if($_SERVER['REQUEST_URI'] == "/file")
{
	$attachment_location = "files/austin.mp3";
	if (file_exists($attachment_location)) {

		header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
		header("Cache-Control: public"); // needed for i.e.
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Length:".filesize($attachment_location));
		header("Content-Disposition: attachment; filename=austin.mp3");
		readfile($attachment_location);
		die();        
	} else {
		die("Error: File not found.");
	}
}
else
	echo '404';