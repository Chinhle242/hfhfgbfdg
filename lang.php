<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
$lang= $_GET['lang'];
if( $lang=='Vietnamese' || $lang=='English' )
		setcookie('LangCookie',$lang, time()+22118400); 

else
		setcookie('LangCookie','Vietnamese', time()+22118400); 
echo  "<meta http-equiv='refresh' content='0;url=javascript:history.go(-1)'>";
echo '<a href="'.$web_link.'/index.html" style="text-decoration:none;">Click Here</a>';
?>