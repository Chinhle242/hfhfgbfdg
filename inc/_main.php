<?php

if (!defined('IN_MEDIA')) die("Hack");

function box($name) 
{
	global $temp;
	$main = $temp->get_tpl($name);
	return $main;
}

function cat($type='') 
{
	global $temp;
	
	if (!$type)	$main = $temp->get_tpl('cat');
	
	return $main;
}
function cat_menu() {
	global $mysql,$temp,$tb_prefix,$web_link;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."cat ORDER BY cat_order ASC");
	$htm = $temp->get_htm('cat_menu');
	$h['row'] = $temp->get_block_from_htm($htm,'cat_menu.row',1);	
	if (!$mysql->num_rows($q)) return ''; 
	$i = 0;
	while ($r = $mysql->fetch_array($q)) {
		$main .= $temp->replace_value($h['row'],
			array(
				'cat.URL'  => $web_link.'/the-loai/'.replace(strtolower(get_ascii($r['cat_name_'.$_COOKIE['LangCookie']]))).'/g'.$r['cat_id'].'.html',
				'cat.NAME' => $r['cat_name_'.$_COOKIE['LangCookie']].' - '.$r['cat_name_Vietnamese'],
				'cat.TOTAL_FILM' => get_total('film','film_id',"WHERE film_cat = '".$r['cat_id']."'"),
			)
		);
		$i++;
	}
	$main = $temp->replace_blocks_into_htm($htm,array(
		'cat_menu' 		=> $main
		)
	);
	return $main;
}
function country_menu() {
	global $mysql,$temp,$tb_prefix,$web_link,$cacheFile;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."country ORDER BY country_order ASC");
	$htm = $temp->get_htm('country_menu');
	$h['row'] = $temp->get_block_from_htm($htm,'country_menu.row',1);	
	if (!$mysql->num_rows($q)) return ''; 
	$i = 0;
	while ($r = $mysql->fetch_array($q)) {
		$main .= $temp->replace_value($h['row'],
			array(
				'country.URL'  => $web_link.'/country/'.$r['country_id'].'/'.replace($r['country_name_ascii']),
				'country.NAME' => $r['country_name'],
				'country.TOTAL_FILM' => get_total('film','film_id',"WHERE film_country = '".$r['country_id']."'"),
			)
		);
		$i++;
	}
	$main = $temp->replace_blocks_into_htm($htm,array(
		'country_menu' 		=> $main
		)
	);
	return $main;
}
function request_menu() {
	global $mysql,$temp,$tb_prefix,$web_link,$cacheFile;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_request=1 ORDER BY film_date DESC");
	$htm = $temp->get_htm('request_menu');
	$h['row'] = $temp->get_block_from_htm($htm,'request_menu.row',1);	
	if (!$mysql->num_rows($q)) return ''; 
	$i = 0;
	while ($rs = $mysql->fetch_array($q)) {
		$film_title = check_film_name($rs['film_name'],$rs['film_name_real']);

		$main .= $temp->replace_value($h['row'],
			array(		
				'request.URL'		=> $web_link."/thong-tin/".replace(strtolower(get_ascii($rs['film_name_real'])))."_".$rs['film_id'].".html",
				
				'request.CUT_NAME'	=> get_words($film_title,3),

				'request.TITLE'	=> $film_title,
			)
		);
		$i++;
	}
	$main = $temp->replace_blocks_into_htm($htm,array(
		'request_menu' 		=> $main
		)
	);
	return $main;
}
function cache_film($type, $limit = 5, $apr = 1, $cat_id = 0, $page = 1, $film_id = 0) 
{
	global $cachedir, $cacheext;
	
	if (!$page) $page = 1;	
	
	if ($type == 'relate') 	$cachefile = $cachedir.'cache_'.$type.'_'.$cat_id.'_'.$film_id.'_p'.$page.'.'.$cacheext;
		
	else $cachefile = $cachedir.'cache_'.$type.'_p'.$page.'.'.$cacheext;	
	
	if ($type == 'relate'  || $type == 'new' || $type == 'phimbomoi' || $type == 'rate'  || $type == 'cinema')
	 
		$html = cache_begin($cachefile,5*60);
		
	else	$html = cache_begin($cachefile);
		
	if (!$html)  
	{
		$html = film($type, $limit, $apr, $cat_id, $page, $film_id);
		
		cache_end ($cachefile,$html);
	}
	
	return $html;
	
}

