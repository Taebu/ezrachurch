<?php
/************************************************
* 목적 : 서울 에스라교회 주 메인 설교 youtube리스트 불러오기
* file : /wp/theme/modificate/youtube/scroll.php
* 작성일 : 2017-??-??
* 수정일 : 2018-06-18 (월) 17:24:17 
*
* @author Moon Taebu
* @Copyright (c) 2018, 태부
************************************************/
header('Access-Control-Allow-Origin: *');

include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


include_once('../head.php');


//print_r($_SERVER);
//print_r($member);
$is_admin=$member['mb_id']=="admin";
?>


 <script src="js/jquery.js"></script>

 <!-- This is what you need -->
 <script src="js/sweetalert.js"></script>
 <script src="js/edu_01.js"></script>
 <link rel="stylesheet" href="css/sweetalert.css">
 <style type="text/css">
textarea {
  margin:0px 0px;
  padding:5px;
  min-height:16px;
  line-height:16px;
  width:96%;
  display:block;
  margin:0px auto;    
}
/* Source: http://bootsnipp.com/snippets/featured/video-list-thumbnails */

.video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:112px
}
.video-container {
position: relative;
padding-bottom: 56.25%;
height: 0; overflow: hidden;
}


.video-container {
margin-bottom:10%;
}

.video-container iframe,
.video-container object,
.video-container embed {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}
.mw40{
min-width: 40px;
}
#myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}
</style>
<script type="text/javascript" src="<?php echo $pr_list;?>.js"></script>
<script type="text/javascript">

	console.log("admin@ezrachurch.kr:/wp/theme/modificate/youtube/scroll.php");

var is_list="<?php echo $pr_list;?>"=="lecture_01"||"<?php echo $pr_list;?>"=="lecture_02"||"<?php echo $pr_list;?>"=="edu_03";
var list_size=5;
var list_cnt=0;
var list_page=1;

var bible_title=["창세기","출애굽기","레위기","민수기","신명기","여호수아","사사기","룻기","사무엘상","사무엘하","열왕기상","열왕기하","역대상","역대하","에스라","느헤미야","에스더","욥기","시편","잠언","전도서","아가서","이사야","예레미야","예레미야애가","에스겔","다니엘","호세아","요엘","아모스","오바댜","요나","미가","나훔","하박국","스바냐","학개","스가랴","말라기","마태복음","마가복음","누가복음","요한복음","사도행전","로마서","고린도전서","고린도후서","갈라디아서","에베소서","빌립보서","골로새서","데살로니가전서","데살로니가후서","디모데전서","디모데후서","디도서","빌레몬서","히브리서","야고보서","베드로전서","베드로후서","요한일서","요한이서","요한삼서","유다서","요한계시록"];

var psalter_title=["0","1","2","3","4","5","6","7","8","9","10","11","12","13","14"];
var psalter_list=["1-9","10-19","20-29","30-39","40-49","50-59","60-69","70-79","80-89","90-99","100-109","110-119","120-129","130-139","140-149"];

// 제1권 1-41편, 제2권 42-72편, 제3권 73-89편, 제4권 90-106편, 제5권 107-150편

if(is_list)
{
//pastor=eval(<?php echo $pr_list;?>);
}

var nextPageToken="";
var prevPageToken="";
var mp3_loc="<?php echo $pr_list;?>";
var old_keyword="";
var is_enable=false;

 $(function(){
  // alert('test');
  //get_youtube();
	//
    if(mp3_loc=="lecture_01"){
      //get_youtube(" ");
      get_youtube_page(" ");
    
    }
    if(mp3_loc=="edu_01"){
//       get_youtube("제11장");  
       get_youtube("22장");  
    }

	if(mp3_loc=="edu_03"){

       get_youtube(0);  
	}
    
    $('.list-group a').click(function(e) {
        //e.preventDefault();
				is_enable=!$(this).hasClass('disabled');
				if(is_enable)
				{
					$(this).parent().find('a').removeClass('active');
					$(this).addClass('active');
					location.href="#youtube_area";
				}
    });

    console.log('ready');
	
	layout_resize();
	
	/*db 유투브 링크 사이즈 크기 가져오기 */
	get_size();

	/* modal hidden*/
	set_hidden_modal();

	/* 카운트 표기 2019-10-29 14:44:29 (화요일) git issue #43 */
	get_youtube(' ');

});
//list/get_youtube.php?pr_list=lecture_01
/* 레이아웃을 각 카테고리 별로 리사이즈 한다.
2017-08-21 (월) 1:01:09 
*/
function layout_resize()
{
if($("#pr_list").val()=="edu_01")
{
//$("#left_layout").removeClass("col-xs-4 col-md-2 col-lg-3");
//$("#left_layout").addClass("col-xs-4 col-md-2 col-lg-3");

//$("#right_layout").removeClass("col-xs-8 col-md-10 col-lg-9");
//$("#right_layout").addClass("col-xs-8 col-md-10 col-lg-9");
}
if($("#pr_list").val()=="lecture_01")
{
$("#left_layout").removeClass("col-xs-4 col-md-2 col-lg-3");
$("#left_layout").addClass("col-xs-6 col-md-2 col-lg-2");

$("#right_layout").removeClass("col-xs-8 col-md-10 col-lg-9");
$("#right_layout").addClass("col-xs-6 col-md-10 col-lg-10");
}
}

