<?php

if (!defined('IN_MEDIA')) die("Hack");

function m_setcookie($name, $value = '', $permanent = true) {
	global $web_link;
	$setCookieType=1;	
	$expire = ($permanent)?(time() + 60 * 60 * 24 * 365):0;
	
	if ($setCookieType == 1) {
		$url = $web_link;
		if ($url[strlen($url)-1] != '/') $url .= '/';
		$secure = (($_SERVER['HTTPS'] == 'on' OR $_SERVER['HTTPS'] == '1') ? true : false);
		$p = parse_url($url);
		$path = !empty($p['path']) ? $p['path'] : '/';
		$domain = $p['host'];
		if (substr_count($domain, '.') > 1) {
			while (substr_count($domain, '.') > 1)
			{
				$pos = strpos($domain, '.');
				$domain = substr($domain, $pos + 1);
			}
			
		}
		else $domain = '';
		@setcookie($name, $value, $expire, $path, $domain, $secure);
	}
	else @setcookie($name,$value,$expire);
} 

function m_check_random_str($str,$len = 5) {
	if (!ereg('^([A-Za-z0-9]){'.$len.'}$',$str)) return false;
	return true;
}

function m_checkLogin(){
	global $mysql, $tb_prefix;
	
	if ($_COOKIE['USER']) {
		$identifier = $_COOKIE['USER'];
		$q = $mysql->query("SELECT user_identifier, user_id, user_name FROM ".$tb_prefix."user WHERE user_identifier = '".$identifier."'");
		if ($mysql->num_rows($q)) {
			$r = $mysql->fetch_array($q);
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['user_name'] = $r['user_name'];
			$return = true;
		}
		else $return = false;
	}
	else $return = false;
	return $return;
}
function get_data($f1,$table,$f2,$f2_value){



	global $mysql,$tb_prefix;



	$q = $mysql->query("SELECT $f1 FROM ".$tb_prefix.$table." WHERE $f2='".$f2_value."'");



	$rs = $mysql->fetch_array($q);



	$f1_value = $rs[$f1];



	return $f1_value;



}




function get_data_forum($f1,$table,$f2,$f2_value){



	global $mysql,$forum_name,$forum_prefix;



	$q = $mysql->query("SELECT $f1 FROM ".$forum_name.".".$forum_prefix.$table." WHERE $f2='".$f2_value."'");



	$rs = $mysql->fetch_array($q);



	$f1_value = $rs[$f1];



	return $f1_value;



}

function rating_img($rate,$rate_tt,$type='',$film_id='') {

	if ($rate_tt =='0') $rating = 0;

	else $rating = $rate / $rate_tt;

	if ($rating <= 0  ){$star1 = "none"; $star2 = "none"; $star3 = "none"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 0.5){$star1 = "half"; $star2 = "none"; $star3 = "none"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 1  ){$star1 = "full"; $star2 = "none"; $star3 = "none"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 1.5){$star1 = "full"; $star2 = "half"; $star3 = "none"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 2  ){$star1 = "full"; $star2 = "full"; $star3 = "none"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 2.5){$star1 = "full"; $star2 = "full"; $star3 = "half"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 3  ){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "none"; $star5 = "none";}

	if ($rating >= 3.5){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "half"; $star5 = "none";}

	if ($rating >= 4  ){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "full"; $star5 = "none";}

	if ($rating >= 4.5){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "full"; $star5 = "half";}

	if ($rating >= 5  ){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "full"; $star5 = "full";}

	if ($type == 1 ) $r_s_img = ' <ul id="rating_container_video">'

.'<li><a href="javascript:void(0);" onclick="return rating('.$film_id.',1);" title="1 Star" id="star_video_1_'.$film_id.'" class="'.$star1.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);" onclick="return rating('.$film_id.',2);" title="2 Stars" id="star_video_2_'.$film_id.'" class="'.$star2.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);" onclick="return rating('.$film_id.',3);" title="3 Stars" id="star_video_3_'.$film_id.'" class="'.$star3.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);" onclick="return rating('.$film_id.',4);" title="4 Stars" id="star_video_4_'.$film_id.'" class="'.$star4.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);" onclick="return rating('.$film_id.',5);" title="5 Stars" id="star_video_5_'.$film_id.'" class="'.$star5.'">&nbsp;</a></li>'

									.'</ul>';	

	elseif ($type == 2)   $r_s_img = ' <ul id="rating_container_video">'