function film($type, $number = 5, $apr = 1, $cat_id = '', $page = 1,$film_id = 0) {

	global $mysql, $temp, $tb_prefix, $link_href, $r_s_img,$web_link,$ads_play_02;

	if (!$page) $page = 1;

	$limit = ($page-1)*$number;	

    if ($type == 'new') 
	{
		$where_sql = " WHERE film_type=0 AND film_show=1"; 
		
		$order_sql = " ORDER BY film_date ";
		
		$num = 1; 
		
		$file_name = 'new_film';
	}

	elseif ($type == 'top') 
	{
		$where_sql = " WHERE film_viewed_day > 0 AND film_show=1"; 
		
		$order_sql = " ORDER BY film_viewed_day";

		$num = 2; 
		
		$file_name = 'top_film';
	}

	elseif ($type == 'rand') {
	$where_sql = " WHERE film_show=1 "; $order_sql = "ORDER BY RAND()";
	$file_name = 'rand_film';
	}

	elseif ($type == 'rate') 
	{
		$where_sql = " WHERE film_rating_total >= 1 AND film_show=1"; 
		
		$order_sql = " ORDER BY film_rating_total";

		$num = 4; 
		
		$file_name = 'rate_film';
	}

	elseif ($type == 'relate') 
	{
		$where_sql = " WHERE film_cat = $cat_id   AND film_id <> $film_id AND film_show=1"; 
		
		$order_sql = " ORDER BY film_date";
		
		$num = 5; 
		
		$file_name = 'relate_film';
	}	
		
	elseif ($type == 'phimbomoi') 
	{
		$where_sql = " WHERE film_type=1 AND film_show=1"; 
	
		$order_sql = " ORDER BY film_date ";
		
		$num = 6; 
		$file_name = 'new_dramaseries';
	}
	elseif ($type == 'phimlemoi') 
	{
		$where_sql = " WHERE film_type=1 AND film_show=1"; 
	
		$order_sql = " ORDER BY film_date ";
		
		$num = 7; 
		$file_name = 'phimlemoi';
	}
	elseif ($type == 'series') 
	{
		$where_sql = " WHERE film_type=1 AND film_show=1"; 
	
		$order_sql = " ORDER BY film_date ";
		
		$num = 8; 
		$file_name = 'series';
	}				
	
	elseif ($type == 'cinema') 
	{
		$where_sql = " WHERE film_cinema = 1"; 
		
		$order_sql = " ORDER BY film_date ";
	
		$num = 10; 
		
		$file_name = 'cinema';
	}

	elseif ($type == 'request_menu') 
	{
		$where_sql = " WHERE film_viewed_day > 0 AND film_show=1"; 
		
		$order_sql = " ORDER BY film_viewed_day";

		$num = 11; 
		
		$file_name = 'request_menu';
	}





	
	
	$htm = $temp->get_tpl($file_name);

	$h['end_tag'] = $temp->get_block_from_htm($htm,$file_name.'.end_tag',1);

	$h['row'] = $temp->get_block_from_htm($htm,$file_name.'.row',1);

	$query = $mysql->query("SELECT film_id,film_name,film_name_real,film_name_ascii,film_actor,film_year,film_img,film_viewed,film_rating,film_rating_total,film_rate,film_lang FROM ".$tb_prefix."film $where_sql $order_sql DESC LIMIT ".$limit.",$number");

	$total = get_total("film","film_id","$where_sql $order_sql");

    if (!$mysql->num_rows($query)) return ''; 

	$i = 0;

	while ($rs = $mysql->fetch_array($query)) 
	{
		$j = $j +1;
		$film_title = check_film_name($rs['film_name_real'],$rs['film_name']);

		$rater_stars_img = rating_img($rs['film_rating'],$rs['film_rating_total']);
		
		$rater_stars_text = $rs['film_rating'].' Stars | '.$rs['film_rating_total'].' Rates';
				
		if ($h['start_tag'] && fmod($i,$apr) == 0) $main .= $h['start_tag'];

		$main .= $temp->replace_value($h['row'],

			array(

				'film.ID'		=> $rs['film_id'],
				
				'film.URL'		=> $web_link."/thong-tin/".replace(strtolower(get_ascii($rs['film_name_ascii'])))."_".$rs['film_id'].".html",
				
				'film.CUT_NAME'	=> get_words($film_title,3),

				'film.TITLE'	=> $film_title,
				
				'film.VIEWED' 	=> $rs['film_viewed'],
				
				'film.IMG'		=> check_img($rs['film_img'],1),

				'rate.IMG'		=> $rater_stars_img,
				
				'rate.TEXT'		=>	"",
	
		    )

		);
		
		

		

		if ($h['end_tag'] && fmod($i,$apr) == $apr - 1) $main .= $h['end_tag'];

		$i++;

	}

	if ($h['end_tag'] && fmod($i,$apr) != $apr - 1) $main .= $h['end_tag'];

	$main = $temp->replace_blocks_into_htm($htm,array(

		'film_menu' 		=> $main

		)

	);

	$main = $temp->replace_value($main,array(

			'TOTAL'			=> $total,

			'pages.FILM'		=>view_pages('film',$total,$number,$page,$num,$apr,$cat_id),

		)

	);

	return $main;

}

