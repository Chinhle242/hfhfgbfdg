var http = createRequestObject();
var field = '';
var loadingText="Đang tải...."
function createRequestObject() {
	var xmlhttp;
	try { xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); }
	catch(e) {
    try { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	catch(f) { xmlhttp=null; }
  }
  if(!xmlhttp&&typeof XMLHttpRequest!="undefined") {
	xmlhttp=new XMLHttpRequest();
  }
	return  xmlhttp;
}

function handleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			response = http.responseText;
			field.innerHTML = response;
			field.scrollIntoView();
			if(!response) window.location.href = url;
		}
  	}
	catch(e){}
	finally{}
}

function nohandleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			response = http.responseText;
			field.innerHTML = response;
			if(!response) window.location.href = url;
		}
  	}
	catch(e){}
	finally{}
}

function load_pages(type,num,apr,id,page) { //load_pages('comment',num,film_id,0,1);	
	field = document.getElementById(type);
	if (type != 'comment')	
	field.innerHTML = loadingText;
	http.open('POST',  base_url+'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('load_pages=1&type='+type+'&num='+num+'&apr='+apr+'&id='+id+'&page='+page); 
  return false; 
}
//#######################################
//# CONVERT NON MARK
//#######################################
function convert_non_mark(str){
     str= str.replace(/\u00E1/g,'a');
	 str= str.replace(/\u00C1/g,'a');
	 str= str.replace(/\u00E0/g,'a');
	 str= str.replace(/\u00C0/g,'a');
     str= str.replace(/\u1EA3/g,'a');
	 str= str.replace(/\u1EA2/g,'a');
	 str= str.replace(/\u00E3/g,'a');
	 str= str.replace(/\u00C3/g,'a');
     str= str.replace(/\u1EA1/g,'a');
	 str= str.replace(/\u1EA0/g,'a');
	 str= str.replace(/\u0103/g,'a');
	 str= str.replace(/\u0102/g,'a');
     str= str.replace(/\u1EAF/g,'a');
	 str= str.replace(/\u1EAE/g,'a');
	 str= str.replace(/\u1EB1/g,'a');
	 str= str.replace(/\u1EB0/g,'a');
     str= str.replace(/\u1EB3/g,'a');
     str= str.replace(/\u1EB2/g,'a');
	 str= str.replace(/\u1EB5/g,'a');
	 str= str.replace(/\u1EB4/g,'a');
     str= str.replace(/\u1EB7/g,'a');
	 str= str.replace(/\u1EB6/g,'a');
	 str= str.replace(/\u00E2/g,'a');
	 str= str.replace(/\u00C2/g,'a');
     str= str.replace(/\u1EA5/g,'a');
	 str= str.replace(/\u1EA4/g,'a');
	 str= str.replace(/\u1EA7/g,'a');
	 str= str.replace(/\u1EA6/g,'a');
     str= str.replace(/\u1EA9/g,'a');
	 str= str.replace(/\u1EA8/g,'a');
	 str= str.replace(/\u1EAB/g,'a');
	 str= str.replace(/\u1EAA/g,'a');
     str= str.replace(/\u1EAD/g,'a');
	 str= str.replace(/\u1EAC/g,'a');
	 str= str.replace(/\u00E9/g,'e');
	 str= str.replace(/\u00C9/g,'e');
     str= str.replace(/\u00E8/g,'e');
	 str= str.replace(/\u00C8/g,'e');
	 str= str.replace(/\u1EBB/g,'e');
	 str= str.replace(/\u1EBA/g,'e');
     str= str.replace(/\u1EBD/g,'e');
	 str= str.replace(/\u1EBC/g,'e');
	 str= str.replace(/\u1EB9/g,'e');
	 str= str.replace(/\u1EB8/g,'e');
     str= str.replace(/\u00EA/g,'e');
	 str= str.replace(/\u00CA/g,'e');
	 str= str.replace(/\u1EBF/g,'e');
	 str= str.replace(/\u1EBE/g,'e');
     str= str.replace(/\u1EC1/g,'e');
	 str= str.replace(/\u1EC0/g,'e');
	 str= str.replace(/\u1EC3/g,'e');
	 str= str.replace(/\u1EC2/g,'e');
     str= str.replace(/\u1EC5/g,'e');
	 str= str.replace(/\u1EC4/g,'e');
	 str= str.replace(/\u1EC7/g,'e');
	 str= str.replace(/\u1EC6/g,'e');
     str= str.replace(/\u00ED/g,'i');
	 str= str.replace(/\u00CD/g,'i');
	 str= str.replace(/\u00EC/g,'i');
	 str= str.replace(/\u00CC/g,'i');
     str= str.replace(/\u1EC9/g,'i');
	 str= str.replace(/\u1EC8/g,'i');
	 str= str.replace(/\u0129/g,'i');
	 str= str.replace(/\u0128/g,'i');
     str= str.replace(/\u1ECB/g,'i');
	 str= str.replace(/\u1ECA/g,'i');
	 str= str.replace(/\u00F3/g,'o');
	 str= str.replace(/\u00D3/g,'o');
     str= str.replace(/\u00F2/g,'o');
	 str= str.replace(/\u00D2/g,'o');
	 str= str.replace(/\u1ECF/g,'o');
	 str= str.replace(/\u1ECE/g,'o');
     str= str.replace(/\u00F5/g,'o');
	 str= str.replace(/\u00D5/g,'o');
	 str= str.replace(/\u1ECD/g,'o');
	 str= str.replace(/\u1ECC/g,'o');
     str= str.replace(/\u01A1/g,'o');
	 str= str.replace(/\u01A0/g,'o');
	 str= str.replace(/\u1EDB/g,'o');
	 str= str.replace(/\u1EDA/g,'o');
     str= str.replace(/\u1EDD/g,'o');
	 str= str.replace(/\u1EDC/g,'o');
	 str= str.replace(/\u1EDF/g,'o');
	 str= str.replace(/\u1EDE/g,'o');
     str= str.replace(/\u1EE1/g,'o');
	 str= str.replace(/\u1EE0/g,'o');
	 str= str.replace(/\u1EE3/g,'o');
	 str= str.replace(/\u1EE2/g,'o');
     str= str.replace(/\u00F4/g,'o');
	 str= str.replace(/\u00D4/g,'o');
	 str= str.replace(/\u1ED1/g,'o');
	 str= str.replace(/\u1ED0/g,'o');
     str= str.replace(/\u1ED3/g,'o');
	 str= str.replace(/\u1ED2/g,'o');
	 str= str.replace(/\u1ED5/g,'o');
	 str= str.replace(/\u1ED4/g,'o');
     str= str.replace(/\u1ED7/g,'o');
	 str= str.replace(/\u1ED6/g,'o');
	 str= str.replace(/\u1ED9/g,'o');
	 str= str.replace(/\u1ED8/g,'o');
     str= str.replace(/\u00FA/g,'u');
	 str= str.replace(/\u00DA/g,'u');
	 str= str.replace(/\u00F9/g,'u');
	 str= str.replace(/\u00D9/g,'u');
     str= str.replace(/\u1EE7/g,'u');
	 str= str.replace(/\u1EE6/g,'u');
	 str= str.replace(/\u0169/g,'u');
	 str= str.replace(/\u0168/g,'u');
     str= str.replace(/\u1EE5/g,'u');
	 str= str.replace(/\u1EE4/g,'u');
	 str= str.replace(/\u01B0/g,'u');
	 str= str.replace(/\u01AF/g,'u');
     str= str.replace(/\u1EE9/g,'u');
	 str= str.replace(/\u1EE8/g,'u');
	 str= str.replace(/\u1EEB/g,'u');
	 str= str.replace(/\u1EEA/g,'u');
     str= str.replace(/\u1EED/g,'u');
	 str= str.replace(/\u1EEC/g,'u');
	 str= str.replace(/\u1EEF/g,'u');
	 str= str.replace(/\u1EEE/g,'u');
     str= str.replace(/\u1EF1/g,'u');
	 str= str.replace(/\u1EF0/g,'u');
	 str= str.replace(/\u00FD/g,'y');
	 str= str.replace(/\u00DD/g,'y');
     str= str.replace(/\u1EF3/g,'y');
	 str= str.replace(/\u1EF2/g,'y');
	 str= str.replace(/\u1EF7/g,'y');
	 str= str.replace(/\u1EF6/g,'y');
     str= str.replace(/\u1EF9/g,'y');
	 str= str.replace(/\u1EF8/g,'y');
	 str= str.replace(/\u1EF5/g,'y');
	 str= str.replace(/\u1EF4/g,'y');
     str= str.replace(/\u0110/g,'d');
	 str= str.replace(/\u0111/g,'d');
   return str;
}
//#######################################
//# SEARCH
//#######################################
function valButton(btn) {
var cnt = -1;
for (var i=btn.length-1; i > -1; i--) {
   if (btn[i].checked) {cnt = i; i = -1;}
   }
if (cnt > -1) return btn[cnt].value;
else return null;
}

function do_search() {
	kw = document.getElementById("keyword").value;
	kw = convert_non_mark(kw);
	type = document.getElementsByName("search_type");
	t = valButton(type);
	if (!kw) alert('Bạn chưa nhập từ khóa');
	else {
		kw = encodeURIComponent(kw);
		if (t == 'all')
		window.location.href = base_url + '/search/'+kw + '.html';	
		else if (t == 'film')
		window.location.href = base_url + '/search-film/'+kw + '.html';	
		else if (t == 'actor')
		window.location.href = base_url + '/search-actor/'+kw + '.html';				
	}
	
  return false;
}
//#######################################
//# COUNT WORDS
//#######################################
var submitcount=0;
   function checkSubmit() {
      if (submitcount == 0){
      submitcount++;
      document.Surv.submit();
      }
}

function wordCounter(field, countfield, maxlimit) {
wordcounter=0;
for (x=0;x<field.value.length;x++) {
      if (field.value.charAt(x) == " " && field.value.charAt(x-1) != " ")  {wordcounter++}
      if (wordcounter > 250) {field.value = field.value.substring(0, x);}
      else {countfield.value = maxlimit - wordcounter;}
      }
}

function textCounter(field, countfield, maxlimit) {
  if (field.value.length > maxlimit)
      {field.value = field.value.substring(0, maxlimit);}
      else
      {countfield.value = maxlimit - field.value.length;}
}
//#######################################
//# COMMENT
//#######################################
function showComment(num,film_id,page) { 
	field = document.getElementById("comments");
	field.innerHTML = loadingText;
	http.open('POST', base_url + 'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('showcomment=1&num='+num+'&film_id='+film_id+'&page='+page); 
  return false; 
}
function comment_handleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			var response = http.responseText;
			if (response == 'OK') {
				film_id = encodeURIComponent(document.getElementById("film_id").value);
				num = encodeURIComponent(document.getElementById("num").value);
               	showComment(num,film_id,1);			   
            }
			else document.getElementById("comment_loading").innerHTML = response;

		}
  	}
	catch(e){}
	finally{}
}