var bible_array=[];
/* json javascript object를 불러 온다. */

	var is_psalter=false;
function get_youtube(q)
{
  $("#btn_more").hide();

	var param=$("#youtube_form").serialize();
	var is_damin=$("#mb_id").val()=="admin";
	var k=0;

	var bible=[];
	var not_ready="제24장";
	not_ready+="제25장제26장제27장제28장제29장제30장";
	not_ready+="제23장제31장제32장제33장";

	if(not_ready.indexOf(q)>-1&&$("#pr_list").val()=="lecture_02")
	{
		swal("정보!", q+"은 준비 중 입니다!!!", "info");
		location.href="#youtube_area";
		return;
	}
	if(Number.isInteger(q))
	{
		is_psalter=true;
	}
	object=[];
	var is_same_keyword=false;
	is_same_keyword=old_keyword==q;

			for(var i in ez_youtube_wm)
			{		/* 시편 찬송가가 아닌 경우 */
		if(!is_psalter&&ez_youtube_wm[i].ey_title.indexOf(q)>-1)
		{

			for(var j in bible_title)
			{
				if(ez_youtube_wm[i].ey_title.indexOf(bible_title[j])>-1)
				{
					bible.title=bible_title[j];
					bible.cnt=j;
				}
			}
      k++;
      console.log("mod % 5 "+k%5);
      if(k%6==0&&q==" ")
      {
        break;
      }
			//echo '';
			object.push("<div class='col-lg-12 col-sm-12 col-xs-12 youtube-video'>");

			object.push(ez_youtube_wm[i].ey_title);
			/* 2017-10-12 (목) 14:48:58  서버 접속 이상으로 다운로드 막음
			if(ez_youtube_wm[i].ey_audio)
			{
			object.push('<p><a href="#" data-id="'+ez_youtube_wm[i].ey_videoid+'" ');
			object.push('data-toggle="modal" ');
			object.push('data-title="'+ez_youtube_wm[i].ey_title+'" ');
			object.push('data-file="'+ez_youtube_wm[i].ey_audio+'" ');
			object.push('data-target="#myModal" ');
			object.push('class="btn btn-primary btn-xs round-small btn-icon-left btn-shadow open-AddBookDialog">');

			object.push('<span class="icon fa-music"></span> 오디오</a></p>');
			//object.push('<div class="video-container">');

			$("#audiobook_title").html(ez_youtube_wm[i].ey_title);
			$("#audiobook_area").html("<audio src='/wp/youtube/lecture_01/"+ez_youtube_wm[i].ey_audio+"' controls loop style='width:100%'></audio>");
			}
      */
			object.push("<div class=\"video-container\">");
			object.push("<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ");

			object.push(" title=\"test\" ");
			object.push(" src=\"https://www.youtube.com/embed/");
			
			object.push(ez_youtube_wm[i].ey_videoid);

			object.push("?autoplay=0&controls=1&loop=1&rel=1");
			object.push("&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe></div><!-- .video-container -->");

			//set_youtubelink(ez_youtube_wm[i].ey_title,ez_youtube_wm[i].ey_videoid);

			object.push("</div>");	
		
			} // for(var i in ez_youtube_wm){...}
		}
		/* 시편 찬송가인 경우*/
//		if(is_psalter&&ez_youtube_wm[i].ey_title.indexOf(q)>-1&&ez_youtube_wm[i].ey_title.indexOf("칼빈")>-1)
		var ten_count = 0;
		var is_match_keyword = false;
		var ii = 0;
		if(is_psalter)
		{
				for(var i in ez_youtube_wm)
				{
					var str = ez_youtube_wm[i].ey_title;
					if(q==0)
					{
						q="";
					}
					var re = eval("/ "+q+"\\d편/i");
					var found = str.match(re);

					search_key=Number(i)+Number(q);
					console.log(i+" : "+search_key);

					if(found)
					{
				console.log("i : "+i+", q :"+q+" search_key : "+search_key+" : "+str);


					for(var j in bible_title)
					{
						if(ez_youtube_wm[i].ey_title.indexOf(bible_title[j])>-1)
						{
							bible.title=bible_title[j];
							bible.cnt=j;
						}
					}
					  k++;
					  console.log("mod % 5 "+k%5);
					if(k%6==0&&q==" ")
					{
						break;
					}
					object.push("<div class='col-lg-12 col-sm-12 col-xs-12 youtube-video'>");
					object.push(ez_youtube_wm[i].ey_title);
					object.push("<div class=\"video-container\">");
					object.push("<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ");

					object.push(" title=\"test\" ");
					object.push(" src=\"https://www.youtube.com/embed/");
					
					object.push(ez_youtube_wm[i].ey_videoid);

					object.push("?autoplay=0&controls=1&loop=1&rel=1");
					object.push("&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe></div><!-- .video-container -->");
					object.push("</div>");

				}
			}
		}

		//bible_array.push(bible);


	var bible_array=[];
	var total_cnt=0;

    if(mp3_loc=="lecture_01"){
	for(var i in bible_title)
	{
	  var cnt=0;
	  var bible_word=[]; 
	  for(var j in ez_youtube_wm)
	  {
		if(ez_youtube_wm[j].ey_title.indexOf(bible_title[i])>-1)cnt++;
		total_cnt++;
	  }
	  bible_word.title=bible_title[i];
	  bible_word.cnt=cnt;
	  bible_array.push(bible_word);
	  $("#book_"+i).html(bible_title[i]+'<span class="badge">'+cnt+'</span>');
	}

	$("#book_all").html('주일 설교<span class="badge mw40">'+total_cnt/66+'</span>');
	}

    if(mp3_loc=="edu_03"){


	for(var i in psalter_title)
	{
			var str = psalter_title[i];
			if(str==0)
			{
				str="";
			}
			var re = eval("/ "+str+"\\d편/i");
			console.log(re+" / "+str);
	  var cnt=0;
	  var bible_word=[]; 
	  for(var j in ez_youtube_wm)
	  {

		var found = ez_youtube_wm[j].ey_title.match(re);
		if(found){
			console.log(found);
			cnt++;

		total_cnt++;
		}
	  }
	  bible_word.title=psalter_title[i];
	  bible_word.cnt=cnt;
	  bible_array.push(bible_word);
	  $("#psalter_"+i).html(psalter_list[i]+'<span class="badge">'+cnt+'</span>');
	}

	$("#psalter_all").html('시편 찬송가<span class="badge mw40">'+total_cnt+'</span>');
	
	}

    
	if(is_psalter){
	if(k==0){object.push("이 장은 시편 찬송가가 준비 되지 않았습니다.");};
	}else{
	if(k==0){object.push(q+" 대하설교가 준비 되지 않았습니다.");};
	}
	$("#youtube_area").html(object.join(""));
	old_keyword=q;
	
}


