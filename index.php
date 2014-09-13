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
//var_dump(scandir("files"));
//var_dump($_SERVER);
//echo "_SERVER['PATH_INFO']  " . $_SERVER['PATH_INFO'];
$uri_exp = explode('/', $_SERVER['PATH_INFO']);
include('application/alias.php');
if($_SERVER['REQUEST_URI'] == "" || $_SERVER['REQUEST_URI'] == "/")
	include('application/list.php');
else if(sizeof($uri_exp) == 3 && $uri_exp[1] == 'file' && file_exists("files/" . $uri_exp[2]))
{
	header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
	header("Cache-Control: public"); // needed for i.e.
	//header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Length:".filesize($uri_exp[2]));
	header("Content-Disposition: attachment; filename=" . $uri_exp[2]);
	readfile($uri_exp[2]);
}
else if(sizeof($uri_exp) == 3 && $uri_exp[1] == 'alias' && isset($ALIAS[$uri_exp[2]]))
{
	$file_path = $ALIAS[$uri_exp[2]];
	header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
	header("Cache-Control: public"); // needed for i.e.
	//header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: Binary");
	header("Content-Length:".filesize($file_path));
	header("Content-Disposition: attachment; filename=" . $uri_exp[2]);
	readfile($file_path);
}
else
	echo '404';