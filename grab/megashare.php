<?php
include('encode.php');
$id=$_GET['id'];
$cache='cache/megashare/'.str_replace('/','_',$id).'.txt';
function grab_megashare($id){
	global $cache;
	$url='http://megashare.vn/dl.php/'.$id;
	$code=grab_link($url,'','','','PHPSESSID=ST6103cbkDQ1xl4RAJHVabqIlgcas; Megavnn=movewho; OpenID=https%3A%2F%2Fwww.google.com%2Faccounts%2Fo8%2Fid%3Fid%3DAItOawl2Ck6-XirZ-dMWjTiuLh_eb7hM6LN6vbY');
	$u=getStr($code,'a href=\"','\">');
	if ($u!="") @file_put_contents($cache,'id_clip='.return_time().'id_clip='.$u);
	return $u;
}
if (isset($id) && check_time($_GET['t'])){
	if (file_exists($cache)){
		$html=@file_get_contents($cache);
		$time=explode('id_clip=',$html);
		$now=return_time();
		if ((($now-$time[1])<=25) && (($now-$time[1])>=0)){
			$u=$time[2];
		}else{
			$u=grab_megashare($id);
		}
	}else{
		$u=grab_megashare($id);
	}
header("Location: ".$u);
}
?>