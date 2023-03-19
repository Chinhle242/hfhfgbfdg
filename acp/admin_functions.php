<?
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
function acp_local($local = 0, $other = false) {
    global $mysql, $tb_prefix;
    if($other) {
        if ($other == 'main') $other = ' onchange="check_local(this.value)"';
        elseif(is_numeric($other)) $other = '['.$other.'] id=local_url['.$other.']';
    }
    $html = "<select name=local_url".$other.">".
	$html .= "<option value=0".(($local == 0 && !$other)?" selected":'').">- No Local</option>";
    $q = $mysql->query("SELECT * FROM ".$tb_prefix."local ORDER BY local_id ASC");
    while ($r = $mysql->fetch_array($q)) { 
    $html.= "<option value=".$r['local_id']."".(($local==$r['local_id'])?' selected':'').">- ".$r['local_name']."</option>";
    }
    "</select>";
    return $html;
}  

function admin_emotions_replace($s) {
	$emotions = emotions_array();
	foreach ($emotions as $a => $b) {
		$x = array();
		if (is_array($b)) {
			for ($i=0;$i<count($b);$i++) {
				$b[$i] = htmlchars($b[$i]);
				$x[] = $b[$i];
				$v = strtolower($b[$i]);
				if ($v != $b[$i]) $x[] = $v;
				}
		}
		else {
			$b = htmlchars($b);
			$x[] = $b;
			$v = strtolower($b);
			if ($v != $b) $x[] = $v;
			}
		$p = '';
		for ($u=0;$u<strlen($x[0]);$u++) {
			$ord = ord($x[0][$u]);
			if ($ord < 65 && $ord > 90) $p .= '&#'.$ord.';';
			else $p .= $x[0][$u];
		}
		$s = str_replace($x,'<img src=../images/emoticons/'.$a.'.gif>',$s);  
	}
	return $s;
}


function set_type($file_type) {
	$html = "<select name=file_type>".
		"<option value=0".(($file_type==0)?' selected':'').">0 - DEFAULT</option>".
		"<option value=1".(($file_type==1)?' selected':'').">1 - OTHER</option>".
		"<option value=2".(($file_type==2)?' selected':'').">2 - FLASH</option>".
		"<option value=3".(($file_type==3)?' selected':'').">3 - VIDEO</option>".
		"<option value=5".(($file_type==5)?' selected':'').">5 - FLV - MP4</option>".
		"<option value=7".(($file_type==7)?' selected':'').">7 - TAMTAY.VN</option>".
		"<option value=8".(($file_type==8)?' selected':'').">8 - YUME.VN</option>".
		"<option value=10".(($file_type==10)?' selected':'').">10 - CHACHA.VN</option>".
		"<option value=9".(($file_type==9)?' selected':'').">9 - DIVX</option>".
		"<option value=11".(($file_type==11)?' selected':'').">11 - CLIP.VN</option>".
		"<option value=12".(($file_type==12)?' selected':'').">12 - BLOG.COM.VN</option>".
		"<option value=26".(($file_type==26)?' selected':'').">26 - TAMTAYEMBED</option>".
		"<option value=25".(($file_type==25)?' selected':'').">25 - RTMP</option>".
		"<option value=28".(($file_type==28)?' selected':'').">28 - Sevenload</option>".
		"<option value=29".(($file_type==29)?' selected':'').">29 - Google</option>".
		"<option value=30".(($file_type==30)?' selected':'').">30 - Megavideo</option>".
		"<option value=31".(($file_type==31)?' selected':'').">31 - Dailymotion</option>".
		"<option value=32".(($file_type==32)?' selected':'').">32 - Youtube</option>".
		"<option value=33".(($file_type==33)?' selected':'').">33 - Veoh</option>".
		"<option value=35".(($file_type==35)?' selected':'').">35 - Live Video</option>".
		"<option value=36".(($file_type==36)?' selected':'').">36 - Kapsule- Movie Zing</option>".		
		"<option value=37".(($file_type==37)?' selected':'').">37 - 60s.com.vn</option>".		
		"<option value=38".(($file_type==38)?' selected':'').">38 - Youku</option>".	
		"<option value=39".(($file_type==39)?' selected':'').">39 - Myspace</option>".	
		"<option value=40".(($file_type==40)?' selected':'').">40 - Movshare</option>".				
		"<option value=41".(($file_type==41)?' selected':'').">41 - Zshare</option>".
		"<option value=49".(($file_type==49)?' selected':'').">49 - 2share</option>".
		"<option value=53".(($file_type==53)?' selected':'').">53 - GoClip</option>".
		"<option value=34".(($file_type==34)?' selected':'').">34 - Video Zing</option>";
		"<option value=54".(($file_type==54)?' selected':'').">54 - Viddler</option>";
		"<option value=56".(($file_type==56)?' selected':'').">56 - Vidxden</option>";
		"<option value=57".(($file_type==57)?' selected':'').">57 - Zippyshare</option>";
		"<option value=58".(($file_type==58)?' selected':'').">58 - videobb</option>";
		"<option value=60".(($file_type==60)?' selected':'').">60 - Twitvid</option>";
		"<option value=60".(($file_type==61)?' selected':'').">61 - Seeclip</option>";
		$html .= "</select>";
	return $html;
}

