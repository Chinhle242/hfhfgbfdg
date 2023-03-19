<?php

define('IN_MEDIA',true);
$value = array();
if ($user) $value = split('/','/'.$user);
if ($value[1]=='home') {
	$uid = trim(urldecode($value[2]));
	$q = $mysql->query("SELECT user_name,user_id,user_fullname,user_email,user_avatar,user_level FROM ".$tb_prefix."user WHERE user_name = '".$uid."'");
	$r = $mysql->fetch_array($q);
	if ($r['user_id']=="") $warn="Không có thành viên này!";
	if ($r['user_level']==1) $level="Member - Thành viên";
	elseif ($r['user_level']==2) $level="Moderator - Mod";
	elseif ($r['user_level']==3) $level="Admin - Quản Trị Viên";
	elseif ($r['user_level']==4) $level="Collborators - Cộng Tác Viên";
	if ($r['user_avatar']=="") $avatar=$web_link."/no-avatar.gif";
	else $avatar=$r['user_avatar'];
	if ($isLoggedIn && ($r['user_name']==$_SESSION['user_name'])) $show='block';
	else $show='none';
	if ($_POST['user_edit']) {
		
		$warn = '';
		if (!$isLoggedIn)$warn.="Bạn chưa đăng nhập!<br/>";
		$avatar = stripslashes(trim(urldecode($_POST['user_avatar'])));
		$fullname = stripslashes(urldecode($_POST['user_fullname']));
		$pwd = md5(stripslashes(urldecode($_POST['user_pwd'])));
		$pwd_new = stripslashes(urldecode($_POST['user_pwdn']));
		$pwd_new2 = stripslashes(urldecode($_POST['user_pwdn2']));
		$email = stripslashes(urldecode($_POST['user_email']));
		$q = $mysql->query("SELECT user_password,user_email FROM ".$tb_prefix."user WHERE user_name = '".$name."' ");	
		$r = $mysql->fetch_array($q);
		if (($email=="") || (substr_count($email ,'@')==0))	$email=$r['user_email'];
		if (($pwd_new!="") && ($pwd_new==$pwd_new2)){
			if($pwd==$r['user_password']){
				$mysqlvalue="user_password = '".$pwd_new."' ,";
				$change_pwd=true;
			}else $warn.="Để có thể thay đổi mật khẩu, bạn cần phải nhập chính xác mật khẩu cũ!<br/>";
		}
		$mysqlvalue.="user_avatar='".$avatar."',"."user_fullname='".$fullname."',"."user_email='".$email."'";
		if (!$warn){
			$mysql->query("UPDATE ".$tb_prefix."user SET ".$mysqlvalue." WHERE user_id = '".$_SESSION['user_id']."'");			
		}
	}
	$main = $temp->get_tpl('user_info');
	$main = $temp->replace_value($main,array(
			'fullname' 		=> $r['user_fullname'],
			'name' 		    => $r['user_name'],
			'email' 		=> $r['user_email'],
			'level' 		=> $level,
			'avatar' 		=> $avatar,
			'warn' 		    => $warn,
			'edit_warn' 	=> $warn,
			'show_home'          => $show,
			)
		);
	$web_keywords_main = $web_title_main = "Thông Tin thành viên || ".$r['user_name']." || ".$title_web;
}
elseif ($value[1]=='reg') { 
	if ($isLoggedIn) {
	echo "<center><b>Bạn đã đăng nhập</b></center>";
	exit();
	}
	if ($_POST['reg']) {
		$warn = '';
		$name = stripslashes(trim(urldecode($_POST['reg_name'])));
		$pwd = md5(stripslashes(urldecode($_POST['reg_pwd'])));
		$pwd2 = md5(stripslashes(urldecode($_POST['reg_pwd2'])));
		$fullname = stripslashes(urldecode($_POST['reg_fullname']));
		$email = stripslashes(urldecode($_POST['reg_email']));
		$avatar = stripslashes(urldecode($_POST['reg_avatar']));
		$check = $_POST['reg_agree'];
		
		if ($name=='') $warn .= "- Bạn chưa nhập tên đăng nhập - username!<br>";
                if (strtolower($name)==array('admin','mod','uploader')) $warn .= "- Bạn không được lấy tên đăng nhập này!<br>";
		if ($check!='on') $warn .= "- Bạn chưa đồng ý với các điều khoản trên!<br>";
		if ($pwd!=$pwd2) $warn .= "- Xác nhận mật khẩu không đúng!<br>";
		if ($mysql->num_rows($mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_name = '".$name."'"))) $warn .= "- Tài khoản này đã có người sử dụng<br>";
		if (!$warn){
				//$mysql->query("INSERT INTO ".$tb_prefix."user (user_name,user_password)");
				$mysql->query("INSERT INTO ".$tb_prefix."user (user_name,user_password,user_fullname,user_email,user_avatar,user_level) VALUES ('".$name."','".$pwd."','".$fullname."','".$email."','".$avatar."','1')");
				if (substr_count($lastvisit ,$web_link)!=0) header("Location: ".$lastvisit);
				else header("Location: ./login.html");
			}
		}
	$main = $temp->get_tpl('register');
	$main = $temp->replace_value($main,array(
				'reg_err'			=>	$warn,
			)
		);
	$web_keywords_main = $web_title_main = "Đăng ký thành viên || ".$title_web;
}
elseif ($value[1]=='login') { 
	if ($isLoggedIn) {
	//echo "<center><b>Bạn đã đăng nhập</b></center>";
	header("Location: ".$web_link."/index.php");
	exit();
	}
	if ($_POST['login']) {
		
		$name = stripslashes(trim(urldecode($_POST['name'])));
		$pwd = stripslashes(urldecode($_POST['pwd']));
		$q = $mysql->query("SELECT user_id, user_ban, user_ban_time FROM ".$tb_prefix."user WHERE user_name = '".$name."' AND user_password = '".md5($pwd)."'");
		if (!$mysql->num_rows($q)) {
			if (m_check_random_str($pwd,15))
				$q = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_name = '".$name."' AND (user_new_pass = '".$pwd."' AND user_new_pass != '')");
			if (!$mysql->num_rows($q)) $warn .= "Username hoặc mật khẩu không chính xác<br>";
		}
		else {
			$r = $mysql->fetch_array($q);
			if ($r['user_ban']==1){
				$bannedday=date('Ymd',$r['user_ban_time']);
				$day_now=date('Ymd',NOW);
				if (($day_now-$bannedday)<=100){
					$next=false;
					$warn .= "Xin lỗi , Tài khoản bạn vừa đăng nhập đã bị site liệt kê vào danh sách đen vào ngày ".date('d-m-Y',$r['user_ban_time'])." và sẽ hết được loại khỏi danh sách đen sau thời gian quy định của website.<br>";				
				}else {
					$next=true;
					$mysql->query("UPDATE ".$tb_prefix."user SET user_ban = 1 WHERE user_id =".$r['user_id']."");
					$mysql->query("UPDATE ".$tb_prefix."user SET user_ban_time = '' WHERE user_id user_id =".$r['user_id']."");
				}
			}else $next=true;
			if($next){
				$_SESSION['user_id'] = $r['user_id'];
				$_SESSION['user_name']=$r['user_name'];
				$salt = 'Nothing';
				$identifier = md5($salt.$r['user_id'].$salt);
				m_setcookie('USER', $identifier);
				$mysql->query("UPDATE ".$tb_prefix."user SET user_identifier = '".$identifier."' WHERE user_id = '".$r['user_id']."'");
				if (substr_count($lastvisit ,$web_link)!=0) header("Location: ".$lastvisit);
				else header("Location: ".$web_link."/index.php");
			}
		}
	}
	$main = $temp->get_tpl('login');
	$main = $temp->replace_value($main,array(
				'login_err'			=>	$warn,
			)
		);
	$web_keywords_main = $web_title_main = "Đăng nhập vào website || ".$title_web;
}
elseif ($value[1]=='logout'){
	if (!$isLoggedIn) {
	header("Location: ".$web_link."/index.php");
	}
	else {
		$mysql->query("UPDATE ".$tb_prefix."user SET user_identifier = '' WHERE user_id = '".$_SESSION['user_id']."'");
		m_setcookie('INFO', '', false);
		session_destroy();
		header("Location: ".$web_link."/index.php");
	}
}
elseif ($value[1]=='lost'){
	if ($_POST['forgot']) {
	$warn = '';
	$email = trim(urldecode($_POST['email']));
	$q = $mysql->query("SELECT user_name FROM ".$tb_prefix."user WHERE user_email = '".$email."'");
	if ($mysql->num_rows($q)) {
		$r = $mysql->fetch_array($q);
		$user_name = $r['user_name'];
		$new_password = m_random_str(15);
		$web_email = get_data('cf_web_email','config','cf_id',1);('');
		$title = "Mật khẩu mới - ".$webTitle;
		$header = m_build_mail_header($email,$web_email);
		$content = "Chao <b>".$user_name."</b>,<br>".
			"Mat khau moi cua ban : <b>".$new_password."</b> <br>".
			"Ban nho doi mat khau lai ngay sau khi dang nhap.<br>".
			"<a href='".$web_link."'><b>".$web_title."</b></a>";
		if ( mail($email,$title,$content,$header) ) {
			$mysql->query("UPDATE ".$tb_prefix."user SET user_new_password = '".$new_password."' WHERE user_name = '".$user_name."'");
		}
		else $warn .= "Host không hỗ trợ Mail";
	}
	else $warn .= "Không có email này";
	if (!$warn) $warn.="Mật khẩu mới sẽ được gởi đến email của bạn trong vài phút nữa.<br>Bạn nhớ đổi mật khẩu lại ngay sau khi đăng nhập";
}
$main = $temp->get_tpl('forgot');
$main = $temp->replace_value($main,array(
			'forgot_err'			=>	$warn,
		)
	);
	$web_keywords_main = $web_title_main = "Lấy lại mật khẩu || ".$title_web;
}
elseif ($value[1]=='request'){
	if (!$isLoggedIn) {
	header("Location: ".$web_link."/index.php");
	}
	else {
		if ($_POST['request_user']) {
		$warn = '';
		$request_content = bad_words($_POST['request_content']);
		$request_name = bad_words($_POST['request_name']);
		$request_user_id = $_SESSION['user_id'];
		if ($request_name){
		$mysql->query("INSERT INTO ".$tb_prefix."request (request_user_id,request_name,request_content) VALUES ('".$request_user_id."','".$request_name."','".$request_content."')");
		$warn.="Chúng tôi sẽ sớm cập nhật phim bạn yêu cầu!";
		}
		else $warn .= "Bạn chưa nhập tên phim bạn muốn yêu cầu!";
	}
	}
	$main = $temp->get_tpl('user_request');
	$main = $temp->replace_value($main,array(
			'request_err'			=>	$warn,
		)
	);
	$web_keywords_main = $web_title_main = "Yêu cầu phim || ".$title_web;
}
?>