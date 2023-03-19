<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
include('inc/_functions.php');
header("Cache-Control: private");
header("Pragma: public");
header("Content-Type: application/xml; charset=utf-8");
$id = intval($_GET['id']);

$asx = '<asx Version="3.0">'.
	'<Title>VuaPhim.Net - Xem Phim Online</Title>'.
	'<Param Name="Encoding" Value="UTF-8" />';
$rs = $mysql->fetch_array($mysql->query("SELECT episode_url,episode_local,episode_type FROM ".$tb_prefix."episode WHERE episode_id = '".$id."'"));
	if($rs['episode_local'])
	 $url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
	else
	
{
	if($rs['episode_type']==36)
		$url=$rs['episode_url'].'?k=103';
}

		$asx .= '<entry>'.
			'<Title>VuaPhim.Net - Xem Phim Online</Title>'.
			'<Author>VuaPhim.Net - Xem Phim Online</Author>'.
			'<Copyright>VuaPhim.Net - Xem Phim Online</Copyright>'.
			'<Ref Href="'.$url.'" />'.
		'</entry>';
		$asx .='<Banner href="http://VuaPhim.Net/images/logofilm.gif">'.
			'<MoreInfo href="http://VuaPhim.Net" /></Banner>';
$asx .= '</asx>';
echo $asx;
?>