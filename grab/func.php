<?php
include('encode.php');
function absoluteURI($url = null, $protocol = null, $port = null)
    {
        // filter CR/LF
        $url = str_replace(array("\r", "\n"), ' ', $url);
        
        // Mess around with already absolute URIs
        if (preg_match('!^([a-z0-9]+)://!i', $url)) {
            if (empty($protocol) && empty($port)) {
                return $url;
            }
            if (!empty($protocol)) {
                $url = $protocol .':'. end($array = explode(':', $url, 2));
            }
            if (!empty($port)) {
                $url = preg_replace('!^(([a-z0-9]+)://[^/:]+)(:[\d]+)?!i', 
                    '\1:'. $port, $url);
            }
            return $url;
        }
            
        $host = 'localhost';
        if (!empty($_SERVER['HTTP_HOST'])) {
            list($host) = explode(':', $_SERVER['HTTP_HOST']);
        } elseif (!empty($_SERVER['SERVER_NAME'])) {
            list($host) = explode(':', $_SERVER['SERVER_NAME']);
        }

        if (empty($protocol)) {
            if (isset($_SERVER['HTTPS']) && !strcasecmp($_SERVER['HTTPS'], 'on')) {
                $protocol = 'https';
            } else {
                $protocol = 'http';
            }
            if (!isset($port) || $port != intval($port)) {
                $port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 80;
            }
        }
        
        if ($protocol == 'http' && $port == 80) {
            unset($port);
        }
        if ($protocol == 'https' && $port == 443) {
            unset($port);
        }

        $server = $protocol .'://'. $host . (isset($port) ? ':'. $port : '');
        
        if (!strlen($url)) {
            $url = isset($_SERVER['REQUEST_URI']) ? 
                $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
        }
        
        if ($url{0} == '/') {
            return $server . $url;
        }
        
        // Check for PATH_INFO
        if (isset($_SERVER['PATH_INFO']) && strlen($_SERVER['PATH_INFO']) && 
                $_SERVER['PHP_SELF'] != $_SERVER['PATH_INFO']) {
            $path = dirname(substr($_SERVER['PHP_SELF'], 0, -strlen($_SERVER['PATH_INFO'])));
        } else {
            $path = dirname($_SERVER['PHP_SELF']);
        }
        
        if (substr($path = strtr($path, '\\', '/'), -1) != '/') {
            $path .= '/';
        }
        
        return $server . $path . $url;
    }
