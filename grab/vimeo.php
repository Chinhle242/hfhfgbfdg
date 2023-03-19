<?php
include('encode.php');
$id=$_GET['id'];
$cache='cache/vimeo/'.str_replace('/','_',$id).'.txt';
function grab_vimeo($id){
	global $cache;
	$t=$_GET['type'];
	if ($t=="") $t='sd';
	$content=grab_link('http://vimeo.com/moogaloop/load/clip:'.$id.'/local/','','','');
	$signature=getStr($content,'<request_signature>','</request_signature>');
	$expire_signature=getStr($content,'<request_signature_expires>','</request_signature_expires>');
	$urlfile='http://vimeo.com/moogaloop/play/clip:'.$id.'/'.$signature.'/'.$expire_signature.'/?q='.$t.'&type=local';
	if ($urlfile!="") @file_put_contents($cache,'id_clip='.return_time().'id_clip='.$urlfile);
	return $urlfile;
}
if (isset($id) && check_time($_GET['t'])){
	if (file_exists($cache)){
		$html=@file_get_contents($cache);
		$time=explode('id_clip=',$html);
		$now=return_time();
		if ((($now-$time[1])<=30) && (($now-$time[1])>=0)){
			$urlfile=$time[2];
		}else{
			$urlfile=grab_vimeo($id);
		}
	}else{
		$urlfile=grab_vimeo($id);
	}
	header("Location: ".$urlfile);
}

?>