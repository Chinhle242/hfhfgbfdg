<?php
define('IN_MEDIA', true);
define('IN_MEDIA_ADMIN', true);
include("../inc/_data.php");
include("../inc/_settings.php");
include("../inc/_form.php");
include("../inc/_functions.php");
include("../inc/_string.php");
if (!$_COOKIE['LangCookie']) $_COOKIE['LangCookie'] = 'English';
$level = $_SESSION['adminlevel'];
$form =& new HTMLForm;
?>
<html>
<head>
	<?php if ($act == 'left') echo '<base target="frame_content">'; ?>
	<title>.: CONTRON PANEL :.</title>
	<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
	<link rel=stylesheet href="style.css" type=text/css>
</head>
<? if (!$level) { ?>
<form method="post" action="login.php">
<table width=31% align=center cellpadding=2 cellspacing=0 class=border bgcolor=white>
	<tr><td colspan=2 align=center class=title><? if($error=="u"){ ?>Sai mật khẩu<? }else{ ?>Điền đầy đủ thông tin đăng nhập<? } ?></td></tr>
	<tr><td width=48% class=fr>Tên đăng nhập</td><td width=52% class=fr_2><input name="name" type="text" size="20"></td></tr>
	<tr><td class=fr>Mật khẩu</td><td class=fr_2><input name="password" type="password" size="20"></td></tr>
	<tr><td class=fr colspan=2 align=center><input class="submit" type="submit" name="submit" value="Đăng nhập"></td></tr>
</table>
</form>
<?
	exit();
}
include("admin_functions.php");

if ($level == 2) $mod_permission = acp_get_mod_permission();
$link = 'index.php';
if ($_SERVER["QUERY_STRING"]) $link .= '?'.$_SERVER["QUERY_STRING"];
?>
<script src="../js/admin.js"></script>
<script src="../js/unikey.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script>
<?php
if ($act) echo '<table cellspacing="0" align="center" cellpadding="0" width="100%"><tr><td align="center" width="100%">';
switch($act){
	case "episode":	include("episode.php");break;
	case "trailers":	include("trailers.php");break;
	case "multi_edit_episode":	include("multi_edit_episode.php");break;
	case "multi_edit_trailers":	include("multi_edit_trailers.php");break;
	case "cat":		include("cat.php");break;
	case "country":		include("country.php");break;
	case "film":	include("film.php");break;
	case "multi_edit_film":	include("multi_edit_film.php");break;
	case "skin":		include("skin.php");break;
	case "ads":		include("ads.php");break;
	case "user":	include("user.php");break;
	case "news":	include("news.php");break;
	case "lang":		include("lang.php");break;	
	case "config":	include("configures.php");break;
	case "comment":	include("comment.php");break;
	case "downloadlink":	include("downloadlink.php");break;	
	case "local":	include("local.php");break;
	case "request":	include("request.php");break;
	case "permission":	include("permission.php");break;
	case "main"	:	echo "<div class=title><b>Welcome to ".$web_title." Control Panel"; break;
	case "left"	:	include("left.php");break;
	default : echo '<script type="text/javascript">if (self.parent.frames.length != 0) self.parent.location.replace(document.location.href);</script>';
	?>

<frameset cols="200,*" frameborder="no" border="0" framespacing="0" id="mainFrameset">
  <frame src="index.php?act=left"  name="frame_navigation" scrolling="yes" noresize="" id="leftFrame" title="leftFrame" />
  <frame src="index.php?act=main"name="frame_content" id="frame_content" title="mainFrame" />
</frameset>
	<?
		break;
}
if ($act) echo '</td></tr></table>';
?>
</html>