/* json javascript object 페이징으로 불러 온다. 
2017-10-13 (금) 11:34:24 
*/
function get_youtube_page(q)
{
  $(".list_comment").remove();
  if(list_page==1)
  {
    $("#youtube_area").html("");
  }
  $("#btn_more").show();
  var param=$("#youtube_form").serialize();
  var is_admin=$("#mb_id").val()=="admin";
	var k=0;
	var bible=[];
  var max_cnt=list_page*list_size;
  var search_key=0;
  var not_ready="제22장제24장";
     not_ready+="제25장제26장제27장제28장제29장";
     not_ready+="제30장제23장제31장제32장제33장";

	if(not_ready.indexOf(q)>-1)
  {
//    alert(q+"은 준비 중 입니다.");
		swal("정보!", q+"은 준비 중 입니다!!!", "info");
    location.href="#youtube_area";
    return;
  }

	object=[];
	var is_same_keyword=false;
	is_same_keyword=old_keyword==q;

	for(list_cnt;list_cnt<max_cnt;list_cnt++){
		
		if(ez_youtube_wm[list_cnt].ey_title.indexOf(q)>-1)
		{
			console.log();
			for(var j in bible_title)
			{

				if(ez_youtube_wm[list_cnt].ey_title.indexOf(bible_title[j])>-1)
				{
					bible.title=bible_title[j];
					bible.cnt=j;
				}
			}
      k++;
      console.log("mod % 5 "+k%5);
      if(k%6==0&&q==" ")
      {
        break;
      }
			//echo '';
			object.push("<div class='col-lg-12 col-sm-12 col-xs-12 youtube-video'>");


			object.push(ez_youtube_wm[list_cnt].ey_title);
			if(is_admin)
			{
				object.push("<input type='button' class='offset-5 btn btn-primary btn-xs round-small btn_submit' value='삭제'  onclick='javascript:del_youtube(\""+ez_youtube_wm[list_cnt].ey_videoid+"\")'>");
			}
			object.push("<div class=\"video-container\">");
			object.push("<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ");

      object.push(" title=\"test\" ");
			object.push(" src=\"https://www.youtube.com/embed/");
			
			object.push(ez_youtube_wm[list_cnt].ey_videoid);

			object.push("?autoplay=0&controls=1&loop=1&rel=1");
			object.push("&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe></div><!-- .video-container -->");
			console.log("ez_youtube_wm[list_cnt]"+ez_youtube_wm[list_cnt].ey_title);
			console.log("ez_youtube_wm[list_cnt]"+ez_youtube_wm[list_cnt].ey_videoid);
			//set_youtubelink(ez_youtube_wm[list_cnt].ey_title,ez_youtube_wm[list_cnt].ey_videoid);

			object.push("</div>");	
		}
		//bible_array.push(bible);
	}
var bible_array=[];
var total_cnt=0;

for(var i in bible_title)
{
  var cnt=0;
  var bible_word=[]; 
  for(var j in ez_youtube_wm)
  {
    if(ez_youtube_wm[j].ey_title.indexOf(bible_title[list_cnt])>-1)cnt++;
    total_cnt++;
  }
  bible_word.title=bible_title[list_cnt];
  bible_word.cnt=cnt;
  bible_array.push(bible_word);
  //$("#book_"+i).html(bible_title[list_cnt]+'<span class="badge">'+cnt+'</span>');
  
}
total_cnt=total_cnt/66;

$("#book_all").html("주일 설교<span class=\"badge mw40\">"+total_cnt+"</span>");


	if(k==0){object.push(q+" 대하설교가 준비 되지 않았습니다.");};
	$("#youtube_area").append(object.join(""));
	old_keyword=q;
	list_page++;
}