function admin_viewpages($ttrow,$n,$pg){
	global $link;
	$link = preg_replace("#&pg=([0-9]{1,})#si","",$link);
	$html="<table valign=bottom cellpadding=2 cellspacing=2 align=center>";
	$html.="<tr><td align=justify>";
	$pgt = $pg-1;
	if ($pg<>1) $html.="<a class=pagelink href=$link onfocus=this.blur() title ='Xem trang đầu'><b>&laquo;&laquo;</b></a> <a class=pagelink href=$link&pg=$pgt onfocus=this.blur() title='Xem trang trước'><b>&laquo;</b></a> ";
	for($l = 0; $l < $ttrow/$n; $l++) {
		$m = $l+1;
		if($m == $pg) $html .= "<a onfocus=this.blur() class=pagecurrent>$m</a> ";
		else $html .= "<a onfocus=this.blur() href=$link&pg=$m title='Xem trang $m' class=pagelink>$m</a> ";
	}
	$pgs = $pg+1;
	if ($pg<>$m) $html.="<a class=pagelink href=$link&pg=$pgs onfocus=this.blur() title='Xem trang kế tiếp'><b>&raquo;</b></a> <a class=pagelink href=$link&pg=$m onfocus=this.blur() title='Xem trang cuối'><b>&raquo;&raquo;</b></a> ";
	$html.="</td></tr></table>";
	return $html;
}

function acp_quick_add_film_form() {
	$html = "<table cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">	
	<tr>
	<td width=\"40%\" align=\"right\"><b>NAME</b></td>
	<td><input name=\"new_film\" size=\"50\"></td>
    </tr>
    <tr>
	<td width=\"40%\" align=\"right\"><b>NAME REAL</b></td>
	<td><input name=\"name_real\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>IMG</b></td>
	<td class=fr_2><input name=\"upload_img\" size=\"37\" type=\"file\"><BR /><BR />
	    <input name=\"url_img\" size=\"49\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>DIRECTOR</b></td>
	<td><input name=\"director\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>ACTOR</b></td>
	<td><input name=\"actor\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>TAG</b></td>
	<td><input name=\"tag\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>PRODUCER</b></td>
	<td><input name=\"area\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>ISSUE DAY</b></td>
	<td><input name=\"year\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>TIME</b></td>
	<td><input name=\"time\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"40%\" align=\"right\"><b>Thể Loại</b></td>
	<td>".acp_cat()."</td>
    </tr>
	<tr>
	<td colspan=\"2\" align=\"center\" style=\"padding-top:15px;\"><textarea name=\"info\" id=\"info\" cols=\"100\" rows=\"15\">    </textarea>
    <script language=\"JavaScript\">generate_wysiwyg('info');</script></td>
    </tr>
	</table>";
	return $html;
}
function join_value($str){
	$num=count($str);
	$max=$num-1;
	$string="";
	for ($i=0; $i<$num;$i++){
		if ($i<$max) $string .=$str[$i].',';
		else $string .=$str[$i];
	}
return $string;
}

