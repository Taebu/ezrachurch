<?php
include "./db_con.php";
extract($_FILES);
extract($_GET);
$TABLES=$_POST;
$table = isset($table)?$table:"";
$ab_no=isset($ab_no)?$ab_no:"";
$mode=isset($mode)?$mode:"";
$json = array();
$json['success'] = false;
function get_randval()
{
$serial_make = "0123456789"; // 시리얼 번호 생성
$rand_val = "";
for($j=0; $j<10; $j++)
{ 
	$rand_val.= $serial_make[rand()%strlen($serial_make)];
}
return $rand_val;
}
/* image file insert */
function set_image_file($ins_data)
{
  global $mysqli;
  $sql=array();
  $sql[]="INSERT INTO `account_image_file` SET ";
  $sql[]=sprintf("ab_class='%s',",$ins_data[0]);
  $sql[]=sprintf("ab_no='%s',",$ins_data[1]);
  $sql[]=sprintf("bf_no='%s',",$ins_data[2]);
  $sql[]=sprintf("bf_source='%s',",$ins_data[3]);
  $sql[]=sprintf("bf_file='%s',",$ins_data[4]);
  $sql[]=sprintf("bf_filesize='%s',",$ins_data[5]);
  $sql[]=sprintf("bf_width='%s',",$ins_data[6]);
  $sql[]=sprintf("bf_height='%s',",$ins_data[7]);
  $sql[]=sprintf("bf_type='%s',",$ins_data[8]);
  $sql[]=sprintf("bf_date='%s',",$ins_data[9]);
  $sql[]="bf_download=0,";
  $sql[]="bf_content='',";
  $sql[]="bf_datetime=NOW();";
  $mysqli->query(join("",$sql));
}

if($mode=="modify")
{
$size="1280";
if (!empty($_FILES['file'])) 
{
		$file_sizes=count($_FILES['file']['name']);
	//$file_sizes=$page_start_size;

	$i=0;
	for ($i=0;$i<$file_sizes; $i++)
	{
	//printf("i : %s, files_sizes : %s<br>",$i,$file_sizes);
	if($_FILES['file']['tmp_name'][$i]!="")
	{
	// File Variables
	$fileName=$_FILES['file']['name'][$i];
	$fileTmpLoc=$_FILES['file']['tmp_name'][$i];
	$fileType=$_FILES['file']['type'][$i];
	$fileSize=$_FILES['file']['size'][$i];
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

	$upload = "";
	$upload = get_randval();
	// Restrictions for uploading
	$maxwidth=1920;
	$maxheight=1080;
	$allowed=array("image/jpeg", "image/png", "image/gif" );
	$shape=2;
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
	// 배달통 : S0169543_1/20170512/1494569614_2141930156.jpeg
	/**
	* 캐시큐 : 73863_1/20170717/1494569614_2141930156.jpeg
	* store.seq_img.no/YMD/unixtimestamp_random.jpeg
	*
	*******************/
	$file_upload_url="/upload/".sprintf('%s/%s/%s_%s', $ab_class, date("Ymd"),$ab_no,$i);
	$bf_file=sprintf('%s_%s',time(),$upload.$ext);
	$thumb_path=$_SERVER['DOCUMENT_ROOT'].$file_upload_url."/".$bf_file;
	$targetPath = $_SERVER['DOCUMENT_ROOT'].$file_upload_url;
	
	if(!is_dir($targetPath)){
		mkdir($targetPath,0700,true);
	}

	if( $width == $height ){ $shape=1; }
	if( $width > $height ){ $shape=2; }
	if( $width < $height ){ $shape=3; }
	// Ajusting the resize script on shape.
	$shape=2;
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
		
		// Image/png
		case 'image/png':
		$img = ImageCreateFromPNG($fileTmpLoc);
		$thumb = imagecreatetruecolor( $newwidth, $newheight );
//		imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
		// 이미지 투명값 적용시 깨짐.
		// turning off
		imagealphablending($thumb, false);
		// turning on 
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
		imagegif( $thumb, $thumb_path );
		imagedestroy($thumb);
		imagedestroy($img);
		break;
	}

		$bf_no=$i;
		$bf_soruce=$fileName;
		$bf_filesize=filesize($thumb_path);
		$bf_width=$newwidth;
		$bf_height=$newheight;
		//$bf_date=$YMD;

		$ins_data=array($ab_class,$ab_no, $i,$fileName,$bf_file,$bf_filesize,$bf_width,$bf_height,$bf_type,date("Ymd"));
		set_image_file($ins_data);

		//$json['posts']=array();
		$obj['name']=$bf_file;
		$obj['size']=filesize($thumb_path);
		$obj['bl_imgprefix']=date("Ymd");
		$obj['file_sizes']=$file_sizes;
		//array_push($json['posts'],$obj);
		$result[]=$obj;

		$result['file']=true;

	}/* if(){} */
	
	}/* for(***) */
}
$file_sizes=0;
if(!empty($_FILES)){
$file_sizes=count($_FILES['file']['name']);
}
$TABLES=array_diff_key($TABLES, array('table' => "",'ab_no' => "",'mode' => "","ab_image_file"=>""));

$TABLES['ab_amount'] = preg_replace("/[^0-9-+]/", "",$TABLES['ab_amount']);
$sql=sprintf("update `%s` SET ",$table);
$sqls=array();
foreach($TABLES as $key =>$value)
{
	$value=addslashes($value);
	$sqls[]=sprintf("`%s`='%s' ",$key,$value);
}
if(isset($_FILES['file'])&&$_FILES['file']['error']!="4")
{
$sqls[]=sprintf("`ab_file`='%s' ",$file_sizes);
}
$sqls[]="`ab_modify_datetime`=now() ";
$sql.=join(",",$sqls);
$sql.=sprintf("where ab_no='%s';",$ab_no);

$query=$mysqli->query($sql);
		$json['message']='수정완료';
		$json['success']=true;
} /**  mode==modify */

if($mode=="image_delete")
{

	$json=array();
	$json['success']=false;
		
	$sql=array();
	$sql[]="select * from account_image_file  ";
	$sql[]=sprintf("where ab_no='%s' ",$ab_no);
	$sql[]=sprintf("and bf_no='%s' ",$bf_no);
	$query=join("",$sql);
	$query=$mysqli->query($query);
	$images=$query->fetch_assoc();
	$sql=array();
	$sql[]="delete from account_image_file  ";
	$sql[]=sprintf("where ab_no='%s' ",$ab_no);
	$sql[]=sprintf("and bf_no='%s' ",$bf_no);
	$query=join("",$sql);
	$result=$mysqli->query($query);

	$url1=sprintf("/upload/%s/%s/%s_%s",$images['ab_class'],date("Ymd"),$ab_no,$bf_no);
	$url2=sprintf("/%s",$images['bf_file']);
	$filename=$_SERVER['DOCUMENT_ROOT'].$url1.$url2;

	if (file_exists($filename)) {
		unlink($filename);

		$json['message']='File '.$images['bf_file'].' has been deleted';
		$json['success']=true;
	} else {
		$json['message']='Could not delete '.$images['bf_file'].', file does not exist';
	}

	$sql=array();
	$sql[]="UPDATE account_book SET ";
	$sql[]="ab_file=ab_file-1 ";
	$sql[]=sprintf("where ab_no='%s';",$ab_no);
	$query=join("",$sql);
	$result=$mysqli->query($query);
	$json['query']=$query;
}
echo json_encode($json);