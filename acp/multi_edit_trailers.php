<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

if (!$_GET['id']) die('ERROR');

$id = $_GET['id'];

if (!$_POST['submit']) {

?>

<form enctype="multipart/form-data" method=post>

<table class=border cellpadding=2 cellspacing=0 width=95%>

<tr><td colspan=2 class=title align=center>Sửa Nhiều Tập Phim</td></tr>

<tr>

	<td class=fr width=30%><b>Danh Sách</b></td>

	<td class=fr_2>

	<?php

	$in_sql = $id;

	$q = $mysql->query("SELECT * FROM ".$tb_prefix."trailers WHERE trailers_id IN (".$in_sql.")");

	while ($r = $mysql->fetch_array($q)) {

		echo '+ <b>'.$r['trailers_name'].'</b> - <b><font color=red>'.check_data(get_data('film_name','film','film_id',$r['trailers_film'])).'</font><br>';

	}

	?>

	</td>

</tr>

<tr>Chọn Film</b></td>

	<td class=fr_2><?=acp_film(NULL,1)?></td>

</tr>



<tr>

	<td class=fr width="30%">

		<b>Thêm Nhanh Film</b>

		<br>If database ised havent Web is gently self-made</td>

	<td class=fr_2>

	<table cellpadding=2 cellspacing=0 width=100%>	

	<tr>

	<td width="40%" align="right"><b>Tên Film</b></td>

	<td><input name="new_film" size="50"></td>

    </tr>

    <tr>

	<td width="40%" align="right"><b>Tên Thật</b></td>

	<td><input name="name_real" size="50"></td>

    </tr>

	<tr>

	<td width="40%" align="right"><b>Hình Ảnh</b></td>

	<td class=fr_2><input name="upload_img" size="37" type="file"><BR /><BR />

	    <input name="url_img" size="49"></td>

    </tr>

	<tr>

	<td width="40%" align="right"><b>Đạo Diễn</b></td>

	<td><input name="director" size="50"></td>

    </tr>

	<tr>

	<td width="40%" align="right"><b>Diễn Viên</b></td>

	<td><input name="actor" size="50"></td>

    </tr>

	<tr>

	<td width="40%" align="right"><b>Sản Xuất</b></td>

	<td><input name="area" size="50"></td>

    </tr>

    <tr>

	<td width="40%" align="right"><b>Thời Lượng</b></td>

	<td><input name="time" size="50"></td>

    </tr>

	<tr>

	<td width="40%" align="right"><b>Năm Sẳn Xuất</b></td>

	<td><input name="year" size="50"></td>

    </tr>

	<tr>

	<td width="40%" align="right"><b>Thể Loại</b></td>

	<td><?=acp_cat()?></td>

    </tr>

	<tr>

	<td colspan="2" align="center" style="padding-top:15px;"><textarea name="info" id="info" cols="100" rows="15"></textarea>

    <script language="JavaScript">generate_wysiwyg('info');</script></td>

    </tr>

	</table>

	</td>

</tr>



<tr><td class=fr colspan=2 align=center><input type="submit" name="submit" class="submit" value="Thực Hiện"></td></tr>

</table>

</form>

<?php

}

else {

	if ($new_film) {

	            if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))

				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];

				else $new_film_img = $_POST['url_img'];

				$film = acp_quick_add_film($new_film,$name_real,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info);

	}	

    $in_sql = $id;

	$t_film = $film;

	$sql = '';

	if ($t_film != 'dont_edit') $sql .= "trailers_film = '".$t_film."',";

	$sql = substr($sql,0,-1);

	if ($sql) $mysql->query("UPDATE ".$tb_prefix."trailers SET ".$sql." WHERE trailers_id IN (".$in_sql.")");

	echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=index.php?act=film&mode=edit'>";

}

?>