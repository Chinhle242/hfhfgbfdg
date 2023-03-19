<?php

define('IN_MEDIA',true);

include('inc/_data.php');

include('inc/_settings.php');

include('inc/_functions.php');

include('inc/_string.php');

include('inc/_grab.php');

$id = intval($_GET['id']);

$s	=	$_GET['s'];		

$t	=	$_GET['t'];	

$mainURL='http://vuaphim.vn';	

if($s)		{

		if($t==1)

	$flash=$mainURL."/flash/player.swf?file=".$mainURL."/f/embed/".$id."/".$s.".xml&playlist=right&playlistsize=280&fullscreen=true&skin=".$mainURL."/flash/skin/dangdang.swf&logo=".$mainURL."/logo.png";

		else

	$flash=$mainURL."/flash/player.swf?file=".$mainURL."/f/embed/".$id."/".$s.".xml&playlist=bottom&playlistsize=280&fullscreen=true&skin=".$mainURL."/flash/skin/simple.swf&logo=".$mainURL."/logo.png&playlistsize=50";	

	}

else	{	

$img='http://ken365.com/images/logo.gif';

$rs = $mysql->fetch_array($mysql->query("SELECT episode_url,episode_local,episode_type FROM ".$tb_prefix."episode WHERE episode_id = '".$id."'"));

	$type =$rs['episode_type'];

	if($rs['episode_local'])

		$url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];

	else $url=$rs['episode_url'];

if ($type==2)

	$flash=$url;

	



elseif ($type==30)

	$flash=str_replace('http://www.megavideo.com/?v=','http://wwwstatic.megavideo.com/mv_player.swf?image=http://ken365.com/images/logo.gif&v=',$rs['episode_url']);



else

{

	switch ($type) 	{

		case 7:		$url=str_replace('http://video.tamtay.vn/video/play/config/','',$url);

					$url=$linkgrabvn.'/tamtay/'.$url.'/'.md5($hash.$url).'.flv';	break;

		case 8:		$url=get_link_timnhanh($url,1);	break;

		case 11:	$url=get_link_clipvn($url);	break;

		case 12:	$url=get_link_blog($url,1);	break;

		case 29:	$url=get_link_google($url); break;

		case 31:	$url=get_link_dailymotion($url,1);	break;

		case 32:	$url=get_link_youtube($url);	break;

		case 33:	$url=get_link_veoh($url);	break;

		case 34:	$url= get_link_videozing($url,1);	break;

					}

/*	$flash=$mainURL."/flash/player.swf?file=".$url."&plugins=drelated-1&drelated.dxmlpath=".$mainURL."/f/relate/".$id.".xml&drelated.dposition=bottom&drelated.dskin=/flash/skin/relate/grayskin.swf&drelated.dtarget=_self&skin=".$mainURL."/flash/skin/dangdang.swf&image=".$img."&autostart=false&repeat=false&logo=/logo.png&stretching=exactfit&allowfullscreen=true&wmode=\"opaque\"&allowscriptaccess=\"always\"&volume=100";*/

//$url = replacechar($url);

$flash=$mainURL."/flash/player.swf?file=".$url."&skin=".$mainURL."/flash/skin/dangdang.swf&image=".$img."&autostart=false&repeat=false&logo=/logo.png&stretching=exactfit&allowfullscreen=true&wmode=\"opaque\"&allowscriptaccess=\"always\"&volume=100";

	

}	}



	header('Location: '.$flash.'');



?>