<?php

define('IN_MEDIA',true);

include('inc/_data.php');

include('inc/_settings.php');

include('inc/_functions.php');

include('inc/_main.php');

include('inc/_string.php');

include('inc/_grab.php');

include('inc/_temp.php');

include('inc/_pages.php');

include('inc/_players.php');
#######################################
# GET COOKIE
#######################################
$visit=$_SERVER['HTTP_REFERER'];
if ((preg_match('#user/login(.*?)#s', $visit))||(preg_match('#user/logout(.*?)#s', $visit))||(preg_match('#user/reg(.*?)#s', $visit))){
	$lastvisit=$_SESSION['last_visit'];
}else{
	$lastvisit=$visit;
	$_SESSION['last_visit']=$lastvisit;
}
$isLoggedIn = m_checkLogin();
//$sql = 'ALTER TABLE `table_config` ADD `cf_server_inv` CHAR(10) NOT NULL DEFAULT \'0\' AFTER `cf_protect`;'; 
//$web_protect = get_data('cf_protect','config','cf_id',1);
//if ($web_protect!=0) include('protect.php');
if (!$_COOKIE['LangCookie']) $_COOKIE['LangCookie'] = 'English';

setcookie("LangCookie", 'English', time() + 60*60*24*365, "/", "");  

include('lang/'.$_COOKIE['LangCookie'].'/lang.php');

$temp =& new temp;

if ($_GET['episode'])	include('load/play-film.php');

if (!$_COOKIE['LANG']) 
{

	$lang_default = 'english';
	
    setcookie("LANG", $lang_default, time() + 60*60*24*365, "/", "");     

	$_COOKIE['LANG'] = $lang_default;

}

if ($_COOKIE['LANG'] <> 'english') 	$_COOKIE['LANG'] = 'english';

include('lang/'.$_COOKIE['LANG'].'.php');
#######################################

# GET SKIN

#######################################

$_SESSION['skin_folder'] = 'skin/'.$skin_folder;

//$isLoggedIn = checkLogin();

#######################################

# SITE OFF

#######################################

if ($site_on <> 1) 
{

	echo get_data('cf_announcement','config','cf_id',1);

	exit();

}

#######################################

# GET FILE

#######################################

elseif ($_POST['showcomment']) 
{

    $showcomment = write_comment(intval($num),intval($film_id),intval($page));

    $temp->print_htm($showcomment);

	exit();

}

elseif ($_POST['showfilm']) 
{
	if ($num == 1) $type = 'new';

	elseif ($num == 2) $type = 'top'; 

	elseif ($num == 4) $type = 'rate';

	elseif ($num == 5) $type = 'relate'; 
   
	elseif ($num == 6) $type = 'phimbomoi'; 
	
	elseif ($num == 7) $type = 'new_index'; 

	$showfilm = film($type,intval($number),intval($apr),intval($cat_id),intval($page));

	$temp->print_htm($showfilm);

	exit();

}

elseif ($_POST['rating'] || $_POST['comment'] || $_POST['request'] || $_POST['broken']  || $_POST['download']) 
{
	include('post.php');

	exit();

}
if ($episode)
{
	include('episode.php');
	
	exit();
}

elseif ($trailers) 
{

	include('trailers.php');

	exit();

}

if ($popup) 
{

include('popup.php');

exit();

}


#######################################

# SET TOP OF DAY

#######################################

$day = date('d',NOW);

$current_day = get_data('cf_current_day','config','cf_id',1);

if ($day != $current_day) 
{

	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed_day = 0");

	$mysql->query("UPDATE ".$tb_prefix."config SET cf_current_day = ".$day." WHERE cf_id = 1");

}

#######################################

# GET VALUE

#######################################
$user=$_GET['user'];

if ($category || $list || $search || $quick_search ||$info || $actor  || $tag || $sfilm || $sactor ||$sdirector)

	include('film.php');

elseif ($news)

	include('news.php');	

elseif ($user)

	include('users.php');

elseif ($error)

	include('error.php');	


#######################################

# GET HTML

#######################################

if ($news || $list  || $actor  || $tag || $sfilm || $sactor || $sdirector  || $error || $category  || $search || $quick_search || $info || $user)	

	$html = $temp->get_tpl('index_list');
	
	
	else    $html = $temp->get_tpl('index_home');
	$html = $temp->replace_value($html,array(

			'web.DES'		=>	$web_des,
            'web.KEY' => $tag,
		)
	);
	$html = $temp->replace_blocks_into_htm($html,array(

			'main'		=>	$main,

		)

	);

	$temp->print_htm($html);
	exit();

?>