<?

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");



$edit_url = 'index.php?act=ads&mode=edit';



$inp_arr = array(

		'name'	=> array(

			'table'	=>	'ads_name',

			'name'	=>	'Tên Site',

			'type'	=>	'free'

		),

		'url'	=> array(

			'table'	=>	'ads_url',

			'name'	=>	'Link Site',

			'type'	=>	'free'

		),

		'img'	=> array(

			'table'	=>	'ads_img',

			'name'	=>	'Link Ảnh',

			'type'	=>	'img',

			'can_be_empty'	=> true,

		),

	);

##################################################

# ADD ADS

##################################################

if ($mode == 'add') {

	    if($level == 2)	acp_check_permission_mod('add_link');

	if ($_POST['submit']) {

		$error_arr = array();

		$error_arr = $form->checkForm($inp_arr);

		if (!$error_arr) {

		    if(move_uploaded_file($_FILES['img']['tmp_name'],'../'.$img_ads_folder."/".$_FILES['img']['name']))

			$img = $img_ads_folder."/".$_FILES['img']['name'];

			else $img = $_POST['img'];

			$sql = $form->createSQL(array('INSERT',$tb_prefix.'ads'),$inp_arr);

			eval('$mysql->query("'.$sql.'");');

			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";

			exit();

		}

	}

	$warn = $form->getWarnString($error_arr);



	$form->createForm('Thêm Ads',$inp_arr,$error_arr);

}

##################################################

# EDIT ADS

##################################################

if ($mode == 'edit') {

	if ($_POST['do']) {

		$arr = $_POST['checkbox'];

		if (!count($arr)) die('BROKEN');

		if ($_POST['selected_option'] == 'del') {

			if($level == 2)	acp_check_permission_mod('del_link');

			$in_sql = implode(',',$arr);

			$img = $mysql->fetch_array($mysql->query("SELECT ads_img FROM ".$tb_prefix."ads WHERE ads_id IN (".$in_sql.")"));

			$img_remove = "../".$img[0];

			unlink($img_remove);

			$mysql->query("DELETE FROM ".$tb_prefix."ads WHERE ads_id IN (".$in_sql.")");

			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";

		}

	}

	elseif ($ads_id) {

		if($level == 2)	acp_check_permission_mod('edit_link');

		if (!$_POST['submit']) {

			$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads WHERE ads_id = '$ads_id'");

			$r = $mysql->fetch_array($q);

			

			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];

		}

		else {

			$error_arr = array();

			$error_arr = $form->checkForm($inp_arr);

			if (!$error_arr) {

			    if(move_uploaded_file ($_FILES['img']['tmp_name'],'../'.$img_ads_folder."/".$_FILES['img']['name']))

			    $img = $img_ads_folder."/".$_FILES['img']['name'];

			    else $img = $_POST['img'];

				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'ads','ads_id','ads_id'),$inp_arr);

				eval('$mysql->query("'.$sql.'");');

				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";

				exit();

			}

		}

		$warn = $form->getWarnString($error_arr);

		$form->createForm('EDIR ADS',$inp_arr,$error_arr);

	}

	else {

	if($level == 2)	acp_check_permission_mod('edit_link');

       	$m_per_page = 30;

		if (!$pg) $pg = 1;

		$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads ORDER BY ads_id ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);

		$tt = get_total('ads','ads_id');

		if ($tt) {

			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";

			echo "<tr align=center><td class=title width=3%></td><td class=title width=40%>Tên Site</td><td class=title>Link Site</td><td class=title>Banner</td></tr>";

			while ($r = $mysql->fetch_array($q)) {

				$id = $r['ads_id'];

				$img = ''; if ($r['ads_img']) { $img_src = $r['ads_img']; if (!ereg("http://",$img_src)) $img_src = "../".str_replace(" ","%20",$img_src); $img ="<img src=".$img_src." width=150 height=75>"; }

				echo "<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><b><a href=?act=ads&mode=edit&ads_id=".$id.">".$r['ads_name']."</a></b></td><td class=fr_2 align=center><a href=\"".$r['ads_url']."\" target=_blank><b>".$r['ads_url']."</b></a></td><td class=fr_2 align=center>".$img."</td></tr>";

			}

			echo '<tr><td class=fr><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>

			     <td colspan=3 align="center" class=fr>Với Ads Đã Chọn '.

				'<select name=selected_option><option value=del>Xóa</option>'.

				'<input type="submit" name="do" class=submit value="Thực Hiện"></td></tr>';

			echo "<tr><td colspan=4>".admin_viewpages($tt,$m_per_page,$pg)."</td></tr>";

			echo '</form></table>';

		}

		else echo "THERE IS NO ADS";

	}

}

?>