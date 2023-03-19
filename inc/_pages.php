<?php
if (!defined('IN_MEDIA')) die("Hack");
function view_pages($type,$ttrow,$limit,$page,$ext='',$apr='',$cat_id=''){
	global $web_link;
	$total = ceil($ttrow/$limit);
	if ($total <= 1) return '';
	$style_1 = 'onfocus="this.blur()"';
	$style_2 = 'onfocus="this.blur()"';
    if ($page<>1){
	    if($type=='request') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return showRequest(".$limit.",1); return false;'><b>&laquo;&laquo;</b></a>&nbsp;&nbsp;";
        elseif($type=='trailer') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return showTrailer(".$limit.",".$ext.",1); return false;'><b>&laquo;&laquo;</b></a>&nbsp;&nbsp;";
		elseif($type=='film') 
		$main .= "<a $style_1 href=".$web_link."/".$ext.".html onClick='return showFilm(".$ext.",1,".$limit.",".$apr.",".$cat_id."); return false;'><b>&laquo;&laquo;</b></a>&nbsp;&nbsp;";
        elseif($type=='comment') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return showComment(".$limit.",".$ext.",1); return false;'><b>&laquo;&laquo;</b></a>&nbsp;&nbsp;";
        elseif($type=='download') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return ShareLink(".$limit.",".$ext.",1); return false;'><b>&laquo;&laquo;</b></a>&nbsp;&nbsp;";
    }
	for($num = 1; $num <= $total; $num++){
		if ($num < $page - 1 || $num > $page + 4) 
		continue;
		if($num==$page) 
		$main .= "<a><span class=\"currentpage\"><span>".$num."</span></span></a>&nbsp;&nbsp;"; 
        else { 
           if($type=='request') 
		   $main .= "<a $style_1 href='javascript:void(0)' onClick='return showRequest(".$limit.",".$num."); return false;'>$num</a>&nbsp;&nbsp;&nbsp;";
		   elseif($type=='trailer') 
		   $main .= "<a $style_1 href='javascript:void(0)' onClick='return showTrailer(".$limit.",".$ext.",".$num."); return false;'>$num</a>&nbsp;&nbsp;&nbsp;"; 
		   elseif($type=='film') 
		   $main .= "<a $style_1 href=".$web_link."/".$ext."/p".$num.".html onClick='return showFilm(".$ext.",".$num.",".$limit.",".$apr.",".$cat_id."); return false;'>$num</a>&nbsp;&nbsp;&nbsp;"; 
           elseif($type=='comment') 
		   $main .= "<a $style_1 href='javascript:void(0)' onClick='return showComment(".$limit.",".$ext.",".$num."); return false;'>$num</a>&nbsp;&nbsp;";
           elseif($type=='download') 
		   $main .= "<a $style_1 href='javascript:void(0)' onClick='return ShareLink(".$limit.",".$ext.",".$num."); return false;'>$num</a>&nbsp;&nbsp;";
       } 		
    }
    if ($page<>$total){
	    if($type=='request') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return showRequest(".$limit.",".$total."); return false;'><b>&raquo;&raquo;</b></a>&nbsp;&nbsp;&nbsp;";      
		elseif($type=='trailer') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return showTrailer(".$limit.",".$ext.",".$total."); return false;'><b>&raquo;&raquo;</b></a>&nbsp;&nbsp;&nbsp;"; 
        elseif($type=='film') 
		$main .= "<a $style_1 href=".$web_link."/".$ext."/p".$total.".html onClick='return showFilm(".$ext.",".$total.",".$limit.",".$apr.",".$cat_id."); return false;'><b>&raquo;&raquo;</b></a>&nbsp;&nbsp;&nbsp;"; 
        elseif($type=='comment') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return showComment(".$limit.",".$ext.",".$total."); return false;'><b>&raquo;&raquo;</b></a>&nbsp;&nbsp;&nbsp;";
       elseif($type=='download') 
		$main .= "<a $style_1 href='javascript:void(0)' onClick='return ShareLink(".$limit.",".$ext.",".$total."); return false;'>&gt;&gt;</a>";		 
    }
  return '<div class="pagination"><p>'.$main.'</p></div>';
}

?>