function acp_quick_add_film($new_film,$name_real,$new_film_img,$actor,$year,$time,$area,$country,$director,$cat,$info,$cinema,$complete,$server,$type,$language,$request) {
	global $mysql, $tb_prefix;
	$poster=get_data('user_name','user','user_id',$_SESSION['admin_id']);
	$info='<div style="text-align: right;">Post by:<b>'.$poster.'</b></div>'.$info;
	$mysql->query("UPDATE ".$tb_prefix."user SET user_point = user_point + 1 WHERE user_id = '".$_SESSION['admin_id']."'");
	$q="INSERT INTO ".$tb_prefix."film (film_name,film_name_real,film_name_ascii,film_img,film_actor,film_actor_ascii,film_year,film_time,film_area,film_country,film_director,film_director_ascii,film_cat,film_info,film_cinema,film_complete,film_server,film_date,film_type,film_lang,film_request) VALUES ('".check_name($new_film)."','".check_name($name_real)."','".strtolower(get_ascii(check_name($new_film)))."','".$new_film_img."','".check_name($actor)."','".strtolower(get_ascii(check_name($actor)))."','".$year."','".$time."','".$area."','".$country."','".check_name($director)."','".strtolower(get_ascii(check_name($director)))."','".$cat."','".queryspecail($info)."',".$cinema.",".$complete.",'".$server."',".NOW.",".$type.",'".$language."',".$request.")";
	$mysql->query($q);
	$film = $mysql->insert_id();
return $film;
}

function acp_film($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT film_id,film_name,film_name_real FROM ".$tb_prefix."film ORDER BY film_id ASC");
if ($id !=0) $s = $mysql->query("SELECT film_id,film_name FROM ".$tb_prefix."film  WHERE film_id=".$id."");
	$html = "<select name=film>";
	if ($add) $html .= "<option value=dont_edit".(($id == 0)?" selected":'').">Don't edit</option>";
	while ($r = $mysql->fetch_array($q)) {
		if ( $r['film_name'] == $r['film_name_real']) $film_name = $r['film_id'].' - '.$r['film_name']; else $film_name= $r['film_id'].' - '.$r['film_name'].' - '.$r['film_name_real'];
		$html .= "<option value=".$r['film_id'].(($id == $r['film_id'])?" selected":'').">".$film_name."</option>";
	}
	$html .= "</select>";
	return $html;
}

function acp_cat($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."cat ORDER BY cat_order ASC");
	$cat=explode(',',$id);
	$num=count($cat);
	while ($r = $mysql->fetch_array($q)) {
		for ($i=0; $i<$num;$i++) if ($cat[$i]==$r['cat_id']) $checked='checked="checked"';
		$html .= '<input type="checkbox" id="selectcat" name="selectcat[]" value="'.$r['cat_id'].'" '.$checked.'> - '.$r['cat_name_Vietnamese']." - ".$r['cat_name_English']."<br/>";
		$checked="";
		}
	return $html;
}
function acp_server($id = 0, $add = false) {
	global $mysql,$tb_prefix,$film_id;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film where film_id = $film_id");
	$r = $mysql->fetch_array($q);
	$ser=explode(',',$r['film_server']);
	$num=count($ser);
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."server");
		while ($r = $mysql->fetch_array($q)) {
			for ($i=0; $i<$num;$i++) {
				if ($ser[$i]==$r['server_id']) $checked='checked="checked"';
			}
		$html .= '<input type="checkbox" id="selectserver" name="selectserver[]" value="'.$r['server_id'].'" '.$checked.'> - '.$r['server_name']."<br/>";
		$checked="";
		}
	return $html;
}
function acp_country($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."country");
	$html = "<select name=country>";
	if ($add) $html .= "<option value=dont_edit".(($id == 0)?" selected":'').">Không sửa</option>";
		while ($r = $mysql->fetch_array($q)) {
		$html .= "<option value=".$r['country_id'].(($id == $r['country_id'])?" selected":'').">- ".$r['country_name_English']."</option>";
		}
	$html .= "</select>";
	return $html;
}
function acp_lang($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."language");
	$html = "<select name=language>";
	if ($add) $html .= "<option value=dont_edit".(($id == 0)?" selected":'').">Không sửa</option>";
		while ($r = $mysql->fetch_array($q)) {
		$html .= "<option value=".$r['lang_id'].(($id == $r['lang_id'])?" selected":'').">- ".$r['lang_name_English']."</option>";
		}
	$html .= "</select>";
	return $html;
}

