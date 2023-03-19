<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");



$edit_url = 'javascript:history.go(-2)';

$edit_del = 'javascript:history.go(-1)';



$inp_arr = array(

		'name'		=> array(

			'table'	=>	'trailers_name',

			'name'	=>	'Trailer',

			'type'	=>	'free',

		),
		'des'		=> array(

			'table'	=>	'trailers_des',

			'name'	=>	'Trailer Description',

			'type'	=>	'free',
			'can_be_empty'	=> true,

		),		

		'film'		=> array(

			'table'	=>	'trailers_film',

			'name'	=>	'Tên Film',

			'type'	=>	'function::acp_film::number',

		),

		'file_type'	=> array(

			'table'	=>	'trailers_type',

			'name'	=>	'Định Dạng',

			'desc'	=>	'If not already known in order to wear think of',

			'type'	=>	'function::set_type::number',

			'change_on_update'	=>	true,

		),

		'local_url'    => array(

            'table'    =>    'trailers_local',

            'name'    =>    'Local URL',

            'type'    =>    'function::acp_local::number',

        ),  

		'url'		=> array(

			'table'	=>	'trailers_url',

			'name'	=>	'Link',

			'type'	=>	'free',

		),



);



##################################################

# ADD trailers

##################################################

if ($mode == 'multi_add') {

	if($level == 2)	acp_check_permission_mod('add_film');

	include('multi_add_trailers.php');

}

##################################################

# EDIT trailers

##################################################

if ($mode == 'edit') {

	if ($_POST['do']) {

		$arr = $_POST['checkbox'];

		if (!count($arr)) die('BROKEN');

		if ($_POST['selected_option'] == 'del') {

		if($level == 2)	acp_check_permission_mod('del_film');

		$in_sql = implode(',',$arr);

		$mysql->query("DELETE FROM ".$tb_prefix."trailers WHERE trailers_id IN (".$in_sql.")");			

			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_del."'>";

		}		

		if($level == 2)	acp_check_permission_mod('edit_film');

		if ($_POST['selected_option'] == 'multi_edit') {

			$arr = implode(',',$arr);

			header("Location: ./?act=multi_edit_trailers&id=".$arr);

		}

		elseif ($_POST['selected_option'] == 'normal') {

			$in_sql = implode(',',$arr);

			$mysql->query("UPDATE ".$tb_prefix."trailers SET trailers_broken = 0 WHERE trailers_id IN (".$in_sql.")");

			$broken_fix = $mysql->fetch_array($mysql->query("SELECT trailers_film FROM ".$tb_prefix."trailers WHERE trailers_id IN (".$in_sql.")"));

			$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 0 WHERE film_id = '".$broken_fix['trailers_film']."'");

			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";

		}

		exit();

	}

	elseif ($trailers_id) {

		if($level == 2)	acp_check_permission_mod('edit_film');

		if (!$_POST['submit']) {

			$q = $mysql->query("SELECT * FROM ".$tb_prefix."trailers WHERE trailers_id = '$trailers_id'");

			if (!$mysql->num_rows($q)) {

				echo "THERE IS NO TRAILERS";

				exit();

			}

			$r = $mysql->fetch_array($q);

				

			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];

		}

		else {

			$error_arr = array();

			$error_arr = $form->checkForm($inp_arr);

			if (!$error_arr) {

				if($file_type == 0) $file_type = acp_type($url);

				if ($new_film) {

				if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))

				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];

				else $new_film_img = $_POST['url_img'];

				$film = acp_quick_add_film($new_film,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info);

			    }

				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'trailers','trailers_id','trailers_id'),$inp_arr);

				eval('$mysql->query("'.$sql.'");');

				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";

				exit();

			}

		}

		$warn = $form->getWarnString($error_arr);

		$form->createForm('EDIT TRAILERS',$inp_arr,$error_arr);

	}

	else {

		if($level == 2)	acp_check_permission_mod('edit_film');		

		$trailers_per_page = 10;

		if (!$pg) $pg = 1;

		if ($film_id) {

        $q = $mysql->query("SELECT * FROM ".$tb_prefix."trailers WHERE trailers_film='".$film_id."' ".(($extra)?"AND ".$extra." ":'')."ORDER BY trailers_id DESC LIMIT ".(($pg-1)*$trailers_per_page).",".$trailers_per_page);

		$tt = get_total('trailers','trailers_id',"WHERE trailers_film = '".$film_id."' ".(($extra)?"AND ".$extra." ":''));

		}

		if ($mysql->num_rows($q)) {

     		echo "<table width=90% align=center cellpadding=0 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";

			echo "<tr align=center><td width='3%' class=title></td><td class=title width=40%>Tập || Link</td><td class=title>Tên Film</td><td class=title width=7%>Lỗi</td><td class=title width=10%>Chọn</td></tr>";

			while ($r = $mysql->fetch_array($q)) {

				$id = $r['trailers_id'];

				$trailers_name = $r['trailers_name'];

				$film_name = check_data(get_data("film_name","film","film_id",$r['trailers_film']));

				$broken = ($r['trailers_broken'])?'<font color=red><b>X</b></font>':'';

	            if($r['trailers_local']) $url = get_data('local_link','local','local_id',$r['trailers_local']).$r['trailers_url'];

                else $url = $r['trailers_url'];

				echo "<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><a href='index.php?act=trailers&mode=edit&trailers_id=".$id."'><b>- ".$trailers_name."</b></a><br><font color=red>".$url."</font></td><td class=fr_2 align=center><b><a href=?act=film&mode=edit&film_id=".$r['trailers_film'].">".$film_name."</a></b></td><td  class=fr_2 align=center>".$broken."</td><td class=fr align=center><a href='../?trailers=".$id."' target=_blank >PLAY</a> </td></tr>";

			}

			echo '<tr><td class=fr><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>

			     <td colspan=7 align="center" class=fr>Với Tập Phim Đã Chọn '.

				'<select name=selected_option>

			    <option value=multi_edit>Sửa</option>

			    <option value=del>Xóa</option>

				<option value=normal>Sửa Lỗi</option></select>'.

				'<input type="submit" name="do" class=submit value="Thực Hiện"></td></tr>';

			echo "<tr><td colspan=8>".admin_viewpages($tt,$trailers_per_page,$pg)."</td></tr>";

			echo '</form></table>';

			}

		else echo "THERE IS NO TRAILERS";

	}

}

?>