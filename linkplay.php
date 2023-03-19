<?php
define('IN_MEDIA',true);

include('inc/_data.php');

include('inc/_settings.php');

include('inc/_functions.php');

include('inc/_string.php');

include('inc/_grab.php');

$episode_id = $fcommon -> decID($_GET['id']);

if ($episode_id)
{
	$q = $mysql->query("SELECT episode_url,episode_local,episode_type FROM ".$tb_prefix."episode WHERE episode_id = ".$episode_id);
	
	$rs = $mysql->fetch_assoc($q);
	
	if ($rs['episode_url'])
	{
		if ($rs['episode_type'] == 33)
		{
			$url = get_veoh($rs['episode_url']);
		}
	}
}

if (!$url) $url = $web_link;

header('Location: '.$url.'');
?>