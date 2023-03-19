<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
include('inc/_functions.php');
$episode_id= intval($_GET['episode_id']);
$rs = $mysql->fetch_array($mysql->query("SELECT episode_url,episode_local,episode_type FROM ".$tb_prefix."episode WHERE episode_id = '".$episode_id."'"));
	if($rs['episode_local'])
		$url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
	else
		$url=$rs['episode_url'];	
	if ($rs['episode_type']==7)
		$url=str_replace('/config/','/',$url);
	elseif ($rs['episode_type']==11)
		$url=str_replace('/w/','/watch/',$url);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
     "http://www.w3.org/TR/html4/frameset.dtd">
  <HTML>
  <HEAD>
  <TITLE>Xem Phim Online</TITLE>
  </HEAD>
<script type="text/javascript">if (self.parent.frames.length != 0) self.parent.location.replace(document.location.href);</script>	<frameset rows="100%,*" cols="*" id="mainFrameset">

		<frame src="<?=$url?>" name="frame_navigation" frameborder="0" noresize />		
		<frame src="#" name="frame_content" id="frame_content" frameborder="0" noresize />

  </HTML>
