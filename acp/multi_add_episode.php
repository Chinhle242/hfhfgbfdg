<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");


if ((!$_POST['ok']) AND (!$_POST['submit']))  {

?>

<form method="post">

<table class=border cellpadding=2 cellspacing=0 width=30%>

<tr><td class=title align=center colspan=2>Thêm Phim Mới</td></tr>

<tr>

	<td class=fr align=center><input name="episode_begin" size="15" value="Thêm Tập Đầu" onclick="this.select()" style="text-align:center;background:violet;font-weight: bold;"></td>

</tr>

<tr>

	<td class=fr align=center><input name="episode_end" size="15" value="Thêm Tập Cuối" onclick="this.select()" style="text-align:center;background:yellow;font-weight: bold;"></td>
</tr>
<tr>
	<td class=fr align=center><input name="episode_part" size="15" value="Số phần mỗi tập" onclick="this.select()" style="text-align:center;background:#6CF;font-weight: bold;"></td>
</tr>

<tr><td class=fr align=center colspan=2><input type="submit" name="ok" class="submit" value="Done"></td></tr>

</table>

</form>

<?

}

else

{

$begin = $_POST['episode_begin'];

$end = $_POST['episode_end'];
$film_id= $_GET['film_id'];
$part = $_POST['episode_part'];
if(!is_numeric($part) || ($part<1) ) $part=1;
if(!$film_id)
$add_new_film ="<tr>

	<td class=fr width=\"15%\">

		<b>Thêm Phim Mới</b>
</td>

	<td class=fr_2>

	<table cellpadding=2 cellspacing=0 width=100%>	

	<tr>

	<td width=\"15%\" align=\"right\"><b>Tên Phim</b></td>

	<td width=\"85%\"><input name=\"new_film\" size=\"50\">

    </tr>

    <tr>

	<td width=\"15%\" align=\"right\"><b>Tên Tiếng Anh</b></td>
    <td><input name=\"name_real\" size=\"50\"></td>
    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Hình</b></td>

	<td ><input name=\"upload_img\" size=\"46\" type=\"file\">   --Tải Ảnh Lên

	    <input name=\"url_img\" size=\"50\">-Coppy Link Ảnh</td>

    </tr>


	<tr>

	<td width=\"15%\" align=\"right\"><b>Đạo Diễn</b></td>

	<td><input name=\"director\" size=\"50\"></td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Diễn Viên</b></td>

	<td><input name=\"actor\" size=\"50\"></td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Nhà Sản Xuất</b></td>

	<td><input name=\"area\" size=\"50\"></td>

    </tr>

    <tr>

	<td width=\"15%\" align=\"right\"><b>Thời Lượng</b></td>

	<td><input name=\"time\" size=\"50\"></td>

    </tr>

	<tr>

	<td width=\"20%\" align=\"right\"><b>Năm Phát Hành</b></td>

	<td><input name=\"year\" size=\"50\"></td>

    </tr>
	<tr>

	<td width=\"15%\" align=\"right\"><b>Từ Khóa</b></td>

	<td><input name=\"tag\" size=\"50\"></td>

    </tr>
		<tr>

	<td width=\"15%\" align=\"right\"><b>Quốc Gia</b></td>

	<td>".acp_country()."</td>

    </tr>

	<tr>
	<tr>

	<td width=\"15%\" align=\"right\"><b>Server</b></td>

	<td><input name=\"server\" size=\"50\" value=1 type=text></td>

    </tr>
	
	<tr>

	<td width=\"15%\" align=\"right\"><b>Hình Thức</b></td>
	<td><select name=\"cinema\"><option value=\"1\">- Chiếu Rạp</option><option value=\"0\" selected=\"selected\">- Không Chiếu Rạp</option></select></td></td>
	<tr>
    <tr>

	<td width=\"15%\" align=\"right\"><b>Complete: </b></td>
	<td><select name=\"complete\"><option value=\"1\" selected=\"selected\">- Hoàn Thành</option><option value=\"0\">- Chưa Hoàn Thành</option></select>&nbsp;&nbsp;<b>Phim bộ/lẻ</b> :<select name=\"type\"><option value=\"0\" selected=\"selected\">- Phim Lẻ</option><option value=\"1\">- Phim Bộ</option></select></td></td>
		
	<tr>
	<tr>

	<td width=\"15%\" align=\"right\"><b>Yêu Cầu</b></td>

	<td><input name=\"request\" size=\"50\" value=1 type=checkbox></td>

    </tr>
	

	<td width=\"15%\" align=\"right\"><b>Thể Loại</b></td>

	<td>".acp_cat()."</td>

    </tr>

	<tr>

	<td colspan=\"2\" align=\"center\" style=\"padding-top:15px;\"><textarea name=\"info\" id=\"info\" cols=\"100\" rows=\"15\"></textarea>

    <script language=\"JavaScript\">generate_wysiwyg('info');</script></td>

    </tr>

	</table>

	</td>

</tr>";
else $add_new_film ="<tr>

	<td class=fr width=15%><b>Choose Film</b></td>

	<td class=fr_2>".acp_film($film_id)."</td>

</tr>";
////BEGIN CHECK EPISODE

if(!is_numeric($begin) && !is_numeric($end)){

$episode_begin = 1;

$episode_end = 10;

}elseif(!is_numeric($begin)){


$episode_begin = $episode_end = $end;

}else{

$episode_begin = $begin; $episode_end = $end;

}

////END CHECK EPISODE

if (!$_POST['submit']) {

?>
<form enctype="multipart/form-data" method=post>

<table class=border cellpadding=2 cellspacing=0 width=95%>

<tr><td colspan=2 class=title align=center>Add episodes</td></tr>






<?=$add_new_film?>




<?php
$name=$episode_begin;
$total=$episode_begin;
for ($i=$episode_begin;$i<=$episode_end;$i++) {
if ($name<10) $name='00'.$name;
else if($name<100) $name='0'.$name;
	for ($p=1;$p<=$part;$p++) {
			if ($part==1) $name_is=$name;
			else $name_is=$name.str_replace(array(1,2,3,4,5,6,7,8,9),array('a','b','c','d','e','f','g','h','i'),$p);

?>

<tr>

<td class=fr width=15%><b>Tập <input onclick="this.select()" type="text" name="name[<?=$total?>]" value="<?=$name_is?>" size=5 style="text-align:center"></b></td><td class=fr_2><input type="text" name="url[<?=$total?>]" size="75"> <?=acp_local(0,$total)?>  <input type="text" name="episodelang[<?=$total?>]" size="5" value="1"></td>

</tr>

<?php
	$total++;
	}
	$name++;
}

?>

<tr><td class=fr colspan=2 align=center><input type="hidden" name="episode_begin" value="<?=$episode_begin?>">
<input type="hidden" name="episode_end" value="<?=$total-1?>"><input type="hidden" name="episode_part" value="<?=$part?>"><input type="hidden" name="ok" value="SUBMIT"><input type="submit" name="submit" class="submit" value="Done"></td></tr>

</table>

</form>
<script>

var total = <?=$total-1?>;

function check_local(id){

    for(i=<?=$episode_begin?>;i<=total;i++)

           document.getElementById("local_url["+i+"]").value=id;

}

</script>
<?php

}

else {	

	if ($new_film) {

	            if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))

				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];

				else $new_film_img = $_POST['url_img'];
				$cat=join_value($_POST['selectcat']);
				if ($_POST['request']=='on') $request=1; else $request=0;
				$film = acp_quick_add_film($new_film,$name_real,$new_film_img,$actor,$year,$time,$area,$country,$director,$cat,$info,$cinema,$complete,$server,$type,$language,$request);

	}	

	$t_film = $film;
	if (!$new_film) {
	$mysql->query("UPDATE ".$tb_prefix."film SET film_date=".NOW." where film_id=".$t_film."");
	}
    for ($i=$episode_begin;$i<=$episode_end;$i++){
	//if ($i<10) $i='0'.$i;

		$t_url = $_POST['url'][$i];

		$t_name = $_POST['name'][$i];
		
		$episode_lang = $_POST['episodelang'][$i];

		$t_type = acp_type($t_url);
if ($t_type =='1' ||	$t_type =='2' ||	$t_type =='3' ||	$t_type =='5' )	 $s_type=1; else $s_type=$t_type;
		$t_local = $_POST['local_url'][$i];

		if ($t_url && $t_name) {

		$mysql->query("INSERT INTO ".$tb_prefix."episode (episode_film,episode_url,episode_type,episode_name,episode_local,server_id,episode_lang) VALUES ('".$t_film."','".$t_url."','".$t_type."','".$t_name."','".$t_local."','".$s_type."','".$episode_lang."')");

		}

	}

	echo "add finish<meta http-equiv='refresh' content='0;url=index.php?act=episode&mode=multi_add'>";

  }

}

?>