.'<li><a href="javascript:void(0);"  class="'.$star1.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);"  class="'.$star2.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);"  class="'.$star3.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);"  class="'.$star4.'">&nbsp;</a></li>'

.'<li><a href="javascript:void(0);"   class="'.$star5.'">&nbsp;</a></li>'

									.'</ul>';											

	else $r_s_img =       ' <ul class="rating_small">'

											.'<li><span class="'.$star5.'">&nbsp;</span></li>'

											.'<li><span class="'.$star4.'">&nbsp;</span></li>'

											.'<li><span class="'.$star3.'">&nbsp;</span></li>'

											.'<li><span class="'.$star2.'">&nbsp;</span></li>'

											.'<li><span class="'.$star1.'">&nbsp;</span></li>'

									.'</ul>';

  return $r_s_img;

}



function get_total($table,$f1,$f2 = '') {

	global $mysql, $tb_prefix;

	$q = "SELECT COUNT($f1) FROM ".$tb_prefix.$table;

	$q .= ($f2)?" ".$f2:'';

	$tt = $mysql->fetch_array($mysql->query($q));

	return $tt[0];

}



function replace($str) {

	$str = str_replace('%20', '-', $str);

	$str = str_replace(',', '-', $str);

	$str = str_replace('_', '-', $str);	

	$str = str_replace(' ', '-', $str);

	$str = str_replace(':', '-', $str);

	$str = str_replace('(', '-', $str);	

	$str = str_replace(')', '-', $str);		

	$str = str_replace('?', '-', $str);

	$str = str_replace('--', '-', $str);

	return $str;

}



function check_img($img,$t='') {

   	global $web_link;

	if ($img == '') $img = $web_link."/".$_SESSION['skin_folder']."/img/no_img.gif";

	if (preg_match("#http://(.*?)#s",$img))

	$img=$img;

	else 

	{

		if($t)	$img=str_replace('images/film',"http://vuaphim.vn/".'images/film',$img);

		else	$img= "http://vuaphim.vn".'/'.$img;

	}

	return $img;

}



function check_data($name) {

	global $lang_no;

	if ($name == '') $name = $lang_no;//If $lang_no="";
	if ($name == '') $name = "Äang cáº­p nháº­t";

	return $name;

}



function splitlink($name,$type, $class) {

	global $web_link,$lang_no;

	if ($name == '' || $name== $lang_no) $name = $lang_no;

	else

	{

		$dem = explode(', ',$name);

		$d=count($dem);

		for($i=0; $i<$d-1;$i++) {

		$fas= $fas.'<a href="'.$web_link.'/'.$type.'/'.replacesearch($dem[$i]).'.html" style="text-decoration:none;" class="'.$class.'">'.$dem[$i].'</a>, ';					}

	    $name = $fas.'<a href="'.$web_link.'/'.$type.'/'.replacesearch($dem[$d-1]).'.html" style="text-decoration:none;" class="'.$class.'">'.$dem[$d-1].'</a>';


	}

	return $name;

}



function text_tidy($string) {

	$string = str_replace ( '&amp;', '&', $string );

	$string = str_replace ( "'", "'", $string );

	$string = str_replace ( '&quot;', '"', $string );

	$string = str_replace ( '&lt;', '<', $string );

	$string = str_replace ( '&gt;', '>', $string );

	return $string;

}



function cut_string($str,$len) {

	if ($str=='' || $str==NULL) return $str;

	if (is_array($str)) return $str;

	$str = trim($str);

	if (strlen($str) <= $len) return $str;

	$str = substr($str,0,$len);

	$str = $str.' ...';

	return $str;

}



function get_words($str,$num)

