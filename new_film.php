<?php
define('IN_MEDIA',true);
include('inc/_settings.php');
include('inc/_functions.php');
include('inc/_main.php');
include('inc/_string.php');
include('inc/_grab.php');
include('inc/_temp.php');
include('inc/_pages.php');
include('inc/_players.php');
$temp =& new temp;
#######################################
# GET SKIN
#######################################
$skin_folder = get_data('skin_folder','skin','skin_id',get_data('cf_skin_default','config','cf_id',1));
$_SESSION['skin_folder'] = 'skin/'.$skin_folder;

#######################################
# GET HTML
#######################################
    $web_title = $web_title_main.$web_title; 
    $web_keywords = $web_keywords_main.$web_keywords;
    $html = $temp->get_htm('new_phim');
	$html = $temp->replace_value($html,array(
			'web.TITLE'			=>	$web_title,
			'web.KEYWORDS'		=>	$web_keywords,
			'web.JS'                => $js,
		)
	);
	$html = $temp->replace_blocks_into_htm($html,array(
			'main'		=>	$main,
		)
	);
	$temp->print_htm($html);
	exit();

?>