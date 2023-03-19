<?php
define('IN_MEDIA',true);
include('inc/_data.php');
include('inc/_settings.php');
include('inc/_functions.php');

header("Cache-Control: private");
header("Pragma: public");
header("Content-Type: application/xml; charset=utf-8");
$id = intval($_GET['id']);
$xml = '<?xml version="1.0" encoding="iso-8859-1"?>'.
	'<content>'.
	
	
$q = $mysql->query("SELECT film_img,film_name,film_id FROM `table_film` order by film_date DESC limit 20");
while ($r = $mysql->fetch_array($q)) {
$xml .= '<image>'.
		'<path><![CDATA[/film/'.$r['film_img'].']]></path>'.
		'<description><![CDATA['.$r['film_name'].']]></description>'.
		'<data><![CDATA[/film/thong-tin/vn_'.$r['film_id'].'.html]]></data>'.
		'</image>';
}
$xml .= '</content>';
echo $xml;
exit();
?>
      						
    						