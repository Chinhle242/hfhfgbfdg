<?php
function Code_sevenload($id){
	$fp = fsockopen("flash.sevenload.com", 80, $errno, $errstr, 30);
	$out = "GET /".$id." HTTP/1.1\r\n";
	$out .= "Host: flash.sevenload.com\r\n";;
	$out .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/3.0.1.1\r\n";
	$out .= "Referer: http://video.zing.vn/player/flvPlayer.swf\r\n";;
	$out .= "Connection: Close\r\n\r\n";
	
	fwrite($fp, $out);
	while (!feof($fp)) {
	$url_contents .= fgets($fp, 128);
	}
	fclose($fp);
	return $url_contents;
}
function grab_seven($id){
	global $cache;
	$code=Code_sevenload('player?portalId=en&screenlink=0&itemId='.$id);
	$link1=explode('<location seeking=',$code);
	$link2=explode('>',$link1[1]);
	$link=explode('</location',$link2[1]);
	$file=str_replace('&amp;','&',$link[0]);
	if ($file!="") @file_put_contents($cache,'id_clip='.return_time().'id_clip='.$file);
	return $file;
}
include('encode.php');
$id=$_GET['id'];
$cache='cache/sevenload/'.str_replace('/','_',$id).'.txt';
if (isset($id) && check_time($_GET['t'])){
	if (file_exists($cache)){
		$html=file_get_contents($cache);
		$time=explode('id_clip=',$html);
		$now=return_time();
		if ((($now-$time[1])<=25) && (($now-$time[1])>=0)){
			$urlfile=$time[2];
		}else{
			$urlfile=grab_seven($id);
		}
	}else{
		$urlfile=grab_seven($id);
	}
header("Location: ".$urlfile);
}
?>