function acp_film_type($type) {
	$html = "<select name=film_type>";
if($type==1){
		$html .= "<option value=1 selected>- Phim Bộ</option>";
		$html .= "<option value=0>- Phim Lẻ</option>";}
else {	$html .= "<option value=1 >- Phim Bộ</option>";
		$html .= "<option value=0 selected>- Phim Lẻ</option>";}	
	$html .= "</select>";
	return $html;
}
function yes_no($html) {
	global $mysql,$tb_prefix;
				$ex_arr = explode('+',$html);
$name=$ex_arr[0]; $column=$ex_arr[2]; $id=$ex_arr[1];
	$q = $mysql->query("SELECT ".$column." FROM ".$tb_prefix."film where film_id=".$id."");
	$html = "<select name=".$name.">";
		while ($r = $mysql->fetch_array($q)) {
if 	($r[$column]==1){
		$html .= "<option value=1 selected>- Yes</option>";
		$html .= "<option value=0>- No</option>";}
else {	$html .= "<option value=1 >- Yes</option>";
		$html .= "<option value=0  selected>- No</option>";}		
		}
	$html .= "</select>";
	return $html;
}
function acp_user_level($lv) {
	$html = "<select name=level>".
	    "<option value=1".(($lv==1)?' selected':'').">Members</option>".
		"<option value=2".(($lv==2)?' selected':'').">Moderator</option>".
		"<option value=3".(($lv==3)?' selected':'').">Admin</option>".
		"<option value=4".(($lv==4)?' selected':'').">Collaborators</option>".

	"</select>";
	return $html;
}

function acp_user_ban($lv) {
	$html = "<select name=ban>".
	    "<option value=0".(($lv==0)?' selected':'').">No</option>".
		"<option value=1".(($lv==1)?' selected':'').">Yes</option>".
	"</select>";
	return $html;
}

