<?php

define('IN_MEDIA',true);

include('../inc/_data.php');

include('../inc/_settings.php');

include('../inc/_functions.php');

include('../inc/_main.php');

include('../inc/_grab.php');

//if (!$_SESSION['lang']) $_SESSION['lang'] = 'English';

//include('../lang/'.$_SESSION['lang'].'/lang.php');

function LD($episode_id)	{

global $mysql,$tb_prefix;

	$rs=$mysql->fetch_array($mysql->query("SELECT episode_url,episode_local,episode_type, episode_name FROM ".$tb_prefix."episode WHERE episode_id=".$episode_id.""));

	$local=$rs['episode_local'];	$url= $rs['episode_url'];	$type= $rs['episode_type'];

	if($local!=0)	

	$down= $url = get_data('local_link','local','local_id',$local).$url;

return $down;

}



if ($_POST['down']) {



   $down = LD(intval($episode_id));



    echo $down;



exit();



}

$film_id = intval($film_id);

$episode_id = intval($episode_id);

if ($film_id || $episode_id)
{

	if ($film_id) 
	{

		$f=$mysql->fetch_array($mysql->query("SELECT episode_id FROM ".$tb_prefix."episode WHERE episode_film=".$film_id." ORDER BY episode_name ASC"));
	
		$episode_id=$f['episode_id'];
	
	}

	if($episode_id)	
	{

		$check =$mysql->query("SELECT episode_film from ".$tb_prefix."episode WHERE episode_id=".$episode_id."");
	
		$num = $mysql->num_rows($check); 

		if ($num)
		{	

			$e = $mysql -> fetch_array($check);
		
			$down= 'DOWN('.$episode_id.');';
		
			$film_info = $mysql -> fetch_array($mysql->query("SELECT film_name,film_name_real from ".$tb_prefix."film WHERE film_id=".$e['episode_film'].""));		
		
			$sl = $mysql -> fetch_array($mysql->query("SELECT episode_name,download_type,download_content from ".$tb_prefix."downloadlink WHERE film_id=".$e['episode_film']." ORDER BY episode_name ASC"));

			if($sl) 
			{

			if($sl['download_type']==1)
			
			{

				$dl= $mysql->query("SELECT episode_name,download_type,download_content from ".$tb_prefix."downloadlink WHERE film_id=".$e['episode_film']." ORDER BY episode_name ASC");

				while ($rs = $mysql->fetch_array($dl)) 
				{

						$otherlink .= '<div style="padding-top:3px;" align="left">'.$rs['download_content'].'</div>';

				}

			}

			else 
			{

				$name=	intval($name);	if ($name<10) $name='00'.$name;		elseif($name >=10 && $name <100) $name= '0'.$name;

				$dl= $mysql->query("SELECT episode_name,download_content from ".$tb_prefix."downloadlink WHERE film_id=".$e['episode_film']." AND (episode_name='".$name."' )");

				while ($rs = $mysql->fetch_array($dl)) 
				{

						$otherlink .= '<div style="padding-left:10px;padding-top:3px;" align="left">'.$rs['download_content'].'</div>';

				}

			}

			$otherlink = str_replace('href=',' target=_blank href=',$otherlink);

		}

else $otherlink =' &raquo; Not yet available,  please check back soon';

	



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Download <?=$film_info['film_name_real'].' - '.$film_info['film_name']?></title>

<meta name="robots" content="index, follow" />

<meta name="keywords" content="watch free movies online, tvb series, watch tvb drama online, free tvb movies, watch asian drama online, watch taiwanese drama, watch chinese drama, tvb shows online, download movies, online movies, chinese movies, phim, film, movie, xem phim TVB" />



<meta name="author" content="watch free movies online, tvb series, watch tvb drama online, free tvb movies, watch asian drama online, watch taiwanese drama, watch chinese drama, tvb shows online, download movies, online movies, chinese movies, phim, film, movie, xem phim TVB" />



<meta name="description" content="watch free movies online, tvb series, watch tvb drama online, free tvb movies, watch asian drama online, watch taiwanese drama, watch chinese drama, tvb shows online, download movies, online movies, chinese movies, phim, film, movie, xem phim TVB" />



<meta name="generator" content="watch free movies online, tvb series, watch tvb drama online, free tvb movies, watch asian drama online, watch taiwanese drama, watch chinese drama, tvb shows online, download movies, online movies, chinese movies, phim, film, movie, xem phim TVB" />







<script type="text/javascript" src="<?=$web_link?>/download/download.js"></script>

<link rel="stylesheet" href="<?=$web_link?>/download/style.css" type="text/css" />

</head>



<body>


    <div class="main">
<center>	
<script type="text/javascript"><!--
google_ad_client = "pub-1366496892893038";
/* Download_Film_Ngang_001 */
google_ad_slot = "3393233419";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</center>

<div class="col01"><div style="padding-top:5px;"></div>

<div class="directlink">&nbsp;</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="20" height="20" background="images/top_left.png">&nbsp;</td>

    <td width="610" background="images/center_top.png">&nbsp;</td>

    <td width="20" height="20" background="images/top_right.png">&nbsp;</td>

  </tr>

  <tr>

    <td background="images/center_left.png">&nbsp;</td>

    <td width="710" valign="top" bgcolor="#666666" ><div id="download"><script><?=$down?></script></div></td>

    <td background="images/center_right.png">&nbsp;</td>

  </tr>

  <tr>

    <td width="20" height="20" background="images/bottom_left.png">&nbsp;</td>

    <td background="images/center_bottom.png">&nbsp;</td>

    <td width="20" height="20" background="images/bottom_right.png">&nbsp;</td>

  </tr>

</table>
<table width="650" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left">
				<script type="text/javascript"><!--
				google_ad_client = "pub-1366496892893038";
				/* Download_Film_Vuong_001 */
				google_ad_slot = "7456306851";
				google_ad_width = 300;
				google_ad_height = 250;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
		</td>
		
		<td align="right">

			<script type="text/javascript"><!--
			google_ad_client = "pub-1366496892893038";
			/* Download_Film_Vuong_002 */
			google_ad_slot = "7808284615";
			google_ad_width = 300;
			google_ad_height = 250;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</td>
	</tr>
</table>	

<div class="mirrorlink">&nbsp;</div>

<table width="650" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="20" height="20" background="images/top_left.png">&nbsp;</td>

    <td width="610" background="images/center_top.png">&nbsp;</td>

    <td width="20" height="20" background="images/top_right.png">&nbsp;</td>

  </tr>

  <tr>

    <td background="images/center_left.png">&nbsp;</td>

    <td width="710" valign="top" bgcolor="#666666" ><div id="other_link" ><?=$otherlink?></div></td>

    <td background="images/center_right.png">&nbsp;</td>

  </tr>

  <tr>

    <td width="20" height="20" background="images/bottom_left.png">&nbsp;</td>

    <td background="images/center_bottom.png">&nbsp;</td>

    <td width="20" height="20" background="images/bottom_right.png">&nbsp;</td>

  </tr>

</table>

<table width="650" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left">
<!-- BEGIN SMOWTION TAG - 300x250 - watch free tvb drama tvb shows:  - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "300x250";
smowtion_section = "754983";
//-->
</script>
<script type="text/javascript"
src="http://ads2.smowtion.com/ad.js">
</script>
<!-- END SMOWTION TAG - 300x250 - watch free tvb drama tvb shows:  - DO NOT MODIFY -->
		</td>
		
		<td align="right">

<!-- BEGIN SMOWTION TAG - 300x250 - watch free tvb drama tvb shows:  - DO NOT MODIFY -->
<script type="text/javascript"><!--
smowtion_size = "300x250";
smowtion_section = "754983";
//-->
</script>
<script type="text/javascript"
src="http://ads2.smowtion.com/ad.js">
</script>
<!-- END SMOWTION TAG - 300x250 - watch free tvb drama tvb shows:  - DO NOT MODIFY -->

			
		</td>
	</tr>
</table>	

 <div style="padding-top: 5px;" align="center">

<!-- Histats.com  START  -->

<a href="http://www.histats.com" target="_blank" title="web page hit counter" ><script  type="text/javascript" language="javascript">

var s_sid = 782094;var st_dominio = 4;

var cimg = 0;var cwi =150;var che =30;

</script></a>

<script  type="text/javascript" language="javascript" src="http://s10.histats.com/js9.js"></script>

<noscript><a href="http://www.histats.com" target="_blank">

<img  src="http://s4.histats.com/stats/0.gif?782094&1" alt="web page hit counter" border="0"></a>

</noscript>

<!-- Histats.com  END  -->

<script type="text/javascript" src="http://widgets.amung.us/small.js"></script><script type="text/javascript">WAU_small('7bqfy1pjebx6')</script></div>

</center>

</div>

<div class="col02">

<div style="padding-left:15px; padding-top:5px;">

<div style="padding-bottom:2px;">

<script type="text/javascript"><!--
google_ad_client = "pub-1366496892893038";
/* Download_Film_Doc_001 */
google_ad_slot = "1904116680";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

							<!-- Google Analytics -->

<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>

<script type="text/javascript">

try {

var pageTracker = _gat._getTracker("UA-9919408-1");

pageTracker._setDomainName(".enterhk.com");

pageTracker._trackPageview();

} catch(err) {}</script>				

							<!-- Google Analytics -->

</div>

</div>

</div>







</body>

</html>



<?php

}

else

	    header('Location: http:/enterhk.com');

}

}

else

	    header('Location: http:/enterhk.com');

?>