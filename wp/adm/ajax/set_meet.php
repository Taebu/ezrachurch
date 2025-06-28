<?php
include_once("../../common.php");
extract($_POST);

extract($_FILES);
$json = array();
//echo "<pre>";
//print_r($_POST);
//print_r($_SERVER);

//print_r($_FILES);
$json['success']=false;
$json['message']="";


if($mode=="write")
{
	if(isset($_FILES))
	{
	// 설정
	$uploads_dir = '/uploads';
	$allowed_ext = array('jpg','jpeg','png','gif');
	 
	// 변수 정리
	$error = $_FILES['em_image_file']['error'];
	$name = $_FILES['em_image_file']['name'];
	$ext = array_pop(explode('.', $name));
	$date=date("Ymd_His");
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
	 
	// 확장자 확인
	/*
	if( !in_array($ext, $allowed_ext) ) {
		$json['message']="허용되지 않는 확장자입니다.";
		echo json_encode($json);
		exit;
	}
	*/
	 
	// 파일 이동
	if(isset($_FILES))
	{
	move_uploaded_file( $_FILES['em_image_file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$file_name);
	}
}
$sql=array();
$sql[]="INSERT INTO  ez_meet SET ";
$sql[]=sprintf("em_lecture_no='%s',",$em_lecture_no);
$sql[]=sprintf("em_receipt_st='%s',",$em_receipt_st);
$sql[]=sprintf("em_receipt_ed='%s',",$em_receipt_ed);
$sql[]=sprintf("em_lecture_st='%s',",$em_lecture_st);
$sql[]=sprintf("em_lecture_ed='%s',",$em_lecture_ed);
$sql[]=sprintf("em_lecture_type='%s',",$em_lecture_type);
$sql[]=sprintf("em_place='%s',",$em_place);
$sql[]=sprintf("em_lecture_name='%s',",$em_lecture_name);
$sql[]=sprintf("em_lecture_contents='%s',",$em_lecture_contents);
$sql[]=sprintf("em_author='%s',",$em_author);
$sql[]=sprintf("em_phone='%s',",$em_phone);
$sql[]=sprintf("em_status='%s',",$em_status);
$sql[]=sprintf("em_contents='%s',",$em_contents);
$sql[]=sprintf("em_new_win_yn='%s',",$em_new_win_yn);
$sql[]=sprintf("em_new_win_position='%s',",$em_new_win_position);
if(isset($_FILES['em_image_file']))
{
$sql[]=sprintf("em_image_file='%s',",$file_name);
}
$sql[]="em_datetime=now();";

$query=join("",$sql);
$result=sql_query($query);
$json=array();
$json['success']=$result;
$json['query']=$query;
$json['file_name']=$_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$file_name;
echo json_encode($json);
} // if($mode=="write"){...} 

if($mode=="update")
{

$json=array();
$json['message'] = "none";
if(isset($_FILES['em_image_file']))
{	
	// 설정
	$uploads_dir = '/uploads';
	$allowed_ext = array('jpg','jpeg','png','gif');
	 
	// 변수 정리
	$error = $_FILES['em_image_file']['error'];
	$name = $_FILES['em_image_file']['name'];
	$ext = array_pop(explode('.', $name));
	$date=date("Ymd_His");
	$file_name=$date.".".$ext;

	// 오류 확인
	if( $error != UPLOAD_ERR_OK ) {
		switch( $error ) {
            case UPLOAD_ERR_INI_SIZE: 
                $json['message'] = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                $json['message'] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break; 
            case UPLOAD_ERR_PARTIAL: 
                $json['message'] = "The uploaded file was only partially uploaded"; 
                break; 
            case UPLOAD_ERR_NO_FILE: 
                $json['message'] = "No file was uploaded"; 
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                $json['message'] = "Missing a temporary folder"; 
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                $json['message'] = "Failed to write file to disk"; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $json['message'] = "File upload stopped by extension"; 
                break; 
            default: 
                $json['message'] = "Unknown upload error"; 
                break; 
		}
		echo json_encode($json);
		exit;
	}
	 
	// 확장자 확인
	/*
	if( !in_array($ext, $allowed_ext) ) {
		$json['message']="허용되지 않는 확장자입니다.";
		echo json_encode($json);
		exit;
	}
	*/
	

	// 파일 이동
	$file_upload=move_uploaded_file($_FILES['em_image_file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$file_name);
	
	
}
$sql=array();
$sql[]="UPDATE  ez_meet SET ";
$sql[]=sprintf("em_lecture_no='%s',",$em_lecture_no);
$sql[]=sprintf("em_receipt_st='%s',",$em_receipt_st);
$sql[]=sprintf("em_receipt_ed='%s',",$em_receipt_ed);
$sql[]=sprintf("em_lecture_st='%s',",$em_lecture_st);
$sql[]=sprintf("em_lecture_ed='%s',",$em_lecture_ed);
$sql[]=sprintf("em_lecture_type='%s',",$em_lecture_type);
$sql[]=sprintf("em_place='%s',",$em_place);
$sql[]=sprintf("em_lecture_name='%s',",$em_lecture_name);
$sql[]=sprintf("em_lecture_contents='%s',",$em_lecture_contents);
$sql[]=sprintf("em_author='%s',",$em_author);
$sql[]=sprintf("em_phone='%s',",$em_phone);
$sql[]=sprintf("em_status='%s',",$em_status);
$sql[]=sprintf("em_contents='%s',",$em_contents);
$sql[]=sprintf("em_new_win_yn='%s',",$em_new_win_yn);
$sql[]=sprintf("em_new_win_position='%s',",$em_new_win_position);
if(isset($_FILES['em_image_file']))
{
$sql[]=sprintf("em_image_file='%s',",$file_name);
}
$sql[]="em_datetime=now() ";
$sql[]="where em_no='{$em_no}';";
 
$query=join("",$sql);
$result=sql_query($query);
$json['success']=$result;
$json['query']=$query;
$json['file_name']=$_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$file_name;
echo json_encode($json);
} //if($mode=="update"){...} 

if($mode=="delete")
{
$sql=array();
$sql[]="delete from  ez_meet ";
$sql[]="where em_no='{$em_no}';";
 
$query=join("",$sql);
$result=sql_query($query);
$json=array();
$json['success']=$result;
$json['query']=$query;
echo json_encode($json);
} //if($mode=="delete"){...} 


if($mode=="image_delete")
{
	$json=array();
	$filename=$_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$em_image_file;
	
	if (file_exists($filename)) {
	unlink($filename);
	$json['message']='File '.$em_image_file.' has been deleted';
	} else {
	$json['message']='Could not delete '.$em_image_file.', file does not exist';
	}

	$sql=array();
	$sql[]="UPDATE  ez_meet SET ";
	$sql[]="em_image_file='' ";
	$sql[]=sprintf("where em_no='%s';",$em_no);
	$query=join("",$sql);
	$result=sql_query($query);

	$json['success']=$result;
	$json['query']=$query;
	echo json_encode($json);
}

if($mode=="del_array")
{
$sql=array();
$join_chk=join(",",$chk);
$sql[]="delete from  ez_meet ";
$sql[]="where em_no in ($join_chk);";
 
$query=join("",$sql);
$result=sql_query($query);
$json=array();
$json['success']=$result;
$json['query']=$query;
echo json_encode($json);
} //if($mode=="delete"){...}
?>