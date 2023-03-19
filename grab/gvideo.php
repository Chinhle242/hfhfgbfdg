<?php
include('encode.php');
function LayCode2($id)
{
	$fp = fsockopen("video.google.com", 80, $errno, $errstr, 30);
	//--------------------------------
	$out = "GET /".$id." HTTP/1.1\r\n";
	$out .= "Host: video.google.com\r\n";;
	$out .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/3.0.1.1\r\n";
	$out .= "Referer: http://www.google.com/\r\n";;
	$out .= "Connection: Close\r\n\r\n";
	//--------------------------------
	fwrite($fp, $out);
	while (!feof($fp)) {
	$url_contents .= fgets($fp, 128);
	}
	fclose($fp);
	return $url_contents;
}

$id=$_GET['id'];
if (isset($id) && check_time($_GET['t'])){
//http://video.google.com/videoplay?docid=-5559978018410569533
$bestand = LayCode2("videofeed?fgvns=1&fai=1&docid=".$id);
$title='&tile=ThienDuongViet_'.getStr($bestand,'<media:title>','</media:title>');
$link1=explode('googleplayer.swf?videoUrl=',$bestand);
$link=explode('&',$link1[1]);
$link2=urldecode($link[0]);
if ($link2!="") $link2.=$title;
header("Location: ".$link2);
}
?>