<?php
function grab_link($url,$referer='',$var='',$cookie){
    $headers = array(
        "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MS Internet Explorer)",
        "Content-Type: application/x-www-form-urlencoded"
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
function laycode($url)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,"Google");
return curl_exec($ch);
}
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
function decode($str){
	$code=str_replace(array('a','b','c','d','e','g','h','k','v','u','w'),array('9','8','7','6','5','4','3','2','1','0','_'),$str);
	return $code;
}
function encode(){
	$t = return_time();
	$t=($t+192837465);
	$t= str_replace(array('9','8','7','6','5','4','3','2','1','0','_'),array('a','b','c','d','e','g','h','k','v','u','w'),$t);
	return $t;
}
function return_time(){
	$day=date('d',time());
	$date = gmdate("h:i:s a", time()+7*3600);
	$time = substr($date,0,2);
	$min = substr($date,3,2);
	$str=$day.$time.$min;
	return $str;
}
function check_time($t){
	$t=decode($t);
	$time=($t-192837465);
	$t2 = return_time();
	$check=$t2-$time;
	if (($check<0) || ($check>60)) 
		return false;
	else 
		return true;
}
function return_id($url)
    {
    $s = explode(".",$url);
    $id = intval($s[3]);
    $id = dechex($id + 307843200);
    $id = str_replace(1,'I',$id);
    $id = str_replace(2,'W',$id);
    $id = str_replace(3,'O',$id);
    $id = str_replace(4,'U',$id);
    $id = str_replace(5,'Z',$id);
    return strtoupper($id);
    } 
$nofile="http://getlink.thienduongviet.org/no.flv";
if (preg_match("#allmem.com(.*?)#", $_SERVER['HTTP_HOST'])) die("");
if (isset($_GET['c'])) echo encode(return_time());
file_put_contents('a.txt',$_SERVER['HTTP_REFERER']);
?>