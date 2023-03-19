<?php
include('encode.php');
$id=$_GET['id'];
if (isset($id) && check_time($_GET['t'])){
	$code=grab_link('http://clips.goonline.vn/pages/watch.aspx?id='.$id,'','','');
	$streamer=getStr($code,'value="sp=','&amp;fn=');
	 $file=getStr($code,'&amp;fn=','"');
	if (($streamer) && ($file)) $urlfile="file=$file.flv&streamer=rtmp://$streamer";
	header("Location: http://vuaphim.vn/player.swf?$urlfile&skin=http://vuaphim.vn/skin.swf&autostart=true");
}
?>