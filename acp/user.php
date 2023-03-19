<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if ($level != 3) {

	echo "Ban Khong Du Quyen Truy Cap.";

	exit();

}
$edit_url = 'index.php?act=user&mode=edit';

$inp_arr = array(
		'name'		=> array(
			'table'	=>	'user_name',
			'name'	=>	'USER NAME',
			'type'	=>	'free',
		),
		'fullname'	=> array(
			'table'	=>	'user_fullname',
			'name'	=>	'Full Name',
			'type'	=>	'free',
		),
		'email'	=> array(
			'table'	=>	'user_email',
			'name'	=>	'Email',
			'type'	=>	'free',
		),
		'avatar'	=> array(
			'table'	=>	'user_avatar',
			'name'	=>	'Avatar',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'password'	=> array(
			'table'	=>	'user_password',
			'name'	=>	'PASSWORD',
			'type'	=>	'password',
			'always_empty'	=>	true,
			'update_if_true'	=>	'trim($password) != ""',
			'can_be_empty'	=>	true,
		),
		'ban'	=> array(

			'table'	=>	'user_ban',
			'name'	=>	'Ban Nick',
			'type'	=>	"function::acp_user_ban",
		),
		'level'	=> array(
			'table'	=>	'user_level',
			'name'	=>	'PERMISSION',
			'type'	=>	'function::acp_user_level::number',
		),
		
);

##################################################
# ADD USER
##################################################
if ($mode == 'add') {
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$password = md5(stripslashes($_POST['password']));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'user'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('ADD USER',$inp_arr,$error_arr);
}
##################################################
# EDIT USER
##################################################
if ($mode == 'edit') {
	if ($us_del_id) {
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."user WHERE usre_id = ".$us_del_id);
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">
		WOULD YOU LIKE TO SCRUB?<br>
		<input value="YES" name=submit type=submit class=submit>
		</form>
		<?
	}
	elseif ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			$in_sql = implode(',',$arr);
			$mysql->query("DELETE FROM ".$tb_prefix."user WHERE user_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		elseif ($_POST['selected_option'] == 'ban') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."user SET user_ban = 1 WHERE user_id IN (".$in_sql.")");
			$mysql->query("UPDATE ".$tb_prefix."user SET user_ban_time = '".NOW."' WHERE user_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		elseif ($_POST['selected_option'] == 'no_ban') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."user SET user_ban = 0 WHERE user_id IN (".$in_sql.")");
			$mysql->query("UPDATE ".$tb_prefix."user SET user_ban_time = '' WHERE user_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
	}
	elseif ($us_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_id = '$us_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = (($r[$arr['table']]));
			
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				if ($_POST['password']) $password = md5(stripslashes($_POST['password']));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'user','user_id','us_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT USER',$inp_arr,$error_arr);
	}
	else {
		$m_per_page = 30;
		$order="";
		if (!$pg) $pg = 1;
		if ($user_ban) {
			$extra = " user_ban = 1";
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_ban = 1 ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		}elseif ($point){
			$extra = " user_level = 2 OR user_level = 3";
			 $q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_level = 2 OR user_level = 3 ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
			
		}else{
			$search = trim(urldecode($_GET['search']));
			$extra = (($search)?"user_name LIKE '%".$search."%' ":'');
			
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."user ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY user_name ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		}
		$tt = $mysql->num_rows($mysql->query("SELECT user_id FROM ".$tb_prefix."user".(($extra)?" WHERE ".$extra:'')));
		
		if ($tt) {
			if ($search) {
				$link2 = preg_replace("#&search=(.*)#si","",$link);
			}
			else $link2 = $link;
			
			echo "<br>SEARCH USER : <input id=search size=20 value=\"".$search."\"> <input type=button onclick='window.location.href = \"".$link2."&search=\"+document.getElementById(\"search\").value;' value=GO><br><br>";
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "<tr align=center><td width=3%><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td><td class=title width=30%>USER NAME</td><td class=title>PERMISSION</td><td class=title>Post Count</td><td class=title>Mark</td><td class=title>Banned</td><td class=title>Banned Date</td></tr>";
			while ($r = $mysql->fetch_array($q)) {
			    $id = $r['user_id'];
				$name = $r['user_name'];
				$post = $r['user_point'];
				$banned  = ($r['user_ban'])?'<font color=red><b>X</b></font>':'';
				if ($r['user_ban_time']!="") $banned_date= date('d-m-Y',$r['user_ban_time']);
				$level = $r['user_level'];
	            switch ($level) {
					case 1 : $level = 'Member';	break;
		            case 2 : $level = 'Moderator';	break;
		            case 3 : $level = 'Admin';	break;
		        }
				echo "<tr><td><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><a href='$link&us_id=".$id."'><b>".$name."</b></a></td><td class=fr_2 align=center>".$level."</td><td class=fr align=center>".$post."</td><td class=fr align=center>".$post*5 ."</td><td class=fr align=center>".$banned."</td><td class=fr_2 align=center>".$banned_date."</td></tr>";
			}
			echo "<tr><td colspan=3>".admin_viewpages($tt,$m_per_page,$pg)."</td></tr>";
			echo '<tr><td colspan=3 align="center">WITH USERS CHOOSED '.
				'<select name=selected_option><option value=del>DELETE</option>'.
				'<option value=ban>Banned Member</option>'.
				'<option value=no_ban>UnBanned Member</option>'.
				'</select>'.
				'<input type="submit" name="do" class=submit value="SEND"></td></tr>';
			echo '</form></table>';
		}
		else echo "THERE IS NO USERS";
	}
	
}
?>