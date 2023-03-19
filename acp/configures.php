<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

if ($level != 3) {

	echo "Bạn không có quyền vào trang này.";

	exit();

}

if ($_POST['submit']) {

	$web_name = $_POST['web_name'];

	$web_link = $_POST['web_link'];

	$web_key = $_POST['web_key'];

	$web_email = $_POST['web_email'];

	$site_off = $_POST['site_off'];

	$web_keywords = $_POST['web_keywords'];	

	$per_page = $_POST['per_page'];

	$announcement = $_POST['announcement'];		
	
	$protect=$_POST['protect'];
	
	$server_inv=$_POST['server_inv'];

	$sql =  "UPDATE ".$tb_prefix."config SET cf_web_name = '$web_name', cf_web_link = '$web_link', cf_web_keywords = '$web_key', cf_web_email = '$web_email', cf_site_off = '$site_off', cf_web_keywords = '$web_keywords', cf_per_page = '$per_page', cf_announcement = '$announcement', cf_protect = '$protect' , cf_server_inv = '$server_inv'  WHERE cf_id = 1";

	$mysql->query($sql);

	echo "EDIT FINISH! <meta http-equiv='refresh' content='0;url=?act=config'>";

}

else{ 
$q = $mysql->query("SELECT * FROM ".$tb_prefix."config WHERE cf_id = 1");

$rs = $mysql->fetch_array($q);

?>

<form method="post" name= "configures" action="?act=config&id=1">

<table class=border cellpadding=2 cellspacing=0 width=95%>

<tr><td colspan=2 class=title align=center>Cấu Hình</td></tr>

<tr>

	<td class=fr width=30%><b>Tên Web</b></td>

	<td class=fr_2>

		<input name=web_name size=50 value="<?=$rs['cf_web_name']?>">

	</td>

</tr>

<tr>

	<td class=fr width=30%>

		<b>Link</b>

		</td>

	<td class=fr_2>

		<input name=web_link size=50 value="<?=$rs['cf_web_link']?>">

		</td>

</tr>

<tr>

	<td class=fr width=30%><b>Web Keywords</b></td>

	<td class=fr_2>

		<input name=web_keywords size=50 value="<?=$rs['cf_web_keywords']?>">

	</td>

</tr>

<tr>

	<td class=fr width=30%>

	<b>Web mail</b></td>

	<td class=fr_2>

	<input name=web_email size=50 value=<?=$rs['cf_web_email']?>>

	</td>

</tr>

<tr>

	<td class=fr width=30%><b>Dừng Hoạt Động</b></td>

	<td class=fr_2>

	    <select name=site_off>

		<?php

		echo "<option value=0".(($rs['cf_site_off']==0)?' selected':'').">No</option>".

		"<option value=1".(($rs['cf_site_off']==1)?' selected':'').">Yes</option>";

		?>

		</select>

	</td>

</tr>

<tr>
	<td class=fr width=30%><b>Bảo vệ Website</b></td>
	<td class=fr_2>
	    <select name=protect>
		<?php	
		echo "<option value=0".(($rs['cf_protect']==0)?' selected':'').">Không</option>".
		"<option value=1".(($rs['cf_protect']==1)?' selected':'').">Kiểm tra Cookie</option>";
		?>
		</select>
	</td>
</tr>

<tr>
	<td class=fr width=30%><b>Server lỗi</b></td>
	<td class=fr_2>
	    <input name=server_inv size=10 value=<?=$rs['cf_server_inv']?>>
	</td>
</tr>

<tr>

	<td class=fr width=30%><b>Số Kết Quả Hiển Thị</b></td>

	<td class=fr_2>

	<input name=per_page size=10 value=<?=$rs['cf_per_page']?>>

	</td>

</tr>



<tr>

	<td class=fr width=30%><b>Thông Báo</b></td>

	<td class=fr_2>

	<textarea cols=60 rows=10 name="announcement" id="announcement"><?=$rs['cf_announcement']?></textarea>

	<script language="JavaScript">generate_wysiwyg('announcement');</script>

	</td>

</tr>



<tr><td class=fr colspan=2 align=center>

<input type=submit name=submit class=submit value=SUBMIT></td></tr>

</table>

</form>

<?php
}
?>