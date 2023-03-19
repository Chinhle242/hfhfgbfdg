<?php

$db_host	= 'localhost';

$db_name    = 'btv';

$db_user	= 'btv';

$db_pass	= 'freecode.vn';

$tb_prefix	= 'table_';


$refreshType = 1;

$setCookieType = 1;	

if (!defined('IN_MEDIA')) die("Hack");

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler');

else ob_start();

@session_start();

header("Content-Type: text/html; charset=UTF-8");

if (!ini_get('register_globals')) {

	@$_GET = $HTTP_GET_VARS;

	@$_POST = $HTTP_POST_VARS;

	@$_COOKIE = $HTTP_COOKIE_VARS;

	extract($_GET);

	extract($_POST);

}

define('NOW',time());

define('IP',$_SERVER['REMOTE_ADDR']);

define('USER_AGENT',$_SERVER['HTTP_USER_AGENT']);

define('URL_NOW',$_SERVER["REQUEST_URI"]);

if (!USER_AGENT || !IP) exit();

include('_dbconnect.php');

include('_hex.php');

?>