/* set_youtubelink(title,videoId)  
 디비에 기록
*/
function set_youtubelink(title,videoId) {
	// body...
	console.log(title+" : "+videoId);
var param="ey_title="+title;
param+="&ey_videoid="+videoId;
param+="&ey_group="+$("#pr_list").val();
//param=encodeURIComponent(param);
console.log(param);
	$.ajax({
		url:"./set_youtube.php",
		data:param,
		dataType:"json",
		type:"POST",
		success:function(data){
			console.log(data);
		}
	});
}

/*********************************************
*
* get_youtube_json
*
*********************************************/
function get_youtube_json()
{
	var param=$("#youtube_form").serialize();

	$.ajax({
		url:"./list/get_youtube.php",
		data:param,
		dataType:"json",
		type:"GET",
		success:function(data){
			console.log("list/get_youtube.php");
			console.log(data);
			console.log("totalResults : "+data.pageInfo.totalResults);
			
			$("#yt_size").val(data.pageInfo.totalResults);
			console.log(data.pageInfo.totalResults);
			if(data.pageInfo.totalResults>=$("#db_size").val()){
				/*유투브에 새로운 정보가 있을 때 */
				console.log("새로운 영상이 올라 왔습니다. 새로고침 해주세요.");
				nextPageToken=data.nextPageToken;
				/* 갱신 */
				set_make();
				$("#nextPageToken").val(data.nextPageToken);
				var is_end=false;
				var video_id="";
				var is_private=is_deleted=false;
				$.each(data.items,function(key,val){
					console.log(val.snippet);
					video_id=val.snippet.resourceId.videoId;

					/* Private 비디오면 추가 시키지 않는다.
						set_youtubelink(val.snippet.title,video_id);		 */
					is_private=val.snippet.title.indexOf("Private")>-1;

					/*2018-07-16 (월) 10:48:26 
						"Deleted video"
						면 추가 시키지 않는다. 남궁현우, 홍슬기 요청*/
					is_deleted=val.snippet.title.indexOf("Deleted")>-1;

					if(is_private){
            console.log("is Private");
            console.log(val.snippet.title);
			del_youtube_ajax(video_id);
					}else if(is_deleted){
            console.log("is Deleted");
            console.log(val.snippet.title);
			del_youtube_ajax(video_id);
					}else{
						/* 개인적인(private) 과 삭제된(deleted)  파일 외의 유투브는 리스트에 추가 한다. */
						set_youtubelink(val.snippet.title,video_id);	
					}
						
				});

			}
		}
	});
}

/* size */
function get_size()
{
	var param=$("#youtube_form").serialize();
	$.ajax({
		url:"./list/get_size.php",
		data:param,
		dataType:"json",
		type:"GET",
		success:function(data){
			console.log(data.cnt);
			$("#db_size").val(data.cnt);
	
			/* yt api 불러오기 */
			get_youtube_json();
		}
	});

}
/* myFunction() */
function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("youtube_list");
    li = ul.getElementsByTagName('a');
    console.log(li);
    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      console.log(li[i].innerHTML);

        a = li[i].getElementsByTagName("a")[0];
        if (li[i].innerHTML.indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
    //if(i==0){document.getElementById("youtube_list").innerHTML="<div>"+filter+"검색 결과가 없습니다.";};
}

/*js를 갱신 합니다.*/
function set_make()
{
	$.ajax({
		url:"./make_js.php?loc_id="+$("#pr_list").val(),
		data:"",
		dataType:"json",
		type:"GET",
		beforeSend:function(){
			$("#btn_refresh").val("불러오는 중...");
		},
		success:function(data){
			if(data.success){
				$("#btn_refresh").val(data.message);
			}else{
				$("#btn_refresh").val(data.message);
			}
		}
	});
}

