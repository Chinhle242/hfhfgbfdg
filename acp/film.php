<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");



$edit_url = 'javascript:history.go(-2)';

$edit_del = 'javascript:history.go(-1)';



$inp_arr = array(

		'name'	=> array(

			'table'	=>	'film_name',

			'name'	=>	'Tên',

			'type'	=>	'free'

		),

	    'name_real'	=> array(

			'table'	=>	'film_name_real',

			'name'	=>	'Tên Thật',

			'type'	=>	'free',

			'can_be_empty'	=> true,

		),

		'cat'	=> array(

			'table'	=>	'film_cat',

			'name'	=>	'Thể Loại',

			'type'	=>	'function::acp_cat::number',
			
			'can_be_empty'	=> true,

		),

		'img'	=> array(

			'table'	=>	'film_img',

			'name'	=>	'Hình',

			'type'	=>	'img',

			'can_be_empty'	=> true,

		),
		'thumb'	=> array(

			'name'	=>	'Thumb',

			'type'	=>	'img',

			'can_be_empty'	=> true,

		),
		'director'	=> array(

			'table'	=>	'film_director',

			'name'	=>	'Đạo Diễn',

			'type'	=>	'free',

			'can_be_empty'	=> true,

		),

		'actor'	=> array(

			'table'	=>	'film_actor',

			'name'	=>	'Diễn Viên',

			'type'	=>	'free',

			'can_be_empty'	=> true,

		),
		'tag'	=> array(

			'table'	=>	'film_tag',

			'name'	=>	'Từ Khóa',

			'type'	=>	'free',

			'can_be_empty'	=> true,
			
			'tag' => array(
			
            'table' => 'film_tag',
			
            'name' => 'TAG',
			
            'type' => 'free',
			
            'can_be_empty' => true,
),

		),

	    'area'	=> array(

			'table'	=>	'film_area',

			'name'	=>	'Nhà Sản Xuất',

			'type'	=>	'free',

			'can_be_empty'	=> true,

		),
	    'country'	=> array(

			'table'	=>	'film_country',

			'name'	=>	'Quốc Gia',

			'type'	=>	'function::acp_country::number',

			'can_be_empty'	=> true,

		),

		'time'	=> array(

			'table'	=>	'film_time',

			'name'	=>	'Thời Gian',

			'type'	=>	'free',

			'can_be_empty'	=> true,

		),

		'year'	=> array(

			'table'	=>	'film_year',

			'name'	=>	'Năm Sản Xuất',

			'type'	=>	'free',

			'can_be_empty'	=> true,

		),

		'cinema'	=> array(

			'table'	=>	'film_cinema',

			'name'	=>	'Chiếu Rạp',

			'type'	=>	"yes_no::cinema+".$_GET['film_id']."+film_cinema",

		),
		'complete'	=> array(

			'table'	=>	'film_complete',

			'name'	=>	'Hoàn Thành',

			'type'	=>	"yes_no::complete+".$_GET['film_id']."+film_complete",
		),
		'request'	=> array(

			'table'	=>	'film_request',

			'name'	=>	'Yêu Cầu',

			'type'	=>	"yes_no::request+".$_GET['film_id']."+film_request",
		),
	    'language'	=> array(

			'table'	=>	'film_lang',

			'name'	=>	'Language',

			'type'	=>	'function::acp_lang::number',

			'can_be_empty'	=> true,

		),

		'server'	=> array(

			'table'	=>	'film_server',
			
			'name'	=>	'Server',	
			
			'type'	=>	'free',
						
			//'type'	=>	'function::acp_server',

			'can_be_empty'	=> true,
			
		),
		'film_type'	=> array(

			'table'	=>	'film_type',
			'name'	=>	'Phim Bộ / Lẻ',	

			'type'	=>	'function::acp_film_type::number',

		),
		'film_show'	=> array(

			'table'	=>	'film_show',
			'name'	=>	'Hiện /Ẩn',	

			'type'	=>	'free',

		),
		'film_info'	=>	array(

			'table'	=>	'film_info',

			'name'	=>	'Thông Tin',

			'type'	=>	'text',

			'can_be_empty'	=>	true,

		),

		'name_ascii'	=>	array(

			'table'	=>	'film_name_ascii',

			'type'	=>	'hidden_value',

			'value'	=>	"",

			'change_on_update'	=>	true,

		),
		'actor_ascii'	=>	array(

			'table'	=>	'film_actor_ascii',

			'type'	=>	'hidden_value',

			'value'	=>	'',

			'change_on_update'	=>	true,

		),
		'director_ascii'	=>	array(

			'table'	=>	'film_director_ascii',

			'type'	=>	'hidden_value',

			'value'	=>	'',

			'change_on_update'	=>	true,

		),
		'date'	=>	array(

			'table'	=>	'film_date',

			'type'	=>	'hidden_value',

			'value'	=>	'',

			'change_on_update'	=>	true,

		),

);

