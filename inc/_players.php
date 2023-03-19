<?php
if (!defined('IN_MEDIA')) die("Hack");
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

function players($url,$type,$video_id,$width,$height,$kind)
{
	global $web_link,$fcommon;
	
	$img = $web_link.'/images/logo.png';
	$url=get_link_total($url,$video_id);
	if ($type == 2 || $type ==  38)		// SWF, sevenload, youku
	{
		if ($type == 38) $url= str_replace('http://v.youku.com/v_show/id_','http://player.youku.com/player.php/sid/',$url);
		
		$player = '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="'.$url.'"/><param name="allowFullScreen" value="true"/><param name="allowScriptAccess" value="always"/><embed src="'.$url.'" type="application/x-shockwave-flash" allowScriptAccess="always" allowFullScreen="true" width="'.$width.'" height="'.$height.'" wmode="transparent"></embed></object>'; 
	}
	elseif ($type==5) {
			$player="<script type=\"text/javascript\">
				var so = new SWFObject('player.swf','mpl','$width','$height','9','#FFF');  
				so.addParam('allowscriptaccess','always');  
				so.addParam('bgcolor','#FFF'); 
				so.addParam('allowfullscreen','true');  
				so.addParam('flashvars','file=$url&autostart=true&volume=100');
				so.write('player');
			</script>";
		}
	elseif ($type==7) $player = "<iframe allowtransparency=\"true\" style=\"border: 0px none;\" name=\"tamtayp\" id=\"tamtayp\" src=\"tamtay.php?url=$url_org\" width=\"600\" frameborder=\"0\" height=\"$height\" scrolling=\"no\"></iframe>";
	else{
		if (preg_match("#static.yume.vn/yumevideo/(.*?)#s", $url)){
				$player = "<iframe allowtransparency=\"true\" style=\"border: 0px none;\" name=\"yume\" id=\"yume\" src=\"$url\" width=\"600\" frameborder=\"0\" height=\"$height\" scrolling=\"no\"></iframe>";
			}else{
				$p=explode('?',$url);
				$player="<script type=\"text/javascript\">
					var so = new SWFObject('$p[0]','mpl','$width','$height','9','#FFF');  
					so.addParam('allowscriptaccess','always');  
					so.addParam('bgcolor','#FFF'); 
					so.addParam('allowfullscreen','true');  
					so.addParam('flashvars','$p[1]');
					so.write('player');
				</script>";
			}
		}
	
return $player;	

}
function cut_str($str_cut,$str_c,$val)
{	
	$url=split($str_cut,$str_c);
	$urlv=$url[$val];
	return $urlv;
}
function encode_url($f,$f1)
{
	$f= base64_encode($f);
	for ($i=strlen($f);$i>=0;$i--)
	{
		$f2 .=$f[$i];
	}
  return $f1."****".$f2;
}
function get_link_total($url,$episode_id) {
	global $web_link,$type_return;
	$link=$url;
	$mylink='http://vuaphim.vn/grab/'.encode();
if (preg_match('#veoh.com/browse/videos/category/([^/]+)/watch/([^/]+)#', $url, $id_sr)){
		$id = $id_sr[2];
		$link=$mylink.'/veoh/'.$id.'.flv';
		$url="http://www.phim88.com/online/xxxxxx?plugins=$web_link/vuaphim.swf&plugin.thienduongviet=true&plugin.tdv_id=xml_video/$episode_id&autostart=true&skin=http://vuaphim.vn/video/skewd.xml&autostart=true";
    }
	elseif (preg_match('#www.veoh.com\/videodetails2\.swf\?permalinkId=(.*?)#s', $url) || preg_match('#www.veoh.com\/veohplayer\.swf\?permalinkId=(.*?)#s', $url)){
		$id = cut_str('=',$url,1);
		$id = cut_str('&',$id,0);
		$link=$mylink.'/veoh/'.$id.'.flv';
		$url="http://www.phim88.com/online/xxxxxx?plugins=$web_link/vuaphim.swf&plugin.thienduongviet=true&plugin.tdv_id=xml_video/$episode_id&autostart=true&skin=http://vuaphim.vn/video/skewd.xml&autostart=true";
    }
	
    elseif (preg_match('#veoh.com/(.*?)#s', $url, $id_sr)){
		$linkvideo=explode('/', $url);
		$num=count($linkvideo);
		$id=$linkvideo[$num-1];
		$link=$mylink.'/veoh/'.$id.'.flv';
		$url="http://www.phim88.com/online/xxxxxx?plugins=$web_link/vuaphim.swf&plugin.thienduongviet=true&plugin.tdv_id=xml_video/$episode_id&autostart=true&skin=http://vuaphim.vn/video/skewd.xml&autostart=true";
    }
    elseif (preg_match("#blog.com.vn/Video/([^/_]+)_([^/.]+).html#",$url,$id_sr)) {
		$id = $id_sr[2];
		$url = "http://blog.com.vn/embed/f/f/".$id;
		$link=$mylink.'/blogvn/'.$id.'.flv';
		$t="f";
    }
	elseif(preg_match('#http:\/\/clip.vn\/watch\/([^/,]+),([^/]+)#', $url, $id_sr)) {
		$id = $id_sr[2];
		$url = 'http://clip.vn/w/'.$id.',a';
		$t="f";
	}
    elseif (preg_match("#dailymotion.com/(.*?)#s",$url,$id_sr)) {
		$linkvideo=explode('/', $url);
		$num=count($linkvideo);
		$link=$linkvideo[$num-1];
		$id=explode('_', $link);
		$id=explode('&', $id[0]);
		$link=$mylink.'/daily/'.$id[0].'.flv';
		//$url='http://st3.gamecreds.com/images/swf/player.swf?vidID='.$id[0];
                $url='http://st1.gamecreds.com/images/swf/player-embed.swf?vidID='.$id[0];
		//$url=$web_link.'/'.'player.swf?file='.$link."&skin=$web_link/video/skewd.xml";
		
    }
    elseif (preg_match("#youtube.com/watch([^/]+)#",$url,$id_sr)) {
		$id = cut_str('=',$url,1);
		/*$url = "http://www.youtube.com/watch?v=".$id;*/
		$link=$mylink.'/youtube/'.$id.'.flv';
		$link=$mylink.'/youtube/'.$id.'.xml';
		$url="http://www.youtube.com/v/".$id;
		$url=encode_url($url,'phimnhanh');
		$url="http://player.longtailvideo.com/player.swf?plugins=http://vuaphim.vn/phimnhanh360.swf&phimnhanh360.file=$url&phimnhanh360.img=http://vuaphim.vn/player/screen_play.png&skin=http://vuaphim.vn/video/skewd.xml";	

    }
	elseif (preg_match("#youtube.com/v/([^/]+)#",$url,$id_sr)) {
		$id = cut_str('/',$url,4);
		$link=$mylink.'/youtube/'.$id.'.flv';
		$link=$mylink.'/youtube/'.$id.'.xml';
		$url="http://www.youtube.com/v/".$id;
		$url=$web_link.'/'.'mediaplayer.swf?file=http://www.youtube.com/watch%3Fv%3D'.$id."&skin=$web_link/mediaplayer_skin.xml&autostart=true";
		
    }
	elseif (preg_match("#youtube.com/view_play_list([^/]+)#",$url,$id_sr)) {
		$id = cut_str('=',$url,1);
		$link=$mylink.'/youtube/playlist/'.$id.'.html';
		$link2=$mylink.'/youtube/playlist/'.$id.'.xml';
		$url=$web_link.'/'.'player.swf?file=http://gdata.youtube.com/feeds/api/playlists/'.$id.'.xml&playlist=over&skin=$web_link/video/skewd.xml&autostart=tru&repeat=liste';
    }
	elseif (preg_match("#gdata.youtube.com/#",$url,$id_sr)) {
		$url=$web_link.'/'.'player.swf?file='.$url.'&playlist=over&&autostart=true&skin=http://vuaphim.vn/stylish.swf&repeat=list';
    }
	elseif (preg_match("#video.google.com/#",$url,$id_sr)) {
		$link=str_replace('docId=','docid',$url);
		$link .='&';
		$id = cut_str('docid=',$link,1);
		$id = cut_str('&',$id,0);
		$link=$mylink.'/google/'.$id.'.flv';
		$url=$web_link.'/'.'mediaplayer.swf?file='.$link."&skin=$web_link/mediaplayer_skin.xml&autostart=true";
		
    }
	elseif (preg_match("#sevenload.com/videos/([^/-]+)-([^/]+)#",$url,$id_sr)) {
		$linkvideo=explode('/', $link);
		$num=count($linkvideo);
		$link=$linkvideo[$num-1];
		$id=explode('-', $link);
		$link=$mylink.'/sevenload/'.$id[0].'.flv';
		$url=$web_link.'/player.swf?file='.$link."&skin=$web_link/video/skewd.xml";
		
    }
	else if (preg_match("#http://movie.zing.vn/Movie/xem-online/(.*?)#s", $url)){
		$link=str_replace(array('http://movie.zing.vn/Movie/xem-online/','.html'),array($mylink.'/zingm/','.wpl'),$url);
		$url=$link;
	}
	else if (preg_match("#video.yume.vn/playlist/(.*?)#s", $url)){
		$link=str_replace('http://video.yume.vn/',$mylink.'/timnhanh/',$url);
		$link=trim($link);
		$link2 = cut_str('&',$link,0).'.xml';
		$link = cut_str('&',$link,0).'.flv';
		$url="$web_link/player.swf?file=$link&plugins=http://static.hosting.vcmedia.vn/players/plugins/sharePlugin.swf&skin=$web_link/skin.swf&autostart=true";
	}
	else if ((preg_match("#video.timnhanh.com(.*?)#s", $url)) || (preg_match("#video.yume.vn(.*?)#s", $url))){
		$link=str_replace(array('http://video.timnhanh.com/','http://video.yume.vn/'),$mylink.'/timnhanh/',$url);
		$link2=str_replace('.html','.xml',$link);
		$link=str_replace('.html','.flv',$link);
		$url="$web_link/player.swf?file=$link&plugins=http://static.hosting.vcmedia.vn/players/plugins/sharePlugin.swf&skin=$web_link/skin.swfs&autostart=true";
	}
	else if (preg_match("#megavideo.com/\?v=(.*?)#s", $url,$id_sr)){
		$id=cut_str('=',$url,1);
		$link=$mylink.'/megavideo/'.$id.'.flv';
		$url='http://www.megavideo.com/ep_gr.swf?v=UYPTH58N?v='.$id;
	}
	else if (preg_match("#^http://www.metacafe.com/watch/(.*?)#s", $url)){
		$id = cut_str('/',$url,4);
		$link=$mylink.'/metacafe/'.$id.'.flv';
		$url="$web_link/player.swf?plugins=$web_link/vuaphim.swf&plugin.thienduongviet=true&plugin.tdv_id=xml_video/$episode_id&skin=$web_link/skin.swf";		
	}
	else if (preg_match("#^http://timvui.vn/video/(.*?)#s", $url)){
		$id = cut_str('view/',$url,1);
		$id = cut_str('\.',$id,0);
		$link=$mylink.'/timvui/'.$id.'.flv';
		$url=$web_link.'/'.'player.swf?file='.$link."&skin=$web_link/video/skewd.xml";
		$url='http://timvui.vn/player/vPlayer.swf?f=http://timvui.vn/player/videConfig.php%3Fvideoid='.$id;
	}
	else if (preg_match("#nhaccuatui.com(.*?)#s", $url)){
			$id = cut_str('=',$url,1);
			$link=$mylink.'/nct/'.$id.'.flv';
			$url='http://www.nhaccuatui.com/m2/'.$id;
			//$url=$web_link.'/'.'player.swf?file='.$link."&skin=$web_link/video/skewd.xml";
	}
	else if (preg_match("#video.baamboo.com(.*?)#s", $url)){
			$t = cut_str('/',$url,4);
			$id =cut_str('/',$url,6);
			$link=$mylink.'/baamboo/'.$id.'_'.$t.'.flv';
			$url=$web_link.'/'.'player.swf?file='.$link."&skin=$web_link/video/skewd.xml&autostart=true";
	}
	else if (preg_match("#video.baamboo.com(.*?)#s", $url)){
			$t = cut_str('/',$url,4);
			$id =cut_str('/',$url,6);
			$link=$mylink.'/baamboo/'.$id.'_'.$t.'.flv';
			$url=$web_link.'/'.'player.swf?file='.$link."&skin=$web_link/video/skewd.xml&autostart=true";
	}
	elseif (preg_match('#2shared.com/([^/]+)#', $url, $id)){
	    $id = cut_str('/',$link,4);
		$link=$mylink.'/2shared/'.$id.'.flv';
		$url='http://www.2shared.com/flash/player.swf?file='.$link."&skin=http://vuaphim.vn/video/skewd.xml&autostart=true";
		//$url="http://www.2shared.com/flash/player.swf?plugins=http://vuaphim.vn/vuaphim.swf&plugin.thienduongviet=true&plugin.tdv_id=xml_video/$episode_id&autostart=true&skin=$web_link/skin.swf";	
	}
	else if (preg_match("#4shared.com/(.*?)#s", $link)){
		$id = cut_str('/',$link,4);
		$link=$mylink.'/4shared/'.$id.'.flv';
		$url='http://www.4shared.com/flash/player.swf?file='.$link."&skin=http://vuaphim.vn/video/skewd.xml&autostart=true";
                //$url="http://www.4shared.com/flash/player.swf?plugins=http://vuaphim.vn/vuaphim.swf&plugin.thienduongviet=true&plugin.tdv_id=xml_video/$episode_id&autostart=true&skin=http://vuaphim.vn/skin.swf";		
	}
	else if (preg_match("#clips.goonline.vn/pages/(.*?)#s", $url)){
		$link= str_replace('uid=0&','',$url);
		$id = cut_str('id=',$link,1);
		$link=$mylink.'/goclip/'.$id.'.swf';
		$url="$link?$plugins";
	}
	else if (preg_match("#clips.goonline.vn/(.*?)#s", $url)){
		$id = cut_str('/',$url,5);
		$link=$mylink.'/goclip/'.$id.'.swf';
		$url="$link?$plugins";
	}
	else if (preg_match("#viddler.com/explore/(.*?)#s", $link)){
		$id =str_replace(array('http://www.viddler.com/explore/','/'),array('','-'),$link);
		$link=$mylink.'/viddler/'.$id.'.flv';
		$url=$web_link.'/'.'player.swf?file='.$link."&skin=$web_link/video/skewd.xml";
	}
	
	else if (preg_match("#viddler.com/explore/(.*?)#s", $link)){
		$id =str_replace(array('http://www.viddler.com/explore/','/'),array('','-'),$link);
		$link=$mylink.'/viddler/'.$id.'.flv';
		$url="http://vuaphim.vn/player/mediaplayer.swf?pathlateral=true&type=video&file=$link";	

	}
	else if (preg_match("#www.videobb.com/video/(.*?)#s", $url)){
		$url="http://v1vn.com/player/mediaplayer.swf?file=$url&amp;pathlateral=true&amp;type=video&amp;";	
	}
	else if (preg_match("#zippyshare.com/v/(.*?)#s", $url)){
		$url=encode_url($url,'phimnhanh');
		$url="http://vuaphim.vn/player/vixden_check.swf?plugins=http://vuaphim.vn/phimnhanh360.swf&phimnhanh360.file=$url&phimnhanh360.img=http://vuaphim.vn/player/screen_play.png&skin=http://vuaphim.vn/video/skewd.xml";	
	}
	else if (preg_match("#novamov.com/video/(.*?)#s", $url)){
		$url="http://vuaphim.vn/player/mediaplayer.swf?file=$url&amp;pathlateral=true&amp;type=video&amp;";	
	}
	else if (preg_match("#movshare.net/video/(.*?)#s", $url)){
		$url="http://vuaphim.vn/player/mediaplayer.swf?file=$url&amp;pathlateral=true&amp;type=video&amp;";	
	}
	else if (preg_match("#video.zing.vn/video/(.*?)#s", $url)){
		$url=encode_url($url,'phimnhanh');
		$url="http://vuaphim.vn/player/vixden_check.swf?plugins=http://vuaphim.vn/phimnhanh360.swf&phimnhanh360.file=$url&phimnhanh360.img=http://vuaphim.vn/player/screen_play.png&skin=http://vuaphim.vn/video/skewd.xml";	
	}
	else if (preg_match("#www.sendspace.com/file/(.*?)#s", $url)){
		$id = cut_str('/',$link,4);
		$link=$mylink.'/sendspace/'.$id.'.flv';
		$url="http://vuaphim.vn/player/mediaplayer.swf?pathlateral=true&type=video&file=$url";	
	}
	else if (preg_match("#badongo.com/vid/(.*?)#s", $url,$id_sr)){
		$id=cut_str('/',$url,4);
		$link=$mylink.'/badongo/'.$id.'.flv';
		$url="http://phim47.com/phim/images/swf/gac_kiem/mediaplayer.swf?pathlateral=true&type=video&file=$url";	
	}     
	else if (preg_match("#vidxden.com/(.*?)#s", $url)){
		$url=encode_url($url,'phimnhanh');
		$url="http://www.vidxden.com/player/player.swf?plugins=http://vuaphim.vn/phimnhanh360.swf&phimnhanh360.file=$url&phimnhanh360.img=http://vuaphim.vn/player/screen_play.png&skin=http://vuaphim.vn/video/skewd.xml";	
	}
	else if (preg_match("#video.seeon.tv/(.*?)#s", $url)){
		$url=encode_url($url,'phimnhanh');
		$url="http://player.longtailvideo.com/player.swf?plugins=http://vuaphim.vn/pn360.swf&pn360.file=$url&pn360.img=http://vuaphim.vn/player/screen_play.png&skin=http://vuaphim.vn/video/skewd.xml";	
	}
	else if (preg_match("#twitvid.com/(.*?)#s", $url)){
		$url=encode_url($url,'phimnhanh');
		$url="http://player.longtailvideo.com/player.swf?plugins=http://vuaphim.vn/pn360.swf&pn360.file=$url&pn360.img=http://vuaphim.vn/player/screen_play.png&skin=http://vuaphim.vn/video/skewd.xml";
	}
	
if ($link=="") $link="http://getlink.thienduongviet.org/?url=".$url;
if ($type_return=="download") return $link;
	else return $url;
}
?>