$(document).on("click", ".open-AddBookDialog", function () {
     var myBookId = $(this).data('id');
     var audio_file= $(this).data('file');
	 console.log(myBookId);
	 get_memo(myBookId);
	$("#audiobook_title").html($(this).data('title'));
	var object=[];
	object.push("<audio src='/wp/youtube/lecture_01/"+audio_file+"' controls loop style='width:100%'></audio>");
	object.push('<div class="form-group col-sm-12">');
	object.push('<label for="exampleTextarea" class="text-uppercase font-secondary">메모하기</label>');
	object.push('                  <textarea id="yt_memo" rows="3" placeholder="Write your message here" class="form-control"></textarea>');
	object.push('                  </div>');
	object.push('<div class="col-sm-12">');
	object.push('                    <button type="submit" class="btn btn-primary btn-xs round-xl btn-block form-el-offset-1" onclick="javascript:set_memo(\''+myBookId+'\');">저장하기</button>');
	object.push('                  </div>');
	$("#audiobook_area").html(object.join(""));
     //$(".modal-body #bookId").val( myBookId );
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});



function set_hidden_modal()
{
$('#myModal').on('hidden.bs.modal', function () {
    // do something…
   $("#audiobook_title").html("");
   $("#audiobook_area").html("");
});
}

function set_memo(v)
{
	if($("#mb_id").val()==""){
			swal({
			  title: "로그인",
			  text: "로그인이 필요한 서비스 입니다.",
			  type: "info",
			  timer:3000
			});			
		return;
	}

	$.ajax({
		url:"./set_memo.php",
		data:"ey_videoid="+v+"&mb_id="+$("#mb_id").val()+"&lm_content="+$("#yt_memo").val(),
		dataType:"json",
		type:"POST",
		success:function(data){
			if(data.success){
			swal({
			  title: "저장",
			  text: "저장완료!!!",
			  type: "info",
			  timer:1000
			});	
			  }else{
			swal({
			  title: "저장",
			  text: "오류!!!",
			  type: "warning",
			  timer:1000
			});				  
			  }
		}
	});
}

function get_memo(v)
{
	var mb_id=$("#mb_id").val();
	$.ajax({
		url:"./get_memo.php",
		data:"ey_videoid="+v+"&mb_id="+mb_id,
		dataType:"json",
		type:"GET",
		success:function(data){
			console.log();
			$("#yt_memo").val(data.lm_content);
		}
	});
}
 </script>

 <form action="" id="youtube_form">
 <input type="hidden" name="nextPageToken" id="nextPageToken" />
 <input type="hidden" name="prevPageToken" id="prevPageToken" />
 <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $member['mb_id'];?>"/>
 <input type="hidden" name="db_size" id="db_size" />
 <input type="hidden" name="yt_size" id="yt_size" />

 <input type="hidden" name="pr_list" id="pr_list" value="<?php echo $_GET['pr_list'];?>"/>
 </form>
  <script src="https://apis.google.com/js/platform.js"></script>
<?php printf('<script src="/wp/theme/modificate/youtube/%s.js?t=%s"></script>',$_GET['pr_list'],time());?>
<script>
console.log(ez_youtube_wm);
  function onYtEvent(payload) {
    if (payload.eventType == 'subscribe') {
      // Add code to handle subscribe event.
    } else if (payload.eventType == 'unsubscribe') {
      // Add code to handle unsubscribe event.
    }
    if (window.console) { // for debugging only
      window.console.log('YT event: ', payload);
    }
  }

	function del_youtube(link)
	{
		if(!confirm("정말삭제?"))
		{
			return;
		}

		$.ajax({
			url:"./del_youtube.php",
			data:{"link":link},
			dataType:"json",
			type:"POST",
			success:function(data){
				if(data.success){
//				alert("삭제 성공");
					swal("Good job!", "삭제 성공", "success");
				}
				set_make();
			}
		});
	}

	function del_youtube_ajax(link)
	{

		$.ajax({
			url:"./del_youtube.php",
			data:{"link":link},
			dataType:"json",
			type:"POST",
			success:function(data){
				set_make();
			}
		});
	}
</script>


