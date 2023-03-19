<title>&#272;&#259;ng Nh&#7853;p</title>

<?php
define('Xuanhoa88',true);

include('../inc/_data.php');

include('../inc/_functions.php');

if ($_POST['submit'])
{
	$username = mysql_escape_string($_POST['username']);
			
	$pass = mysql_escape_string($_POST['pass']);	

	if (!$username || !$pass) echo '<font color="red"><b> - B&#7841;n c&#7847;n ph&#7843;i &#273;i&#7873;n &#273;&#7847;y &#273;&#7911; th&ocirc;ng tin y&ecirc;u c&#7847;u!</b></font><br>';
	
	else
	{
		$check_name = $mysql->query("SELECT hash FROM ".$tb_prefix."user WHERE username = '".$username."'");
		
		if ($mysql->num_rows($check_name)) 
		{
			$cn = $mysql -> fetch_assoc($check_name);
			
			$check_pass = $mysql->query("SELECT userid,username,avatar FROM ".$tb_prefix."user WHERE username = '".$username."'
										AND userpsw ='".md5(md5($pass.$cn['hash']))."'");
										
			if ($mysql->num_rows($check_pass)) 
			{
				$cp = $mysql -> fetch_assoc($check_pass);
				
				$user_session = md5(md5(NOW.$pass.$cn['hash']));
				
				setcookie('UserName',$cp['username'], time()+ 60*60*24*7, "/", "");
				
				setcookie('UserAvatar',$cp['avatar'], time()+ 60*60*24*7, "/", "");						
				
				setcookie('UserCookieSession',$user_session, time()+ 60*60*24*7, "/", "");   
				 
				$mysql->query("UPDATE  ".$tb_prefix."user SET lastvisit = lastactivity, lastactivity ='".NOW."', usersession = '".$user_session."' WHERE userid = ".$cp['userid']."");						
				$url = $movie_home."movie-home/" ;
				
			//	header("Location: ".$url);
				
			echo $user_session;							
			}
			
			else echo '<font color="red"><b> - M&#7853;t kh&#7849;u kh&ocirc;ng &#273;&uacute;ng!</b></font><br>';	
		}
													
		else echo '<font color="red"><b> - T&ecirc;n &#273;&#259;ng nh&#7853;p kh&ocirc;ng &#273;&uacute;ng!</b></font><br>';
	}

}
?>
<div align="center">
<form id="form1" name="form1" method="post" action="">
  <table width="500" border="0" cellpadding="5" cellspacing="5">
    <tr>
      <td width="100">T&ecirc;n &#273;&#259;ng nh&#7853;p </td>
      <td width="400"><label>
        <input name="username" type="text" id="username" size="35" maxlength="100" />
      </label></td>
    </tr>
    <tr>
      <td>M&#7853;t kh&#7849;u </td>
      <td><label>
        <input name="pass" type="password" id="pass" size="35" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <label>
        <input name="submit" type="submit" id="submit" value="&#272;&#259;ng Nh&#7853;p" />
        </label>
      </div></td>
    </tr>
  </table>
</form>
</div>