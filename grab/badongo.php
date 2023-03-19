<?php
include('encode.php');
$id= $_GET['id'];
$pas=$_GET['pass'];
function get($id){
	$code=grab_link('http://www.badongo.com/en/vid/'.$id,'','','');
	$link=getStr($code,'flashvars:"file=','&');
        $link2=getStr($code,'&file=','&');
	$server=getStr($code,'<div id="videoBoxNormal"','<!--');
	$server= urldecode($server);
	$d=getStr($server,'che','.');
        if ($link2) $urlfile='http://www.badongo.com/'.urldecode($link2);
        else $urlfile=urldecode($link);	
        if ($urlfile=="") $urlfile=$nofile;
	else $urlfile=str_replace('http://mediacache66','http://cache'.$d,$urlfile);
	return $urlfile;
}
if (isset($id) && check_time($_GET['t'])){
	$code=grab_link('http://www.badongo.com/en/vid/original/'.$id,'','','');
	$link=getStr($code,'flashvars:"file=','&');
        $link2=getStr($code,'&file=','&');
	$server=getStr($code,'<div id="videoBoxNormal"','<!--');
	$server= urldecode($server);
	$d=getStr($server,'che','.');
        if ($link2) $urlfile='http://www.badongo.com/'.urldecode($link2);
        else $urlfile=urldecode($link);	
        if ($urlfile=="") $urlfile=$nofile;
	else $urlfile=str_replace('http://mediacache66','http://cache'.$d,$urlfile);
        if ( $d==35)$urlfile=get($id);
	header("Location: ".$urlfile);
}

?>