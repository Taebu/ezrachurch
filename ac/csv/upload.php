<?php
include_once "../db_con.php";
extract($_GET);
extract($_POST);

$i=0;

header("Content-Type: text/html; charset= euc-kr ");
function get_type($key)
{
	$array = array();
	$array['++']="Budget";
	$array['--']="Expenditure";
	$array['+']="In";
	$array['-']="Out";

	if (array_key_exists($key, $array)) {
		$result=$array[$key];
	}else{
		$result="No Code";
	}
	return $result;
}

$file = $_FILES['csv']['tmp_name'];
$filename = $_FILES['csv']['name'];

$pos = strrpos($filename, '.');
$ext = strtolower(substr($filename, $pos, strlen($filename)));

$csv = array();
$csv_query = array();  
date_default_timezone_set('Asia/Seoul');
// 출처: https://nowonbun.tistory.com/633 [명월 일지:티스토리]
$date = date("Y-m-d H:i:s");
if($ext==".csv")
{
		$data = file($file);
        $num_rows = count($data) + 1;
        foreach ($data as $item) 
        {
            $item = explode(',', $item);

			$item[1] = get_type($item[1]);
			if(strpos($item[2] , "   ")!==false)
			{
				$item[2] = str_replace("   ", "&emsp;", $item[2]);
			}
			$item[2] = iconv("EUC-KR", "UTF-8", $item[2]);
			$item[4] = iconv("EUC-KR", "UTF-8", $item[4]);
			$item[] = $date;
			$item[] = $ab_class;

			array_push($csv_query, $item);

			if($i>0){
			$product = array();
			$product['ab_date']=$item[0];
			$product['ab_type']= $item[1];
			$product['ab_contents']= $item[2];
			$product['ab_amount']=number_format($item[3]);
			$product['ab_etc']= $item[4];
			$product['ab_datetime']= $item[5];
			$product['ab_class']= $ab_class;
			    array_push($csv, $product);
			}
			$i++;
            
        }
}

$i=0;
$query = "insert into account_book (ab_date,ab_type,ab_contents,ab_amount,ab_etc,ab_datetime,ab_class) values ";
foreach($csv_query as $items)
{
	if($i>0)
	{
		$query.= sprintf("('%s'),",join("','",$items));
	}
	$i++;
}

$json = array();
$json['success']=false;
$json['csv'] = $csv;
$sql = substr_replace($query, ";", strlen($query)-1, strlen($query));
if(isset($filesave)&&$filesave=="Y")
{
$query=$mysqli->query($sql);
if($query){
	$json['success']=true;
}
}
echo json_encode($json);