{

	$limit = $num - 1 ;

    $str_tmp = '';

    $arrstr = explode(" ", $str);

    if ( count($arrstr) <= $num ) { return $str; }

    if (!empty($arrstr))

    {

        for ( $j=0; $j< count($arrstr) ; $j++)    

        {

            $str_tmp .= " " . $arrstr[$j];

            if ($j == $limit) 

            {

                break;

            }

        }

    }

    return $str_tmp.' ...';

}





function get_words_film_info($str,$num)

{

	$limit = $num - 1 ;

    $str_tmp = '';

    $arrstr = explode(" ", $str);

    if ( count($arrstr) <= $num ) { return $str; }

    if (!empty($arrstr))

    {

        for ( $j=0; $j< count($arrstr) ; $j++)    

        {

            $str_tmp .= " " . $arrstr[$j];



            if ($j == $limit) 

            {

                break;

            }

        }

    }



    return $str_tmp.' ...';

}



function bad_words($str) {

	$chars = array('Ä‘á»‹t','Äá»‹t','Äá»ŠT','Ä‘Ã©o','ÄÃ©o','ÄÃ‰O','lá»“n','Lá»“n','Lá»’N','cáº·c','Cáº·c','Cáº¶C','dÃ¡i','DÃ¡i','DÃI','chÃ³','ChÃ³','CHÃ“','Cá»©t','cá»©t','Cá»¨T','á»‰a','á»ˆa','Ä‘Ã¡i','ÄÃ¡i','á»ˆA');

	foreach ($chars as $key => $arr)

		$str = preg_replace( "/(^|\b)".$arr."(\b|!|\?|\.|,|$)/i", "***", $str ); 

	return $str;

}



function un_htmlchars($str) {

	return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;', '&#92;', '&#39'), array('<', '>', '"', '&', chr(92), chr(39)), $str );

}



function htmlchars($str) {

	return str_replace(

		array('&', '<', '>', '"', chr(92), chr(39)),

		array('&amp;', '&lt;', '&gt;', '&quot;', '&#92;', '&#39'),

		$str

	);

}

function m_random_str($len = 5) {
	$s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	mt_srand ((double)microtime() * 1000000);
	$unique_id = '';
	for ($i=0;$i< $len;$i++)
		$unique_id .= substr($s, (mt_rand()%(strlen($s))), 1);
	return $unique_id;
}

function check_random_str($str,$len = 5) {

	if (!ereg('^([A-Za-z0-9]){'.$len.'}$',$str)) return false;

	return true;

}





function get_ascii($str) {

	$chars = array(

		'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),

		'e' 	=>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),

		'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),

		'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),

		'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),

		'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),

		'd'	=>	array('đ','Đ'),

	);

	foreach ($chars as $key => $arr) 

		foreach ($arr as $val)

			$str = str_replace($val,$key,$str);

	return $str;

}



function emotions_array() {

	return array(

	

		'heo1' =>':heo1:',

		6 => '>:D<',		18 => '#:-S',				36 => '<:-P',		42 => ':-SS',

		48 => '<):)',		50 => '3:-O',				51 => ':(|)',		53 => '@};-',

		55 => '**==',		56 => '(~~)',				58 => '*-:)',		63 => '[-O<',

		67 => ':)>-',		77 => '^:)^',				106 => ':-??',		25 => 'O:)',

		26 => ':-B',		28 => 'I-)',				29 => '8-|',		30 => 'L-)',

		31 => ':-&',		32 => ':-$',				33 => '[-(',		34 => ':O)',

		35 => '8-}',		7 => ':-/',					37 => '(:|',		38 => '=P~',

		39 => ':-?',		40 => '#-O',				41 => '=D>',		9 => ':">',

		43 => '@-)',		44 => ':^O',				45 => ':-W',		46 => ':-<',

		47 => '>:P',		11 => array(':*',':-*'),	49 => ':@)',		12 => '=((',

		13 => ':-O',		52 => '~:>',				16 => 'B-)',		54 => '%%-',

		17 => ':-S',		5 => ';;)',					57 => '~O)',		19 => '>:)',

		59 => '8-X',		60 => '=:)',				61 => '>-)',		62 => ':-L',

		20 => ':((',		64 => '$-)',				65 => ':-"',		66 => 'B-(',

		21 => ':))',		68 => '[-X',				69 => '\:D/',		70 => '>:/',

		71 => ';))',		72 => 'O->',				73 => 'O=>',		74 => 'O-+',

		75 => '(%)',		76 => ':-@',				23 => '/:)',		78 => ':-J',

		79 => '(*)',		100 => ':)]',				101 => ':-C',		102 => '~X(',

		103 => ':-H',		104 => ':-T',				105 => '8->',		24 => '=))',

		107 => '%-(',		108 => ':O3',				1 => array(':)',':-)'),		2 => array(':(',':-('),

		3 => array(';)',';-)'),		22 => array(':|',':-|'),		14 => array('X(','X-('),		15 => array(':>',':->'),

		8 => array(':X',':-X'),		4 => array(':D',':-D'),		27 => '=;',		10 => array(':P',':-P'),

	);

}



