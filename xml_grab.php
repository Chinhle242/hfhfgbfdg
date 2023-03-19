<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_players.php');
$id=$_GET['id'];
$type=$_GET['type'];
$xml="";
$web_link="http://vuaphim.vn";
$q = $mysql->query("SELECT * FROM ".$tb_prefix."episode WHERE episode_id = $id ");
	$rs = $mysql->fetch_array($q); 
if ($type=="embed"){
	if($rs['episode_local']) $url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
	else $url=$rs['episode_url'];
	if($rs['episode_type'] == 2 || $rs['episode_type'] == 3) 
		$url = $url;
	elseif($rs['episode_type'] == 5) $url = $web_link.'/'.'player.swf?file='.$url;
	else $url = get_link_total($url,$id);
	$player = str_replace('autostart=true','autostart=fasle',$url);
	header("Location: ". $player);
}
elseif ($type=="download")
{
	if($rs['episode_local']) $url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
	else $url=$rs['episode_url'];
	$type_return="download";
	$url = get_link_total($url,$id);
	header("Location: ".$url);
}else{
	if($rs['episode_local']){
		$url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
		$xml .="<flv>$url</flv>";
	}else $url=$rs['episode_url'];
	
	if($rs['episode_type'] == 2 || $rs['episode_type'] == 3) 
		$xml .="<flv>http://thienduongviet.org/no.flv</flv>";
	elseif($rs['episode_type'] == 32) 
		$xml .="<youtube>$url</youtube>";
	elseif($rs['episode_type'] == 5)
		$xml .="<flv>$url</flv>";
	elseif($rs['episode_type'] == 33) {
			if (preg_match('#veoh.com/browse/videos/category/([^/]+)/watch/([^/]+)#', $url, $id_sr)){
				$id = $id_sr[2];
				$url='http://www.veoh.com/rest/v2/execute.xml?apiKey=5697781E-1C60-663B-FFD8-9B49D2B56D36&method=veoh.video.findByPermalink&permalink='.$id;
			}
			elseif (preg_match('#www.veoh.com\/videodetails2\.swf\?permalinkId=(.*?)#s', $url) || preg_match('#www.veoh.com\/veohplayer\.swf\?permalinkId=(.*?)#s', $url)){
			$id = cut_str('=',$url,1);
			$id = cut_str('&',$id,0);
			$url='http://www.veoh.com/rest/v2/execute.xml?apiKey=5697781E-1C60-663B-FFD8-9B49D2B56D36&method=veoh.video.findByPermalink&permalink='.$id;
		}
		elseif (preg_match('#veoh.com/(.*?)#s', $url, $id_sr)){
			$linkvideo=explode('/', $url);
			$num=count($linkvideo);
			$id=$linkvideo[$num-1];
			$url='http://www.veoh.com/rest/v2/execute.xml?apiKey=5697781E-1C60-663B-FFD8-9B49D2B56D36&method=veoh.video.findByPermalink&permalink='.$id;
		}
		$xml .="<veoh>$url</veoh>";
	}
	elseif($rs['episode_type'] == 34) 
		$xml .="<zingvideo>$url</zingvideo>";
	elseif($rs['episode_type'] == 48) 
		$xml .="<metacafe>$url</metacafe>";
	elseif($rs['episode_type'] == 49) 
		$xml .="<2share>$url</2share>";
	elseif($rs['episode_type'] == 47) 
		$xml .="<4share>$url</4share>";
	elseif($rs['episode_type'] == 44) 
		$xml .="<nhaccuatui>$url</nhaccuatui>";
        elseif(($rs['episode_type'] == 40))$xml .="<movshare>$url</movshare>";
        elseif(($rs['episode_type'] == 51))$xml .="<novamov>$url</novamov>";
	else $url = get_link_total($url,0);
	header("Content-Type: application/xml; charset=utf-8");
		echo '<?xml version="1.0" encoding="utf-8"?><vuaphim version="1" xmlns="http://xspf.org/ns/0/"><listvideo>'.$xml.'</listvideo></vuaphim>';
}
?>
