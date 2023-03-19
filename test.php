<script>
function docheck(status,from_){
	var alen=document.media_list.checkbox.length;
	cb = document.media_list.checkbox;
	if (alen>0)
	{
		for(var i=0;i<alen;i++)
			if(document.media_list.checkbox[i].disabled==false)
				document.media_list.checkbox[i].checked=status;
	}
	else
		if(cb.disabled==false)
			cb.checked=status;
	if(from_>0)
		document.media_list.chkall.checked=status;
}

function docheckone(id){
	var alen=document.media_list.checkbox.length;
	var isChecked=true;
	if (alen>0){
		for(var i=0;i<alen;i++){
			if(document.media_list.checkbox[i].checked==false){
				isChecked=false;
			}
		}
	}else{
		if(document.media_list.checkbox.checked==false){
			isChecked=false;
		}
	}				
	document.media_list.chkall.checked=isChecked;
}
function check_checkbox() {
	var alen=document.media_list.checkbox.length;
	var isChecked=false;
	if (alen>0) {
		for(var i=0;i<alen;i++)
			if(document.media_list.checkbox[i].checked==true) isChecked=true;
	}
	else {
		if(document.media_list.checkbox.checked==true) isChecked=true;
	}
	if (!isChecked){
		alert("Bạn chưa chọn");
	}
	else if (confirm('Bạn có chắc chắn muốn thực hiện không ?')) return true;
		else return false;
	return isChecked;
}

</script>
<?php
$a= $_POST['selectcat'];
$num=count($a);
for ($i=1; $i<$num;$i++){
	$b .=$a[$i].',';
}
echo $b;

?>


<table cellspacing="0" align="center" cellpadding="0" width="100%"><tr><td align="center" width="100%"><form enctype="multipart/form-data" method="post"><table class="border" cellpadding="2" cellspacing="0" width="90%"><tr><td colspan="2" class="title" align="center">Sửa Phim</td></tr><tr><td class="fr" width="30%"><b>Tên tiếng Việt</b></td><td class=fr_2><input type="text" name="name" size="50" value="Vua Câu Cá Phần 1"></td></tr><tr><td class="fr" width="30%"><b>Tên Quốc tế</b></td><td class=fr_2><input type="text" name="name_real" size="50" value="Super Fishing Grander Musashi Season I"></td></tr><tr><td class="fr" width="30%"><b>Ảnh</b></td><td class=fr_2><input type="text" name="img" size="50" value="vuacauca.jpg"><br><br>
				                   <input type="file" name="img" size="47" value="vuacauca.jpg"></td></tr><tr><td class="fr" width="30%"><b>Đạo diễn</b></td><td class=fr_2><input type="text" name="director" size="50" value="Takayoshi Suzuki"></td></tr><tr><td class="fr" width="30%"><b>Diễn viên</b></td><td class=fr_2><input type="text" name="actor" size="50" value="Kouji Tsujitanimm, Maya Okamoto, Urara Takano, Rin Mizuhara"></td></tr><tr><td class="fr" width="30%"><b>Sản xuất</b></td><td class=fr_2><input type="text" name="area" size="50" value="FaFilm VN"></td></tr><tr><td class="fr" width="30%"><b>Thời lượng</b></td><td class=fr_2><input type="text" name="time" size="50" value="25 tập"></td></tr><tr><td class="fr" width="30%"><b>Năm phát hành</b></td><td class=fr_2><input type="text" name="year" size="50" value="1997"></td></tr><tr><td class="fr" width="30%"><b>Mirror</b></td><td class=fr_2><input type="text" name="server" size="50" value="25,19,30,32,29"></td></tr><tr><td class="fr" width="30%"><b>Country</b></td><td class=fr_2><select name=country><option value=1>- Đang cập nhập</option><option value=2>- Mỹ</option><option value=3>- Việt Nam</option><option value=4>- Hàn Quốc</option><option value=5>- Trung Quốc</option><option value=6 selected>- Nhật Bản</option><option value=7>- Đài Loan</option><option value=8>- Hồng Kông</option></select></td></tr><tr><td class="fr" width="30%"><b>Phim B&#7897;/L&#7867;</b></td><td class=fr_2><select name=film_type><option value=1 selected>- Phim B&#7897;</option><option value=2>- Phim L&#7867;</option></select></td></tr><tr><td class="fr" width="30%"><b>Ho&agrave;n Th&agrave;nh</b></td><td class=fr_2><select name="film_complete"><option value=0>Chờ duyệt</option><option value=1 selected>Đã Post</option><option value=2>Không tìm thấy</option></select></td></tr><tr><td class="fr" width="30%"><b>Thể loại</b></td><td class=fr_2><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="1"> HÀNH ĐỘNG<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="7"> PHIÊU LƯU<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="4"> KINH DỊ<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="5"> TÌNH CẢM<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="27" checked="checked"> HOẠT HÌNH<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="6"> VÕ THUẬT<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="3"> HÀI HƯỚC<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="9"> HÌNH SỰ<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="10"> TÂM LÝ<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="34"> VIỄN TƯỞNG<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="51"> PHIM 18+<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="29"> THẦN THOẠI<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="30"> VIỆT NAM<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="31"> DÃ SỬ | CỔ TRANG<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="32"> CHIẾN TRANH<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="41"> THỂ THAO | ÂM NHẠC<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="47"> PHIM BỘ TỔNG HỢP<br><input type="checkbox" id="selectcat" onclick="docheckone()" name="selectcat[]" value="50"> SHOWS<br></td></tr><tr><td class="fr" width="30%"><b>Nội dung</b></td><td class=fr_2><textarea rows="8" cols="70" id="film_info" name="film_info"><div style="text-align: center;"><strong>Giới thiệu:</strong> Phim được chuyển thể từ manga nổi tiếng 
Grander Musashi, nói về cậu bé Mushashi có khả năng câu cá bậc thầy<font size="3"><span style="font-weight: bold;"></span><br></font></div><div style="text-align: right; font-weight: bold; font-family: Comic Sans MS; color: rgb(255, 0, 102);">Nhóc&nbsp; Wanbi - V1VN.COM<br></div></textarea><script language="JavaScript">generate_wysiwyg('film_info');</script></td></tr><tr><td class="fr_2" colspan="2" align="center"><input type="submit" name="submit" value="Thực hiện"></td></tr></table></form>

</td></tr></table>

