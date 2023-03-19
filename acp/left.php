<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$menu_arr = array(

	'cat'	=>	array(

		'Thể Loại',

		array(
			'add'	=>	array('Thêm Thể Loại','act=cat&mode=add'),
			'edit'	=>	array('Quản Lý','act=cat&mode=edit'),
			),

	),
	
	'country'	=>	array(

		'Country',

		array(
			'add'	=>	array('Thêm Quốc Gia','act=country&mode=add'),
			'edit'	=>	array('Quản Lý','act=country&mode=edit'),
			),

	),	

	'film'	=>	array(

		'Film',

		array(

			'add_episode'	=>	array('Thêm Phim','act=episode&mode=multi_add'),
			'add_trailers'	=>	array('Thêm Trailers','act=trailers&mode=multi_add'),
			'edit'	=>	array('Quản Lý Phim','act=film&mode=edit'),
			'edit_broken'	=>	array('Phim Bị Lỗi','act=film&mode=edit&show_broken=1'),
			'edit_incomplete'	=>	array('Chưa Hoàn Thành','act=film&mode=edit&show_incomplete=1'),
			'add_request'	=>	array('Phim Được Yêu Cầu','act=request&mode=edit'),
			'comment'	=>	array('Cảm Nhận','act=comment&mode=edit'),			

		),

	),



	'news'	=>	array(

		'Tin Tức',

		array(

			'add'	=>	array('Thêm Tin Tức','act=news&mode=add'),
			'edit'	=>	array('Quản Lý','act=news&mode=edit'),


		),

	),

	'user'	=>	array(

		'Thành Viên',

		array(

			'add'	=>	array('Thêm','act=user&mode=add'),
			'edit'	=>	array('Quản Lý','act=user&mode=edit'),
			'edit_ban' => array('Danh Sach Đen','act=user&mode=edit&user_ban=1'),


		),

	),

	'link'	=>	array(

		'Quảng Cáo',

		array(

			'add'	=>	array('Thêm','act=ads&mode=add'),
			'edit'	=>	array('Quản Lý','act=ads&mode=edit'),			

		),

	),

	'skin'	=>	array(

		'Giao Diện',

		array(

			'add'	=>	array('Thêm Giao Diện','act=skin&mode=add'),

			'edit'	=>	array('Quản Lý','act=skin&mode=edit'),

		),

	),
	'lang'	=>	array(

		'Language',

		array(
			'add'	=>	array('Add Lang','act=lang&mode=add'),
			'edit'	=>	array('Management','act=lang&mode=edit'),
			),

	),	
	'config'	=>	array(

		'Hệ Thống',

		array(

			'permission'	=>	array('Phân Quyền','act=permission'),

			'config'	=>	array('Cấu Hình','act=config'),

			'local'	=>	array('Film Server','act=local'),
			'Mod_ponit'	=>	array('Kiểm soát - Thưởng Mod','act=user&mode=edit&point=yes'),	
		),

	)

);

if ($level == 2) {



	unset($menu_arr['config']);

	foreach ($menu_arr as $key => $v) {

		if (!$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add']);

		if (!$mod_permission['edit_'.$key]) unset($menu_arr[$key][1]['edit']);

		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_episode']);

		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_trailers']);

		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_request']);

		if ($key == 'film' && !$mod_permission['edit_'.$key]) unset($menu_arr[$key][1]['edit_broken']);

		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['edit_trailer']);

		if ($key == 'episode' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_multi']);
		if ($key == 'trailers' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_multi']);

		if ($key == 'trailer' && !$mod_permission['edit_'.$key]) unset($menu_arr[$key][1]['edit_broken']);

		if (!$menu_arr[$key][1]) unset($menu_arr[$key]);

	}

}

echo "<div><a href='index.php?act=main'><b>Admincp</b></a> || <a href='logout.php'><b>Thoát</b></a></div>";

foreach ($menu_arr as $key => $arr) {

	echo "<table cellpadding=2 cellspacing=0 width=100% class=border style='margin-bottom:5'>";

	echo "<tr><td class=title><b>".$arr[0]."</b></td></tr>";

	foreach ($arr[1] as $m_key => $m_val) {

		echo "<tr><td>+ <a href=\"?".$m_val[1]."\">".$m_val[0]."</a></td></tr>";

	}

	echo "</table>";

}

echo "<div class=footer><a href=\"http://vuaphim.vn\"><b>vuaphim.vn</b></a></div>";

?>