function emotions_replace($s) {

   	global $web_link;

	$emotions = emotions_array();

	foreach ($emotions as $a => $b) {

		$x = array();

		if (is_array($b)) {

			for ($i=0;$i<count($b);$i++) {

				$b[$i] = htmlchars($b[$i]);

				$x[] = $b[$i];

				$v = ucfirst(strtolower($b[$i]));

				if ($v != $b[$i]) $x[] = $v;

				}

		}

		else {

			$b = htmlchars($b);

			$x[] = $b;

			$v = ucfirst(strtolower($b));

			if ($v != $b) $x[] = $v;

		}

		$p = '';

		for ($u=0;$u<strlen($x[0]);$u++) {

			$ord = ord($x[0][$u]);

			if ($ord < 65 && $ord > 90) $p .= '&#'.$ord.';';

			else $p .= $x[0][$u];

		}

		$s = str_replace($x,'<img src='.$web_link.'/images/emoticons/'.$a.'.gif align=absmiddle>',$s); 

			

	}

	return $s;

}



function isFloodPost(){

	$_SESSION['current_message_post'] = time();

	global $wait_post;

	$timeDiff_post = $_SESSION['current_message_post'] - $_SESSION['prev_message_post'];

	$floodInterval_post	= 45;

	$wait_post = $floodInterval_post - $timeDiff_post ;	

	if($timeDiff_post <= $floodInterval_post)

	return true;

	else 

	return false;

}

function get_videozp($string)

{	

	 $string = str_replace(' ','+',$string);

	  $fp = fsockopen("video.zing.vn",80, $errno, $errstr, 60);

    if (!$fp)

       return;

    else {

				fputs ($fp, "GET ".$string." HTTP/1.0\r\n");

		     	fputs ($fp, "Host: video.zing.vn\r\n");

	      		fputs ($fp, "User-Agent: Mozilla 4.0\r\n\r\n");

        $d = '';

        while (!feof($fp))

            $d .= fgets ($fp,2048);

    fclose ($fp);

    return $d;

    }	

}

function ngaythang($date,$type)

{

//	$date= date('H  m s D d-m-Y',$date);

	$dayofweek = date('D',$date);

		if ($dayofweek=='Mon')

			$dayofweek='Thá»© Hai';

		elseif ($dayofweek=='Tue')

			$dayofweek='Thá»© Ba';

		elseif ($dayofweek=='Wed')

			$dayofweek='Thá»© TÆ°';

		elseif ($dayofweek=='Thu')

			$dayofweek='Thá»© NÄƒm';

		elseif ($dayofweek=='Fri')

			$dayofweek='Thá»© SÃ¡u';

		elseif ($dayofweek=='Sat')

			$dayofweek='Thá»© Báº£y';

		elseif ($dayofweek=='Sun')

			$dayofweek='Chá»§ Nháº­t';

		else $dayofweek='';

	$datemonth = date('d/m/Y',$date);

	$time = date('H:m:s',$date);

	$kq = $dayofweek.', ngÃ y '.$datemonth.', '.$time;

	return $kq;

}

function check_name($str)

{

for($i=0;$i<5;$i++)	{

$str= str_replace('  ',' ',$str);}

$str= str_replace(' ,',',',$str);

$str = ltrim($str); $str= rtrim($str);

$str = queryspecail($str);

return $str;

}	

