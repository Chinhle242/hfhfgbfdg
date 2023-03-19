<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$film_id=$_GET['film_id'];
if(!$film_id)
$add_new_film ="<tr>

	<td class=fr width=\"15%\">

		<b>Add New Film</b>
</td>

	<td class=fr_2>

	<table cellpadding=2 cellspacing=0 width=100%>	

	<tr>

	<td width=\"15%\" align=\"right\"><b>Name</b></td>

	<td width=\"85%\"><input name=\"new_film\" size=\"50\">&nbsp;&nbsp;<select name=\"complete\"><option value=\"1\" selected=\"selected\">- Complete</option><option value=\"0\">- Incomplete</option></select>&nbsp;&nbsp;<select name=\"cinema\"><option value=\"1\">- Cinema</option><option value=\"0\" selected=\"selected\">- No Cinema</option></select></td>

    </tr>

    <tr>

	<td width=\"15%\" align=\"right\"><b>Real name</b></td>

	<td><input name=\"name_real\" size=\"50\">&nbsp;&nbsp;<select name=\"type\"><option value=\"0\" selected=\"selected\">- Phim Lẻ</option><option value=\"1\">- Phim Bộ</option></select>&nbsp;&nbsp;".acp_lang()."</td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Images</b></td>

	<td ><input name=\"upload_img\" size=\"46\" type=\"file\"> * Upload file

	    <input name=\"url_img\" size=\"50\"> * Post from url</td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Director</b></td>

	<td><input name=\"director\" size=\"50\"></td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Actor</b></td>

	<td><input name=\"actor\" size=\"50\"></td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Pub</b></td>

	<td><input name=\"area\" size=\"50\"></td>

    </tr>
	<tr>

	<td width=\"15%\" align=\"right\"><b>Country</b></td>

	<td>".acp_country()."</td>

    </tr>
    <tr>

	<td width=\"15%\" align=\"right\"><b>Time</b></td>

	<td><input name=\"time\" size=\"50\"></td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Year</b></td>

	<td><input name=\"year\" size=\"50\"></td>

    </tr>

	<tr>
	<tr>

	<td width=\"15%\" align=\"right\"><b>Server</b></td>

	<td><input name=\"server\" size=\"50\" value=1 type=text></td>

    </tr>

	<tr>

	<td width=\"15%\" align=\"right\"><b>Catelogy</b></td>

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

if ($mode=='edit')	{
if ($film_id)	{
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."downloadlink WHERE film_id =".$film_id." ORDER BY episode_name ASC");
		$i=0;
				while ($r = $mysql->fetch_array($q)) {
						$i++;
						if ($i%10==0)	
							$tr=$tr.'<td width=10% align=left height=30><a href="index.php?act=downloadlink&mode=edit&id='.$r['download_id'].'"><b>Ep '.$r['episode_name'].'</b></a></td></tr>';
						else
							$tr=$tr.'<td width=10% align=left height=30><a href="index.php?act=downloadlink&mode=edit&id='.$r['download_id'].'"><b>Ep '.$r['episode_name'].'</b></a></td>';					
				}
	echo '<br>Choose episode to edit<br><br><br><center><table width=750  cellspacing="2" cellpadding="2"><tr>'.$tr.'</tr></table></center>';
	}