function news($num=10,$apr=1) {

	global $mysql, $temp, $tb_prefix,$link_href,$web_link;

	$file_name = 'news';

	$htm = $temp->get_htm($file_name.'_menu');

	$h['end_tag'] = $temp->get_block_from_htm($htm,'news_menu.end_tag',1);

	$h['row'] = $temp->get_block_from_htm($htm,'news_menu.row',1);

	$q = $mysql->query("SELECT news_id,news_name,news_name_ascii,news_content,news_img FROM ".$tb_prefix."news ORDER BY news_id DESC LIMIT $num");

	$i = 0;

	while ($rs = $mysql->fetch_array($q)) {

        if ($h['start_tag'] && fmod($i,$apr) == 0) $main .= $h['start_tag'];
	$sql = $mysql->query("SELECT news_id,news_name,news_name_ascii FROM ".$tb_prefix."news where news_id <> ".$rs['news_id']." order by news_id DESC LIMIT 1");
	    $r_news = $mysql->fetch_array($sql);
//Lay thong tin ngan gon ve tin
  		$str_url = text_tidy( $rs['news_content']);
		$str_url =strip_tags($str_url);
		$news_info_cut = get_words_film_info($str_url,50);
//End lay thong tin ngan gon ve tin
		$main .= $temp->replace_value($h['row'],

			array(

//				'news.ID'			=> $rs['news_id'],

				'news.URL'			=> $web_link."/tin-tuc/".replace($rs['news_name_ascii'])."_".$rs['news_id'].".html",

				'news.CUT_NAME'		=> ucwords($rs['news_name']),

				'news.NAME'		=> ucwords($rs['news_name']),

				'news.IMG'			=> check_img($rs['news_img']),
				'news.DETAILS.CUT' => get_words_film_info($rs['news_content'],55),
				'news.OTHER' => $r_news['news_name'],
				'new.OTHER.URL' => "/tin-tuc/".replace($r_news['news_name_ascii'])."_".$r_news['news_id'].".html",
				'news.INFOCUT' =>ucfirst($news_info_cut),

				)

		);

		if ($h['end_tag'] && fmod($i,$apr) == $apr - 1) $main .= $h['end_tag'];

		$i++;

	}

	if ($h['end_tag'] && fmod($i,$apr) != $apr - 1) $main .= $h['end_tag'];

	$main = $temp->replace_blocks_into_htm($htm,array(

		'news_menu' 		=> $main

		)

	);

	return $main;

}