<main class="page-content">

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="g-ytsubscribe" data-channelid="UC2r1rV2lL6zQVSnmkM8dwrg" data-layout="default" data-count="default" data-onytevent="onYtEvent" style="text-align:center;"></div>
<div class="col-xs-4 col-md-2 col-lg-3" id="left_layout">
<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="검색해 주세요.">
      <div class="list-group" id="youtube_list">
      <?php 
      if($_GET['pr_list']=="edu_01"){
        ?>
  <!-- <a href="javascript:get_youtube('');" class="list-group-item">모두보기</a> -->
  <a href="javascript:get_youtube('제1장');" class="list-group-item">제1장 : 성경</a>
  <a href="javascript:get_youtube('제2장');" class="list-group-item">제2장 : 하나님과 삼위일체</a>
  <a href="javascript:get_youtube('제3장');" class="list-group-item">제3장 : 하나님의 영원한 작정</a>
  <a href="javascript:get_youtube('제4장');" class="list-group-item">제4장 : 창조</a>
  <a href="javascript:get_youtube('제5장');" class="list-group-item">제5장 : 섭리</a>
  <a href="javascript:get_youtube('제6장');" class="list-group-item">제6장 : 인간의 타락과 죄와 형벌</a>
  <a href="javascript:get_youtube('제7장');" class="list-group-item">제7장 : 하나님의 언약</a>
  <a href="javascript:get_youtube('제8장');" class="list-group-item">제8장 : 중보자 그리스도</a>
  <a href="javascript:get_youtube('제9장');" class="list-group-item">제9장 : 자유 의지</a>
  <a href="javascript:get_youtube('제10장');" class="list-group-item">제10장 : 유효한 부르심</a>
  <a href="javascript:get_youtube('제14장');" class="list-group-item">제14장 : 구원에 이르는 신앙</a>
  <a href="javascript:get_youtube('제15장');" class="list-group-item">제15장 : 생명에 이르는 회개</a>
  <a href="javascript:get_youtube('제11장');" class="list-group-item">제11장 : 칭의</a>
  <a href="javascript:get_youtube('제12장');" class="list-group-item">제12장 : 양자됨</a>
  <a href="javascript:get_youtube('제13장');" class="list-group-item">제13장 : 성화</a>
  <a href="javascript:get_youtube('제16장');" class="list-group-item">제16장 : 선행</a>
  <a href="javascript:get_youtube('제17장');" class="list-group-item">제17장 : 성도의 견인</a>
  <a href="javascript:get_youtube('제18장');" class="list-group-item">제18장 : 은혜와 구원의 확신</a>
  <a href="javascript:get_youtube('제19장');" class="list-group-item">제19장 : 하나님의 율법</a>
  <a href="javascript:get_youtube('제20장');" class="list-group-item">제20장 : 그리스도 인의 자유와 양심의 자유</a>
  <a href="javascript:get_youtube('제21장');" class="list-group-item">제21장 : 예배와 안식일 </a>
  <a href="javascript:get_youtube('제22장');" class="list-group-item active">제22장 : 합당한 맹세와 서원</a>
  <a href="javascript:get_youtube('제24장');" class="list-group-item disabled">제24장 : 결혼과 이혼</a>
  <a href="javascript:get_youtube('제25장');" class="list-group-item disabled">제25장 : 교회</a>
  <a href="javascript:get_youtube('제26장');" class="list-group-item disabled">제26장 : 성도의 교통</a>
  <a href="javascript:get_youtube('제27장');" class="list-group-item disabled">제27장 : 성례</a>
  <a href="javascript:get_youtube('제28장');" class="list-group-item disabled">제28장 : 세례</a>
  <a href="javascript:get_youtube('제29장');" class="list-group-item disabled">제29장 : 성찬</a>
  <a href="javascript:get_youtube('제30장');" class="list-group-item disabled">제30장 : 교회의 권징</a>
  <a href="javascript:get_youtube('제23장');" class="list-group-item disabled">제23장 : 국가 위정자</a>
  <a href="javascript:get_youtube('제31장');" class="list-group-item disabled">제31장 : 대회와 협의회</a>
  <a href="javascript:get_youtube('제32장');" class="list-group-item disabled">제32장 : 사후상태와 죽은자의 부활</a>
  <a href="javascript:get_youtube('제33장');" class="list-group-item disabled">제33장 : 최후심판</a>
  <?php } /*edu_01 웨민 */?>

      <?php 
      if($_GET['pr_list']=="edu_03"){
        ?>
  <!-- <a href="javascript:get_youtube('');" class="list-group-item">모두보기</a> -->
  
  <a id="psalter_all" class="list-group-item" >시편 찬송가</a>
  <a id="psalter_0" href="javascript:get_youtube(0);" class="list-group-item active">1-9</a>
  <a id="psalter_1" href="javascript:get_youtube(1);" class="list-group-item">10-19</a>
  <a id="psalter_2" href="javascript:get_youtube(2);" class="list-group-item">20-29</a>
  <a id="psalter_3" href="javascript:get_youtube(3);" class="list-group-item">30-39</a>
  <a id="psalter_4" href="javascript:get_youtube(4);" class="list-group-item">40-49</a>
  <a id="psalter_5" href="javascript:get_youtube(5);" class="list-group-item">50-59</a>
  <a id="psalter_6" href="javascript:get_youtube(6);" class="list-group-item">60-69</a>
  <a id="psalter_7" href="javascript:get_youtube(7);" class="list-group-item">70-79</a>
  <a id="psalter_8" href="javascript:get_youtube(8);" class="list-group-item">80-89</a>
  <a id="psalter_9" href="javascript:get_youtube(9);" class="list-group-item">90-99</a>
  <a id="psalter_10" href="javascript:get_youtube(10);" class="list-group-item">100-109</a>
  <a id="psalter_11" href="javascript:get_youtube(11);" class="list-group-item">110-119</a>
  <a id="psalter_12" href="javascript:get_youtube(12);" class="list-group-item">120-129</a>
  <a id="psalter_13" href="javascript:get_youtube(13);" class="list-group-item">130-139</a>
  <a id="psalter_14" href="javascript:get_youtube(14);" class="list-group-item">140-150</a>
  <?php } /*edu_03 시편찬송가 */?>
