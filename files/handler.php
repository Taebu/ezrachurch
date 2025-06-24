<?php
define('DS',DIRECTORY_SEPARATOR);
define('DES','uploads');
$action		= "upload";
if ( isset($_GET['action']) ) {
	$action = $_GET['action'];
}
//routing for different tasks
switch( $action ) {
	case 'upload':
		if ( !empty($_FILES) ) { 
			storeFile($_FILES);
		}
		break;
	case 'remove':
		$filename = $_GET['name'];
		removeFile( $filename );
		break;
	case 'show':
		showFiles();
		break;
}

function showFiles()
{
	$result = array();
	$files  = scandir(DES);					
	if ( false!==$files ) {
		foreach ( $files as $file ) {
			//ignore current and parent folder indicator
			if ( '.'!=$file && '..'!=$file) {	
				$obj['name'] = $file;
				$obj['size'] = filesize(DES.DS.$file);
				$result[] = $obj;
			}
		}
	}
	header('Content-type: text/json');				
	header('Content-type: application/json');
	echo json_encode($result);
}

function storeFile( $file )
{	
	$tempFile = $file['file']['tmp_name'];
	//file extensions allowed
	$allowedExt = array('gif');
	//file size allowed in kb
	$allowedMaxSize = 1024000;
	//file extension validation
	/*
	if ( count($allowedExt) >0 ) {
		$fileExt = pathinfo($file['file']['name'],PATHINFO_EXTENSION);
		if ( !in_array( $fileExt, $allowedExt ) ) {
			header("HTTP/1.0 500 Internal Server Error");
			echo 'Invalid file extension';
			exit();
		}
	}
	*/
	//file size valiation
	if ( (filesize($tempFile)/1024)> $allowedMaxSize ) {
		header("HTTP/1.0 500 Internal Server Error");
		echo 'File exceeds maximum allowed size';
		exit();
	}
	//move file to server
	$targetPath = dirname( __FILE__ ) . DS. DES . DS;
	$targetFile = $targetPath. $file['file']['name'];
	if ( !move_uploaded_file($tempFile,$targetFile) ) {
		header("HTTP/1.0 500 Internal Server Error?ot?ound");
		echo 'Unknown server error';
		exit();
	}
}

function removeFile( $fileName ) {
	$targetPath = dirname( __FILE__ ) . DS. DES . DS;
	$targetFile = $targetPath. $fileName;
	//remove only when file exists
	if ( file_exists($targetFile) ) {
		unlink($targetFile);
	}
}
?>