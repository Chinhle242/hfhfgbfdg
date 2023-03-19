<?php

if (!defined('IN_MEDIA')) die("Hack");

$page = $p = intval($page);

		

#######################################

# LIST

#######################################



if ($list || $search || $quick_search || $category || $actor || $sactor || $sfilm || $sdirector ) 

{

    if ($list) 

	{

		$where_sql = '';

		

		$link_page ='list/'.$list;

		

		if ($list=='phim-xem-nhieu')

		{

			$order_sql = 'WHERE film_viewed > 0  AND film_show = 1 ORDER BY film_viewed DESC';

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[most_views]'];

		}

		

		elseif ($list=='top-rate')

		{ 

			$order_sql = "WHERE film_rating_total > 0  AND film_show = 1  ORDER BY film_rating_total DESC";

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[most_rate]'];

		}

		

		elseif ($list=='language')

		{ 

			$l = intval($l);

			

			if ($l==3 || $l ==5 || $l==6 )

			{ 

				$wl='film_lang=3 OR film_lang=5 OR film_lang=6';

				

				$lang_name=lang_f(3);

			}

			

			else 

			{ 

				$wl= 'film_lang='.$l; 

				

				$lang_name=lang_f($l);

			}

			

			$order_sql = "WHERE $wl AND film_show = 1  ORDER BY film_date DESC";



			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[lang]'].': '.$lang_name;

			

			$link_page ='language/'.replace(strtolower(get_ascii(lang_f($l)))).'/l'.$l;

		}

		

		elseif ($list=='phim-bo')

		{ 

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[drama_series]'];



			$l = intval($l);

			

			if ($l)	

			{	

				if ($l==3 || $l ==5 || $l==6) 

				{ 

					$wl='AND (film_lang=5 OR film_lang=3 OR film_lang=6)'; 

					

					$lang_name=lang_f(3);

				}

				else 

				{

					$wl= 'AND film_lang='.$l; 

					

					$lang_name=lang_f($l);

				}

				

				$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[drama_series]'].': '.$lang_name;



				$link_page ='phim-bo/'.replace(strtolower(get_ascii($lang_name))).'/l'.$l;

			}	

			

			$c = intval($c);

			

			if ($c) 

			{	

				$wc = 'AND film_country = '.$c; 

				

				$name=	replace(strtolower(get_ascii(country_name($c))));

				

				if ($l) 

				{		

					$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[drama_series]'].': '.country_name($c).' ('.$lang_name.')';

					

					$name = $name.'/'.replace(strtolower(get_ascii($lang_name))).'/l'.$l;	

				}

				else 

					$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[drama_series]'].': '.country_name($c);

					

				$link_page ='phim-bo/'.$name.'/c'.$c;	

			}

			

			$order_sql = "WHERE film_type = 1 $wl $wc AND film_show = 1  ORDER BY film_date DESC";		



		}		

		

		elseif ($list=='phim-le')

		{ 

			$order_sql = "WHERE film_type=0 AND film_show = 1  ORDER BY film_date DESC";

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[single_movies]'];

		}

		

		elseif ($list=='phim-le-hot')

		{ 

			$order_sql = "WHERE film_type=0 and film_viewed > 0 AND film_show = 1  ORDER BY film_viewed DESC";

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[hot_movies]'];

		}

		

		elseif ($list=='phim-bo-hot')

		{ 

			$order_sql = "WHERE film_type=1 and film_viewed > 0 AND film_show = 1  ORDER BY film_viewed DESC";

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[hot_movies]'];

		}

	

		elseif ($list=='phim-chieu-rap')

		{ 

			$order_sql = "WHERE film_cinema =1 AND film_show = 1  ORDER BY film_id DESC";

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[cinema]'];

		}

		

		elseif ($list == 'xem-trong-ngay') 

		{



			$where_sql = "WHERE film_viewed_day > 0 AND film_show = 1 "; $order_sql = "ORDER BY film_viewed_day";



			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[view_day]'];



		}

		

		elseif ($list == 'country') 

		{

			$c = intval($c);

			

			$country=$c;

			

			$country_name = country_name($c);

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[country]'].": ".$country_name;



			$name=replace(strtolower(get_ascii($country_name)));

			

			$link_page ='country/'.$name.'/c'.$c;	

			

			$l = intval($l);

			

			if ($l) 

			{	

				if ($l==3 || $l ==5 || $l==6 )

				{ 

					$wl='AND (film_lang=3 OR film_lang=5 OR film_lang=6)';

					

					$lang_name=lang_f(3);

				}

				else 

				{ 

					$wl= 'AND film_lang='.$l; 

					

					$lang_name=lang_f($l);

				}

				

				$name = $name.'/'.replace(strtolower(get_ascii(lang_f($l)))).'/l'.$l;

				

				$title = $keywords = $description = $title.' ('.$lang_name.')';

				

				$link_page ='country/'.$name.'/c'.$c;	

			}

				

			$where_sql = "WHERE film_country = ".$c." $wl AND film_show = 1  ORDER BY film_date DESC";



		}			// Country

		else

		{ 

			$order_sql = 'WHERE film_show = 1 ORDER BY film_date DESC';

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[new]'];

		}

	}			// List phim



	elseif ($actor) 

	{

		$actor = mysql_escape_string($actor);

		

		$where_sql = '';

		

		$link_page ='actor/'.$actor;

		

		$actor = str_replace('-',' ',$actor);

		

		$t_film_actor = urldecode($actor);

		

		$order_sql = "WHERE film_actor_ascii LIKE '%".get_ascii($t_film_actor).", %' OR film_actor_ascii LIKE '%, ".get_ascii($t_film_actor)."%'  OR film_actor_ascii LIKE '".get_ascii($t_film_actor)."' AND film_show = 1  ORDER BY film_date DESC";

		

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[actor]']." ". ucwords($t_film_actor);

	}	

			// dien vien

	elseif ($search) 

	{	

		$key= str_replace('+',' ', $search);

		

		$key=str_replace('  ',' ',$key);

		

	    $kw = get_ascii(urldecode(mysql_escape_string($key)));

		

		$where_sql = "WHERE (film_name_ascii LIKE '%".$kw."%' OR  film_name_real LIKE '%".urldecode($key)."%' OR film_actor_ascii LIKE '%".$kw."%' OR film_director_ascii LIKE '%".$kw."%') AND film_show = 1  ORDER BY film_date DESC";

		

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[search_resurlt]'].": ".Unistr(urldecode($key))."";

		

		$key= str_replace(' ','+', $search);

		

		$link_page = 'search/'.$key;

	}	

			// Search

	elseif ($sfilm) 

	{	

		$key= str_replace('+',' ', $sfilm); 		$key=str_replace('  ',' ',$key);

	    $kw = get_ascii(urldecode(mysql_escape_string($key)));

		$where_sql = "WHERE film_name_ascii LIKE '%".$kw."%'  OR film_name_real LIKE '%".urldecode($key)."%' AND film_show = 1  ORDER BY film_date DESC";

		$page = $p;

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[search_resurlt]'].": ".Unistr(urldecode($key))."";

		$key= str_replace(' ','+', $sfilm);

		$link_page = 'search-film/'.$key;

	}	

		// Search Film

	elseif ( $sactor ) 

	{	

		$key=str_replace('+',' ', $sactor); 

		

		$key=str_replace('  ',' ',$key);

		

	    $kw = get_ascii(urldecode(mysql_escape_string($key)));

		

		$where_sql = "WHERE film_actor_ascii LIKE '%".$kw."%'  AND film_show = 1  ORDER BY film_date DESC ";

		

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[search_resurlt]'].": ".Unistr(urldecode($key))."";

		

		$key=str_replace(' ','+', $sactor );

		

		$link_page = 'search-actor/'.$key;

	}	

		// Search Actor

	elseif ($sdirector) {

		$key=str_replace('+',' ', $sdirector);

		

		$key=str_replace('  ',' ',$key);

		

		$key=str_replace('-',' ', $sdirector);	

				

	    $kw = get_ascii(urldecode(mysql_escape_string($key)));

		

		$where_sql = "WHERE film_director_ascii LIKE '%".$kw."%' AND film_show = 1  ORDER BY film_date DESC ";

		

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[search_resurlt]'].": ".Unistr(urldecode($key))."";

		

		$key=str_replace(' ','+', $sdirector);

		

		$link_page = 'search-director/'.$key;

	}	

		// Search Director

	elseif ($quick_search) 

	{

	    $kw = urldecode(mysql_escape_string($quick_search));

		

		if ($_COOKIE['LangCookie'] =='vietnamese') $w='film_name_ascii'; else $w='film_name_real';

		

		if ($quick_search== "0-9") $where_sql = "WHERE $w RLIKE '^[0-9]' AND film_show = 1  ORDER BY film_date DESC";

		

		else $where_sql = "WHERE $w LIKE '".$kw."%' AND film_show = 1  ORDER BY film_date DESC";

		

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[quick_search]'];

		

		$link_page = 'quick_search/'.$quick_search;

	}

				// Quick Search

	elseif ($category) 

	{

	    $cat_id = intval($category);

		

		$l = intval($l);		

		

		$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[cat]'].": ".get_data('cat_name_English','cat','cat_id',$cat_id);

		

		$name= 'the-loai/'.replace(strtolower(get_ascii(get_data('cat_name_English','cat','cat_id',$cat_id))));

		

		if ($t) 

		{

			$wt= 'AND film_type =0'; 

			

			$name=str_replace('the-loai/','phim-le/category/',$name); 

			

			$title = $keywords = $description = $lang[$_COOKIE['LANG']]['lang[single_movies]'].' - '.$title;

		}

		

	

		if(!$l)	$where_sql = "WHERE film_cat = $cat_id $wt AND film_show = 1  ORDER BY film_date DESC";

		

		else	

		{

			if ($l==3 || $l ==5 || $l==6 )

			{ 

				$wl='(film_lang=3 OR film_lang=5 OR film_lang=6)';

				

				$lang_name=lang_f(3);

			}

			else 

			{ 

				$wl= 'film_lang='.$l; 

				

				$lang_name=lang_f($l);

			}

			

			$where_sql = "WHERE film_cat = $cat_id AND $wl $wt  AND film_show = 1 ORDER BY film_date DESC";

			

			$title = $keywords = $description = $title.' ('.$lang_name.')';

			

			$name= $name.'/'.strtolower(replace(get_ascii(lang_f($l)))).'/l'.$l;

		}

		

		$link_page = $name.'/g'.$category;

		

	}		// Category



	

	$htm = $temp->get_tpl('list');

	

	if (!$page) $page = 1;

	

	$limit = ($page-1)*$per_page;

	

	$h['num_tag'] = $temp->get_block_from_htm($htm,'num_tag',1);

	

	$h['start_tag'] = $temp->get_block_from_htm($htm,'start_tag',1);

	

	$h['end_tag'] = $temp->get_block_from_htm($htm,'end_tag',1);

	

	$h['row'] = $temp->get_block_from_htm($htm,'row',1);

	

	$q = $mysql->query("SELECT film_id, film_name, film_name_real, film_name_ascii, film_img,film_viewed,film_lang,film_rating,film_rating_total FROM ".$tb_prefix."film ".$where_sql." ".$order_sql." LIMIT ".$limit.",".$per_page."");

	

	$total = get_total("film","film_id","$where_sql $order_sql");

	
	if ($total)

	{
	

		while ($rs = $mysql->fetch_array($q)) 

		{

	   		static $i = 0;

			$j = $j+1;
			

			$rater_stars_img = rating_img($rs['film_rating'],$rs['film_rating_total']);	   

			

			//$TITLE = check_film_name($rs['film_name_real'],$rs['film_name']);
                        $TITLE = $rs['film_name']. ' - ' .$rs['film_name_real']. ' - ' .$rs['film_name_ascii']. ' - ' .$rs['film_name_real'];

			

			if ($h['start_tag'] && fmod($i,$h['num_tag']) == 0) $main .= $h['start_tag'];

			

			$main .= $temp->replace_value($h['row'],

					array(

					

				'film.URL'		=> $web_link."/thong-tin/".replace(strtolower(get_ascii($rs['film_name_real'])))."_".$rs['film_id'].".html",

				

				'TITLE'			=> get_words($TITLE,3),

				'Vuaphim'       => $TITLE,

				'film.VIEWED'	=> $rs['film_viewed'],

				

				'film.IMG'		=> check_img($rs['film_img'],1),

				

				'rate.IMG'		=>	$rater_stars_img,

				

				)

			);
			
		

			if ($h['end_tag'] && fmod($i,$h['num_tag']) == $h['num_tag'] - 1) $main .= $h['end_tag'];

		

			$i++;

		}
	
		$main = $temp->replace_blocks_into_htm($htm,array(

			'film_list' 		=> $main

			)

		);

		

		$main = $temp->replace_value($main,

			array(

				'lang.TITLE'		=> $title,



				'VIEW_PAGES'		=> view_pages('film',$total,$per_page,$page,$link_page),

			)

		);

		


		$web_title 		= 	"xem phim ".$title." - ".$web_title ;

		

		$web_keywords 	= 	"xem phim ".$title.', '.$web_keywords;

		

		$web_des		=  	"xem phim ".$title.', '.$web_des;
	

  	}

  

  else header("Location: ".$web_link.'/error.html');

  

}



