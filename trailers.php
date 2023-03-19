<?php

$trailers_id = intval($_GET['trailers']);

$q = $mysql->query("SELECT trailers_film,trailers_name,trailers_type, trailers_url, trailers_des FROM ".$tb_prefix."trailers WHERE trailers_id = $trailers_id");

$rs = $mysql->fetch_array($q); $num = $mysql->num_rows($q); 

#######################################

# FUNCTIONS RELATE trailers

#######################################

function trailers($total_trailers,$film_id,$trailers_id){

	global $mysql,$temp,$tb_prefix,$web_link;

	$film_name = get_data('film_name_ascii','film','film_id',$film_id);

	if($total_trailers != 1){

	$html = $temp->get_htm('trailers');
	
	$q = $mysql->query("SELECT trailers_name,trailers_id FROM ".$tb_prefix."trailers WHERE trailers_film = ".$film_id." ORDER BY trailers_name ASC");

	while ($r = $mysql->fetch_array($q)){
	
	$str=$r['trailers_name'];
	if($str[0].$str[1]==00)
	$trailers_name=$str[2].$str[3];
	elseif($str[0]==0)
	$trailers_name=$str[1].$str[2].$str[3];
	else
	$trailers_name=$str;		

		if($r['trailers_id']==$trailers_id){

	    $h['row'] = $temp->get_block_from_htm($html,'current_trailers.row',1);

		$main .= $temp->replace_value($h['row'],

			array(

                'trailers.NAME' => $trailers_name,

				'trailers.URL'  => $web_link."/xem-trailer/".replace($film_name)."_".$r['trailers_id'].".html",

				)

		    );

		}

        else {

			 $h['row'] = $temp->get_block_from_htm($html,'other_trailers.row',1);

		     $main .= $temp->replace_value($h['row'],array(

                'trailers.NAME' => $trailers_name,

				'trailers.URL'  => $web_link."/xem-trailer/".replace($film_name)."_".$r['trailers_id'].".html",

				)

		    );

		  } 

		}

    }

  return $main;

}

#######################################

# PLAY

####################################### 

if ($num){

    $width=935;
	$height=600;

	$film = $mysql->fetch_array($mysql->query("SELECT film_rating_total,film_rating,film_name,film_name_ascii,film_name_real FROM ".$tb_prefix."film WHERE film_id = '".$rs['trailers_film']."'"));
	if ($film['film_rating_total'] == 0) $rate_text = "<br>RATE";

	else $rate_text = "<br>".$film['film_rating']." Star | ".$film['film_rating_total']." Rates";

	rating_img($film['film_rating'],$film['film_rating_total']);

	$rater_stars_img = $r_s_img; $film_id = $rs['trailers_film'];

	$web_keywords_main = $web_title_main = cut_string($rs['trailers_des'],100)." - ".$film['film_name']." - ".$film['film_name_real'];

	$total_trailerss = get_total("trailers","trailers_id","WHERE trailers_film = $film_id"); 	
	$str=$rs['trailers_name'];
	if($str[0].$str[1]==00)
	$trailers_name=$str[2].$str[3];
	elseif($str[0]==0)
	$trailers_name=$str[1].$str[2].$str[3];
	else
	$trailers_name=$str;
    $player = players($rs['trailers_url'],'',$trailers_id,625,450,1);
	$TangFilm =$web_link."/xem-trailer/".replace($film['film_name_ascii'])."_".$rs['trailers_name'].".html";
	$menu_film =$khungdieuchinh;
	$web_title = 'Trailer Phim  '.$web_title_main; 

	$web_keywords = $web_keywords_main.$web_keywords;
	
	$html = $temp->get_tpl('index_trailers');
	$html = $temp->replace_value($html,array(
				'TITLE'				=> 	$web_title,		
				'PLAYER'			=>	$player,
				'EPISODE'			=>	trailers($total_trailerss,$film_id,$trailers_id),
					)

			);

	

		$temp->print_htm($html);
}
?>




