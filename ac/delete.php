<?php
include "./db_con.php";
$ab_no=$_GET['ab_no'];


$sql="select * from account_book ";
$sql.=sprintf("where ab_no='%s';",$ab_no);
$query=$mysqli->query($sql);
$list=$query->fetch_assoc();

$ab_image_file = $list['ab_image_file'];
$uploads_dir = '/uploads';

$json=array();
$filename=$_SERVER['DOCUMENT_ROOT']."/wp/adm".$uploads_dir."/".$ab_image_file;

if (file_exists($filename)&&strlen($ab_image_file)>0) {
unlink($filename);
$json['message']='File '.$ab_image_file.' has been deleted';
} else {
$json['message']='Could not delete '.$ab_image_file.', file does not exist';
}

$sql="delete from account_book ";
$sql.=sprintf("where ab_no='%s';",$ab_no);
$query=$mysqli->query($sql);
$json=array();
$json['success']=$query;
echo json_encode($json);
