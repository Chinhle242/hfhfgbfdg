<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");



$edit_url = 'javascript:history.go(-2)';

$edit_del = 'javascript:history.go(-1)';



$inp_arr = array(

		'name'		=> array(

			'table'	=>	'episode_name',

			'name'	=>	'Episode',

			'type'	=>	'free',

		),

		'film'		=> array(

			'table'	=>	'episode_film',

			'name'	=>	'Name',

			'type'	=>	'function::acp_film::number',

		),

		'file_type'	=> array(

			'table'	=>	'episode_type',

			'name'	=>	'Format',

			'desc'	=>	'Default also server',

			'type'	=>	'function::set_type::number',

			'change_on_update'	=>	true,

		),
		'server'    => array(

            'table'    =>    'server_id',

            'name'    =>    'Server',
			'type'	=>	'free',

        ),  

		'local_url'    => array(

            'table'    =>    'episode_local',

            'name'    =>    'Local URL',

            'type'    =>    'function::acp_local::number',

        ),
		
		'lang'    => array(

            'table'    =>   'episode_lang',

            'name'    =>    'Lang',

            'type'    =>    'free',

        ),		  

		'url'		=> array(

			'table'	=>	'episode_url',

			'name'	=>	'Link',

			'type'	=>	'free',

		),


);



##################################################

# ADD EPISODE

##################################################

if ($mode == 'multi_add') {

	if($level == 2)	acp_check_permission_mod('add_film');

	include('multi_add_episode.php');

}

##################################################

# EDIT EPISODE

##################################################

if ($mode == 'edit') {

	if ($_POST['do']) {

		$arr = $_POST['checkbox'];

		if (!count($arr)) die('BROKEN');

		if ($_POST['selected_option'] == 'del') {

		if($level == 2)	acp_check_permission_mod('del_film');

		$in_sql = implode(',',$arr);

		$mysql->query("DELETE FROM ".$tb_prefix."episode WHERE episode_id IN (".$in_sql.")");			

			echo "<a href=".$edit_del.">DEL FINISH </a><meta http-equiv='refresh' content='0;url=".$edit_del."'>";

		}		

		if($level == 2)	acp_check_permission_mod('edit_film');

		if ($_POST['selected_option'] == 'multi_edit') {

			$arr = implode(',',$arr);

			header("Location: ./?act=multi_edit_episode&id=".$arr);

		}

		elseif ($_POST['selected_option'] == 'normal') {

			$in_sql = implode(',',$arr);

			$mysql->query("UPDATE ".$tb_prefix."episode SET episode_broken = 0 WHERE episode_id IN (".$in_sql.")");

			$broken_fix = $mysql->fetch_array($mysql->query("SELECT episode_film FROM ".$tb_prefix."episode WHERE episode_id IN (".$in_sql.")"));

			$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 0 WHERE film_id = '".$broken_fix['episode_film']."'");

			echo "<a href=".$edit_url.">EDIT FINISH </a><meta http-equiv='refresh' content='0;url=".$edit_url."'>";

		}

		exit();

	}

	elseif ($episode_id) {

		if($level == 2)	acp_check_permission_mod('edit_film');

		if (!$_POST['submit']) {

			$q = $mysql->query("SELECT * FROM ".$tb_prefix."episode WHERE episode_id = '$episode_id'");

			if (!$mysql->num_rows($q)) {

				echo "THERE IS NO EPISODE";

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

				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'episode','episode_id','episode_id'),$inp_arr);

				eval('$mysql->query("'.$sql.'");');

				echo "<a href=".$edit_url.">EDIT FINISH</a><meta http-equiv='refresh' content='0;url=".$edit_url."'>";

				exit();

			}

		}

		$warn = $form->getWarnString($error_arr);

		$form->createForm('EDIT EPISODE',$inp_arr,$error_arr);

	}

	else {

		if($level == 2)	acp_check_permission_mod('edit_film');		

		$episode_per_page = 150;

		if (!$pg) $pg = 1;

		if ($film_id) {
if(!$server)
$where=	"WHERE episode_film='".$film_id."'";
else 
$where=	"WHERE episode_film='".$film_id."' AND server_id='".$server."'";
if($show_error) 
$where=	"WHERE episode_film='".$film_id."' AND episode_broken =1";
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."episode ".$where." ORDER BY episode_name DESC LIMIT ".(($pg-1)*$episode_per_page).",".$episode_per_page);
		$tt = get_total('episode','episode_id',$where);

		}
		$fs = $mysql->query("SELECT film_server FROM ".$tb_prefix."film WHERE film_id=".$film_id."");
		$fs = $mysql->fetch_array($fs);
		$c	= explode(',',$fs['film_server']);
		$t	= count($c);
for($i=0;$i<$t;$i++)
{
//	$servername = $mysql->fetch_array($mysql->query("SELECT server_name FROM ".$tb_prefix."server WHERE server_id =".$c[$i].""));
	$f_s= $f_s.'<a href=index.php?act=episode&mode=edit&film_id='.$film_id.'&server='.$c[$i].' ><b>'.$c[$i].'</b></a>  ';
}	
		if ($mysql->num_rows($q)) {
		
		
			echo '<div style="padding-top:10px;padding-bottom:10px;" align=center>Server: '.$f_s.'</div>';
     		echo "<table width=90% align=center cellpadding=0 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";

			echo "<tr align=center><td width='3%' class=title></td><td class=title width=40%>Tập || Link</td><td class=title>Tên Film</td><td class=title width=7%>Lỗi</td><td class=title width=10%>&nbsp;</td></tr>";

			while ($r = $mysql->fetch_array($q)) {

				$id = $r['episode_id'];

				$episode_name = $r['episode_name'];

				$film_name = check_data(get_data("film_name","film","film_id",$r['episode_film']));

				$broken = ($r['episode_broken'])?'<font color=red><b>X</b></font>':'';

	            if($r['episode_local']) $url = get_data('local_link','local','local_id',$r['episode_local']).$r['episode_url'];

                else $url = $r['episode_url'];

				echo "<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><a href='index.php?act=episode&mode=edit&episode_id=".$id."'><b>- ".$episode_name."</b></a><br><input type='text' value='".$url."' style='height:20px;width:90%;background-color:#EFEFEF' /></td><td class=fr_2 align=center><b><a href=?act=film&mode=edit&film_id=".$r['episode_film'].">".$film_name."</a></b></td><td  class=fr_2 align=center>".$broken."</td><td class=fr align=center><a href='../?episode=".$id."' target=_blank >PLAY</a> </td></tr>";

			}

			echo '<tr><td class=fr><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>

			     <td colspan=7 align="center" class=fr>'.

				'<select name=selected_option>

			    <option value=multi_edit>Sửa</option>

			    <option value=del>Xóa</option>

				<option value=normal>Sửa Lỗi</option></select>'.

				'<input type="submit" name="do" class=submit value="Done"></td></tr>';

			echo "<tr><td colspan=8>".admin_viewpages($tt,$episode_per_page,$pg)."</td></tr>";

			echo '</form></table>';

			}

		else echo "THERE IS NO EPISODES";

	}

}

?>