##################################################

# EDIT FILM

##################################################

if ($mode == 'edit') {

	if ($_POST['do']) {

		$arr = $_POST['checkbox'];

		if (!count($arr)) die('BROKEN');

		if ($_POST['selected_option'] == 'del') {

		if($level == 2)	acp_check_permission_mod('del_film');

			$in_sql = implode(',',$arr);

/*			$img = $mysql->fetch_array($mysql->query("SELECT film_img FROM ".$tb_prefix."film WHERE film_id IN (".$in_sql.")"));

			$img_remove = "../".$img[0];

			unlink($img_remove);*/

			$mysql->query("DELETE FROM ".$tb_prefix."episode WHERE episode_film IN (".$in_sql.")");

			$mysql->query("DELETE FROM ".$tb_prefix."film WHERE film_id IN (".$in_sql.")");

   			$mysql->query("DELETE FROM ".$tb_prefix."comment WHERE comment_film IN (".$in_sql.")");

			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_del."'>";

		}

		if($level == 2)	acp_check_permission_mod('edit_film');

		if ($_POST['selected_option'] == 'multi_edit') {

			$arr = implode(',',$arr);

			header("Location: ./?act=multi_edit_film&id=".$arr);

		}

		if($level == 2)	acp_check_permission_mod('edit_film');

		if ($_POST['selected_option'] == 'normal') {

			$in_sql = implode(',',$arr);

			$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 0 WHERE film_id IN (".$in_sql.")");

			$mysql->query("UPDATE ".$tb_prefix."episode SET episode_broken = 0 WHERE episode_film IN (".$in_sql.")");

			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";

		}

		exit();

	}	

	elseif ($film_id) {

		if($level == 2)	acp_check_permission_mod('edit_film');

		if (!$_POST['submit']) {

			$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = '".$film_id."'");

			$r = $mysql->fetch_array($q);			

			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];

		}

		else {

			$error_arr = array();

			$error_arr = $form->checkForm($inp_arr);

			if (!$error_arr) {
				$actor=check_name($actor);
				$director=check_name($director);
				$name = check_name($name);
				//$server=join_value($_POST['selectserver']);
				$cat=join_value($_POST['selectcat']);
				$name_real = check_name($_POST['name_real']);
			    $inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
			    $inp_arr['actor_ascii']['value'] = strtolower(get_ascii($actor));
			    $inp_arr['director_ascii']['value'] = strtolower(get_ascii($director));
				$inp_arr['date']['value'] = "".NOW."";
				$inp_arr['server']['value'] = $server;
				$inp_arr['cat']['value'] = $cat;
				if(move_uploaded_file ($_FILES['thumb']['tmp_name'],'../images/thumbs/film/'.$_FILES['thumb']['name']))
				$thumb ='T';
				if(move_uploaded_file ($_FILES['img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['img']['name']))

				$img = $img_film_folder."/".$_FILES['img']['name'];

				else $img = $_POST['img'];

				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'film','film_id','film_id'),$inp_arr);

				eval('$mysql->query("'.$sql.'");');

			 	echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";

				exit();

			}

		}

		$warn = $form->getWarnString($error_arr);

		//$name = UNIstr($name);

		$form->createForm('Edit Film',$inp_arr,$error_arr);

	}

	else {

		if($level == 2)	acp_check_permission_mod('edit_film');

		$film_per_page = 15;
		$order ='ORDER BY film_date DESC';

		if (!$pg) $pg = 1;

		$xsearch = strtolower(get_ascii(urldecode($_GET['xsearch'])));

		$extra = (($xsearch)?"film_name_ascii LIKE '%".$xsearch."%' OR film_name_real LIKE '%".$xsearch."%'  ":'');		

		if ($cat_id) {

        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_cat = '".$cat_id."' ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);

		$tt = get_total('film','film_id',"WHERE film_cat = '".$cat_id."'".(($extra)?"AND ".$extra." ":'')."");

		}
		elseif ($film_country) {

        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_country = '".$film_country."' ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);

		$tt = get_total('film','film_id',"WHERE film_country = '".$film_country."'".(($extra)?"AND ".$extra." ":'')."");

		}	
		elseif ($film_lang) {

        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_lang = '".$film_lang."' ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);

		$tt = get_total('film','film_id',"WHERE film_lang = '".$film_lang."'".(($extra)?"AND ".$extra." ":'')."");

		}	

		elseif ($show_broken) {

        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_broken = 1 ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);

		$tt = get_total('film','film_id','WHERE film_broken = 1 '.(($extra)?"AND ".$extra." ":''));

		}
		elseif ($show_incomplete) {

        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_complete = 0 ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);

		$tt = get_total('film','film_id','WHERE film_complete = 0 '.(($extra)?"AND ".$extra." ":''));

		}

        else {

		$q = $mysql->query("SELECT * FROM ".$tb_prefix."film ".(($extra)?"WHERE ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);

		$tt = get_total('film','film_id',"".(($extra)?"WHERE ".$extra." ":'')."");

        }

			if ($tt) {

			if ($xsearch) {

				$link2 = preg_replace("#&xsearch=(.*)#si","",$link);

			}

			else $link2 = $link;

			echo "<table><tr><td>ID Film Cần Sửa</td><td><input id=film_id size=20> <input type=button  style=\"background-color:#00FFFF\" onclick='window.location.href = \"".$link."&film_id=\"+document.getElementById(\"film_id\").value;' value=Sửa></td>";

			echo "<td> ID Film Cần Xóa</td><td><input id=film_del_id size=20> <input type=button style=\"background-color:#00FFFF\" onclick='window.location.href = \"".$link."&film_del_id=\"+document.getElementById(\"film_del_id\").value;' value=Xóa></td></tr>";


			echo "<tr><td>Tìm Phim</td><td align=left><input id=xsearch size=20 value=\"\" onclick=\"this.select()\"> <input type=button style=\"background-color:#00FFFF\" onclick='window.location.href = \"".$link2."&xsearch=\"+document.getElementById(\"xsearch\").value;' value=Tìm ></td><td colspan=2> Note:Điền Tên Phim Bạn Cần Tìm!</td></tr></table>";


			echo "<table width=100% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";

			echo "<tr align=center><td width=3% class=title></td><td class=title width=50%>Tên Phim</td><td class=title>Tổng Số Tập</td><td class=title>Quản Lý Film</td><td class=title>Hình</td><td class=title>Lỗi</td><td class=title>Complete</td></tr>";

			while ($r = $mysql->fetch_array($q)) {

				$id = $r['film_id'];
if ($r['film_name'] == $r['film_name_real']) $film= $r['film_name_real'];
else			$film = $r['film_name'].' - '.$r['film_name_real'];
				$film = '<b>'.$film.'</b> ('.lang_f($r['film_lang']).')';
				$totalepisodes_of_film = get_total('episode','episode_id',"WHERE episode_film = ".$id."");
				$totaltrailers_of_film = get_total('trailers','trailers_id',"WHERE trailers_film = ".$id."");

				$img = ''; if ($r['film_img']) { $img_src = check_img($r['film_img'],1);  $img_src = str_replace(' ','%20',$img_src); 
				$img ="<img src=".$img_src." width=50 height=50>"; }
				$complete = $r['film_complete'];
				 if ($complete==1) $complete  = "<font color=#00FF66><b>&radic;</b></font>";
				else $complete = '<font color=red><b>X</b></font>';
				$broken = ($r['film_broken'])?'<a href=?act=episode&mode=edit&film_id='.$id.'&show_error=1><font color=red><b>X</b></font></a>':'';
				// Multi Cat
				$cat=explode(',',$r['film_cat']);
				$num=count($cat);
				$cat_name="";
				for ($i=0; $i<$num;$i++) $cat_name .= '<a href="?act=cat&mode=edit&cat_id='.$cat[$i].'">&raquo;<i>'.check_data(get_data('cat_name_Vietnamese','cat','cat_id',$cat[$i])).'</i></a>, ';

				echo "<tr><td align=center><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><a href=?act=film&mode=edit&film_id=".$id.">".$film."</a><br><br>".$cat_name."</td><td class=fr_2 align=center><b>".$totalepisodes_of_film."</b> | <b>".$totaltrailers_of_film ." </b></td><td class=fr_2 align=left><a href=?act=episode&mode=edit&film_id=".$id."><b>Tập |</b></a>&nbsp;<a href=?act=episode&mode=multi_add&film_id=".$id."><b>| Thêm Tập</b></a> <br> <a href=?act=trailers&mode=edit&film_id=".$id."><b>Trailers |</b></a>&nbsp;<a href=?act=trailers&mode=multi_add&film_id=".$id."><b>| Thêm</b></a><br>
<a href=?act=downloadlink&mode=edit&film_id=".$id."><b>Down |</b></a>&nbsp;<a href=?act=downloadlink&mode=multi_add&film_id=".$id."><b>| Thêm</b></a> 				</td><td class=fr_2 align=center>".$img."</td><td class=fr_2 align=center>".$broken."</td><td class=fr_2 align=center>".$complete."</td></tr>";

			}

			echo '<tr><td class=fr align=center><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>

			     <td colspan=6 align="center" class=fr>'.

				'<select name=selected_option>

				<option value=del>Xóa</option>

				<option value=multi_edit>Sửa</option>

				<option value=normal>Sửa Lỗi</option></select>'.

				'<input type="submit" name="do" class=submit value="SEND"></td></tr>';

			echo "<tr><td colspan=6>".admin_viewpages($tt,$film_per_page,$pg)."</td></tr>";

			echo '</form></table>';

		}

		else echo "Không Có Film";

	}

}

?>

