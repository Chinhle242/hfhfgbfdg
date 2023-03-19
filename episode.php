<?php

$episode_id = intval($_GET['episode']);

$q = $mysql->query("SELECT episode_name, episode_film, episode_local, episode_url, episode_type, episode_lang  FROM ".$tb_prefix."episode WHERE episode_id = ".$episode_id);



$rs = $mysql->fetch_assoc($q);



if ($rs['episode_url'])

{
	
	## BEGIN FILM INFO
	
	
	

	$f = $mysql->fetch_assoc($mysql->query("SELECT film_name,film_name_real,film_name_ascii,film_server,film_rating,film_rating_total FROM ".$tb_prefix."film WHERE film_id = ".$rs['episode_film']." AND film_show = 1"));



	if ($f['film_name'])

	{

		$TITLE = check_film_name($f['film_name_real'],$f['film_name']);

		

		if ($f['film_rating_total'] == 0) 

		{

			$rate_text = $lang[$_COOKIE['LANG']]['lang[rate]'];

			

			$rating = 0;

		}

		

		else 

		{

			$rate_text = $f['film_rating']." Stars | ".$f['film_rating_total']." Rates";

			

			$rating = $f['film_rating'] / $f['film_rating_total'];

		}



   		$rater_stars_img = rating_img($f['film_rating'],$f['film_rating_total'],1,$rs['episode_film']);

	

		if ($rating <= 0  ) $rate_current = '0';

		if ($rating >= 0.5) $rate_current = '0.5';

		if ($rating >= 1  ) $rate_current = '1';

		if ($rating >= 1.5) $rate_current = '1.5';

		if ($rating >= 2  ) $rate_current = '2';

		if ($rating >= 2.5) $rate_current = '2.5';

		if ($rating >= 3  ) $rate_current = '3';

		if ($rating >= 3.5) $rate_current = '3.5';

		if ($rating >= 4  ) $rate_current = '4';

		if ($rating >= 4.5) $rate_current = '4.5';

		if ($rating >= 5  ) $rate_current = '5';		



	## END FILM INFO

	

	## BEGIN EPISODES INFO



		if ($rs['episode_local'])	$url = get_data('local_link','local','local_id',$rs['episode_local'],1).$rs['episode_url'];

		

		else $url = $rs['episode_url'];

		

		$player = players($url,$rs['episode_type'],$episode_id,595,476,1);

		

	## END EPISODES INFO	

	

		$web_title = $TITLE.' Online Tập '. $rs['episode_name'];

		

		$web_keywords = ' xem phim '.$f['film_name'].', xem phim  '.$f['film_name_real'].', phim '.$f['film_name'].', phim '.$f['film_name_real'].','.$f['film_name'].','.$f['film_name_real'].', xem '.$f['film_name'].', xem '.$f['film_name_real'].', xem phim online '.$f['film_name'].', xem phim online '.$f['film_name_real'].', '.$f['film_name'].' episode '.$rs['episode_name'].', '.$f['film_name_real'].' episode '.$rs['episode_name'].', '.$f['film_name'].' tap '.$rs['episode_name'].', '.$f['film_name_real'].' tap '.$rs['episode_name'].', '.$web_keywords;

		

		$web_des = 'xem phim '.$f['film_name'].', xem phim '.$f['film_name_real'].', phim '.$f['film_name'].', phim '.$f['film_name_real'].','.$f['film_name'].','.$f['film_name_real'].', xem '.$f['film_name'].', xem '.$f['film_name_real'].', xem phim online '.$f['film_name'].', xem phim online '.$f['film_name_real'].', '.$f['film_name'].' episode '.$rs['episode_name'].', '.$f['film_name_real'].' episode '.$rs['episode_name'].', '.$f['film_name'].' tap '.$rs['episode_name'].', '.$f['film_name_real'].' tap '.$rs['episode_name'].', '.$web_des;		



		$html = $temp->get_tpl('index_play');

		

		$html = $temp->replace_value($html,array(

		

				'film.ID'			=>	$rs['episode_film'],



				'TITLE'				=> 	$TITLE,		

				

				'PLAYER'			=>	$player,	

	

				'LINK.DOWN'			=>	$web_link.'/xem-phim/download/'.$f['film_name_ascii'].'_'.$episode_id.'.html',									

				'send'              =>  $web_link.'/?episode='.$episode_id,


				'rate.CURRENT'		=>	$rate_current,

				

				'rate.IMG'			=>	$rater_stars_img,

				

				'rate.TEXT'			=>	$rate_text,	

				

				'EPISODE.ID'		=>	$episode_id,

				

				'EPISODE'			=>	check_server($rs['episode_film'],$episode_id,$rs['episode_lang'],$f['film_server'],$f['film_name_ascii']),

                'DOWNLOAD'	=>	check_server_download($rs['episode_film'],$episode_id,$rs['episode_lang'],$f['film_server'],$f['film_name_ascii']),

	

					)

			);

	

		$temp->print_htm($html);

		exit();

	}

	

	else header('Location: '.$web_link.'/error.html');

}



else header('Location: '.$web_link.'/error.html');

?>







