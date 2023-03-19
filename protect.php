<?php
if (!defined('IN_MEDIA')) die("Hack");
if ($web_protect==1){
//Check Cookie
	$movie_cookie=$_COOKIE['PHPSESSID'];
	if ($movie_cookie=="") die("<html><head><title>$web_title</title></head><body><center><a href='' >Click vào đây để tiếp tục vào site</a></center></body></html>");
}
/*
else if ($web_protect==2){
	$user=$_SERVER['SERVER_NAME'];
	exit();
}*/
?>
