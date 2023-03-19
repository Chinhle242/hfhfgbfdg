<?php
if (!defined('IN_MEDIA')) die("Hacking attempt");

function get_contents_c($post_vars_p,$url_p,$ua){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url_p);
		if (empty($ua)) curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		if (isset($post_vars_p)) {
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$post_vars_p);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		return curl_exec($ch);
		curl_close($ch);
}
function get($url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_USERAGENT,"Windows-Media-Player/10.00.00.****");
$out = curl_exec($ch);
curl_close($ch);
return $out;
}
function getlink($host,$link,$cookie) {
	$out  = "GET $link HTTP/1.1\r\n";
	$out .= "Host: ".$host."\r\n";
	$out .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6\r\n";
	$out .= "Referer: http://www.google.com/\r\n";	
	$out .= "Cookie: $cookie\r\n";
	$out .= "Connection: Close\r\n\r\n";	
	if (!$con = @fsockopen($host, 80, $errno, $errstr, 10))
		return $errstr." ".$errno;
	fwrite($con, $out);
	$data = '';
	while (!feof($con)) {
		$data .= fgets($con, 512);
	}
	fclose($con);
	return $data;
}

function getCookie($host,$link) {
	$out  = "GET $link HTTP/1.1\r\n";
	$out .= "Host: ".$host."\r\n";
	$out .=  "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6\r\n";
	$out .= "Referer: http://www.google.com/\r\n";
	$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$out .= "\r\n";	
	if (!$con = @fsockopen($host, 80, $errno, $errstr, 10))
		return $errstr." ".$errno;		
	fwrite($con, $out);
	$data = '';
	while (!feof($con)) {
		$data .= fgets($con, 512);
	}	
	fclose($con);	
    preg_match("#Set-Cookie:(.*?)Vary:#s",$data, $res);	
	return $res[1];
}

function getcode($host,$link) {
	$out  = "GET $link HTTP/1.1\r\n";
	$out .= "Host: ".$host."\r\n";
	$out .= "User-Agent: Mozilla 4.0\r\n";
	$out .= "Referer: http://google.com/\r\n";	
	$out .= "Connection: Close\r\n\r\n";	
	if (!$con = @fsockopen($host, 80, $errno, $errstr, 10))
		return $errstr." ".$errno;		
	fwrite($con, $out);
	$data = '';
	while (!feof($con)) {
		$data .= fgets($con, 512);
	}	
	fclose($con);
	return $data;
}

function get_link_tamtay($url) {
	global $linkgrab,$hash;
/*$data= get('http://video.tamtay.vn/video/play/'.$url);
$dem = explode(']=',$data);
$d	= count($dem);
for ($i=1;$i<$d;$i++)
{
	$url= explode('"',$dem[$i]);
	$url= explode('"',$url[1]);
	$link= $link.$url[0];
}
	$data=get('http://video.tamtay.vn'.$link);
	$url = explode("'", $data);
	$url = explode("'", $url[1]);
	$url=$url[0];
/*		$url=$linkgrab.'/tamtay/'.$url.'/'.md5($hash.$url).'.flv';*/
		$url='http://tdchien.co.cc/at/getpro.php?id='.$url;
		$a = get_headers($url, 1);
		$url= $a['Location'];
  return $url;
}

function get_link_clipvn($url) {
	global $linkgrab,$hash;
	$url=explode('/w/',$url);	$url=explode(',',$url[1]);
	$url=$linkgrab.'/clipvn/'.$url[0].'/'.md5($hash.$url[0]).'.mp4';
/*	$a = get_headers($url, 1);
	$url= $a['Location'];*/
	return $url;
}

function get_link_blog($url,$t='') {
	global $linkgrabvn,$hash;
    $s = explode('_',$url);
	$s1=explode(".html",$s[1]);
	$id=$s1[0];
/*if($t==1 || $t==2)	{	
    $link='http://blog.com.vn/home/relatemovie.ashx?videoid='.$id;
    $data=getcode('blog.com.vn',$link);
	$url_64 = explode('<path1>', $data);
	$url_64 = explode('</path1>', $url_64[1]);

	$url_320 = explode('<path2>', $url_64[1]);
	$url_320 = explode('</path2>', $url_320[1]);

/*	$url_512 = explode('<path3>', $url_320[1]);
	$url_512 = explode('</path3>', $url_512[1]);

	$name=explode('<name>', $url_512[1]);
	$name=explode('</name>', $name[1]);
	switch ($t) { case 1 : $url=$url_64[0];	break; 			case 2: $url=$url_320[0]; break;	}
	$link = $url;
	$url = explode('/',$url);
	$url = str_replace($url[2],'video.blog.com.vn',$link);
	}
else	
	$url='http://blog.com.vn/home/'.$id.'.embed';*/
	$url = $linkgrabvn.'/blogvn/'.$id.'/'.md5($hash.$id).'.mp4';
    return $url;
}




