<?
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=country&mode=edit';
$inp_arr = array(
		'name'	=> array(
			'table'	=>	'country_name_Vietnamese',
			'name'	=>	'Country',
			'type'	=>	'free'
		),
		'name_e'	=> array(
			'table'	=>	'country_name_English',
			'name'	=>	'Country (English)',
			'type'	=>	'free'
		),
		'name_cn'	=> array(
			'table'	=>	'country_name_Chinese',
			'name'	=>	'Country (Chinese)',
			'type'	=>	'free'
		),
		'name_ascii'	=>	array(
			'table'	=>	'country_name_ascii',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
);

if ($mode == 'add') {
	if($level == 2)	acp_check_permission_mod('add_country');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'country'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Done <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Add country',$inp_arr,$error_arr);
}//add

if ($mode == 'edit') {	
	if($level == 2)	acp_check_permission_mod('edit_country');
	if ($country_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."country WHERE country_id = '$country_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'country','country_id','country_id'),$inp_arr);
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
		"if (confirm('Are You Sure ?')) window.location='?act=country&mode=del&country_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>ID</td><td class=title style='border-right:0'>Name</td></tr>";
		$country_query = $mysql->query("SELECT * FROM ".$tb_prefix."country ");
		while ($country = $mysql->fetch_array($country_query)) {
			$tt = get_total('film','film_id',"WHERE film_country = ".$country['country_id']."");
	
			echo "<tr><td class=fr_2><input onclick=this.select() type=text name='".$country['country_id']."' value='".$country['country_id']."' size=2 style='text-align:center'></td><td class=fr><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=50%><a href='$link&country_id=".$country['country_id']."'><b>".$country['country_name_Vietnamese']."</b></a> ( ".$tt." )</td><td class=fr_2 width='15%' align=center><a href='?act=film&mode=edit&film_country=".$country['country_id']."'><b>Management Film</b></a></td><td class=fr_2 width='5%' align=center><a href=# onclick=check_del(".$country['country_id'].")><b>Del</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo '</form></table>';
	}
}	
if ($mode == 'del') {
	if($level == 2)	acp_check_permission_mod('del_country');
	if ($country_id) {
		if ($_POST['submit']) {
			$mysql->query("UPDATE ".$tb_prefix."film  SET film_country=1 WHERE film_country = '".$country_id."'");
			$mysql->query("DELETE FROM ".$tb_prefix."country WHERE country_id = '".$country_id."'");
			echo "Done <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Do U want to del ?<br><input value="Yes" name=submit type=submit class=submit></form>
<?
	}
}
?>
