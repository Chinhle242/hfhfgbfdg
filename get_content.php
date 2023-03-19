<?php
function getStr($string,$start,$end)
{
	$str = explode($start,$string);
	if ($end=='')
		return $str[1];
	else{
		$str = explode($end,$str[1]);
		return $str[0];
	}
}
function cut_str($str_cut,$str_c,$val)
{	
	$url=split($str_cut,$str_c);
	$urlv=$url[$val];
	return $urlv;
}
function grab_link($url,$referer='',$var='',$cookie){
    $headers = array(
		"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/3.0.1.1",
        "Content-Type: application/x-www-form-urlencoded",
		"Referer: ".$url,
        );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if($var) {
    curl_setopt($ch, CURLOPT_POST, 1);        
    curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
    }
    curl_setopt($ch, CURLOPT_URL,$url);

    return curl_exec($ch);
}
$cachedir="cache/";
$url = $_GET['url'];
$cache = $_GET['cache'];
$dec = $_GET['dec'];
$sp = $_GET['sp'];
$mega=$_GET['f'];
$zingvideolist= $_GET['listvid'];
if ($dec) header("Location: ".base64_decode($dec));
if ($mega)
{
	$xml="";
	$stream="http://ctl.vsolutions.vn/ctl/video/";
	$mega=explode('|',$mega);
	$num=count($mega);
	if ($num >5) $snum = 0; else $snum = -1;
	$code= file_get_contents($stream+"?file="+$mega[$i]);
	$s1=explode("=",$code);
	$s2=explode("'",$s1[1]);
	$stream=$s2[0];
	$stream = str_replace(array('xmoov.qc.php','http//synhnmedia.megafun.vn/'),array('xmoov.reader.php','http://123.29.73.243/'),$stream);
	for ($i=$num-1; $i > $snum ;$i--)
	{
		$name=" Tập ".($num - $i);
		if (substr_count($mega[$i] ,"vcd.flv")!=0) $name="Chất Lượng VCD";
		else if (substr_count($mega[$i] ,"dvd.flv")!=0)  $name="Chất Lượng DVD";
		$xml.= '<track><title>'.$name.'</title><location>'.$stream.'&start=0&file='.$mega[$i].'</location><image>http://img2-photo.apps.zing.vn/upload/original/2010/12/23/14/29/1293089398307276005_574_0.jpg</image><meta rel="streamer">'.$stream.'</meta></track>';
	}
	$xml ='<playlist version="1" xmlns="http://xspf.org/ns/0/"><trackList>'.$xml.'</trackList></playlist>';
	header("Content-Type: application/xml; charset=utf-8");//XML
	echo $xml;
}
if ($sp)
{
	$xml="";
	$xml.= '<track><title>Speedyshare-Grab</title><location>'.$sp.'</location><image>http://img2-photo.apps.zing.vn/upload/original/2010/12/23/14/29/1293089398307276005_574_0.jpg</image></track>';
	$xml.= '<track><title>Speedyshare-Grab</title><creator>Speedyshare-Grab</creator><location>'.$sp.'</location><image>http://img2-photo.apps.zing.vn/upload/original/2010/12/23/14/29/1293089398307276005_574_0.jpg</image></track>';
	$xml ='<playlist version="1" xmlns="http://xspf.org/ns/0/"><trackList>'.$xml.'</trackList></playlist>';
	header("Content-Type: application/xml; charset=utf-8");//XML
	echo $xml;
}
if ($url) 
{
	if (preg_match("#gdata.youtube.com#",$url)) 
	{
		$html= @file_get_contents($url);
    }
	elseif (preg_match("#youtube.com/view_play_list([^/]+)#",$url)) 
	{
		$id = cut_str('=',$url,1);
		$url="http://gdata.youtube.com/feeds/api/playlists/$id";
		$html= @file_get_contents($url);
	}
	elseif (preg_match("#veoh.com#",$url)) 
	{
		$html= grab_link($url,'','','');
		echo $html;
	}
	else
	{
		$html= grab_link($url,$url,'','');
		echo $html;
	}
}
if ($zingvideolist)
{
	$url="http://video.zing.vn/getXMLPlayList.php?request=chunk&vid=".$zingvideolist;
	$code = grab_link($url,'','','');
	$link=explode('<item>',$code);
	$num=count($link);
	$xml="";
	for ($i=1; $i < $num ;$i++)
	{
		$name	=	getStr($link[$i],"<title>","</title>");
		$play	=	getStr($link[$i],"<link>","</link>");
		$play 	= 	$play.'?query='.md5($play).'&zing='.time();
		$img	=	getStr($link[$i],"<thumb>","</thumb>");
		$xml.= '<track><title>'.$name.'</title><location>'.$play.'</location><image>'.$img.'</image><meta rel="streamer">'.$play.'</meta></track>';
		
	}
	
	$xml ='<playlist version="1" xmlns="http://xspf.org/ns/0/"><trackList>'.$xml.'</trackList></playlist>';
	header("Content-Type: application/xml; charset=utf-8");//XML
	echo $xml;
}
?>