<?php 
if($_GET['pr_list']=="lecture_01"){
?>
<a id="book_all" href="javascript:list_cnt=0;list_page=1;get_youtube_page(' ');" class="list-group-item active" >주일 설교</a>
<a id="book_0" href="javascript:get_youtube('창세기');" class="list-group-item" >창세기</a>
<a id="book_1" href="javascript:get_youtube('출애굽기');" class="list-group-item">출애굽기</a>
<a id="book_2" href="javascript:get_youtube('레위기');" class="list-group-item">레위기</a>
<a id="book_3" href="javascript:get_youtube('민수기');" class="list-group-item">민수기</a>
<a id="book_4" href="javascript:get_youtube('신명기');" class="list-group-item">신명기</a>
<a id="book_5" href="javascript:get_youtube('여호수아');" class="list-group-item">여호수아</a>
<a id="book_6" href="javascript:get_youtube('사사기');" class="list-group-item">사사기</a>
<a id="book_7" href="javascript:get_youtube('룻기');" class="list-group-item">룻기</a>
<a id="book_8" href="javascript:get_youtube('사무엘상');" class="list-group-item">사무엘상</a>
<a id="book_9" href="javascript:get_youtube('사무엘하');" class="list-group-item">사무엘하</a>
<a id="book_10" href="javascript:get_youtube('열왕기상');" class="list-group-item">열왕기상</a>
<a id="book_11" href="javascript:get_youtube('열왕기하');" class="list-group-item">열왕기하</a>
<a id="book_12" href="javascript:get_youtube('역대상');" class="list-group-item">역대상</a>
<a id="book_13" href="javascript:get_youtube('역대하');" class="list-group-item">역대하</a>
<a id="book_14" href="javascript:get_youtube('에스라');" class="list-group-item">에스라</a>
<a id="book_15" href="javascript:get_youtube('느헤미야');" class="list-group-item">느헤미야</a>
<a id="book_16" href="javascript:get_youtube('에스더');" class="list-group-item">에스더</a>
<a id="book_17" href="javascript:get_youtube('욥기');" class="list-group-item">욥기</a>
<a id="book_18" href="javascript:get_youtube('시편');" class="list-group-item">시편</a>
<a id="book_19" href="javascript:get_youtube('잠언');" class="list-group-item">잠언</a>
<a id="book_20" href="javascript:get_youtube('전도서');" class="list-group-item">전도서</a>
<a id="book_21" href="javascript:get_youtube('아가');" class="list-group-item">아가</a>
<a id="book_22" href="javascript:get_youtube('이사야');" class="list-group-item">이사야</a>
<a id="book_23" href="javascript:get_youtube('예레미야');" class="list-group-item">예레미야</a>
<a id="book_24" href="javascript:get_youtube('예레미야애가');" class="list-group-item">예레미야애가</a>
<a id="book_25" href="javascript:get_youtube('에스겔');" class="list-group-item">에스겔</a>
<a id="book_26" href="javascript:get_youtube('다니엘');" class="list-group-item">다니엘</a>
<a id="book_27" href="javascript:get_youtube('호세아');" class="list-group-item">호세아</a>
<a id="book_28" href="javascript:get_youtube('요엘');" class="list-group-item">요엘</a>
<a id="book_29" href="javascript:get_youtube('아모스');" class="list-group-item">아모스</a>
<a id="book_30" href="javascript:get_youtube('오바댜');" class="list-group-item">오바댜</a>
<a id="book_31" href="javascript:get_youtube('요나');" class="list-group-item">요나</a>
<a id="book_32" href="javascript:get_youtube('미가');" class="list-group-item">미가</a>
<a id="book_33" href="javascript:get_youtube('나훔');" class="list-group-item">나훔</a>
<a id="book_34" href="javascript:get_youtube('하박국');" class="list-group-item">하박국</a>
<a id="book_35" href="javascript:get_youtube('스바냐');" class="list-group-item">스바냐</a>
<a id="book_36" href="javascript:get_youtube('학개');" class="list-group-item">학개</a>
<a id="book_37" href="javascript:get_youtube('스가랴');" class="list-group-item">스가랴</a>
<a id="book_38" href="javascript:get_youtube('말라기');" class="list-group-item">말라기</a>
<a id="book_39" href="javascript:get_youtube('마태복음');" class="list-group-item">마태복음</a>
<a id="book_40" href="javascript:get_youtube('마가복음');" class="list-group-item">마가복음</a>
<a id="book_41" href="javascript:get_youtube('누가복음');" class="list-group-item">누가복음</a>
<a id="book_42" href="javascript:get_youtube('요한복음');" class="list-group-item">요한복음</a>
<a id="book_43" href="javascript:get_youtube('사도행전');" class="list-group-item">사도행전</a>
<a id="book_44" href="javascript:get_youtube('로마서');" class="list-group-item">로마서</a>
<a id="book_45" href="javascript:get_youtube('고린도전서');" class="list-group-item">고린도전서</a>
<a id="book_46" href="javascript:get_youtube('고린도후서');" class="list-group-item">고린도후서</a>
<a id="book_47" href="javascript:get_youtube('갈라디아서');" class="list-group-item">갈라디아서</a>
<a id="book_48" href="javascript:get_youtube('에베소서');" class="list-group-item">에베소서</a>
<a id="book_49" href="javascript:get_youtube('빌립보서');" class="list-group-item">빌립보서</a>
<a id="book_50" href="javascript:get_youtube('골로새');" class="list-group-item">골로새</a>
<a id="book_51" href="javascript:get_youtube('데살로니가전서');" class="list-group-item">데살로니가전서</a>
<a id="book_52" href="javascript:get_youtube('데살로니가전서');" class="list-group-item">데살로니가후서</a>
<a id="book_53" href="javascript:get_youtube('디모데전서');" class="list-group-item">디모데전서</a>
<a id="book_54" href="javascript:get_youtube('디모데후서');" class="list-group-item">디모데후</a>
<a id="book_55" href="javascript:get_youtube('디도서');" class="list-group-item">디도서</a>
<a id="book_56" href="javascript:get_youtube('빌레몬');" class="list-group-item">빌레몬</a>
<a id="book_57" href="javascript:get_youtube('히브리');" class="list-group-item">히브리</a>
<a id="book_58" href="javascript:get_youtube('야고보');" class="list-group-item">야고보</a>
<a id="book_59" href="javascript:get_youtube('베드로전서');" class="list-group-item">베드로전서</a>
<a id="book_60" href="javascript:get_youtube('베드로후서');" class="list-group-item">베드로후서</a>
<a id="book_61" href="javascript:get_youtube('요한일서');" class="list-group-item">요한일서</a>
<a id="book_62" href="javascript:get_youtube('요한이서');" class="list-group-item">요한이서</a>
<a id="book_63" href="javascript:get_youtube('요한삼서');" class="list-group-item">요한삼서</a>
<a id="book_64" href="javascript:get_youtube('유다서');" class="list-group-item">유다서</a>
<a id="book_65" href="javascript:get_youtube('요한계시록');" class="list-group-item">요한계시록</a>
  <?php } /* 에스겔 주일 대하설교 */?>
