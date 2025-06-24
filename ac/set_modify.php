<?php
include "./db_con.php";
extract($_FILES);
$TABLES=$_POST;
$table = isset($table)?$table:"";
$ab_no=$_POST['ab_no'];
$table=$_POST['table'];
$mode=isset($mode)?$mode:"";
if($mode=="modify")
{
$size="1280";
if(isset($_FILES['ab_image_file'])&&strlen($_FILES['ab_image_file']['name'])>0)
{
	// 설정
	$uploads_dir = '/uploads';
	$allowed_ext = array('jpg','jpeg','png','gif');
	 
	// 변수 정리
	$error = $_FILES['ab_image_file']['error'];
	$name = $_FILES['ab_image_file']['name'];
	
	$tmp = explode('.', $name);
	$ext = end($tmp);
	//$ext = array_pop(explode('.', $name));
	$date=date("YmdHis");
	$file_name=$date.".".$ext;

	// 오류 확인
	if( $error != UPLOAD_ERR_OK ) {
		switch( $error ) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				$json['message']="파일이 너무 큽니다. ($error)";
				break;
			case UPLOAD_ERR_NO_FILE:
				$json['message']="파일이 첨부되지 않았습니다. ($error)";
				break;
			default:
				$json['message']="파일이 제대로 업로드되지 않았습니다. ($error)";
		}
		echo json_encode($json);
		exit;
	}
	
	
	// File Variables
	$fileName=$_FILES['ab_image_file']['name'];
	$fileTmpLoc=$_FILES['ab_image_file']['tmp_name'];
	$fileType=$_FILES['ab_image_file']['type'];
	$fileSize=$_FILES['ab_image_file']['size'];
	$fileSize2=getimagesize($fileTmpLoc);	
	
	if (!$fileTmpLoc)
	{
		//if file not chosen
		echo "ERROR: Please browse for a file befor clicking the upload button.";
		exit();
	}
	
	/* outer function thumbs*/
	$width=$fileSize2[0];
	$height=$fileSize2[1];
	$bf_type=$fileSize2[2];

	// Restrictions for uploading
	$maxwidth=1920;
	$maxheight=1080;
	$allowed=array("image/jpeg", "image/png", "image/gif" );
	
	// Recognizing the extension
	switch( $fileType){
		// Image/Jpeg
		case 'image/jpeg':
			$ext= '.jpeg';
		break;
		// Image/png
		case 'image/png':
			$ext= '.png';
		break;
		// Image/gif
		case 'image/gif':
			$ext= '.gif';
		break;
	}

	$file_upload_url=$_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir;

	$bf_file=sprintf('%s_%s',time(),date("YmdHis").$ext);
	$thumb_path=$file_upload_url."/".$bf_file;
	$targetPath =$file_upload_url;

	if(!is_dir($targetPath)){
		mkdir($targetPath,0700,true);
	}

	if( $width == $height ){ $shape=1; }
	if( $width > $height ){ $shape=2; }
	if( $width < $height ){ $shape=3; }
	
	// Ajusting the resize script on shape.
	switch( $shape ){
		// Code to resize a square image.
		case 1:
			$newwidth=$size;
			$newheight=$size;
		break;
		// Code to resize a tall image.
		case 2:
			$newwidth=$size;
			$ratio=$newwidth / $width;
			$newheight=round( $height * $ratio );
		break;
		// Code to resize a wide image.
		case 3:
			$newheight=$size;
			$ratio=$newheight / $height;
			$newwidth=round( $width * $ratio );
		break;
	}

	// Resizing according to extension.
	switch( $fileType )
	{
		// Image/Jpeg
		case 'image/jpeg':
		$img = ImageCreateFromJPEG( $fileTmpLoc );
		$thumb=imagecreatetruecolor( $newwidth, $newheight );
		imagecopyresized( $thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
		imagejpeg( $thumb, $thumb_path );
		imagedestroy($thumb);
		imagedestroy($img);
		break;
		

		case 'image/png':
		$img = ImageCreateFromPNG($fileTmpLoc);
		$thumb = imagecreatetruecolor( $newwidth, $newheight );
		imagealphablending($thumb, false);
		imagesavealpha($thumb, true);
		imagecopyresampled($thumb,$img,0,0,0,0,$newwidth, $newheight,$width, $height );
		imagepng( $thumb, $thumb_path,9);
		imagedestroy($thumb);
		imagedestroy($img);
		break;

		// Image/gif
		case 'image/gif':
		$img=ImageCreateFromGIF( $fileTmpLoc );
		$thumb=imagecreatetruecolor( $newwidth, $newheight );
		imagecopyresized( $thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );
		imagegif($thumb,$thumb_path);
		imagedestroy($thumb);
		imagedestroy($img);
		break;
	}
}
$TABLES=array_diff_key($TABLES, array('table' => "",'ab_no' => "",'mode' => "","ab_image_file"=>""));
$sql=sprintf("update `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value=addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}
if(isset($_FILES['ab_image_file'])&&strlen($_FILES['ab_image_file']['name'])>0)
{
$sqls[]=sprintf("`ab_image_file`='%s' ",$bf_file);
}
$sqls[]="`ab_modify_datetime`=now() ";
$sql.=join(",",$sqls);
$sql.=sprintf("where ab_no='%s';",$ab_no);
//$query=mysql_query($sql);
$query=$mysqli->query($sql);
} /**  mode==modify */

if($mode=="image_delete")
{
	$uploads_dir = '/uploads';

	$json=array();
	$filename=$_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$ab_image_file;
	
	if (file_exists($filename)) {
	unlink($filename);
	$json['message']='File '.$ab_image_file.' has been deleted';
	} else {
	$json['message']='Could not delete '.$ab_image_file.', file does not exist';
	}

	$sql=array();
	$sql[]="UPDATE  account_book SET ";
	$sql[]="ab_image_file='' ";
	$sql[]=sprintf("where ab_no='%s';",$ab_no);
	$query=join("",$sql);
	$result=$mysqli->query($query);

	$json['success']=$result;
	$json['query']=$query;
}
$json=array();
$json['success']=$query;
echo json_encode($json);