else {
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."downloadlink WHERE download_id=".$id."");$r = $mysql->fetch_array($q);
				if (!$_POST['submit']) {
if ($r['download_type'] == 1) $s_type ='  <select name="download_type"><option value="0" >- Single</option><option value="1" selected="selected">- All</option></select>';
else $s_type ='  <select name="download_type"><option value="0" selected="selected">- Single</option><option value="1" >- All</option></select>';
?>
<form enctype="multipart/form-data" method=post>

<table class=border cellpadding=2 cellspacing=0 width=95%>

<tr><td colspan=2 class=title align=center>Edit Download Link</td></tr>

<tr>

<td width=15% align="left" valign="top" class=fr><b>Episode
  <input onclick="this.select()" type="text" name="name" value="<?=$r['episode_name']?>" size=10 style="text-align:center"></b>
  <div style="padding-top:10px;"></div><b>Type &nbsp; &nbsp; </b>
  <?=$s_type?>

</td>
<td class=fr_2>
<textarea rows=8 cols=70 id="url" name="url"><?=$r['download_content']?></textarea><script language="JavaScript">generate_wysiwyg('url');</script>
</td>

</tr>
<tr><td class=fr colspan=2 align=center>
<input type="hidden" name="ok" value="SUBMIT"><input type="submit" name="submit" class="submit" value="Done"></td></tr>

</table>

</form>
<?php						
				}
			else	{
		$t_url = $_POST['url'];

		$t_name = $_POST['name'];

		$t_type =$_POST['download_type'];
		if ($t_url && $t_name) {

		$mysql->query("UPDATE ".$tb_prefix."downloadlink SET episode_name='".$t_name."', download_content='".$t_url."',download_type='".$t_type."' WHERE download_id=".$id."");
	echo "add finish<meta http-equiv='refresh' content='0;url=index.php?act=downloadlink&mode=edit&film_id=".$r['film_id']."'>";	
								}
			}
}
}
else{

$begin = 1;

$end = 1;


if (!$_POST['submit']) {

?>


<form enctype="multipart/form-data" method=post>

<table class=border cellpadding=2 cellspacing=0 width=95%>

<tr><td colspan=2 class=title align=center>Add Download Link</td></tr>
<?=$add_new_film?>
<?php

for ($i=$begin;$i<=$end;$i++) {
if($i<10) $i='00'.$i;
?>

<tr>

<td width=15% align="left" valign="top" class=fr><b>Episode
  <input onclick="this.select()" type="text" name="name[<?=$i?>]" value="<?=$i?>" size=10 style="text-align:center"></b><br />
  (3 chu so)
  <div style="padding-top:10px;"></div><b>Type &nbsp; &nbsp; </b>
  <select name="download_type"><option value="0" >- Single</option><option value="1" selected="selected">- All</option></select></td>
<td class=fr_2>
<textarea rows=8 cols=70 id="url[<?=$i?>]" name="url[<?=$i?>]"></textarea><script language="JavaScript">generate_wysiwyg('url[<?=$i?>]');</script>
</td>

</tr>

<?php

}

?>

<tr><td class=fr colspan=2 align=center><input type="hidden" name="episode_begin" value="<?=$begin?>">

<tr><td class=fr colspan=2 align=center><input type="hidden" name="episode_end" value="<?=$end?>">

<input type="hidden" name="ok" value="SUBMIT"><input type="submit" name="submit" class="submit" value="Done"></td></tr>

</table>

</form>

<?php

}

else {	

/*	if ($new_film) {

	            if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))

				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];

				else $new_film_img = $_POST['url_img'];

				$film = acp_quick_add_film($new_film,$name_real,$new_film_img,$actor,$year,$time,$area,$country,$director,$cat,$info,$cinema,$complete,$server,$type,$language);

	}	

	$t_film = $film;
	if (!$new_film) {
	$mysql->query("UPDATE ".$tb_prefix."film SET film_date=".NOW." where film_id=".$t_film."");
	}*/
    for ($i=$begin;$i<=$end;$i++){
	if ($i<10) $i='00'.$i;

		$t_url = $_POST['url'][$i];

		$t_name = $_POST['name'][$i];

		$t_type =$_POST['download_type'];
		if ($t_url && $t_name) {

		$mysql->query("INSERT INTO ".$tb_prefix."downloadlink (film_id,episode_name,download_type,download_content,download_poster,download_time) VALUES ('".$film."','".$t_name."','".$t_type."','".$t_url."','1','".NOW."')");

		}

	}

	echo "add finish<meta http-equiv='refresh' content='0;url=index.php?act=downloadlink&mode=multi_add&film_id=".$film."'>";

  }


}
?>