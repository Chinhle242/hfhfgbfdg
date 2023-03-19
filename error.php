<?php
if (!defined('IN_MEDIA')) die("Hack");
if (isset($_GET['error'])) {
	$htm = $temp->get_tpl('error');
	$main= $temp->replace_value($htm,
		array(
				'ERROR'			=> $lang_error,
		)
	);
}
?>