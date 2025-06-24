<?php
function get_youtube($url)
{
	printf('<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/%s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe><br><br></div>',$url);
}

function get_weekly($n)
{
	$week = array('일요일','월요일','화요일','수요일','목요일','금요일','토요일','일요일');
	
	return $week[$n];
}