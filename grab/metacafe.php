<?php
include('encode.php');
$id=$_GET['id'];
$cache='cache/metacafe/'.str_replace('/','_',$id).'.txt';
function grab_meta($id){
	global $cache;
	$code=grab_link('http://www.metacafe.com/fplayer/'.$_GET['id'].'/a.swf','','','');
	$link=getStr($code,'mediaURL%22%3A%22','%22%7D%7D');
	$link=urldecode($link);
	$link2=explode('","key":"',$link);
	$link2=str_replace("\/","/",$link2);
	$urlfile=$link2[0].'?__gda__='.$link2[1];
	if ($urlfile!="") @file_put_contents($cache,'id_clip='.return_time().'id_clip='.$urlfile);
	return $urlfile;
}
if (isset($id) && check_time($_GET['t'])){
	if (file_exists($cache)){
		$html=file_get_contents($cache);
		$time=explode('id_clip=',$html);
		$now=return_time();
		if ((($now-$time[1])<=25) && (($now-$time[1])>=0)){
			$urlfile=$time[2];
		}else{
			$urlfile=grab_meta($id);
		}
	}else{
		$urlfile=grab_meta($id);
	}
header("Location: ".$urlfile);
}
?>