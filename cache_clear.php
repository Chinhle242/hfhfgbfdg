 <?php

$cachedir = 'cache/';
if ($handle = @opendir($cachedir)) {
while (false !== ($file = @readdir($handle))) {
if ($file != '.' and $file != '..') {
echo $file . ' deleted.<br>';
@unlink($cachedir . '/' . $file);
 }
 }
@closedir($handle);
}

?>