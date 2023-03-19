<?php
if (!defined('IN_MEDIA')) die("Hack");
	$news_id = intval($_GET['news']);
	$sql = "SELECT news_name,news_name_ascii,news_content,news_quote,news_date FROM ".$tb_prefix."news where news_id = '$news_id'";
	$q = $mysql->query($sql);
	$num = $mysql->num_rows($q);
	$rs = $mysql->fetch_array($q);
	if (!$num) header("Location: ".$web_link.'/error.html');
//	$news_viewed = $rs['news_viewed'];
	$sql2 = "update ".$tb_prefix."news set news_viewed = news_viewed+1 where news_id = $news_id";
	$mysql->query($sql2);
# info new
	$htm = $temp->get_htm('news_details');
	$main = $temp->replace_value($htm,
			array(
				'news.NAME'		=> $rs['news_name'],
				'news.CONTENT'		=> text_tidy( $rs['news_content']),
				'news.DATE'		=> ngaythang($rs['news_date'],1),
				'web.LINK' => $web_link,
			)
		);

# other new
	$h['num_tag'] = $temp->get_block_from_htm($htm,'num_tag',1);
	$h['start_tag'] = $temp->get_block_from_htm($htm,'start_tag',1);
	$h['end_tag'] = $temp->get_block_from_htm($htm,'end_tag',1);
	$h['row'] = $temp->get_block_from_htm($htm,'row',1);
	$sql = "SELECT news_name,news_name_ascii,news_id FROM ".$tb_prefix."news where news_id < $news_id order by news_id desc LIMIT 0,10";
	$q = $mysql->query($sql);

	$i = 0;
	while ($rs2 = $mysql->fetch_array($q)) {
		if ($h['start_tag'] && fmod($i,$h['num_tag']) == 0) $news_list .= $h['start_tag'];
		$news_list .= $temp->replace_value($h['row'],
			array(
				'news.URL'			=> $web_link."/tin-tuc/".replace($rs2['news_name_ascii'])."_".$rs2['news_id'].".html",
				'news.CUT_NAME'		=> cut_string($rs2['news_name'],20),
				'news.NAME'		=> $rs2['news_name'],
				'web.LINK' => $web_link,
			)
		);
		if ($h['end_tag'] && fmod($i,$h['num_tag']) == $h['num_tag'] - 1) $news_list .= $h['end_tag'];
		$i++;
	}
	$main = $temp->replace_blocks_into_htm($main,array(
		'news_list' 		=> $news_list
		)
	);
    $web_keywords_main = $web_title_main = check_data($rs['news_name'])." | ".check_data($rs['news_name_ascii'])." | ";

?>