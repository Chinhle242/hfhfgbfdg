<?
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=lang&mode=edit';
$inp_arr = array(
		'name'	=> array(
			'table'	=>	'lang_name_Vietnamese',
			'name'	=>	'Ngon ngu',
			'type'	=>	'free'
		),
		'name_e'	=> array(
			'table'	=>	'lang_name_English',
			'name'	=>	'Language',
			'type'	=>	'free'
		),
		'name_cn'	=> array(
			'table'	=>	'lang_name_Chinese',
			'name'	=>	'Language',
			'type'	=>	'free'
		),

);

if ($mode == 'add') {
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			//$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'language'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Done <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Add lang',$inp_arr,$error_arr);
}//add

if ($mode == 'edit') {	
		if ($lang_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."language WHERE lang_id = '$lang_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
		//		$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'language','lang_id','lang_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "Done <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Edit',$inp_arr,$error_arr);
	}
	else {

		echo "<script>function check_del(id) {".
		"if (confirm('Are You Sure ?')) lolangion='?act=lang&mode=del&lang_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>ID</td><td class=title style='border-right:0'>Name</td></tr>";
		$lang_query = $mysql->query("SELECT * FROM ".$tb_prefix."language ");
		while ($lang = $mysql->fetch_array($lang_query)) {
			$tt = get_total('film','film_id',"WHERE film_lang = ".$lang['lang_id']."");
	
			echo "<tr><td class=fr_2><input onclick=this.select() type=text name='".$lang['lang_id']."' value='".$lang['lang_id']."' size=2 style='text-align:center'></td><td class=fr><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=50%><a href='$link&lang_id=".$lang['lang_id']."'><b>".$lang['lang_name_Vietnamese']."</b></a> ( ".$tt." )</td><td class=fr_2 width='15%' align=center><a href='?act=film&mode=edit&film_lang=".$lang['lang_id']."'><b>Management Film</b></a></td><td class=fr_2 width='5%' align=center><a href=# onclick=check_del(".$lang['lang_id'].")><b>Del</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo '</form></table>';
	}
}	
if ($mode == 'del') {
	if ($country_id) {
		if ($_POST['submit']) {
			$mysql->query("UPDATE ".$tb_prefix."film  SET film_lang=1 WHERE film_lang = '".$lang_id."'");
			$mysql->query("DELETE FROM ".$tb_prefix."lang WHERE lang_id = '".$lang_id."'");
			echo "Done <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Do U want to del ?<br><input value="Yes" name=submit type=submit class=submit></form>
<?
	}
}
?>