function announcement() 
{
	global $mysql,$temp,$tb_prefix;
	
	$cachefile = 'cache/cache_announcement.cache';	
		
	$main = cache_begin($cachefile,120);  // save cache one day
		
	if (!$main) 
	{

		$html = $temp->get_tpl('announcement');
	
		$contents = get_data('cf_announcement','config','cf_id',1,1);
	
		$contents = text_tidy($contents);
	
		if (!$contents) return '';
	
		$main .= $temp->replace_value($html,array(
		
						 'ann.CONTENT'	=>	$contents,
		
					)
		
				);
		cache_end($cachefile,$main);
	}
	
	return $main;

}


function write_comment($num=10,$film_id,$page)
{
    global $mysql,$tb_prefix,$temp,$web_link,$isLoggedIn; 
	
	if (!$isLoggedIn)	$usersession='0';
	
	else $usersession = $_COOKIE['UserCookieSessionTVB'];
	
	if (!$page) $page = 1;

	$limit = ($page-1)*$num;

	$main = $temp->get_tpl('comment');	

	$q = $mysql->query("SELECT * FROM ".$tb_prefix."comment WHERE comment_film = $film_id ORDER BY comment_time DESC LIMIT ".$limit.",$num");

	$total = get_total("comment","comment_id","WHERE comment_film = $film_id");

	if ($total) 
	{
		$comment_block = $temp->get_block_from_htm($main,'comment_block');

		$comment = $temp->get_block_from_htm($comment_block,'comment',1);		

		$html = '';

		$unset = false;

		$i = 0;

		while ($r = $mysql->fetch_assoc($q)) 
		{
			$i++;
			$name=$r['comment_poster'];
			
			$user = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_name = '$name'");

			$u= $mysql->fetch_assoc($user);
			
			if ($u['user_avatar']!="") $avatar= $u['user_avatar'];
			else $avatar= $web_link.'/no-avatar.gif';
			$level = $u['user_level'];
	            switch ($level) {
			    case 1 : $color = '#CCCCCC';	break;
		            case 2 : $color = '#FFFF00';	break;
		            case 3 : $color = '#009900';	break;
                            case 4 : $color = '#FF0000';        break;              

		        }
			$html .= $temp->replace_value($comment,

				array(
					
					'user.URL'			=> $web_link.'/user/home/'.$name,
					
					'user.AVATAR'		=>	$avatar,
					
					'user.COLOR'		=>	$color,

					'comment.POSTER'	=>	$name,
					
					'comment.TIME'		=> 	date('d-m-Y',$r['comment_time']),

					'comment.CONTENT'	=>	ucfirst(bad_words(un_htmlchars(emotions_replace(text_tidy($r['comment_content'],1))))),
					
				)

			);

		}

		

	}

	else $html = $lang[$_COOKIE['LANG']]['lang[no_comment]'];

    $main = $temp->replace_blocks_into_htm($main,

		array(

			'comment_block'	=>	$html,
			
		)

	);

	$main = $temp->replace_value($main,

		array(

			'film.ID'			=>	$film_id,

			'limit.COMMENT'		=>	$num,

			'pages.COMMENT' 	=> 	view_pages('comment',$total,$num,$page,$film_id),
			
			'user.SESSION'		=>	$usersession,		

		)

	);

return $main;

} 
function user_login() {
	global $mysql,$temp,$tb_prefix,$link_href;
	
	$link_href=".";
	$isLoggedIn=m_checkLogin();
	if ($isLoggedIn) {
		$q = $mysql->query("SELECT user_name,user_fullname,user_avatar FROM ".$tb_prefix."user WHERE user_id = '".$_SESSION['user_id']."'");
		$r = $mysql->fetch_array($q);
		if ($r['user_avatar']=="") $avatar="./no-avatar.gif";
		else $avatar=$r['user_avatar'];
		$htm = $temp->get_htm('user_login');
		$main = $temp->replace_value($htm,array(
			'name' 		=> $r['user_name'],
			'fullname' 		=> $r['user_fullname'],
			'avatar' 		=> $avatar,
			)
		);
	}else{
		$main = $temp->get_htm('user_notlogin');
	}
	return $main;
}

?>