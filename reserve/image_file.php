<?php
function get_image_array($dir)
{
	$files1 = scandir($dir);
	$files3 = array();
	foreach($files1 as $key =>$value)
	{
		$tmp = explode(".",$value);
		$temp = explode("-",$value);
		
		if(end($tmp)=="jpeg"||end($tmp)=="JPG"||end($tmp)=="jpg"||end($tmp)=="png")
		{
			if($temp[0]!="thumb")
			$files3[] = $value;
		}
	}
	return $files3;
}



$json = array();
$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/gallery_01/';
$json['images'] = get_image_array($dir);

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/bsc_gallery/';
$json['bsc_gallery'] = get_image_array($dir);

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/gallery_02/';
$json['gallery_02'] = get_image_array($dir);

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/gallery_03/';
$json['gallery_03'] = get_image_array($dir);

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/gallery_04/';
$json['gallery_04'] = get_image_array($dir);

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/gallery_05/';
$json['gallery_05'] = get_image_array($dir);

$dir = $_SERVER['DOCUMENT_ROOT'].'/wp/data/file/bsc_edu/';
$json['bsc_edu'] = get_image_array($dir);


$json['root']=$_SERVER['DOCUMENT_ROOT'];
echo json_encode($json);
?>