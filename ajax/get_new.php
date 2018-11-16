<?
/* 
/ajax/get_new.php
2014-10-23 (목)
{
	"Result":"OK",
	"lastMailSN":"30007",
	"Message":"",
	"newMail":"false"
}
param

*/

$mysql_host = 'localhost';
$mysql_user = 'ezrachurch';
$mysql_password = '0837ezra';
$mysql_db = 'ezrachurch';
$connect=mysql_connect($mysql_host, $mysql_user, $mysql_password);
mysql_select_db($mysql_db, $connect);
mysql_query("set names utf8;") ;

extract($_REQUEST);
extract($_GET);
extract($_POST);
/*
최신 덧글
MariaDB [ezrachurch]> select * from g4_board_new where wr_id<>wr_parent order by bn_datetime desc limit 10;
+-------+----------+-------+-----------+---------------------+------------+
| bn_id | bo_table | wr_id | wr_parent | bn_datetime         | mb_id      |
+-------+----------+-------+-----------+---------------------+------------+
|  2207 | bbs_5_1  |   182 |       173 | 2014-10-20 13:02:48 | Lydia87    |
|  2192 | bbs_5_1  |   179 |       173 | 2014-10-13 09:46:11 | nhyunwoo   |
|  2186 | bbs_5_1  |   178 |       173 | 2014-10-07 18:44:17 | toykyoung  |
|  2173 | bbs_6_3  |   131 |       130 | 2014-09-23 15:44:49 | nhyunwoo   |
|  2172 | bbs_5_1  |   177 |       173 | 2014-09-23 15:36:22 | nhyunwoo   |
|  2171 | bbs_6_8  |    32 |        30 | 2014-09-22 14:31:38 | erm00      |
|  2168 | bbs_5_1  |   176 |       173 | 2014-09-21 21:16:49 | baesoo1004 |
|  2166 | bbs_5_1  |   175 |       173 | 2014-09-21 20:49:56 | skagus15   |
|  2160 | bbs_5_1  |   174 |       142 | 2014-09-19 12:39:14 | jundo2000  |
|  2159 | bbs_6_4  |   414 |       413 | 2014-09-18 10:32:46 | toykyoung  |
+-------+----------+-------+-----------+---------------------+------------+
10 rows in set (0.00 sec)

최신 글 10건
select * from g4_board_new where wr_id=wr_parent order by bn_datetime desc limit 10;


1분 마다 최신 글 여부 검사

1분 마다 최신 덧글 여부 검사
select count(*) cnt from g4_board_new where
 wr_id<>wr_parent  and 
 date(bn_datetime)>date('2014-10-20 13:02:48’);


select count(*) cnt from g4_board_new where
 wr_id<>wr_parent  and 
 date(bn_datetime)>date('2014-10-20 13:02:47');
*/

$sql="select max(bn_id) bn_id from g4_board_new;";
$row=mysql_fetch_assoc(mysql_query($sql));
$json = array();
if($lastBoardID<$row['bn_id']){
$json['Result']="OK";
$json['lastBoardID']=$row['bn_id'];
$json['Message']="";
$json['newBoard']=false;
}else{
$json['Result']="NO";

}
echo json_encode($json);
?>