function get_user($id,$type=''){

	global $mysql,$forum_name,$forum_prefix,$vbb_folder;

/*	$q = $mysql->query("SELECT username,avatarid FROM ".$forum_name.".".$forum_prefix."user WHERE userid='".$id."'");

	$rs = $mysql->fetch_array($q);

if (!$rs)

	$out= $user = 'Guest';

else	{

	if($type=='avatar')	{

		$avatar=$rs['avatarid'];

		if ($avatar==0) {	$av=$mysql->fetch_array($mysql->query("SELECT dateline FROM ".$forum_name.".".$forum_prefix."customavatar WHERE userid='".$id."'")); 

				if ($av)	$out=$vbb_folder.'/image.php?u='.$id.'&dateline='.$av['dateline'];

				else		$out=$vbb_folder.'/images/avatars/noavatar.gif';

		}

		else	{

			$avatar = $mysql->fetch_array($mysql->query("SELECT avatarpath FROM avatar WHERE avatarid = '".$avatar."'"));

			$avatar=$avatar ['avatarpath'];

			$out=$vbb_folder.'/'.$avatar;

		}

	}

	else 

	$out=$user= $rs['username'];

	}*/

	$out = 'Guest';

	return $out;

}

function checkLogin(){

	global $mysql, $tb_prefix,$forum_name,$forum_prefix;

	/*if ($_COOKIE['UserCookie']) 

	 {

	$mysql->query("UPDATE  ".$forum_name.".".$forum_prefix."session SET sessionhash = '".SID."', host = '".IP."', idhash = '".md5(SID)."', lastactivity = '".NOW."',location='".$_SERVER["REQUEST_URI"]."',useragent='None' WHERE sessionhash='".SID."'");

			$return = true;



	}

	else $return = false;*/

	$return= true;

	return $return;

}



function replace_time($str)	{

	if ($_COOKIE['LangCookie']	!= 'Vietnamese')		{

		$str=str_replace('PhÃºt','PhÃºt',$str);

		$str=str_replace('phÃºt','PhÃºt',$str);		

		$str=str_replace('Táº­p','Táº­p',$str);	

		$str=str_replace('táº­p','Táº­p',$str);			

		}

	return $str;

}





function lang_f ($l){

	global $mysql,$tb_prefix;

	$lang_f	= $mysql->fetch_array($mysql->query("SELECT lang_name_".$_COOKIE['LangCookie']." FROM ".$tb_prefix."language WHERE lang_id='$l'"));

	return $lang_f['lang_name_'.$_COOKIE['LangCookie']];

}

function country_name ($c){

	global $mysql,$tb_prefix;

	$cname = $mysql->query("SELECT country_name_".$_COOKIE['LangCookie']." FROM ".$tb_prefix."country WHERE country_id=".$c."");

	$cname = $mysql->fetch_array($cname);

	return $cname['country_name_'.$_COOKIE['LangCookie']];

}

function queryspecail($str){

	global $typeqs;

	if ($typeqs ==1) $str = str_replace("'","\'",$str);	//Linux

return $str;

}



//////////////////////////////

//// CACHE //////////////////

////////////////////////////

function cache_begin($cachefile,$cachetime=''){

if (!$cachetime)	$cachetime = 60*10;

// Ignore List

$ignore_list = array(

'addedbytes.com/rss.php',

'addedbytes.com/search/'

);

// Script

$ignore_page = false;

for ($i = 0; $i < count($ignore_list); $i++) {

$ignore_page = (strpos($page, $ignore_list[$i]) !== false) ? true : $ignore_page;

}

$cachefile_created = ((@file_exists($cachefile)) and ($ignore_page === false)) ? @filemtime($cachefile) : 0;

@clearstatcache();

// Show file from cache if still valid

if (time() - $cachetime < $cachefile_created) {



$html = file_get_contents($cachefile);



 }

return $html;

}



function cache_end($cachefile,$content) {

	$fp = @fopen($cachefile, 'w');

	@fwrite($fp, $content);

	@fclose($fp);

}



function server_list($id)	

