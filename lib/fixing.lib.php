<?
// ���� �迭 ����
$g4_board = array();
//�Խ����� �������� ������ �̸� �����Ѵ�.(�̶� �Խ��Ǹ���Ʈ�� �����ִ� ������ ȸ���������� �����ٸ� �ҷ����� �ʴ´�.)
$g4_board_select = "*";
if($member[mb_level] < 10)
	$g4_board_where = " where bo_list_level <= '$member[mb_level]'";
$g4_board_sql = " select sql_cache $g4_board_select from $g4[board_table] $g4_board_where order by bo_order_search, gr_id, bo_table ";
$g4_board_result = mysql_query($g4_board_sql);
// �ߺ����Ÿ� ���� �ѹ��� (0���� �����ϸ� 0�� false�� ��)
$in = 1;
for($i=0; $g4_board_row = mysql_fetch_array($g4_board_result); $i++){
	$g4_board[$i] = $g4_board_row;
	if($g4_table_in){
		$g4_table_in .= ", '$g4_board_row[bo_table]'";
	}else{
		$g4_table_in  = "'$g4_board_row[bo_table]'";
	}
	// �ѹ��� (���̺������ ����)
	$g4_board[num][$g4_board_row[bo_table]] = $i;
	
	//������̵� �ߺ� ����
	if(!$bo_gr[$g4_board_row[gr_id]]){
		$bo_gr[$g4_board_row[gr_id]] = $in;
		if($g4_group_in){
			$g4_group_in .= ", '$g4_board_row[gr_id]'";
		}else{
			$g4_group_in = "'$g4_board_row[gr_id]'";
		}
		$in++;
	
	}
}
$g4_board[count] = $i;

// ���屸�� �迭 ����
$g4_group = array();
$g4_group_in = "where gr_id in ($g4_group_in)";
$g4_group_select = "gr_id, gr_subject, gr_admin, gr_use_access, gr_1, gr_2";
$g4_group_sql = " select sql_cache $g4_group_select from $g4[group_table] $g4_group_in order by gr_1 asc ";
$g4_group_result = mysql_query($g4_group_sql);
for($i=0; $g4_group_row = mysql_fetch_array($g4_group_result); $i++){
	$g4_group[$i] = $g4_group_row;
	// ���� �ѹ��� (������̵�� ����)
	$g4_group[num][$g4_group_row[gr_id]] = $i; 
}
$g4_group[count] = $i;
	
// �ֽű������� �ҷ��� �����Ѵ�.
$g4_table_in = "and bo_table in ($g4_table_in)";
// �ֱٳ��� ���ϱ�
$new_time = date("Y-m-d H:i:s", $g4['server_time'] - ($config[cf_new_del] * 86400));

// �ֽű� ��� �迭����
$g4_new = array();//�ֽű������
$g4_new_select = '*';
// �ֽű��� ������ (�ڸ�Ʈ�� ����)
$g4_new_query = sql_query(" select $g4_new_select from $g4[board_new_table] where bn_datetime >= '$new_time' and wr_id = wr_parent $g4_table_in ");
for($i=0; $g4_new_row = sql_fetch_array($g4_new_query); $i++){
	$g4_new[$i] = $g4_new_row;
	//���̺� ī����
	$g4_new[board][$i] = $g4_new_row[bo_table];
	// �ѹ���
	$g4_new[$g4_new_row[bo_table]][$g4_new_row[wr_id]] = $i;
}
//�ֽű� ��� ��
$g4_new[rows] = $i;
// Ÿ��Ʋ ����
function gun_title($cf_title, $gr_subject, $gr_2)
{
	global $g4;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table width="940" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="30%" height="40">
          <table width="100%" height="90%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="21" style="padding-left:25"><img src="<?=$g4[path]?>/img/t_icon" width="21" height="20"/></td>
              <td class="latest_title"><?=$gr_subject?></td>
            </tr>
          </table></td>
        <td width="70%" height="40" class="gnu_text"><?=$gr_2?></td>
    </tr>
      <tr>
        <td height="4" colspan="2"><img src="<?=$g4[path]?>/img/underline.gif" width="940" height="4"/></td>
      </tr>
    </table></td>
  </tr>
</table>

<?
}
?>