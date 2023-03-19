<?
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$view_url = 'index.php?act=request&mode=edit';

$inp_arr = array(
         'request_name'	=> array(
			'table'	=>	'request_name',
			'name'	=>	'REQUEST NAME',
			'type'	=>	'free'
		),
		'request_content'	=>	array(
			'table'	=>	'request_content',
			'name'	=>	'CONTENT MOVIE',
			'type'	=>	'free',
		),
		
);
##################################################
# UPDATE REQUEST
##################################################
if ($mode == 'edit') {
	if ($request_del_id) {	
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."request WHERE request_id = '".$request_del_id."'");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">WOULD YOU LIKE TO SCUB?<br><input value="YES" name=submit type=submit class=submit></form>
		<?
	}
	elseif ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			$in_sql = implode(',',$arr);
			$mysql->query("DELETE FROM ".$tb_prefix."request WHERE request_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		elseif ($_POST['selected_option'] == 'updated') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."request SET request_status = 1 WHERE request_user_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
	}
	elseif ($request_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."request WHERE request_id = '$request_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'request','request_id','request_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$view_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('VIEW INFO OF REQUEST',$inp_arr,$error_arr);
	}
	else {
		$request_per_page = 30;
		if (!$pg) $pg = 1;
		$search = strtolower(get_ascii(urldecode($_GET['search'])));
		$extra = (($search)?"request_name LIKE '%".$search."%' ":'');
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."request ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY request_id DESC LIMIT ".(($pg-1)*$request_per_page).",".$request_per_page);
		$tt = get_total('request','request_id',"".(($extra)?"WHERE ".$extra." ":'')."");
		if ($mysql->num_rows($q)) {
			if ($search) {
				$link2 = preg_replace("#&search=(.*)#si","",$link);
			}
			else $link2 = $link;
			echo "<br>REQUEST SEARCH : <input id=search size=20 value=\"".$search."\"> <input type=button onclick='window.location.href = \"".$link2."&search=\"+document.getElementById(\"search\").value;' value=GO><br><br>";
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "	<tr align=center>
						<td width=3% class=title>
							<input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall>
						</td>
						<td class=title width=50%>
							Phim Yêu Cầu
						</td>
						<td class=title>
							Gợi Ý Phim
						</td>
						<td class=title>
							Thành Viên 
						</td>	
						<td class=title>
							Trạng Thái 
						</td>
						</tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['request_id'];
				$name = $r['request_name'];
				$content = $r['request_content'];
				$user_name=get_data('user_name','user','user_id',$r['request_user_id']);
				$status  = ($r['request_status'])?'<font color=blue><b>Cập nhật thành công</b></font>':'<font color=red><b>Chưa Hoàn Thành</b></font>';
				echo "<tr>
						<td class=fr align=center>
							<input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id>
						</td>
						<td class=fr_2>
							<b><a href=$link&request_id=".$id.">".$name."</a></b>
						</td>
						<td class=fr_2 align=center>
							".$content."
						</td>
						<td class=fr_2 align=center>
							".$user_name."
						</td>
						<td class=fr_2 align=center>
							".$status."
						</td>
						</tr>";
			}
			echo "<tr><td colspan=5>".admin_viewpages($tt,$request_per_page,$pg)."</td></tr>";
			echo '<tr><td colspan=5 align="center">Yêu Cầu & Chọn Lựa '.
				'<select name=selected_option><option value=del>Xóa</option>'.
				'<option value=updated>Cập nhật phim yêu cầu</option>'.
				'</select>'.
				'<input type="submit" name="do" class=submit value="Gửi"></td></tr>';
			echo '</form></table>';
		}
		else echo "THERE IS NO REQUESTS";
    }
}
?>