{

	switch ($id)

	{
		case 5: $name = 'Power#1'; break;
		
		case 7: $name = 'Tamtay'; break;
		
		case 8: $name = 'Yume'; break;
		
		case 11: $name = 'Clipvn'; break;

		case 12: $name = 'Blogvn'; break;
		
		case 26: $name = 'Tamtay'; break;
		
		case 28: $name = 'Sevenload'; break;
		
		case 29: $name = 'Googlevideo'; break;
		
		case 30: $name = 'Megavideo'; break;
		
		case 31: $name = 'Dailymotion'; break;
		
		case 32: $name = 'Youtube'; break;

		case 33: $name = 'Veoh'; break;	
		
		case 34: $name = 'ZingVideo'; break;	

		case 35: $name = 'LiveVideo'; break;
		
		case 38: $name = 'Youku'; break;
		
		case 39: $name = 'Myspace'; break;
		
		case 40: $name = 'Movshare'; break;
		
		case 41: $name = 'Zshare'; break;
		
		case 42: $name = 'Metacafe'; break;
		
		case 43: $name = 'Cache VP#4'; break;
		
		case 44: $name = 'OST#1'; break;
		
		case 40: $name = 'Cache VP#5'; break;
		
		case 46: $name = 'Sendspace'; break;
		
		case 47: $name = '4shared'; break;
		
		case 48: $name = 'Megashare'; break;
		
		case 49: $name = '2shared'; break;
		
		case 50: $name = 'Badongo'; break;
		
		case 51: $name = 'Novamov'; break;
		
		case 52: $name = 'Movshare'; break;
		
		case 53: $name = 'Goclip'; break;

		case 54: $name = 'Viddler'; break;

		case 55: $name = 'Cyworld'; break;
		
		case 56: $name = 'Vidxden'; break;
		
		case 57: $name = 'Zippy'; break;
		
		case 58: $name = 'Videobb'; break;
		
		case 60: $name = 'Twitvid'; break;
		
		case 61: $name = 'Seeclip'; break;
		
		default: $name = 'Others'; break;



	}

return $name;	

}



function check_server($film_id,$episode_id,$episode_lang,$server,$film_name)

{

	global $mysql,$temp,$tb_prefix,$web_link;

		

	$film_name = replace($film_name);		

	

	$q_l = $mysql->query("SELECT episode_id,episode_lang FROM ".$tb_prefix."episode WHERE (episode_lang <> ".$episode_lang." AND episode_film = ".$film_id.") GROUP BY episode_lang ORDER BY episode_name ASC");

		

	while ($kt_lang = $mysql->fetch_assoc($q_l))

	{

		if ($kt_lang['episode_lang'] == 1)

		

			$other_lang .= '<a href="'.$web_link.'/xem-phim/online/'.$film_name."_".$kt_lang['episode_id'].'.html">Click Here To Watch Cantonese Version</a><br><br>';

			

		elseif ($kt_lang['episode_lang'] == 2)

		

			$other_lang .= '<a href="'.$web_link.'/xem-phim/online/'.$film_name."_".$kt_lang['episode_id'].'.html">Click Here To Watch English Version</a><br><br>';

			

		elseif ($kt_lang['episode_lang'] == 3)

		

			$other_lang .= '<a href="'.$web_link.'/xem-phim/online/'.$film_name."_".$kt_lang['episode_id'].'.html">Click Here To Watch Vietnamese Version</a><br><br>';

			

		elseif ($kt_lang['episode_lang'] == 4)

		

			$other_lang .= '<a href="'.$web_link.'/xem-phim/online/'.$film_name."_".$kt_lang['episode_id'].'.html">Click Here To Watch Mandarin Version</a><br><br>';

			

		elseif ($kt_lang['episode_lang'] == 5)

		

			$other_lang .= '<a href="'.$web_link.'/xem-phim/online/'.$film_name."_".$kt_lang['episode_id'].'.html">Click Here To Watch Korean Version</a><br><br>';			

	}

	if ($server == '1')

		

		$relate_episode = '<div class="list_episodes content"><div class="listserver"><span class="name">'.ucwords(relate_episode($film_id,$episode_id,$film_name,$episode_lang)).'</span></div></div>';

			

	else

	{

		$s = explode(',',$server);

	         $relate_episode = "";

		for ($i=0;$i<count($s);$i++)

		{

		if (($not_s[$l]!=$s[$i]) && ($s[$i]!=""))  $relate_episode .= relate_episode($film_id,$episode_id,$film_name,$episode_lang,$s[$i]);

		}			

	}

	if ($other_lang)

	

		$relate_episode = '<div class="listlang" align="center"><b><font class="otherlang">'.$other_lang.'</font></b></div>'.$relate_episode;		

	

return $relate_episode;



}

