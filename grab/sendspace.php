<?php
include('encode.php');
$id=$_GET['id'];
$cache='cache/sendspace/'.str_replace('/','_',$id).'.txt';
function grab_sendspace($id){
	global $cache;
	$string=grab_link('http://www.sendspace.com/file/'.$id,'http://www.sendspace.com/file/'.$id,'download=REGULAR DOWNLOAD','');
	$urlfile=getStr($string,'class="mango" href="','"');
	if ($urlfile!="") @file_put_contents($cache,'id_clip='.return_time().'id_clip='.$urlfile);
        else{
          $string=grab_link('http://www.sendspace.com/file/'.$id,'http://www.sendspace.com/file/'.$id,'download=REGULAR DOWNLOAD','SID=67c865908caa5c47658285e629a328fd; ssui=6b8527bfb7621451e7a3c5603ef68012; hi=113.170.158.18-1274966039;__qca=P0-1037327789-1274966047621');
          $urlfile=getStr($string,'class="mango" href="','"');
          if ($urlfile!="") @file_put_contents($cache,'id_clip='.return_time().'id_clip='.$urlfile);
        }
	return $urlfile;
}
if (isset($id) && check_time($_GET['t'])){
	if (file_exists($cache)){
		$html=file_get_contents($cache);
		$time=explode('id_clip=',$html);
		$now=return_time();
		if ((($now-$time[1])<=5) && (($now-$time[1])>=0)){
			$urlfile=$time[2];
		}else{
			$urlfile=grab_sendspace($id);
		}
	}else{
		$urlfile=grab_sendspace($id);
	}
header("Location: ".$urlfile);
}
?>