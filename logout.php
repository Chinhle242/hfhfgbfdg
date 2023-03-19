<?php
define('IN_MEDIA',true);
 session_start();
// if (isset($_SESSION['is_logged_in']))  {
    unset($_SESSION['is_logged_in']);
    setcookie('UserCookie', "", -1);
// }
echo  "<meta http-equiv='refresh' content='0;url=javascript:history.go(-1)'>";
?>
 
