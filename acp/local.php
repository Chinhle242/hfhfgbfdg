<?php

if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

if ($level != 3) {

	echo "Bạn không có quyền vào trang này.";

	exit();

}

$q = $mysql->query("SELECT * FROM ".$tb_prefix."local ORDER BY local_id ASC");

$total = get_total('local','local_id');

if (!$_POST['submit']) {

    ?>

    <form method="post">

    <table cellspacing="0" width="90%" class=border>

        <? $i = 1;

        while ($r = $mysql->fetch_array($q)) { 

        ?>

        <tr><td colspan=2 align=center class=title>Local Sever <?=$i?></td></tr>

        <tr><td class=fr>Local Name <?=$i?></td><td class=fr_2><input name="local_name_[<?=$r['local_id']?>]" size="40" value="<?=$r['local_name']?>"></td></tr>

        <tr><td class=fr>Local Link&nbsp;&nbsp;&nbsp;<?=$i?></td><td class=fr_2><input name="local_link_[<?=$r['local_id']?>]" size="50" value="<?=$r['local_link']?>"></td></tr>

		<? $i++; } ?>

        <tr><td align="center" class=fr_2>Tổng Local Sever<input size=4 name="local_total" value="<?=$total?>" onclick="this.select()"></td><td class=fr><input type="submit" value="Thực Hiện" name=submit class=submit></td></tr>

        <tr><td colspan=2>

        </td></tr>

    </td></tr>

    </table>

    </form>

    <?php

    }

    else {

        $i = 1;    

        while ($r = $mysql->fetch_array($q)) {

            $id[$i] = $r['local_id'];

            $i++;

            if ($r['local_name'] != $local_name_[$r['local_id']]) {

                $mysql->query("UPDATE ".$tb_prefix."local SET local_name = '".$local_name_[$r['local_id']]."' WHERE local_id IN (".$r['local_id'].")");

            }

            if ($r['local_link'] != $local_link_[$r['local_id']]) {

                $mysql->query("UPDATE ".$tb_prefix."local SET local_link = '".$local_link_[$r['local_id']]."' WHERE local_id IN (".$r['local_id'].")");



            }

		}

        if ($local_total > $total) {

            for ($i=$total+1; $i<=$local_total; $i++) {

                $mysql->query("INSERT INTO ".$tb_prefix."local (local_name, local_link) VALUES ('','')");

            }

        }

        elseif ($local_total < $total) {

            for ($i=$local_total+1; $i<=$total; $i++) {

                natsort($id);

                $mysql->query("DELETE FROM ".$tb_prefix."local WHERE local_id IN (".$id[$i].")");

            }

        }

        echo "Đã sửa xong !<meta http-equiv='refresh' content='0;url=$link'>";

    }

?> 

