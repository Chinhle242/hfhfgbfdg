<?php
define('IN_MEDIA', true);
session_start();
@include("inc/_data.php");
include('inc/_settings.php');
include("inc/_functions.php");

if ($isLoggedIn) {
	echo "<center><b>Bạn đã đăng nhập</b></center>";
	exit();
}
if (isset($_POST["submit"]))  {
	$warn = '';
	$name = htmlchars(stripslashes(trim(urldecode($_POST['name']))));
	$pwd = stripslashes(urldecode($_POST['password']));
	$hte_salt = $mysql->query("SELECT salt FROM ".$forum_name.".".$forum_prefix."user WHERE username = '".$name."'");
			while ($THT = $mysql->fetch_array($hte_salt)) {
					$salt = $THT['salt'];
			}
	$q = $mysql->query("SELECT userid FROM ".$forum_name.".".$forum_prefix."user WHERE username = '".$name."' AND password = '".md5(md5($pwd) . $salt)."'");
	if (!$mysql->num_rows($q)) {
		echo "<center><b>Lỗi</b> :Tên đăng nhập hoặc mật khẩu sai !<br>
		Nhấn vào <a href=\"javascript:history.go(-1);\">đây</a> để quay lại</center>";

	}
	else {
		$r = $mysql->fetch_array($q);
		$_SESSION['is_logged_in'] = true;
		setcookie('UserCookie',$r['userid'], time()+604800);  // Luu Cookie 1 tuan
		$mysql->query("UPDATE  ".$forum_name.".".$forum_prefix."session SET lastactivity='".NOW."',host='".IP."',userid = '".$r['userid']."' WHERE sessionhash='".SID."'");
		$mysql->query("UPDATE ".$forum_name.".".$forum_prefix."user SET lastactivity  = '".NOW."' WHERE userid = '".$r['userid']."'");	
	    header('Location: '.$_POST['current_link'].'');
			}

	exit();
}

?>