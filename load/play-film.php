<?php
if (!defined('IN_MEDIA')) die("Hack");
if (!$_COOKIE['SITE_DIV_PLAY']) 
{
	$hash = md5(time().$_SERVER['REMOTE_ADDR']);
	setcookie('SITE_DIV_PLAY',$hash, time()+ 60*60*24*7, "/", ".vuaphim.vn");
	$cookies_file = 'load/cookies/'.$hash.'.play.cookies';
}

else	$cookies_file = 'load/cookies/'.$_COOKIE['SITE_DIV_PLAY'].'.play.cookies';

if (@file_exists($cookies_file))
{
	$fp = fopen($cookies_file,'r');	
	$count = fread($fp,filesize($cookies_file));	
	fclose($fp);
}

else	//CHUA CO -> TAO FILE
{
	$fp = @fopen($cookies_file, 'w');
	@fwrite($fp,'1');
	@fclose($fp);	
}

if ($count < 2) $count = $count +1 ;

else $count = 1;

$fp = @fopen($cookies_file, 'w');	
@fwrite($fp, $count);	
@fclose($fp);

?>