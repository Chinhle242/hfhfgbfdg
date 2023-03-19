<?php
$file_check_sum = "check_sum_md5.php";
$act = @$_GET["do"];
define("FOLDER_CHMOD", 0701);
define("PHP_CHMOD", 0604);
define("FILE_CHMOD", 0604);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Check Sum MD5</title>
<style>
body{
	font-size: 12px;
	font-family: Tahoma;
	margin: 0px;
	line-height: 18px;
}
div{
	font-size: 18px;
	color: red;
}
table td{
	border-bottom: #CCC 1px solid;
	padding:2px;
}

</style>
</head>


<body>


<?php



if ($act == 'check') // kiem tra xem co gi khac khong 
{
	if (!file_exists($file_check_sum))
	{
		exit("<h2>$file_check_sum not found!</h2>");
	}
	include ($file_check_sum);	
	
    $list_tree = array();
    list_save("./", $list_tree);
    
	echo "<table>";
    	
    foreach ($md5_sums as $old_path => $old_md5)
	{
	   $flag = false;
       echo "<tr><td>$old_path</td><td>";
	   for($i = 0; $i < count($list_tree); $i++)
        {
            $new_path = $list_tree[$i][0];
            $new_md5 = $list_tree[$i][1];
            
            if($old_path == $new_path)
            {
                if($old_md5 == $new_md5) // ok
                {
                    echo "OK";
                }
                else { // fail
                    echo "<div>Fail</div>";
                }
                $flag = true;
                break;
            }            
        }
        if(!$flag) // delete
        {
            echo "<div>Deleted</div>";
        }
        echo "</td></tr>";
     }
     for($i = 0; $i < count($list_tree); $i++)
     {
         $new_path = $list_tree[$i][0];
         $new_md5 = $list_tree[$i][1];
         $flag = false;
         foreach($md5_sums as $old_path => $old_md5)
         {
            if($new_path == $old_path)
            {
                $flag = true;
                break;
            }
         }
         if(!$flag) // new
         {
            echo "<tr><td>$new_path</td><td><div>New</div></td></tr>";
         }
     }
     
	echo "</table>";
}
else if ($act == 'save') // de tao md5 an toan
{
    $list_tree = array();
    list_save("./", $list_tree);	
	
    // open write to file
    if (file_exists($file_check_sum)) unlink($file_check_sum);
    $fp = @fopen($file_check_sum, "a");
    fwrite($fp, "<?php \n");
	fwrite($fp, '$md5_sums = array('." \n");
    
	echo "<table>";
	for ($i = 0; $i < count($list_tree); $i++)
	{		
		$path = $list_tree[$i][0];
        $md5 = $list_tree[$i][1];
        echo "<tr><td><b>$path</b></td><td>$md5</td></tr>";
        
        $message = "'$path' => '$md5',\n";	
		fwrite($fp, $message);
	}    
	echo "</table>";
	echo "<h1>Finish</h1>";
	fwrite($fp, ");\n");
	fwrite($fp, "?>");
	fclose($fp);
}
else if ($act =='protect') // chmod toan bo nhung tham so da chinh sua o tren
{
    echo "<table>";
	list_chmod ();
    echo "</table>";
    echo "<h1>Finish</h1>";
}



function list_save ($dir = "./", &$arr)
{
  if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..")
            {    
                $curdir = ($dir == "./") ? "." : $dir;
                $curpath = "{$curdir}/{$file}";
                if (!is_dir( $curpath)) // file is OK
                {
					// xu li
                    $md5 = md5(file_get_contents($curpath));
                    array_push($arr, array($curpath, $md5));
                }
                else // folder
                {
					array_push($arr, array($curpath, "Folder" ));                    
                    list_save ($curpath, $arr);
                }
            }
        }
        closedir($handle);
    }
}

function list_chmod ($dir = "./")
{
  if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..")
            {
                
                $curdir = ($dir == "./") ? "." : $dir;
                $curpath = "{$curdir}/{$file}";                
                if (!is_dir( $curpath)) // file is OK
                {   
                    $parts = pathinfo(strtolower($curpath));
					$ext 		= $parts["extension"];
                    echo "<tr><td>$curpath</td><td><div>";
					if ($ext == 'php')
					{
						chmod($curpath, PHP_CHMOD);
                        echo (int)(PHP_CHMOD);
					}
					else if ($ext == 'js' || $ext == 'html' || $ext == 'htm' || $ext == 'xml' || $ext == 'css' || $ext == 'tpl')
					{
						chmod ($curpath, FILE_CHMOD);
                        echo (int)FILE_CHMOD;						
					}
                    echo "</div></td></tr>";					
                    
                }
                else // folder
                {
                    echo "<tr><td>$curpath</td><td><div>".((int)FOLDER_CHMOD)."</div></td></tr>";
                    chmod ($curpath, FOLDER_CHMOD);                    
                    list_chmod ($curpath);
                }
                
            }
        }
        closedir($handle);
    }
    
}


?>
</body>
</html>