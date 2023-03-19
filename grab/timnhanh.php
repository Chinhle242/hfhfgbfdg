<?php
include('encode.php');

function grab_yume($string)
{
	global $cachedir;
	if (substr_count($string,'http:/video.yume.vn') != 0) $string =str_replace('http:/','http://',$string);
	if (substr_count($string,'http://video.yume.vn') == 0) $string = 'http://video.yume.vn/'.$string;
	if (substr_count($string,'.html') == 0) $string =$string.'.html';
	if (substr_count($string,'/clip/') != 0){
		$a=explode('/',$string);
		$b=explode('.',$a[5]);
		$string="http://video.yume.vn/video-clip/".$b[0].'.'.$a[3].'.'.$b[1].'.'.$b[2];
	}
	$linkvideo=explode('.', $string);
	$num=count($linkvideo);
	$id=$linkvideo[$num-2];
	$cache=$cachedir.'timnhanh/'.$id.'.txt';
	if (file_exists($cache))
	{
		$html=@file_get_contents($cache);
		$htm=explode('id_clip=',$html);
		if ($htm[3]!="tdv"){
			$url=grab_link('http://video.yume.vn/playlist/'.$htm[1].'.xml','','','');
			$link = explode('<track urlFLV="', $url);
			$link_p = explode('" titleFLV="', $link[1]);
			$urlfile=$link_p[0];
			if ($urlfile!="") @file_put_contents($cache,'id_clip='.$id_clip.'id_clip='.$urlfile.'id_clip=tdv');
		}else{
			$id_clip=$htm[1];
			$urlfile=$htm[2];
		}
	}
	else
	{
		if (substr_count($string,'http://video.yume.vn/playlist/') != 0){
			$string=str_replace(".html","",$string);
			$id_clip=getStr($string,"http://video.yume.vn/playlist/",".xml");
			$cache=$cachedir.'timnhanh/'.$id_clip.'.txt';
			$url=grab_link($string,'','','');
			$link = explode('<track urlFLV="', $url);
			$link_p = explode('" titleFLV="', $link[1]);
			$urlfile=$link_p[0];
			if ($urlfile!="") @file_put_contents($cache,'id_clip='.$id_clip.'id_clip='.$urlfile.'id_clip=tdv');
		}else{
			$string=str_replace("xem-clip-","xem-clip/",$string);
			$string=str_replace("http://video.yume.vn","",$string);
			$fp = fsockopen("video.yume.vn",80, $errno, $errstr, 60);
			if (!$fp)
			   return;
			else {
				fputs ($fp, "GET /".$string." HTTP/1.0\r\n");
				fputs ($fp, "Host: video.yume.vn\r\n");
				fputs ($fp, "User-Agent: Mozilla 4.0\r\n\r\n");
				$d = '';
				while (!feof($fp))
					$url_pl .= fgets ($fp,2048);
				fclose ($fp);
				}
			$xml= explode("var strMemberVideo 	= '", $url_pl);
			$idvideo = explode("';", $xml[1]);
			$id_clip =$idvideo[0];
			$url=grab_link('http://video.yume.vn/playlist/'.$id_clip.'.xml','','','');
			$link = explode('<track urlFLV="', $url);
			$link_p = explode('" titleFLV="', $link[1]);
			$urlfile=$link_p[0];
			if ($urlfile!="") @file_put_contents($cache,'id_clip='.$id_clip.'id_clip='.$urlfile.'id_clip=tdv');
	}
	}
	$urlfile=str_replace(array('http://video.timnhanh.com/','http://video.timnhanh.com.vn/'),'http://video.yume.vn/',$urlfile);
	$urlfile=str_replace('&ref=1','',$urlfile);
	$link=explode('&hash=',$urlfile);
	$hash=md5(utf8_decode('Str@mSec!239'.$link[1]));
	$urlfile=$link[0].'&hash='.$hash."&ref=1";
	return $urlfile;
}
$string = $_GET['url'];
$type = $_GET['type'];
if (isset($string) && check_time($_GET['t'])){
    $link=grab_yume($string);
header("Location: ".$link);
}
?>