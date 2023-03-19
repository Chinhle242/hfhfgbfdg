<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
include('inc/_functions.php');
include('inc/_grab.php');
$id =	intval($_GET['id']);	// ID film
$s	=	$_GET['s'];		// Server chua film
$t	=	$_GET['t'];		// Giao dien cua flash ( Vị tri đặt của playlist )
if ($id && $s)		{
header("Cache-Control: private");
header("Pragma: public");
header("Content-Type: application/xml; charset=utf-8");
$film= $mysql ->fetch_array($mysql->query("SELECT  film_name, film_name_ascii,film_img,film_info FROM ".$tb_prefix."film WHERE film_id=".$id.""));
$name_ascii = replace($film['film_name_ascii']);
$str = text_tidy($film['film_info']);
$str =str_replace('  ',' ',$str);
$str=strip_tags($str);
$info = get_words_film_info($str,15);
$img= check_img($film['film_img']);
if ($s == 1) $where="WHERE episode_film = '".$id."'";
else $where="WHERE episode_film = '".$id."' AND  server_id = '".$s."'";
$xml = '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">'.
	'<channel>'.
	'<title>'.ucwords($film['film_name']).'</title>'.
	'<link>'.$web_link.'/thong-tin/'.$name_ascii.'_'.$id.'.html</link>';
$q = $mysql->query("SELECT episode_id, episode_name, episode_type, episode_url,episode_local FROM ".$tb_prefix."episode ".$where." ORDER BY episode_name ");
while ($r = $mysql->fetch_array($q)) {
$name	= $film['film_name'].' Tập '.$r['episode_name'];
$type 	= $r['episode_type'];
$url 	= $r['episode_url'];
if ($type==7)	{$url=str_replace('http://video.tamtay.vn/video/play/config/','',$url);
					$url=$linkgrabvn.'/tamtay/'.$url.'/'.md5($hash.$url).'.flv'; }
$xml .= '<item>'.
		'<title>'.$name.'</title>'.
		'<media:content url="'.$url.'"  type="video/x-flv"/>'.
		'<media:thumbnail url="'.$img.'" />'.	
		'<description>'.$name.' '.$info.'</description>'.
		'<link>'.$web_link.'/xem-phim/'.$name_ascii.'_'.$r['episode_id'].'.html</link>'.
		'</item>';
}
$xml .= '</channel>'.
		'</rss>';		

echo $xml;
}
else 
echo 'mm';
exit();
?>