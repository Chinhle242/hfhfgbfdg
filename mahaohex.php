<?php
class FCommon
{
    static function hexID($id, $ID=999999999)
    {
        return strtoupper(dechex($ID + $id));
    }
    static function decID($id, $ID=999999999)
    {
        return hexdec($id)-$ID;
    }
}

    $fcommon = new FCommon();
	$id = '00OfYAs9yic';
    $id_encode = $fcommon -> hexID($id); // Ma hoa
    $id_decode = $fcommon -> decID($id ); // Giai ma
	echo $id_encode.'<br>'.$id_decode;
?>