function head($url, $timeout = 10){
        $p = parse_url($url);
        if (!isset($p['scheme'])) {
            $p = parse_url(absoluteURI($url));
        }elseif ($p['scheme'] != 'http') {
            die('Unsupported protocol: '. $p['scheme']);
        }
        $port = isset($p['port']) ? $p['port'] : 80;
        if (!$fp = @fsockopen($p['host'], $port, $eno, $estr, $timeout)) {
           die("Connection error: $estr ($eno)");
        }
        $path  = !empty($p['path']) ? $p['path'] : '/';
        $path .= !empty($p['query']) ? '?' . $p['query'] : '';
        fputs($fp, "HEAD $path HTTP/1.0\r\n");
        fputs($fp, 'Host: ' . $p['host'] . ':' . $port . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        $response = rtrim(fgets($fp, 4096));
        if (preg_match("|^HTTP/[^\s]*\s(.*?)\s|", $response, $status)) {
            $headers['response_code'] = $status[1];
        }
        $headers['response'] = $response;
        while ($line = fgets($fp, 4096)) {
            if (!trim($line)) {
                break;
            }
            if (($pos = strpos($line, ':')) !== false) {
                $header = substr($line, 0, $pos);
                $value  = trim(substr($line, $pos + 1));
                $headers[$header] = $value;
            }
        }
        fclose($fp);
        return $headers;
}
function m_setcookie($name, $value = '', $permanent = true) {
	global $mainurl;
	$setCookieType=2;
	$expire = ($permanent)?(time() + 60 * 60 * 24 * 365):0;
	
	if ($setCookieType == 1) {
		$url = $mainurl;
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
function get_redirected_url($url) {
    $res = head($url);
    if (preg_match('/^3/', $res['response_code'])) {
        return $res['Location'];
    }
    return $url;
}
function get_redirected_url2($url) {
	if ((substr_count($url,'.mp3')!=0) || (substr_count($url,'.flv')!=0) || (substr_count($url,'.mp4')!=0) || (substr_count($url,'.wmv')!=0) || (substr_count($url,'.wma')!=0)|| (substr_count($url,'.exe')!=0) || (substr_count($url,'rssdownload')!=0))
			
		return $url;
	else{
		$res = head($url);
		if (preg_match('/^3/', $res['response_code'])) {
			return $res['Location'];
		}
		return $url;
	}
}
function get_link($link,$type){
//Code by Trần Ngô Tuấn Vũ
//Email: thegioitinhocs@yahoo.com
//Đừng thay đổi hoặc xóa bất kỳ thông tim nào!
//Don't change or delete any infomation!
$embed="";
$myurl='http://getlink.thienduongviet.org/'.encode();
//$myurl='http://getlink.thienduongviet.org/';
	if (preg_match("#getlink.thienduongviet.org(.*?)#", $link)){
			$link=str_replace('http://getlink.thienduongviet.org',$myurl,$link);
		}
	//Box.net
	elseif (preg_match("#box.net/shared/(.*?)#", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/box/'.$id;
	}
	//Badongo.com
	elseif (preg_match("#http://www.badongo.com/vid/(.*?)#", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/badongo/'.$id.'.flv';
	}
	/*
	//Mediafire.com
	elseif (preg_match("#http://www.mediafire.com/(.*?)#", $link)){
		$link=str_replace('download.php','',$link);
		$id = cut_str('\?',$link,1);
		$link=$myurl.'/mediafire/'.$id.'.flv';
	}
	//ZShare.com
	elseif (preg_match("#http://www.zshare.net/download/(.*?)#", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/zshare/'.$id.'.flv';
	}
	//YouTube.com
	else if (preg_match("#^http:\/\/www.youtube.com(.*?)#s", $link)){
		$id = cut_str('=',$link,1);
		$id = cut_str('&',$id,0);
		$link=$myurl.'/youtube/'.$id.'.flv';
	}
	//http://vids.myspace.com/
	else if (preg_match("#http://vids.myspace.com/(.*?)#s", $link)){
		$id=explode('=', $link);
		$link=$myurl.'/myspace/'.$id[2].'.flv';
	}
	//Clip.vn
	elseif (preg_match("#^http:\/\/clip.vn(.*?)#s", $link)){
		$id = cut_str(',',$link,1);
		$link='http://namdinh.org/media/clip/'.$id.'.mp4';
	}
	//Video.TamTay.vn
	else if (preg_match("#^http:\/\/video.tamtay.vn(.*?)#s", $link)){
		$id = cut_str('http://video.tamtay.vn/',$link,1);
		$id = cut_str('.html',$id,0);
		$link=$myurl.'/tamtay/'.$id.'.flv';
	}
	//Blog.Com.vn
	else if (preg_match("#^http:\/\/blog.com.vn(.*?)#s", $link)){
		$id = cut_str('_',$link,1);
		$id = cut_str('.html',$id,0);
		$link=$myurl.'/blogvn/'.$id.'.flv';
	}
	//ZingStar
	else if (preg_match("#^http:\/\/star.zing.vn(.*?)#s", $link)){
		$id = cut_str('http://star.zing.vn/',$link,1);
		$id = cut_str('.html',$id,0);
		$link=$myurl.'/zings/'.$id.'.flv';
	*/
	//Video.Google.com
	else if (preg_match("#^http:\/\/video.google.com/(.*?)#s", $link)){
		$link=str_replace('docId=','docid',$link);
		$link .='&';
		$id = cut_str('docid=',$link,1);
		$id = cut_str('&',$id,0);
		$link=$myurl.'/google/'.$id.'.flv';
		$embed="http://video.google.com/googleplayer.swf?docid=".$id;
	}
	//Dailymontion.com
	else if (preg_match("#dailymotion.com(.*?)#s", $link)){
		$linkvideo=explode('/', $link);
		$num=count($linkvideo);
		$link=$linkvideo[$num-1];
		$id=explode('_', $link);
		$link=$myurl.'/daily/'.$id[0].'.flv';
		$embed="http://www.dailymotion.com/swf/video/".$id[0];
	}
	//Veoh.com
	else if (preg_match("#veoh.com/(.*?)#s", $link)){
		$linkvideo=explode('/', $link);
		$num=count($linkvideo);
		$id=$linkvideo[$num-1];
		$link=$myurl.'/veoh/'.$id.'.flv';
		$link='http://www.phim88.com/online/xxxxxx?plugins=http://thienduongviet.org/movie/linkPlugin.swf&plugin.thienduongviet=true&plugin.tdv_id=getlink/xml/veoh/'.$id;
		$embed="http://www.veoh.com/veohplayer.swf?permalinkId=".$id;
	}
	//http://megavideo.com/
	else if (preg_match("#megavideo.com\/\?v=(.*?)#s", $link)){
		$id=explode('=', $link);
		$link=$myurl.'/megavideo/'.$id[1].'.flv';
		$embed="http://www.megavideo.com/v/".$id[1];
	}
	//Metacafe.com
	else if (preg_match("#^http://www.metacafe.com/watch/(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/metacafe/'.$id.'.flv';
		$embed="http://www.metacafe.com/fplayer/".$id.'/thienduongviet_grabber.swf';
	}
	//Sg.sevenload.com
	else if (preg_match("#sg.sevenload.com/(.*?)#s", $link)){
		$linkvideo=explode('/', $link);
		$num=count($linkvideo);
		$link=$linkvideo[$num-1];
		$id=explode('-', $link);
		$link=$myurl.'/sevenload/'.$id[0].'.flv';
		$embed="http://static.sevenload.net/swf/player/player.swf?v=143&configPath=http%3A%2F%2Fflash.sevenload.com%2Fplayer%3FitemId%3".$id[0]."%26portalId%3Dsg%26screenlink%3D0&amp;environment=episode&amp;autoPlayNext=1&amp;locale=en_SG";

	}
	//vimeo.com
	else if (preg_match("#vimeo.com/(.*?)#s", $link)){
		$id = cut_str('/',$link,3);
		$link=$myurl.'/vimeo/'.$id.'.flv';
		$embed="http://vimeo.com/moogaloop.swf?clip_id=".$id;
	}
	//2shared.com
	elseif (preg_match('#2shared.com/([^/]+)#', $link, $id)){
		$id=str_replace(array('http://2shared.com/','http://www.2shared.com/'),'getlink/xml/2share/',$link);
	    $link="http://www.2shared.com/flash/player.swf?plugins=http://thienduongviet.org/movie/linkPlugin.swf&plugin.thienduongviet=true&plugin.tdv_id=$id";	
	}
	//4shared.com
	else if (preg_match("#4shared.com/(.*?)#s", $link)){
		$id=str_replace(array('http://4shared.com/','http://www.4shared.com/'),'getlink/xml/4share/',$link);
	    $link="http://www.4shared.com/flash/player.swf?plugins=http://thienduongviet.org/movie/linkPlugin.swf&plugin.thienduongviet=true&plugin.tdv_id=$id";	
	}
	//Movshared.com
	else if (preg_match("#movshare.net/video/(.*?)#s", $link)){
		$id=str_replace(array('http://www.movshare.net/video/','http://movshare.net/video/'),'getlink/xml/movshare/',$link);
	    $link="http://www.movshare.net/player.swf?plugins=http://thienduongviet.org/movie/linkPlugin.swf&plugin.thienduongviet=true&plugin.tdv_id=$id";	
	}
	//Megashare.vn
	else if (preg_match("#megashare.vn(.*?)#s", $link)){
		$link=str_replace('http://megashare.vn/dl.php/',$myurl.'/megashare/',$link);
		$link=$link.'.flv';
	}
	//Nhac.Vui.Vn
	else if (preg_match("#^(.*)nhac.vui.vn/Music(.*?)#s", $link)){
		$id = cut_str('#Play,',$link,1);
		$link=$myurl.'/nhacvui/'.$id.'.mp3';
	}
	//NhacCuaTui.com
	else if (preg_match("#^http:\/\/www.nhaccuatui.com(.*?)#s", $link)){
		$id = cut_str('=',$link,1);
		//$link=$myurl.'/nct/'.$id.'.mp3';
		$link='http://thienduongviet.org/movie/player.swf?plugins=http://thienduongviet.org/movie/linkPlugin.swf&plugin.thienduongviet=true&plugin.tdv_id=getlink/xml/nct/'.$id;
		$embed="http://www.nhaccuatui.com/m/".$id;
	}
	//Music.TamTay.vn
	else if (preg_match("#^http:\/\/music2.tamtay.vn(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/tamtaym/'.$id.'.mp3';
		$embed="http://music2.tamtay.vn/players/player.swf?file=http://music2.tamtay.vn/main/embed2/type/1/id/".$id;
	}
	//Tialia.Net/Music
	else if (preg_match("#^http:\/\/tialia.net/(.*?)#s", $link)){
		$id = cut_str('=',$link,1);
		$link=$myurl.'/tialiamusic/'.$id.'.mp3';
	}
	//Video.Tialia.net
	else if (preg_match("#^http:\/\/video.tialia.com/(.*?)#s", $link)){
		$id = cut_str('_',$link,1);
		$id = cut_str('.html',$id,0,1);
		$link=$myurl.'/tialiavideo/'.$id.'.flv';
	}
	//Movie.Tialia.Com
	else if (preg_match("#^http:\/\/movies.tialia.com/(.*?)#s", $link)){
		$id = cut_str('_',$link,1);
		$id = cut_str('.html',$id,0,1);
		$link=$myurl.'/tialiamovie/'.$id.'.flv';
	}
	//ZingMp3: Mp3
	else if (preg_match("#^http:\/\/mp3.zing.vn/mp3/nghe-bai-hat(.*?)#s", $link)){
		$id = cut_str('\.',$link,3);
		$link=$myurl.'/zing/'.$id.'.mp3';
		$embed="http://static.mp3.zing.vn/skins/gentle/flash/mp3player.swf?xmlURL=http://mp3.zing.vn/play/?pid=".$id."||4&songID=0&autoplay=false&wmode=transparent";
	}
	//ZingMp3: Video
	else if (preg_match("#^http:\/\/mp3.zing.vn/mp3/video-clip/xem-video/(.*?)#s", $link)){
		$id = cut_str('\.',$link,3);
		$link=$myurl.'/zing/'.$id.'.flv';
		$embed="http://static.mp3.zing.vn/skins/gentle/flash/channelzPlayer.swf?xmlURL=http://mp3.zing.vn/play/?pid=".return_id($link)."||6&songID=0&autoplay=false&wmode=transparent";
	}
	//ZingMp3: Album
	else if (preg_match("#^http:\/\/mp3.zing.vn/mp3/nghe-album/(.*?)#s", $link)){
		$id = cut_str('\.',$link,3);
		$link=$myurl.'/zing/'.$id.'.xml';
		$embed="http://static.mp3.zing.vn/skins/gentle/flash/mp3playlist.swf?xmlURL=http://mp3.zing.vn/play/?pid=".return_id($link)."||1&songID=0&autoplay=false&wmode=transparent";	
	}
	//ZingVideo
	else if (preg_match("#^http:\/\/video.zing.vn(.*?)#s", $link)){
		$s = explode(".",$link);
    	$id = intval($s[3]);
		$link='http://thienduongviet.org/movie/player.swf?plugins=http://thienduongviet.org/movie/linkPlugin.swf&plugin.thienduongviet=true&plugin.tdv_id=getlink/xml/zing/'.$id;
	}
	//ZingMovie
	else if (preg_match("#http://movie.zing.vn/Movie/xem-online/(.*?)#s", $link)){
		$link=str_replace(array('http://movie.zing.vn/Movie/xem-online/','.html'),array($myurl.'/zingm/','.wpl'),$link);
	}
	//Video.TimNhanh.com
	else if (preg_match("#^http:\/\/video.timnhanh.com(.*?)#s", $link)){
		$id = cut_str('http://video.timnhanh.com/',$link,1);
		$id = cut_str('.html',$id,0);
		$link=$myurl.'/timnhanh/'.$id.'.flv';
	}
	//Video.Yume.vn
	else if (preg_match("#^http:\/\/video.yume.vn(.*?)#s", $link)){
		$id = cut_str('http://video.yume.vn/',$link,1);
		$id = cut_str('.html',$id,0);
		$link=$myurl.'/timnhanh/'.$id.'.flv';
	}
	//SocBayMp3
	else if (preg_match("#^http:\/\/www.socbay.com/mp3(.*?)#s", $link)){
		$id = cut_str('/',$link,5);
		$link=$myurl.'/socbay/'.$id.'.mp3';
	}
	//SocBayVideo
	else if (preg_match("#^http:\/\/www.socbay.com/video(.*?)#s", $link)){
		$id = cut_str('/',$link,5);
		$link=$myurl.'/socbay/'.$id.'.flv';
	}
	//NhacSo.Net
	else if (preg_match("#^http:\/\/nhacso.net/Music/Song(.*?)#s", $link)){
		$id = cut_str('http://nhacso.net/',$link,1);
		$link=$myurl.'/ns.php?url='.$id ;
		//$link=get_redirected_url($link);
	}
	//NhacSo.Net
	else if (preg_match("#^http:\/\/nhacso.net/Music/(.*?)#s", $link)){
		$id = cut_str('http://nhacso.net/',$link,1);
		$link=$myurl.'/ns.php?url='.$id ;
		//$link=file_get_contents($link);
	}
	//Yeuamnhac.com-Music
	else if (preg_match("#^http:\/\/www.yeuamnhac.com/cbeta/music_details.php(.*?)#s", $link)){
		$id = cut_str('=',$link,1);
		$link=$myurl.'/yan/'.$id.'.mp3';
	}
	//Yeuamnhac.com-video
	else if (preg_match("#^http:\/\/www.yeuamnhac.com(.*?)#s", $link)){
		$id = cut_str('=',$link,1);
		$link=$myurl.'/yan/'.$id.'.wmv';
	}
	//Chacha.vn
	else if (preg_match("#^http:\/\/chacha.vn(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/chacha/'.$id.'.mp3';
	}
	//music.top1.vn
	else if (preg_match("#^http:\/\/music.top1.vn(.*?)#s", $link)){
		$id = cut_str('http:\/\/music.top1.vn\/',$link,1);
		$id = cut_str('.htm',$id,0);
		$link=$myurl.'/top1/'.$id.'.mp3';
	}
	//vtc.com.vn
	else if (preg_match("#^http:\/\/vtc.com.vn(.*?)#s", $link)){
		$id = cut_str('/',$link,5);
		$link=$myurl.'/vtc/'.$id.'.flv';
	}
	//Music.NhacPro.Info
	else if (preg_match("#^http:\/\/music.nhacpro.info(.*?)#s", $link)){
		$id = cut_str(',',$link,1);
		$link=$myurl.'/nhacpro/1/'.$id.'.mp3';
	}
	//Dj.NhacPro.Info
	else if (preg_match("#^http:\/\/dj.nhacpro.info(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/nhacpro/2/'.$id.'.mp3';
	}
	//nghenhac.info
	else if (preg_match("#^http:\/\/nghenhac.info(.*?)#s", $link)){
		$id = cut_str('http://nghenhac.info',$link,1);
		$id = cut_str('.html',$id,0);
		if (preg_match("#^(.*?)Video-clips/(.*?)#s", $link)) $type='.wmv'; else $type='.mp3';
		$link=$myurl.'/nghenhac/'.$id.$type;
	}
	//Break.Com
	else if (preg_match("#^(.*?)break.com/(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$id = cut_str('.html',$id,0);
		$link=$myurl.'/break/'.$id.'.flv';
	}
	//Timvui.vn
	else if (preg_match("#^http://timvui.vn/video/(.*?)#s", $link)){
		$id = cut_str('view/',$link,1);
		$id = cut_str('\.',$id,0);
		$link=$myurl.'/timvui/'.$id.'.flv';
		$embed="http://timvui.vn/player/vPlayer.swf?f=http://timvui.vn/player/vConfig.php?videoid=".$id;
	}
	//Sendspace.com
	else if (preg_match("#^http://www.sendspace.com/file/(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$link=$myurl.'/sendspace/'.$id.'.flv';
	}
	//XtreMedia No Hack Mod Play
	else if (preg_match("#^(.*?)\#Play(.*?)#s", $link)){
		$host = cut_str('#Play',$link,0);
		$host = cut_str('http:\/\/',$host,1);
		if (substr_count($link,'#Play,')!=0){
			$id = cut_str(',',$link,1);
		}else{
			$id = cut_str('/',$link,4);
		}
		$link=$myurl.'/xtre/'.$host.'/'.$id.'.mp3';
		
	}else $link="Url bạn nhập không hợp lệ, vui lòng thử lại!";
	
	if ($type==1)return $link;
	elseif ($type==0) return $embed;
}
?>