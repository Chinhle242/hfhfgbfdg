<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
include('inc/_functions.php');
header("Cache-Control: private");
header("Pragma: public");
header("Content-Type: application/xml; charset=utf-8");
$id =intval($_GET['id']);
$rs = $mysql->fetch_array($mysql->query("SELECT episode_film,server_id,episode_name FROM ".$tb_prefix."episode WHERE episode_id = '".$id."'"));
$film= $mysql ->fetch_array($mysql->query("SELECT  film_server, film_name_ascii,film_img FROM ".$tb_prefix."film WHERE film_id=".$rs['episode_film'].""));
$name_ascii = replace($film['film_name_ascii']);
$img= check_img($film['film_img']);
if ($film['film_server'] == 1) $where="WHERE episode_film = '".$rs['episode_film']."'";
else $where="WHERE episode_film = '".$rs['episode_film']."' AND  server_id = '".$rs['server_id']."'";
$xml = '<?xml version="1.0" encoding="iso-8859-1"?>'.
	'<videolist>'.
	'<title>Các Tập Khác:</title>';
$q = $mysql->query("SELECT episode_id, episode_name FROM ".$tb_prefix."episode ".$where." ORDER BY episode_name LIMIT 20");
while ($r = $mysql->fetch_array($q)) {
$name = ucwords($film['film_name_ascii']).' Tap '. $r['episode_name'];
$xml .= '<video id="'.$r['episode_id'].'">'.
		'<title>'.$name.'</title>'.
		'<thumb>'.$img.'</thumb>'.
		'<url>'.$web_link.'/xem-phim/'.$name_ascii.'_'.$id.'.html</url>	'.	
		'</video>';
}
$xml .= '</videolist>';
echo $xml;
exit();
?>