</div>
</div><!-- #left_layout .col-lg-2 text-center -->

<div class="col-xs-8 col-md-10 col-lg-9" id="right_layout">
<!-- <input type="button" class="offset-5 btn btn-primary btn-xs round-small btn_submit" value="목록갱신" id="btn_more" onclick="location.href:'/wp/theme/modificate/youtube/refresh.php';"/> -->

<ul id="youtube_area"  class="list-unstyled video-list-thumbs row"><li class="list_comment">시청할 각 장을 클릭해 주세요.</li></ul>
<div class="col-md-12 text-center"> 
<input type="button" class="offset-5 btn btn-primary btn-xs round-small btn_submit" value="더보기" id="btn_more" onclick="javascript:get_youtube_page(' ');;"/><?php 
if($is_admin){
?>
<input type="button" class="offset-5 btn btn-danger btn-xs round-small btn_submit" value="갱신" id="btn_refresh" onclick="javascript:set_make();"/>
<br><br><br>
<input type="button" class="offset-5 btn btn-danger btn-xs round-small btn_submit" value="강좌등록" id="btn_write" onclick="javascript:location.href='write.php?pr_list=<?php echo $pr_list;?>';"/>

<?php 
}
?></div>
</div><!-- #right_layout -->
<div style="text-align:center;clear:both"></div>
<div class="g-ytsubscribe" data-channelid="UC2r1rV2lL6zQVSnmkM8dwrg" data-layout="default" data-count="default" data-onytevent="onYtEvent" style="text-align:center;clear:both"></div>
</div><!-- .col-md-8 col-md-offset-2 -->
</div><!-- .row -->



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title" id="audiobook_title">음성</h4>
      </div>
      <div class="modal-body" id="audiobook_area">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!--// Modal content-->

  </div><!-- // Modal -->
</div><!-- #myModal -->

</main>



<?php
include_once(G5_PATH.'/tail.php');
?>