function check_server_download($film_id,$episode_id,$episode_lang,$server,$film_name)

{
	$film_name = replace($film_name);	
	$relate_episode = relate_episode($film_id,$episode_id,$film_name,$episode_lang,'46');
	$relate_episode .= relate_episode($film_id,$episode_id,$film_name,$episode_lang,'47');
	$relate_episode .= relate_episode($film_id,$episode_id,$film_name,$episode_lang,'49');
	$relate_episode .= relate_episode($film_id,$episode_id,$film_name,$episode_lang,'50');
	$relate_episode = str_replace('xem-phim/online/','xem-phim/download/',$relate_episode);
	return  $relate_episode;
}

function relate_episode($film_id,$episode_id,$film_name,$episode_lang,$server_id='') 

{

	global $mysql,$temp,$tb_prefix,$web_link;

	

	if ($film_id && $episode_id) 

	{

		

		$html = $temp->get_tpl('episode');

		

		if(!$server_id)

		

			$e = $mysql->query("SELECT episode_id,episode_name FROM ".$tb_prefix."episode WHERE (episode_film = ".$film_id."  AND episode_lang = ".$episode_lang.") ORDER BY episode_name ASC");

			

		else 

			$e = $mysql->query("SELECT episode_id,episode_name FROM ".$tb_prefix."episode WHERE (episode_film = ".$film_id."  AND server_id = '".$server_id."' AND episode_lang = ".$episode_lang.") ORDER BY episode_name ASC");

			

		if ($mysql->num_rows($e))

		{			

			while ($r = $mysql->fetch_assoc($e))

			{

				$episode_name = $str = $r['episode_name'];

			

				if($str[0].$str[1]=='00')

				{

					$str .= '0';

				

					$episode_name = substr($str,2,-1);

				}

				

				elseif($str[0]=='0')

				{

					$str .= '0';

				

					$episode_name = substr($str,1,-1);

				}					

					

				if($r['episode_id'] == $episode_id)

				{

					$h['row'] = $temp->get_block_from_htm($html,'current_episode.row',1);

				

					$main .= $temp->replace_value($h['row'],array(

					

		                'episode.NAME' 	=> ucwords(strtolower(($episode_name))),

						
						

						'episode.URL'   => $web_link.'/xem-phim/online/'.$film_name."_".$r['episode_id'].'.html',						

						)

		   			);

				}



      			else 

				{

	       			$h['row'] = $temp->get_block_from_htm($html,'other_episode.row',1);

				

					$main .= $temp->replace_value($h['row'],array(

				

						'episode.NAME' 	=> ucwords(strtolower(($episode_name))),

						

						'episode.URL'   => $web_link.'/xem-phim/online/'.$film_name."_".$r['episode_id'].'.html',			

						)

					);

				} 

			}

		

			if($server_id)

		

				$main = '<div class="listserver" style="padding-left:5px;padding-bottom:5px;" align="left"><b><font class="servername"><img src="/img/icon_server.png"> Server '.server_list($server_id).':</font></b> </img>'.$main.'</div>';

		}

	}

	

return $main;



}



function check_film_name($name, $name_real)

{

	if ($name == $name_real)

		$out = $name;

	else $out = $name_real.' - '.$name;

	

return $out;

}
function replacesearch($str) {
	$str = str_replace('%20', '+', $str);
	
	$str = str_replace(' ', '+', $str);
	
	
	return $str;
}
function injection ($query){

$query = str_replace("\/","",$query);

$query = str_replace("\'","'",$query);

$query = str_replace('\"','"',$query); 


return mysql_real_escape_string(trim($query));

}
?>