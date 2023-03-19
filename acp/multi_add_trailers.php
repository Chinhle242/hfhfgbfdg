<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");


if ((!$_POST['ok']) AND (!$_POST['submit']))  {

?>

<form method="post">

<table class=border cellpadding=2 cellspacing=0 width=30%>

<tr><td class=title align=center colspan=2>Add trailers</td></tr>

<tr>

	<td class=fr align=center><input name="trailers_begin" size="15" value="Begin" onclick="this.select()" style="text-align:center;background:violet;font-weight: bold;"></td>

</tr>

<tr>

	<td class=fr align=center><input name="trailers_end" size="15" value="End" onclick="this.select()" style="text-align:center;background:yellow;font-weight: bold;"></td>

</tr>


<tr><td class=fr align=center colspan=2><input type="submit" name="ok" class="submit" value="Submit"></td></tr>

</table>

</form>

<?

}

else

{

$begin = $_POST['trailers_begin'];

$end = $_POST['trailers_end'];
$film_id= $_GET['film_id'];
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

	<td><input name=\"name_real\" size=\"50\">&nbsp;&nbsp;<select name=\"type\"><option value=\"0\" selected=\"selected\">- Phim Lẻ</option><option value=\"1\">- Phim Bộ</option></select></td>

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
////BEGIN CHECK TRAILERS

if(!is_numeric($begin) && !is_numeric($end)){

$trailers_begin = 1;

$trailers_end = 10;

}elseif(!is_numeric($begin)){

$trailers_begin = $trailers_end = $end;

}else{

$trailers_begin = $begin; $trailers_end = $end;

}



if (!$_POST['submit']) {

?>

<script>

var total = <?=$trailers_end?>;

function check_local(id){

    for(i=1;i<=total;i++)

           document.getElementById("local_url["+i+"]").value=id;

}

</script> 

<form enctype="multipart/form-data" method=post>

<table class=border cellpadding=2 cellspacing=0 width=95%>

<tr><td colspan=2 class=title align=center>Add Trailers</td></tr>

<?=$add_new_film?>


<tr>

    <td class=fr width=15%><b>Local Sever</b></td>

    <td class=fr_2><?=acp_local(0,'main')?> 

</td></tr>

<?php

for ($i=$trailers_begin;$i<=$trailers_end;$i++) {

?>

<tr>

<td class=fr width=15% align="center"><b><input onclick="this.select()" type="text" name="name[<?=$i?>]" value="<?=$i?>" size=5 style="text-align:center"></b></td><td class=fr_2><input type="text" name="url[<?=$i?>]" size="75"> <?=acp_local(0,$i)?></td>

</tr>

<?php

}

?>

<tr><td class=fr colspan=2 align=center><input type="hidden" name="trailers_begin" value="<?=$trailers_begin?>">

<tr><td class=fr colspan=2 align=center><input type="hidden" name="trailers_end" value="<?=$trailers_end?>">

<input type="hidden" name="ok" value="SUBMIT"><input type="submit" name="submit" class="submit" value="Done"></td></tr>

</table>

</form>

<?php

}

else {	

	if ($new_film) {

	            if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))

				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];

				else $new_film_img = $_POST['url_img'];

				$film = acp_quick_add_film($new_film,$name_real,$new_film_img,$actor,$year,$time,$area,$country,$director,$cat,$info,$cinema,$complete,$server,$type);

	}	


	$t_film = $film;
	$t_film = $film;
	if (!$new_film) {
	$mysql->query("UPDATE ".$tb_prefix."film SET film_date=".NOW." where film_id=".$t_film."");
	}
    for ($i=$trailers_begin;$i<=$trailers_end;$i++){

		$t_url = $_POST['url'][$i];

		$t_name = $_POST['name'][$i];

		$t_type = acp_type($t_url);

		$t_local = $_POST['local_url'][$i];

		if ($t_url && $t_name) {

		$mysql->query("INSERT INTO ".$tb_prefix."trailers (trailers_film,trailers_url,trailers_type,trailers_name,trailers_local) VALUES ('".$t_film."','".$t_url."','".$t_type."','".$t_name."','".$t_local."')");

		}

	}

	echo "Done <meta http-equiv='refresh' content='0;url=index.php?act=trailers&mode=multi_add'>";

  }

}

?>