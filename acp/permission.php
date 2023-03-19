<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$mod_permission = acp_get_mod_permission();

$permission_list = array(
	'add_cat'	=>	'Thêm Thể Loại',
	'edit_cat'	=>	'Quản Lý Và & Thể Loại',
	'del_cat'	=>	'Xóa Thể Loại',
	'add_film'	=>	'Thêm Phim',
	'edit_film' =>	        'Quản Lý & Sửa Phim',
	'del_film'	=>	'Xóa Phim',
	'add_link'	=>	'Thêm Quảng Cáo',
	'edit_link'	=>	'Quản Lý & Sửa Quảng Cáo',
	'del_link'	=>	'Xóa Quảng Cáo',
);

if (!$_POST['submit']) {
?>
<form method="post">
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td colspan=2 class=title align=center>PERMISSION FOR MOD</td></tr>
<?php
foreach ($permission_list as $name => $desc) {
?>
<tr>
	<td class=fr width=30%><b><?=$desc?></b></td>
	<td class=fr_2><input type="radio" class="checkbox" value="1" name=<?=$name?><?=(($mod_permission[$name])?' checked':'')?>> YES <input type="radio" class="checkbox" value="0" name=<?=$name?><?=((!$mod_permission[$name])?' checked':'')?>> NO </td>
</tr>
<?php
}
?>
<tr><td class=fr colspan=2 align=center><input type="submit" name="submit" class="submit" value="SUBMIT"></td></tr>
</table>
</form>
<?php
}
else {
	$per = '';
	foreach ($permission_list as $name => $desc) {
		$v = $_POST[$name];
		if ($v == '') $v = 0;
		$per .= $v;
	}
	$per = bindec($per);
	$mysql->query("UPDATE ".$tb_prefix."config SET cf_permission = '".$per."' WHERE cf_id = 1");
	echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=$link'>";
}
?>