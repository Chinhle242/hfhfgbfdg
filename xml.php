<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
include('inc/_functions.php');
header("Cache-Control: private");
header("Pragma: public");
header("Content-Type: application/xml; charset=utf-8");
$linkgrab='http://perhacker.info/flash/embed';
$hash='TNT-04091988';
$id = intval($_GET['id']);
$trailer_id = intval($_GET['0id']);

$asx = '<?xml version="1.0" encoding="utf-8"?>'.
	'<playlist version="1" xmlns="http://xspf.org/ns/0/">'.
	'<trackList>';
if(!$trailer_id)
{
$rs = $mysql->fetch_array($mysql->query("SELECT episode_url,episode_local,episode_type FROM ".$tb_prefix."episode WHERE episode_id = '".$id."'"));
	if($rs['episode_local'])
	 $url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
	else
	
{
	if($rs['episode_type']==7)
		{	$id=str_replace('http://video.tamtay.vn/video/play/config/','',$rs['episode_url']);
			$url=$linkgrab.'/tamtay/'.$id.'/'.md5($hash.$id).'.flv';
	}
	elseif($rs['episode_type']==8) //http://video.timnhanh.com/phim68com/clip/mau-trang-tuyet-vong-blindness-ep-2-2.35AB877D.html
		{
			$id=explode('/',$rs['episode_url']);
			$url=$linkgrab.'/video.timnhanh.com/'.$id[3].'/clip/'.$id[count($id)-1].'/'.md5($hash.$id[count($id)-1]).'.flv';
		}
	elseif($rs['episode_type']==11)
		{$url=explode('/w/',$rs['episode_url']);	$url=explode(',',$url[1]);	$url=$linkgrab.'/clipvn/'.$url[0].'/'.md5($hash.$url[0]).'.mp4';
	//		$a = get_headers($url, 1);
	//		$url= $a['Location'];
	}
	elseif($rs['episode_type']==12)
		{$url=explode('_',$rs['episode_url']);	$url=explode('.',$url[1]);	$url=$linkgrab.'/blogvn/'.$url[0].'/'.md5($hash.$url[0]).'.mp4';}
	elseif($rs['episode_type']==29)
		{
		$id=explode('http://video.google.com/googleplayer.swf?docId=',$rs['episode_url']);
		$url=$linkgrab.'/googlevideo/'.$id[1].'/'.md5($hash.$id[1]).'.flv';
		}	
	elseif($rs['episode_type']==30)
		{
		$id=explode('http://www.megavideo.com/?v=',$rs['episode_url']);
		$url=$linkgrab.'/megavideo/'.$id[1].'/'.md5($hash.$id[1]).'.flv';		
		}	
	elseif($rs['episode_type']==31)
		{
		$id=explode('http://www.dailymotion.com/video/',$rs['episode_url']);
		$url=$linkgrab.'/dailymotion/'.$id[1].'/'.md5($hash.$id[1]).'.flv';		
		}
	elseif($rs['episode_type']==32)
		{
		$id=explode('http://www.youtube.com/watch?v=',$rs['episode_url']);
		$url=$linkgrab.'/youtube/'.$id[1].'/'.md5($hash.$id[1]).'.flv';				
		}		
	elseif($rs['episode_type']==33)
		{
		$id=explode('http://www.veoh.com/videos/',$rs['episode_url']);
		$url=$linkgrab.'/veoh/'.$id[1].'/'.md5($hash.$id[1]).'.flv';					
		}	
	elseif($rs['episode_type']==34)
		{
		$url=explode('.',$rs['episode_url']);
		$url=$linkgrab.'/videozing/'.$url[count($url)-2].'/'.md5($hash.$url[count($url)-2]).'.mp4';
		//	$test = @fopen($url ,"rb");
	//		if ($test) $url=$url; else $url= str_replace('.mp4','.flv',$url);
		}	
						
}

}
else
{
$rs = $mysql->fetch_array($mysql->query("SELECT trailers_url,trailers_local,trailers_type FROM ".$tb_prefix."trailers WHERE trailers_id = '".$trailer_id."'"));
	if($rs['trailers_local'])
	 $url = get_data('local_link','local','local_id',$rs['trailers_local']).$rs['trailers_url'];
	else
	
{
{
	if($rs['trailers_type']==7)
		{	$id=str_replace('http://video.tamtay.vn/video/play/config/','',$rs['trailers_url']);
			$url=$linkgrab.'/tamtay/'.$id.'/'.md5($hash.$id).'.flv';
	}
	elseif($rs['trailers_type']==8)
		{
			$id=explode('/',$rs['trailers_url']);
			$url=$linkgrab.'/video.timnhanh.com/'.$id[3].'/clip/'.$id[count($id)-1].'/'.md5($hash.$id[count($id)-1]).'.flv';
		}
	elseif($rs['trailers_type']==11)
		{$url=explode('/w/',$rs['trailers_url']);	$url=explode(',',$url[1]);	$url=$linkgrab.'/clipvn/'.$url[0].'/'.md5($hash.$url[0]).'.mp4';}
	elseif ($rs['trailers_type']==12)
		{
			$url=explode('_',$rs['trailers_url']);	
			$url=explode('.',$url[1]);	
			$url=$linkgrab.'/blogvn/'.$url[0].'/'.md5($hash.$url[0]).'.mp4';
			}
	elseif($rs['trailers_type']==29)
		{$url=str_replace('http://video.google.com/googleplayer.swf?docId=',$linkgrab.'/googlevideo/',$rs['trailers_url']);	$url=$url.'.flv';}	
	elseif($rs['trailers_type']==30)
		{$url=str_replace('http://www.megavideo.com/?v=',$linkgrab.'/megavideo/',$rs['trailers_url']);	$url=$url.'.flv';}	
	elseif($rs['trailers_type']==31)
		{$url=str_replace('http://www.dailymotion.com/video/',$linkgrab.'/dailymotion/',$rs['trailers_url']);	$url=$url.'.flv';}
	elseif($rs['trailers_type']==32)
		{
		$id=explode('http://www.youtube.com/watch?v=',$rs['episode_url']);
		$url=$linkgrab.'/youtube/'.$id[1].'/'.md5($hash.$id[1]).'.flv';				
		}			
	elseif($rs['trailers_type']==33)//http://video.zing.vn/zv/clip/Doremon--Nobita-va-vuong-quoc-Gio--P1.46209.html
		{$url=str_replace('http://www.veoh.com/videos/',$linkgrab.'/veoh/',$rs['trailers_url']);	$url=$url.'.flv';}	
	elseif($rs['trailers_type']==34)
		{$url=explode('.',$rs['trailers_url']);$url=$linkgrab.'/videozing/'.$url[count($url)-2].'.mp4';
		//	$test = @fopen($url ,"rb");
		//	if ($test) $url=$url; else $url= str_replace('.mp4','.flv',$url);
			}	}	
				

}	
}
  
    $asx .= '<track>'.
	//	'<Title></Title>'.
	//	'<creator></creator>'.
		'<location>'.$url.'</location>'.
	
	'</track>';
$asx .= '</trackList>'.
	'</playlist>';
echo $asx;
exit();
?>