#######################################

# INFO

#######################################

elseif ($info) 

{

	$film_id = intval($info );

	

	$q = $mysql->query("SELECT film_id,film_name,film_name_ascii,film_name_real,film_actor,film_actor_ascii,film_img,film_info,film_country,film_cat,film_director,film_director_ascii,film_time,film_year,film_area,film_rating,film_rating_total,film_rate,film_server,film_lang FROM ".$tb_prefix."film WHERE film_id = '$film_id' AND film_show = 1 ");

	

	if (!$mysql->num_rows($q)) header("Location: ".$web_link.'/error.html');

	

	$r = $mysql->fetch_assoc($q);

	

	$film_name_real= $r['film_name']; 

		

	$film_name=$r['film_name_real'];



	

	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed = film_viewed + 1, film_viewed_day = film_viewed_day + 1 WHERE film_id = '".$film_id."'");	

	

	if($r['film_server']==1)	$splitserver='';

	

	else		

	{

		$splitserver=explode(',',$r['film_server']);

		

		$splitserver="AND server_id='".$splitserver[0]."'";	

	}

	

	$episode = $mysql->fetch_assoc($mysql->query("SELECT episode_id FROM ".$tb_prefix."episode WHERE episode_film = '".$film_id."' ".$splitserver." ORDER BY episode_name ASC LIMIT 0,1"));



	$q_trailers = $mysql->query("SELECT trailers_id FROM ".$tb_prefix."trailers WHERE trailers_film = ".$r['film_id']." ORDER BY rand() LIMIT 1");

	

	$trailers =$rs_trailers = $mysql->fetch_array($q_trailers); 

	if ($rs_trailers['trailers_id'])

	{

	$trailers_button ='<a title="watch trailers" href="'.$web_link.'/watch-trailer/'.replace($r['film_name_ascii']).'_'.$trailers['trailers_id'].'.html" target="_blank"><img src="skin/tmp/images/watch_trailer.png" /></a>';

	}

	else	$trailers_button ='';

	


	

	if (!$episode['episode_id'])		$watch = '';

	

	else 

		$watch	= '<a href="'.$web_link.'/xem-phim/online/'.replace($r['film_name_ascii']).'_'.$episode['episode_id'].'.html"><img src="http://vuaphim.vn/skin/tmp/images/watch_now.png" /></a></p>';

	$vuaphim_play =	'http://vuaphim.vn/xem-phim/online/'.replace($r['film_name_ascii']).'_'.$episode['episode_id'].'.html ';

	$film_img = check_img($r['film_img']);

	

    $film_info = text_tidy($r['film_info']);

	

	$film_year = check_data($r['film_year']);

	

	$film_time = check_data($r['film_time']);

	

	$film_area = check_data($r['film_area']);

	

	$film_director=splitlink(check_data($r['film_director']),'search-director','');

	

	$film_actor=splitlink(check_data($r['film_actor']),'actor','');	

	

	$htm = $temp->get_tpl('info_film');

	

//	$rater_stars_img = rating_img($r['film_rating'],$r['film_rating_total']);

	

	$film_lang	= '<a href="'.$web_link.'/language/'.replace(strtolower(get_ascii(lang_f($r['film_lang'])))).'/l'.$r['film_lang'].'.html" style="text-decoration:none;">'.lang_f($r['film_lang']).'</a>';		

	$film_country =check_data(get_data('country_name_'.$_COOKIE['LangCookie'],'country','country_id',$r['film_country']));

	$cat=explode(',',$r['film_cat']);
	$num=count($cat);
	$film_cat="";
	for ($i=0; $i<$num;$i++) {
		$cat_name=check_data(get_data('cat_name_'.$_COOKIE['LangCookie'],'cat','cat_id',$cat[$i]));
		$film_cat .= '<a href="'.$web_link.'/the-loai/'.replace(strtolower(get_ascii($cat_name))).'/g'.$cat[$i].'.html" >'.$cat_name.'</a>,';
	}

	$film_country= '<a href="'.$web_link.'/country/'.replace(strtolower(get_ascii($film_country))).'/c'.$r['film_country'].'.html" style="text-decoration:none;"> '.$film_country.'</a>';

	

	$title = check_film_name($r['film_name_real'],$r['film_name']);

	

	$main = $temp->replace_value($htm,array(
											

			'film.ID'			=> 	$r['film_id'],

			'film.play'         =>  $vuaphim_play,

			'cat.ID'			=>	$r['film_cat'],

			

			'film.IMG'			=> 	$film_img,

			

			'TITLE'			=> get_words($title,3),

			'Vuaphim'       => $title,

			

			'film.ACTOR'		=> 	$film_actor,

			

			'film.DIRECTOR'		=> 	$film_director,

			

			'film.YEAR'			=> 	$film_year,

			

			'film.TIME'			=> 	replace_time($film_time),

			

			'film.AREA'			=>	ucfirst($film_area),

			

			'film.CAT'			=>  $film_cat,

			

  			'film.INFO'			=>	$film_info,

			

			'film.COUNTRY'		=>	$film_country,

			

			'TRAILER.BUTTON' 	=> 	$trailers_button,

			

			'WATCH'				=>	$watch,		

			

			'film.LANG'			=> 	$film_lang,	



				)

		);

		$web_title 		= 	$title." - ".$web_title ;

		

		$web_keywords 	= 	$title.', '.$web_keywords;

		

		$web_des		=  $title.', '.$web_des;

}

?>