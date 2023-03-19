<?php

class FCommon

{

    static function hexID($id, $ID=19051988)

    {

        return strtoupper(dechex($ID + $id));

    }

    static function decID($id, $ID=19051988)

    {

        return hexdec($id)-$ID;

    }

}



$fcommon = new FCommon();



?>