function acp_type(&$url) {
	$t_url = strtolower($url);
	$ext = explode('.',$t_url);
	$ext = $ext[count($ext)-1];
	$ext = explode('?',$ext);
	$ext = $ext[0];
	$movie_arr = array(
		'wmv',
		'avi',
		'asf',
		'mpg',
		'mpe',
		'mpeg',
		'asx',
		'm1v',
		'mp2',
		'mpa',
		'ifo',
		'vob',
		'smi',
	);
	$is_viikii = (preg_match("#http://www.viikii.net/viewer/viikiiplayer2.swf(.*?)#s",$url));	
	$is_zshare = (preg_match("#http://www.zshare.net/video/(.*?)#s",$url));
	$is_movshare = (preg_match("#http://www.movshare.net/(.*?)#s",$url));	
	$is_myspace = (preg_match("#http://vids.myspace.com/(.*?)#s",$url));	
	$is_youku = (preg_match("#(.*?)youku.com(.*?)#s",$url));	
	$is_60s_com_vn = (preg_match("#(.*?)60s.com.vn(.*?)#s",$url));
	$is_Kapsule = (preg_match("#mms://movie.kapsule.info/(.*?)#s",$url));
	$is_tvzone  = (preg_match("#http://tvzone.us/(.*?)#s",$url));
	$is_video_zing = (preg_match("#http://video.zing.vn/(.*?)#s",$url));
	$is_dailymotion = (preg_match("#http://www.dailymotion.com/video/([^_]+)(.*)#",$url,$id_dailymotion)); 
	$is_dailymotion1 = (preg_match("#http://www.dailymotion.com/video/(.*)#",$url)); 
	$is_youtube = (preg_match("#(.*?).youtube.com/(.*?)#s",$url));
	$is_vntube = (preg_match("#http://www.vntube.com/mov/view_video.php\?viewkey=(.*?)#s",$url));
	$is_tamtay = (preg_match("#http://video.tamtay.vn/video/play/([^/]+)(.*)#",$url,$idvideo_tamtay));
    $is_tamtay_url1 = (preg_match("#http://www.tamtay.vn/video/play/config/(.*)#",$url));
	$is_tamtay_url2 = (preg_match("#http://tamtay.vn/video/play/config/(.*)#",$url));
	$is_chacha = (preg_match("#http://chacha.vn/song/(.*?)#s",$url));
	$is_clipvn = (preg_match("#http://clip.vn/watch/(.*?)#",$url));		
	$is_clipvn_url1 = (preg_match("#http://clip.vn/w/(.*)#",$url));
	$is_googleVideo = (preg_match("#http://video.google.com/videoplay\?docid=(.*?)#s",$url));
	$is_googleVideo1 = (preg_match("#http://video.google.com/googleplayer.swf?docId=(.*?)#s",$url));
	$is_blogvn = (preg_match("#http://blog.com.vn/Video/([^-]+-(.*)+_)((.*)+)([.^])#",$url,$idblog)); 
	$is_yume = (preg_match("#http://video.yume.vn/(.*?)#s",$url));
	$is_veoh = (preg_match("#http://www.veoh.com/(.*?)#s",$url));
	$is_megavideo = (preg_match("#http://www.megavideo.com/(.*?)#s",$url));
	$is_megavideo_url = (preg_match("#http://www.megavideo.com/v/([^?]+)#",$url));
	$is_baamboo = (preg_match("#http://video.baamboo.com/watch/([0-9]+)/video/([^/]+)/(.*?)#",$url,$idvideo_baamboo));
	$is_livevideo = (preg_match("#http://www.livevideo.com/(.*?)#s",$url));
	$is_sevenload = (preg_match("#http://en.sevenload.com/(.*?)#",$url));
	$is_vtv = preg_match("/^mms:\/\/+[a-zA-Z0-9\.]+(.*?)(VTV|VTC|HTV|dn1|dn2)+(.*?)/i",$url);
	$is_metacafe = (preg_match("#http://www.metacafe.com/watch/(.*)#s",$url));
	$is_timvui = (preg_match("#http://timvui.vn/(.*)#s",$url));
	$is_nct = (preg_match("#nhaccuatui.com(.*)#s",$url));
	$is_sendspace = (preg_match("#sendspace.com(.*)#s",$url));
	$is_4shared = (preg_match("#www.4shared.com/(.*?)#s",$url));
	$is_2shared = (preg_match("#www.2shared.com/(.*?)#s",$url));
	$is_megashare = (preg_match("#http://megashare.vn/(.*?)#s",$url));
	$is_rtmp = (preg_match("#rtmp://(.*?)#s",$url));
	$is_badongo = (preg_match("#http://www.badongo.com/vid/(.*?)#s",$url,$idbadongo));
	$is_goclip = (preg_match("#clips.goonline.vn(.*?)#s",$url));
	$is_novamov = (preg_match("#novamov.com(.*?)#s",$url));
	$is_movshare = (preg_match("#movshare.net(.*?)#s",$url));
	$is_vidxden = (preg_match("#vidxden.com(.*?)#s",$url));
	$is_zippy = (preg_match("#zippyshare.com(.*?)#s",$url));
	$is_viddler = (preg_match("#viddler.com/explore(.*?)#s", $url));
    $is_cyworld = (preg_match("#http://kine.cyworld.vn/detail/(.*?)#s",$url));
	$is_videobb = (preg_match("#videobb.com/video/(.*?)#s", $url));
	$is_speedyshare = (preg_match("#speedyshare.com/files/([^/.]+)/([^/.]+)#s",$url,$idvideo_speedyshare));
	$is_twitvid = (preg_match("#twitvid.com/(.*?)#s", $url));
	$is_seeclip = (preg_match("#video.seeon.tv/(.*?)#s", $url));
	
	if ($ext == 'swf'    || $is_baamboo || $is_tvzone || $is_viikii ) $type = 2;
	elseif (in_array($ext,$movie_arr) || $is_vtv) $type = 3;
	elseif ($ext == 'flv' || $ext == 'mp4') $type = 5;
	elseif ($is_tamtay || $is_tamtay_url1 || $is_tamtay_url2) $type = 7;
	elseif ($is_yume) $type = 8;
	elseif ($ext == 'divx') $type = 9;
	elseif ($is_chacha) $type = 10;
	elseif ($is_clipvn || $is_clipvn_url1) $type = 11;
	elseif ($is_blogvn) $type = 12;
	elseif ($is_rtmp) $type = 25;
	elseif ($is_sevenload) $type = 28;
	elseif ($is_googleVideo || $is_googleVideo1) $type = 29;
	elseif ($is_megavideo ||$is_megavideo_url) $type = 30;
	elseif ($is_dailymotion ||$is_dailymotion1) $type = 31;	
	elseif ($is_youtube) $type = 32;	
	elseif ($is_veoh || $is_veoh1) $type = 33;
	elseif ($is_video_zing) $type = 34;
	elseif ($is_livevideo) $type = 35;
	elseif ($is_Kapsule) $type = 36;
	elseif ($is_60s_com_vn) $type = 37;		
	elseif ($is_youku) $type = 38;	
	elseif ($is_myspace) $type = 39;	
	elseif ($is_movshare) $type = 40;	
	elseif ($is_zshare) $type = 41;	
	elseif ($is_metacafe) $type = 42;
	elseif ($is_timvui) $type = 43;
	elseif ($is_nct) $type = 44;
	elseif ($is_baamboo) $type = 45;
	elseif ($is_sendspace) $type = 46;
	elseif ($is_4shared) $type = 47;
	elseif ($is_megashare) $type = 48;
	elseif ($is_2shared) $type = 49;
	elseif ($is_badongo) $type = 50;
	elseif ($is_novamov) $type = 51;
	elseif ($is_movshare) $type = 52;
	elseif ($is_goclip) $type = 53;
	elseif ($is_viddler) $type = 54;
	elseif ($is_cyworld) $type = 55;
	elseif ($is_vidxden) $type = 56;
	elseif ($is_zippy) $type = 57;
	elseif ($is_videobb) $type = 58;
	elseif ($is_speedyshare) $type = 59;
	elseif ($is_twitvid) $type = 60;
	elseif ($is_seeclip) $type = 61;
	
	
	elseif (!$type) $type = 1;

	if ($is_youtube) {
		$url = explode('&',$url);
		$url=$url[0];
	}			
	if ($is_megavideo_url ) {

	$dai =strlen($url);
	if ($dai>40)	{
	$md5=$url[$dai-32].$url[$dai-31].$url[$dai-30].$url[$dai-29].$url[$dai-28].$url[$dai-27].$url[$dai-26].$url[$dai-25].$url[$dai-24].$url[$dai-23].$url[$dai-22].$url[$dai-21].$url[$dai-20].$url[$dai-19].$url[$dai-18].$url[$dai-17].$url[$dai-16].$url[$dai-15].$url[$dai-14].$url[$dai-13].$url[$dai-12].$url[$dai-11].$url[$dai-10].$url[$dai-9].$url[$dai-8].$url[$dai-7].$url[$dai-6].$url[$dai-5].$url[$dai-4].$url[$dai-3].$url[$dai-2].$url[$dai-1].$url[$dai];
$url= str_replace($md5,'',$url);
$url=str_replace('/v/','/?v=',$url);
	}
	else
	$url = str_replace('/v/','/?v=',$url);
    }
    return $type;
}

function acp_get_mod_permission() {
	global $mysql, $tb_prefix;	
	$permission_list = array(
		'add_cat',		
		'edit_cat',
		'del_cat',		
		'add_film',
		'edit_film',		
		'del_film',
		'add_link',
		'edit_link',		
		'del_link',
	);	
	$per = get_data('cf_permission','config','cf_id',1);
	$per = decbin($per);
	$len = count($permission_list);
	while (strlen($per) < $len) $per = '0'.$per;
	
	for ($i=0;$i<$len;$i++) $arr[$permission_list[$i]] = $per[$i];
	return $arr;
	
}

function acp_check_permission_mod($name){
	global $level;
	$mod_permission = acp_get_mod_permission();
	if (($level == 2) && ($mod_permission[$name]==0)) die('<center>BẠN KHÔNG ĐỦ QUYỀN TRUY CẬP VÀO TRANG NÀY</center>');
}
?>