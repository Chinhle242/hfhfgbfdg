<?php

if (!defined('IN_MEDIA')) die("Hack");



$site_on	=  1;



$skin_folder = 'vuap';



$web_title			=	'XEM PHIM NHANH * Xem Phim Online | Xem Phim Mien Phi | Phim Nhanh Nhat';



$web_link 			=	'http://vuaphim.vn';	



if ($web_link[strlen($web_link)-1] == '/') $web_link = substr($web_link,0,-1);


$web_keywords 		=	'xem, phim, xem phim, phim mien phi, he thong xem phim, xem phim nhanh, phim online nhanh, phim nhanh, phim truc tuyen, phim mien phi, google, top 10, phim nhanh nhat, xem phim nhanh nhat, phim moi nhat, danh sach the loai, the loai phim, download phim, viet sub';


$web_des			=	'VuaPhim.vn - He thong xem phim online truc tuyen hoan toan mien phi, cap nhat phim nhanh nhat va moi nhat, phim bo nhieu tap, phim dien anh ...';


$link_folder 		= 	'';



$web_rss			=	'';



$web_email 			=	'phimnhanh360@gmail.com';



$per_page 			= 	'28';



$img_film_folder 	= 	'images/film';



$img_ads_folder  	= 	'images/ads';



$img_trailer_folder	= 	'images/trailer';



$img_news_folder  	= 	'images/news';



$cachedir			= 	'cache/'; // Directory to cache files in (keep outside web root)



$cacheext 			= 	'cache'; // Extension to give cached files (usually cache, htm, txt)



$js 				= 	'<script type="text/javascript" src="/js/unikey.js"></script>



						<script type="text/javascript" src="/js/load.js"></script>

				

						   <script language="javascript" type="text/javascript" src="/js/tooltips.js"></script>

				

						   <script>

				

						   var loadingText = "<center><img src=\''.$web_link.'/images/loading.gif\'></center>";

						   

						   var web_link = "'.$link_folder.'";

				

						   </script>

						   





<script type="text/javascript" src="/js/jquery.js"></script>

';

						   



?>