function comment_check_values() {
	film_id = encodeURIComponent(document.getElementById("film_id").value);
	num = encodeURIComponent(document.getElementById("num").value);
	comment_poster = encodeURIComponent(document.getElementById("comment_poster").value);
//	comment_sec = encodeURIComponent(document.getElementById("comment_sec").value);
//	user_group = encodeURIComponent(document.getElementById("user_group").value);	
	comment_content = encodeURIComponent(document.getElementById("comment_content").value);
	try {
	    document.getElementById("comment_loading").innerHTML = loadingText;
		document.getElementById("comment_loading").style.display = "block";
		http.open('POST',  base_url+'index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		http.onreadystatechange = comment_handleResponse;
		http.send('comment=1&film_id='+film_id+'&num='+num+'&comment_poster='+comment_poster+'&comment_content='+comment_content);
	}
	catch(e){}
	finally{}
  return false;
}
//#######################################
//# RATING
//#######################################
function rating(film_id,star) {
   		field = document.getElementById("rating_field");
	//	field.innerHTML = loadingText;
   		http.open('POST',  base_url+'index.php');
   		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   		http.onreadystatechange = nohandleResponse;
		http.send('rating=1&film_id='+film_id+'&star='+star);
 	return false;
}
	// pre-fetch image
	(new Image()).src = RATE_OBJECT_IMG;
	(new Image()).src = RATE_OBJECT_IMG_HALF;
	(new Image()).src = RATE_OBJECT_IMG_BG;

	function show_star(starNum,rate_text) {
		remove_star();
		document.getElementById("rating_text").innerHTML = rate_text;
		full_star(starNum);
	}
	
	function full_star(starNum) {
		for (var i=0; i < starNum; i++)
			document.getElementById('star'+ (i+1)).src = RATE_OBJECT_IMG;
	}
	function remove_star() {
		for (var i=0; i < 5; i++)
			document.getElementById('star' + (i+1)).src = RATE_OBJECT_IMG_BG; // RATE_OBJECT_IMG_REMOVED;
	}
	function remove_all_star() {
		for (var i=0; i < 5; i++) document.getElementById('star' + (i+1)).src = RATE_OBJECT_IMG_BG; // RATE_OBJECT_IMG_REMOVED;
		document.getElementById("rating_text").innerHTML = 'Bình Chọn';
	}
	function show_rating_process() {
		if(document.getElementById("rating_process")) document.getElementById("rating_process").style.display = "block";
		if(document.getElementById("rating")) document.getElementById("rating").style.display = "none";
	}
	function hide_rating_process() {
		document.getElementById("rating_process").style.display = "none";
		if(document.getElementById("rating")) document.getElementById("rating").style.display = "block";
	}
//#######################################
//# BROKEN
//#######################################
function showBroken(film_id,episode_id) {
   		field = document.getElementById("broken_field");
		field.innerHTML = loadingText;
   		http.open('POST',  base_url+'index.php');
   		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   		http.onreadystatechange = handleResponse;
		http.send('broken=1&film_id='+film_id+'&episode_id='+episode_id);
 	return false;
}
//#######################################
//# GIFT
//#######################################
function gift(url) {
	field = document.getElementById("gift");
	field.innerHTML = '<input type="text" size="30" value="'+url+'" onclick=\"this.select()\"/>';
	return false;
}
function request_check_values() {
	num = encodeURIComponent(document.getElementById("security").value);
	request_name = encodeURIComponent(document.getElementById("request_content").value);
	if(!num) alert('Bạn chưa nhập mã số bảo mật');
	else if(!request_name) alert('Bạn chưa tên bộ phim muốn yêu cầu');
	else {
		try{
				document.getElementById("request_loading").innerHTML = loadingText;
				document.getElementById("request_loading").style.display = "block";
				http.open('POST',  base_url+'index.php');
				http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
				http.onreadystatechange = request_handleResponse;
				http.send('request=1&sec_num='+num+'&request_name='+request_name);
			}
		  catch(e){}
		  finally{}
	}
	return false;
}
function request_handleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			var response = http.responseText;
			if (response) {
				document.getElementById("request_loading").innerHTML = response;
			}			
		}
  	}
	catch(e){}
	finally{}
}
function reloadPlaylist(add_id,remove_id) {
	try{
		http.open('POST',  base_url+'index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		http.onreadystatechange = function () {
										try {
											if((http.readyState == 4)&&(http.status == 200)){
												alert('Đã thực hiện');
												if(remove_id!='')
												window.location.reload( true );
											}
										}
										catch(e){}
										finally{}
									}
		http.send('reloadPlaylist=1&add_id='+add_id+'&remove_id='+remove_id);
	}
	catch(e){}
	finally{}
}
function addToPlaylist(film_id) {
	if(!isLoggedIn)
		alert('Bạn cần đăng nhập để sử dụng chức năng này');
	else
		reloadPlaylist(film_id,0);
}
function removeFromPlaylist(film_id) {
	reloadPlaylist(0,film_id);
}