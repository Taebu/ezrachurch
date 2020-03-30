<?php
/*

http://ezrachurch.kr/wp/theme/modificate/youtube/list/get_qna_count.php

*/
include_once('./_common.php');

/* 관리자 답변 포함 */
$sql=sprintf("SELECT ca_name,count(*) cnt FROM newezra.g5_write_qna where wr_id=wr_parent group by ca_name;",$pr_list);

/* 관리자 답변 제외 */
$sql=sprintf("SELECT ca_name,count(*) cnt FROM newezra.g5_write_qna where mb_id not in ('admin','nhyunwoo') group by ca_name;;",$pr_list);

$query=sql_query($sql);
$bible_lists = array("창세기","출애굽기","레위기","민수기","신명기","여호수아","사사기","룻기","사무엘상","사무엘하","열왕기상","열왕기하","역대상","역대하","에스라","느헤미야","에스더","욥기","시편","잠언","전도서","아가","이사야","예레미야","예레미야애가","에스겔","다니엘","호세아","요엘","아모스","오바댜","요나","미가","나훔","하박국","스바냐","학개","스가랴","말라기","마태복음","마가복음","누가복음","요한복음","사도행전","로마서","고린도전서","고린도후서","갈라디아서","에베소서","빌립보서","골로새서","데살로니가전서","데살로니가후서","디모데전서","디모데후서","디도서","빌레몬서","히브리서","야고보서","베드로전서","베드로후서","요한일서","요한이서","요한삼서","유다서","요한계시록","웨스트민스터");
$json=array();
$json['posts']=array();
$json['total_count']=0;
$key_skip_list=array();
//$item=array();
while($list=sql_fetch_array($query))
{
	foreach($bible_lists as $key =>$value)
	{
		if($value==$list['ca_name']&&!in_array($key, $key_skip_list))
		{
			$list['id']=$key;
			$json['total_count']=$json['total_count']+$list['cnt'];
			$key_skip_list[]=$key;
		}

	}
	array_push($json['posts'],$list);
}
echo json_encode($json);