function get_link_google($url,$t='') {
	global $linkgrab,$hash;
	$url=explode('http://video.google.com/googleplayer.swf?docId=',$url);
if ($t==2)	$url=$linkgrab.'/googlevideo/'.$url[1].'/'.md5($hash.$url[1]).'.mp4';
else 		$url=$linkgrab.'/googlevideo/'.$url[1].'/'.md5($hash.$url[1]).'.flv';
		 return $url;
}
function get_link_dailymotion($url,$t='') {
	global $linkgrab,$hash;
		$url=explode('/video/',$url);
	switch ($t)	{
		case 1:
			$url= $linkgrab.'/dailymotion/'.$url[1].'/'.md5($hash.$url[1]).'.flv';
		break;
		case 2:
			$url= $linkgrab.'/dailymotion/'.$url[1].'/'.md5($hash.$url[1]).'.mp4';
		break;
				}
		 return $url;
}
function get_link_youtube($url,$type='')	{
	global $linkgrab,$hash;
		$url= explode('watch?v=',$url);
if ($type==2) 	$url= $linkgrab.'/youtube/'.$url[1].'/'.md5($hash.$url[1]).'.mp4';
else		    $url= $linkgrab.'/youtube/'.$url[1].'/'.md5($hash.$url[1]).'.flv';
	return $url;
}
function get_link_veoh($url)	{
	global $linkgrab,$hash;
		$url= explode('http://www.veoh.com/videos/',$url);
		$url= $linkgrab.'/veoh/'.$url[1].'/'.md5($hash.$url[1]).'.flv';	
	return $url;
}

function get_veoh($url)
{
	$video_id = explode('/', $url);

	$xml = "http://www.veoh.com/rest/v2/execute.xml?method=veoh.search.search&type=video&maxResults=1&permalink=".$video_id[4]."&contentRatingId=3&apiKey=5697781E-1C60-663B-FFD8-9B49D2B56D36";

	$data = @file_get_contents($xml);
	
	if ($data)
	{
		if (preg_match('#fullPreviewHashPath="(.*?)"#',$data,$link))
		{
			if ($link[1])
			{
				$lp = @get_headers(trim($link[1]), 1);  
				
				$link_play = $lp['Location'];
				
				return $link_play;
			}
		}
	}

    return false;

}
function get_link_videozing($url,$t='')	{
	global $linkgrabvn,$hash;
		$url= str_replace('http://video.zing.vn/zv/clip/','http://video.zing.vn/video/clip/',$url);
/*	    $data=get($url); 
if ($data)	{
/*		$link = explode("javascript: window.open('",$data);
		$link = explode("'",$link[1]);		
		$url= $link[0];
		$test = @fopen($url ,"rb");
		if (!$test) 
		{
		$play = explode('xmlFile:"',$data);
		$play = explode('"',$play[1]);
if ($t==1)	{
		$down=get('http://video.zing.vn/getXML.php?request=chunk&vid='.$play[0]);
		$link=explode('<flvSource>', $down);
		$link=explode('</flvSource>',$link[1]);
		$url = $link[0];	}
else
		$url= 'http://video.zing.vn/player/flvPlayer.swf?autoplay=true&flvFile=&xmlFile='.$play[0];	
			
}
else $url='Error!';*/
	$id	= explode('.',$url);
	$id = $id[3];
	$url = $linkgrabvn.'/videozing/'.$id.'/'.md5($hash.$id).'.flv';
	return $url;
}

function get_link_yume($url,$t='')	{//http://video.yume.vn/video-clip/quai-thu-vo-hinh-3-predators-2010-tap-6-vuaphim-net.rongitvn.35AEA7CA.html
	global $linkgrabvn,$hash;
/*    $data=file_get_contents($url); 
	$xml= explode('&xmlPath=',$data);
	$xml= explode('"></embed>',$xml[1]);
if ($t==1)	{	
	$data_xml= get($xml[0]);
	$link=explode('<track urlFLV="',$data_xml);
	$link=explode('" titleFLV="',$link[1]);
	$url=$link[0];
	$a = get_headers($url, 1);
	$url = $a['Location'];
	$url = str_replace('streaming1','streaming2',$url);
			}
else $url=$xml[0];	*/		
	$id  = explode ('/',$url);
	$url = str_replace('http://','',$url);
	$url = str_replace($id[5],'',$url);
	$url = $linkgrabvn.'/'.$url.$id[5].'/'.md5($hash.$id[5]).'.flv';
return $url;
}

function get_link_60s_com_vn($url)	{
	global $linkgrabvn,$hash;
	$url = explode('/',$url);
	$url = $linkgrabvn.'/p60s/'.$url[4].'/'.$url[5].'/'.md5($hash.$url[5]).'.asx';
return $url;
}
function get_link_megavideo($url)	{
	$id=str_replace('http://www.megavideo.com/?v=','',$url);
/*	global $linkgrabvn,$hash;
	$url=$linkgrabvn.'/megavideo/'.$id.'/'.md5($hash.$id).'.avi';*/
	
	$url='http://www.megavideo.com/xml/player_login.php?u=QOXILZT2-GX99-Z5BKWFZOTEKYB3CSOF&v='.$id;
	$data=get($url); 
if ($data)	{	
	$url=explode('downloadurl="',$data);
	$url=explode('"',$url[1]);
	$url=str_replace('%2F','/',$url[0]);
	$url=str_replace('%3A',':',$url);
			}
return $url;
}
function get_link_vidmyspace($id)	{
	global $linkgrab,$hash;
	$url=$linkgrab.'/vidmyspace/'.$id.'/'.md5($hash.$id).'.flv';
return $url;
}
function get_link_movshare($url)	{
/*	$data = get($url);
	$url  = explode('src" value="',$data);
	$url  = explode('"',$url[1]);
return	$url[0];	*/
	global $linkgrab,$hash;
	$id = str_replace('http://www.movshare.net/video/','',$url);
	$url = $linkgrab.'/movshare/'.$id.'/'.md5($hash.$id).'.avi';
return $url;	
}
function get_link_zshare($url)	{
	global $linkgrab,$hash;
	$id = str_replace('http://www.zshare.net/video/','',$url);
	$id = str_replace('/','',$id);
	$url = $linkgrab.'/zshare/'.$id.'/'.md5($hash.$id).'.flv';
return $url;	
}
	
?>
