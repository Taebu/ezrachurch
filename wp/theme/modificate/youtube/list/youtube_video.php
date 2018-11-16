<?php
/*
*@author Magyar András
*Copyright (c) 2015 Magyar András
*
*Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
*
The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.
*
*THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*
*/

header('Access-Control-Allow-Origin: *');
?>

<style>

/* Source: http://bootsnipp.com/snippets/featured/video-list-thumbnails */

.video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:12px
}
.video-list-thumbs > li:last-child{}
.video-list-thumbs > li > a{
	display:block;
	position:relative;
	background-color: #212121;
	color: #fff;
	padding: 8px;
	border-radius:3px
}
.video-list-thumbs > li > a:hover{
	background-color:#000;
	transition:all 500ms ease;
	box-shadow:0 2px 4px rgba(0,0,0,.3);
	text-decoration:none
}
.video-list-thumbs h2{
	bottom: 0;
	font-size: 14px;
	height: 33px;
	margin: 8px 0 0;
}
.video-list-thumbs .glyphicon-play-circle{
    font-size: 60px;
    opacity: 0.6;
    position: absolute;
    right: 39%;
    top: 31%;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
}
.video-list-thumbs > li > a:hover .glyphicon-play-circle{
	color:#fff;
	opacity:1;
	text-shadow:0 1px 3px rgba(0,0,0,.8);
	transition:all 500ms ease;
}
.video-list-thumbs .duration{
	background-color: rgba(0, 0, 0, 0.4);
	border-radius: 2px;
	color: #fff;
	font-size: 11px;
	font-weight: bold;
	left: 12px;
	line-height: 13px;
	padding: 2px 3px 1px;
	position: absolute;
	top: 12px;
}
.video-list-thumbs > li > a:hover .duration{
	background-color:#000;
	transition:all 500ms ease;
}
@media (min-width:320px) and (max-width: 480px) { 
	.video-list-thumbs .glyphicon-play-circle{
    font-size: 35px;
    right: 36%;
    top: 27%;
	}
	.video-list-thumbs h2{
		bottom: 0;
		font-size: 12px;
		height: 22px;
		margin: 8px 0 0;
	}
}
</style>
<ul class="list-unstyled video-list-thumbs row">
<?php

//You can see related documentation and compose own request here: https://developers.google.com/youtube/v3/docs/search/list
//You must enable Youtube Data API v3 and get API key on Google Developer Console(https://console.developers.google.com)

extract($_GET);
$pr_list=$_GET['pr_list'];
//http://ezrachurch.kr/wp/theme/modificate/youtube/youtube.php?pr_list=lecture_01

if($pr_list=="lecture_01")
{
	$uploads_id= "PLJTXCswf-ZIGU9-4pkIUl8SNEMXDetly7"; 
}else if($pr_list=="lecture_02") {
	$uploads_id = "PLJTXCswf-ZIFGB2K5dPktB3XChaS4VYxm";
}else if($_GET["pr_list"]=="edu_01"){
	$uploads_id = "PLJTXCswf-ZIF4uip8EAPCMAJJAUOCf4Rs";
}else if($_GET["pr_list"] == "edu_02"){
	$uploads_id = "PLJTXCswf-ZIEAyigLQ8syQIRJV8VCsjtY";
}else if($_GET["pr_list"] == "edu_03") {
	$uploads_id = "PLJTXCswf-ZIFe7hgsjR1PHltN8rKHnsBW"; 
}




//	$uploads_id ="PLJTXCswf-ZIGU9-4pkIUl8SNEMXDetly7"; 
$maxResults = 10	;
$API_key = 'AIzaSyCqAjZBq3TXvDIjgZXTPCh3O8sPChiE9z4';

//
//To try without API key: $video_list = json_decode(file_get_contents('example.json'));
$data_url="https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=".$maxResults."&playlistId=".$uploads_id."&key=".$API_key."";
$list_items = json_decode(file_get_contents($data_url));



foreach($list_items->items as $item)
{
echo '<li id="'. $item->snippet->resourceId->videoId .'" class="col-lg-12 col-sm-6 col-xs-6 youtube-video">';
//	echo '<h5>'. $item->snippet->title .'</h5>';
echo '<div class="video-container">';

//echo '   <a href="#'. $item->snippet->resourceId->videoId .'" title="'. $item->snippet->title .'">';
//echo  '           <img src="'. $item->snippet->thumbnails->high->url .'" alt="'. $item->snippet->title .'" class="img-responsive" style=height:650px />';
//echo  '           <img src="'. $item->snippet->thumbnails->high->url .'" alt="'. $item->snippet->title .'"  style=height:650px;width:1110px; />';
//echo '            <span class="glyphicon glyphicon-play-circle"></span>';
//echo '        </a>';

echo '			<iframe frameborder="0"   width="850" height="480"  ';
echo ' src="https://www.youtube.com/embed/'.$item->snippet->resourceId->videoId;
echo '?autoplay=0&controls=1&loop=1&rel=1&showinfo=1&autohide=1&start=5" allowfullscreen></iframe>';
echo '</div><!-- .video-container -->';
echo '    </li>';



}


//echo $pr_list;

?>

	
</ul>
<!-- <div class="video-container"><iframe width="853" height="480" src="https://www.youtube.com/embed/z9Ul9ccDOqE" frameborder="0" allowfullscreen></iframe></div> -->
<style type="text/css">
	
.video-container {
position: relative;
padding-bottom: 56.25%;
padding-top: 30px; height: 0; overflow: hidden;
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
</style>
<script>
//For video
$(".youtube-video").click(function(e){
	$(this).children('a').html('<div class="vid"><iframe width="420" height="315" src="https://www.youtube.com/embed/'+ $(this).attr('id') +'?autoplay=1" frameborder="0" allowfullscreen></iframe></div>');
    return false;
	 e.preventDefault();
	});
	//For playlist
	$(".youtube-playlist").click(function(e){
	$(this).children('a').html('<div class="vid"><iframe width="420" height="315" src="https://www.youtube.com/embed/videoseries?list='+ $(this).attr('id') +'&autoplay=1" frameborder="0" allowfullscreen></iframe></div>');
    return false;
	 e.preventDefault();
	});
	

</script>