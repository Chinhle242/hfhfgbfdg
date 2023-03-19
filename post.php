<?php
if (!defined('IN_MEDIA')) die("Hack");
if ($_POST['rating']) {
	$id = (int)$_POST['film_id'];

	$star = (int)$_POST['star'];

	//if (!preg_match("#(.*?),".$id."(.*?)#s",$_COOKIE['FILM_RATE']) ) {
	
	//setcookie("FILM_RATE", $_COOKIE['FILM_RATE'].','.$id, time() + 60*60*24*365, "/", ""); 
	
	$mysql->query("UPDATE ".$tb_prefix."film SET film_rating = film_rating + ".$star.", film_rating_total = film_rating_total + 1, film_rate = film_rating / film_rating_total WHERE film_id = ".$id);	
	
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = ".$id);

	$q = $mysql->fetch_assoc($q);

	$rater_stars_img = rating_img($q['film_rating'],$q['film_rating_total'],2,$id);
	//$rater_stars_img ="";

	echo '<div id="rating">'.$rater_stars_img.'</div>'
		.'<div id="rating_text">'
		.'<font color="#F5AA59" size="3"><b>'.$q['film_rating'].' Stars | '.$q['film_rating_total'].' Rates</b></font>'
		.'</div>';	
}
elseif ($_POST['broken']) {
	$film_id = (int)$_POST['film_id'];
    $episode_id = (int)$_POST['episode_id'];
    $trailers_id = (int)$_POST['trailers_id'];
	$htm = $temp->get_tpl('broken');	
	$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 1 WHERE film_id = $film_id");
    $mysql->query("UPDATE ".$tb_prefix."episode SET episode_broken = 1 WHERE episode_id = $episode_id");
    $mysql->query("UPDATE ".$tb_prefix."trailers SET trailers_broken = 1 WHERE trailers_id = $trailers_id");
	$main = $temp->replace_value($htm,array(
					'broken.IMG'	=>	$web_link.'/images/emoticons/1.gif',
					'broken.THANKS'	=>	$lang[$_COOKIE['LANG']]['lang[thanks]'],
				)
			);
  echo $main;
 exit();
}

elseif ($_POST['comment']) 
{
/*
  if (isFloodPost($_SESSION['prev_post'])) {
			echo '<p align="center"><img src='.$web_link.'/images/warning.gif width=100 height=100><br><b>You need to wait '.$wait_post.' seconds before post</b></p>';
		exit();
	 }
*/	 
	$warn = '';
	$film_id = (int)$_POST['film_id'];
	
	$comment_poster = mysql_escape_string($_POST['comment_poster']);
	if (!$isLoggedIn) $comment_poster = 0;
	else $comment_poster = $_SESSION['user_name'];
	
	$comment_content = strip_tags(mysql_escape_string($_POST['comment_content']));
	
	if ($comment_content == "" || $comment_content =="Messege" || $comment_content ==" Messege" )
	{
	    echo '<p align="center"><b>You have not enter any text</b></p>';
		exit();
	}
	
	elseif ($comment_poster=='0') {
	 		echo '<center>You must login<br>
			Bấm vào <a href="/user/reg" target=_blank>đây</a> để đăng kí nếu bạn chưa có tài khoản </center>';
		exit();
	}
	
	if ($film_id && $comment_content)
	{
		$sql="INSERT INTO ".$tb_prefix."comment (comment_film,comment_poster,comment_content,comment_time) VALUES ('".$film_id."','".$comment_poster."','".$comment_content."','".NOW."')";
		$mysql->query($sql);
	}

	if ($warn) echo "<b>Error!</b> ".$warn;
	
	else echo "OK";
	
	$_SESSION['prev_message_post'] = time();
	
	exit();
	
}
elseif ($_POST['download']) {
	$warn = '';
	$film_id = (int)$_POST['film_id'];
	$download_poster = $_POST['download_poster'];
	$download_content = strip_tags(mysql_escape_string($_POST['download_content']));
	if ($download_content == ""){
	        echo '<center>Error !</center>';
		exit();
	 }
	 elseif ($download_poster=='0') {
	 		echo '<center>Must to Login<br>
			Click <a href="/forum" target=_blank>Here</a> to register</center>';
		exit();
	}
	elseif ($film_id && $download_content){
	$mysql->query("INSERT INTO ".$tb_prefix."downloadlink (film_id,download_poster,download_content,download_time) VALUES ('".$film_id."','".$download_poster."','".$download_content."','".NOW."')");
	}

	if ($warn) echo "<b><center>Error !</center></b>";
	else echo "OK";
	$_SESSION['prev_message_post'] = time();
	exit();
}
?>