<?php
include('encode.php');
$id=$_GET['id'];

$change=$_GET['t'];
if (isset($id) && check_time($change)){
	$url='http://www.4shared.com/embed/'.$id;
	$code=grab_link($url,'','','','');
	$link=getStr($code,"file=","&");
	header("Location: ".$link);
}
?>