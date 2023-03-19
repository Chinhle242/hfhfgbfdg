<?php
include('encode.php');
$id=$_GET['id'];
$id=str_replace('-','/',$id);
	$content=grab_link('http://www.viddler.com/explore/'.$id,'','','JSESSIONID=563E5AAFD9A88DF5866EB94719947201.viddler_n;_jsuid=5543886757655739690;ACEGI_SECURITY_HASHED_REMEMBER_ME_COOKIE=dHJhaWxlcm1vdmllOjEyODUyMDY0OTQ3NTc6YWI4YjcyNWU1OGMzY2VkZTZjNDFiMWRjOTJmYTE4MGU%3D');
	
        $link=getStr($content,'.flv format" href="','">');
	$url='http://www.viddler.com'.$link;

	$content=grab_link($url,'','','JSESSIONID=563E5AAFD9A88DF5866EB94719947201.viddler_n;_jsuid=5543886757655739690;ACEGI_SECURITY_HASHED_REMEMBER_ME_COOKIE=dHJhaWxlcm1vdmllOjEyODUyMDY0OTQ3NTc6YWI4YjcyNWU1OGMzY2VkZTZjNDFiMWRjOTJmYTE4MGU%3D');
	$url=getStr($content,'Location: ','Content');
	header("Location: ".$url);
?>