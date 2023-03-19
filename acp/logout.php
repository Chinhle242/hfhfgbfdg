<?php
define('IN_MEDIA',true);
include('../inc/_data.php');
include('../inc/_config.php');
unset($_SESSION['admin_id']);
session_destroy();
header("Location: ./");
?>