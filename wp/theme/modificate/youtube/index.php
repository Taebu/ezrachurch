<?php
header('Access-Control-Allow-Origin: *');
include_once('./_common.php');
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('../head.php');
?>
<script src="js/jquery.js"></script>
<!-- This is what you need -->
<script src="js/sweetalert.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/sweetalert.css">
<style type="text/css">
/* Source: http://bootsnipp.com/snippets/featured/video-list-thumbnails */
.video-list-thumbs{}
.video-list-thumbs > li{margin-bottom:112px}
.video-container {position: relative;padding-bottom: 56.25%;height: 0; overflow: hidden;}
.video-container {margin-bottom:10%;}
.video-container iframe,.video-container object,.video-container embed {position: absolute;top: 0;left: 0;width: 100%;height: 100%;}
</style>
<script type="text/javascript" src="<?php echo $pr_list;?>.js"></script>
<script type="text/javascript">
var is_list="<?php echo $pr_list;?>"=="lecture_01"||"<?php echo $pr_list;?>"=="lecture_02";

if(is_list)
{
pastor=eval(ez_youtube_wm);
}
 $(function(){
	// alert('test');
	//get_youtube();

	get_youtube_db();
});

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
var nextPageToken="";
var prevPageToken="";
var mp3_loc="<?php echo $pr_list;?>";
function get_youtube(type)
{
	var param=$("#youtube_form").serialize();
	if(type=="search"){
		param+="&type=search";
		param+="&q="+$("#q").val();
	}
	
	$.ajax({
		url:"./list/get_youtube.php",
		data:param,
		dataType:"json",
		type:"GET",
		success:function(data){
			console.log(data);
			object=[];
			nextPageToken=data.nextPageToken;
			$("#nextPageToken").val(data.nextPageToken);
			var is_end=false;
			var video_id="";
			var is_private=is_deleted=false;

			$.each(data.items,function(key,val){
				

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
					console.log(val.snippet.title+" : "+video_id);
					del_youtube_ajax(video_id);
					return;
				}else if(is_deleted){
					console.log("is Deleted");
					console.log(val.snippet.title+" : "+video_id);
					del_youtube_ajax(video_id);
					return;
				}else{
				set_youtubelink(val.snippet.title,video_id);
				}

				object.push("<div class='col-lg-12 col-sm-12 col-xs-12 youtube-video'>");
				object.push("<div class=\"video-container\">");
				object.push("<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ");

				object.push(" src=\"https://www.youtube.com/embed/");
				console.log(val.snippet.resourceId.videoId);
				console.log(val.snippet.title);


				if(type=="search"){
					object.push(val.id.videoId);
					console.log(val.id.videoId);
				
				}else{
					video_id=val.snippet.resourceId.videoId;
					object.push(val.snippet.resourceId.videoId);
					
				}
				object.push("?autoplay=0&controls=1&loop=1&rel=1");
				object.push("&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe></div><!-- .video-container -->");
				if(is_list){
				var k=pastor.indexOf(val.snippet.title);
				}
				
				if(k>-1&&is_list)
				{
					console.log(pastor.indexOf(val.snippet.title));
					object.push("<audio src='./"+mp3_loc+"/"+pastor[k].replace(/\?/gi, "%3F")+".mp3' controls loop style='width:100%'></audio>");
				}else{
					console.log("k index : "+k+","+val.snippet.title);
				}
				object.push("</div>");
				
				/*전체 갯수와 포지션을 더해서 */
				is_end=data.pageInfo.totalResults==val.snippet.position+1;
			});

			$("#youtube_area").append(object.join(""));
			if(is_end)
			{
				swal({
				  title: "none",
				  text: "더이상 존재하지 않습니다.",
				  type: "info",
				  timer:3000
				});			
				$("#btn_more").attr("disabled",true);
			}
		}
	});
}

function get_youtube_db()
{
	var object=[];
	for(var i in ez_youtube_wm)	{		
		object.push("<div class='col-lg-12 col-sm-12 col-xs-12 youtube-video'>");
//		object.push(ez_youtube_wm[i].ey_title);
		object.push("<div class=\"video-container\">");
		object.push("<iframe frameborder=\"0\"   width=\"853\" height=\"480\"  ");
		object.push(" title=\"test\" ");
		object.push(" src=\"https://www.youtube.com/embed/");
		object.push(ez_youtube_wm[i].ey_videoid);
		object.push("?autoplay=0&controls=1&loop=1&rel=1");
		object.push("&showinfo=1&autohide=1&start=5\" allowfullscreen></iframe></div><!-- .video-container -->");
		object.push("</div>");	
	} // for(var i in ez_youtube_wm){...}
	$("#youtube_area").html(object.join(""));
}



function set_youtubelink(title,videoId) {
	// body...
	console.log(title+" : "+videoId);
var param="ey_title="+title;
param+="&ey_videoid="+videoId;
param+="&ey_group="+$("#pr_list").val();
	$.ajax({
		url:"./set_youtube.php",
		data:param,
		dataType:"json",
		type:"GET",
		success:function(data){
			console.log();
		}
	});
}
 </script>

 <form action="" id="youtube_form">
 <input type="hidden" name="nextPageToken" id="nextPageToken" />
 <input type="hidden" name="prevPageToken" id="prevPageToken" />
 <input type="hidden" name="pr_list" id="pr_list" value="<?php echo $_GET['pr_list'];?>"/>
 </form>
  <script src="https://apis.google.com/js/platform.js"></script>

<script>
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
</script>
<main class="page-content">
<section class="well text-center text-md-left">
<div class="container"><div class="g-ytsubscribe" data-channelid="UC2r1rV2lL6zQVSnmkM8dwrg" data-layout="default" data-count="default" data-onytevent="onYtEvent" style="text-align:center;"></div>
<div class="row"><div class="col-lg-12 text-center">
<!-- <input type="button" class="offset-5 btn btn-primary btn-xs round-small btn_submit" value="목록갱신" id="btn_more" onclick="location.href:'/wp/theme/modificate/youtube/refresh.php';"/> -->
<ul id="youtube_area"  class="list-unstyled video-list-thumbs row"></ul>
<!-- <input type="button" class="offset-5 btn btn-primary btn-xs round-small btn_submit" value="더 불러오기" id="btn_more" onclick="javascript:get_youtube()" /> -->
</div><!-- .col-lg-12 text-center -->
</div><!-- .row -->
<div class="g-ytsubscribe" data-channelid="UC2r1rV2lL6zQVSnmkM8dwrg" data-layout="full" data-count="hidden" data-onytevent="onYtEvent" style="text-align:center;"></div>
</div></section>
</main>
<?php
include_once(G5_PATH.'/tail.php');
?>