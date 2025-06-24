<?php
include_once "./db_con.php";
include_once "./subject.php";
?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./lib/css/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./lib/css/stdtheme.css" media="all" />
<link rel="stylesheet" type="text/css" href="./lib/css/temp.css" media="all" />
<script>

var subject=<?php echo json_encode($SUBJECT['ko']);?>;
console.log(subject['제1장']);
		 /**
 * 한글을 초성/중성/종성 단위로 잘라서 배열로 반환한다.
 * 공백은 반환하지 않는다.
 * 
 * 참조: http://dream.ahboom.net/entry/%ED%95%9C%EA%B8%80-%EC%9C%A0%EB%8B%88%EC%BD%94%EB%93%9C-%EC%9E%90%EC%86%8C-%EB%B6%84%EB%A6%AC-%EB%B0%A9%EB%B2%95
 *       http://helloworld.naver.com/helloworld/76650
 */
String.prototype.toKorChars = function() {
    var cCho  = [ 'ㄱ', 'ㄲ', 'ㄴ', 'ㄷ', 'ㄸ', 'ㄹ', 'ㅁ', 'ㅂ', 'ㅃ', 'ㅅ', 'ㅆ', 'ㅇ', 'ㅈ', 'ㅉ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ' ],
        cJung = [ 'ㅏ', 'ㅐ', 'ㅑ', 'ㅒ', 'ㅓ', 'ㅔ', 'ㅕ', 'ㅖ', 'ㅗ', 'ㅘ', 'ㅙ', 'ㅚ', 'ㅛ', 'ㅜ', 'ㅝ', 'ㅞ', 'ㅟ', 'ㅠ', 'ㅡ', 'ㅢ', 'ㅣ' ],
        cJong = [ '', 'ㄱ', 'ㄲ', 'ㄳ', 'ㄴ', 'ㄵ', 'ㄶ', 'ㄷ', 'ㄹ', 'ㄺ', 'ㄻ', 'ㄼ', 'ㄽ', 'ㄾ', 'ㄿ', 'ㅀ', 'ㅁ', 'ㅂ', 'ㅄ', 'ㅅ', 'ㅆ', 'ㅇ', 'ㅈ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ' ],
        cho, jung, jong;

    var str = this,
        cnt = str.length,
        chars = [],
        cCode;

    for (var i = 0; i < cnt; i++) {
        cCode = str.charCodeAt(i);
        
        if (cCode == 32) { continue; }

        // 한글이 아닌 경우
        if (cCode < 0xAC00 || cCode > 0xD7A3) {
            chars.push(str.charAt(i));
            continue;
        }

        cCode  = str.charCodeAt(i) - 0xAC00;

        jong = cCode % 28; // 종성
        jung = ((cCode - jong) / 28 ) % 21 // 중성
        cho  = (((cCode - jong) / 28 ) - jung ) / 21 // 초성

        chars.push(cCho[cho], cJung[jung]);
        if (cJong[jong] !== '') { chars.push(cJong[jong]); }
    }

    return chars;
}

function is_jong(str)
{
	var chk_jong=str.toKorChars();
	var index=chk_jong.length-1;
	var cJong = ['ㄱ', 'ㄲ', 'ㄳ', 'ㄴ', 'ㄵ', 'ㄶ', 'ㄷ', 'ㄹ', 'ㄺ', 'ㄻ', 'ㄼ', 'ㄽ', 'ㄾ', 'ㄿ', 'ㅀ', 'ㅁ', 'ㅂ', 'ㅄ', 'ㅅ', 'ㅆ', 'ㅇ', 'ㅈ', 'ㅊ', 'ㅋ', 'ㅌ', 'ㅍ', 'ㅎ','1','3','6','7','8' ];
	var a = cJong.indexOf(chk_jong[index]);
	var result=a>-1;
	return result;
}

	var chk_jong=is_jong("사랑");
	console.log(chk_jong);
</script>
<?php
include_once "./db_con.php";
include_once "./subject.php";
printf("<form action='%s' method='POST'>",$_SERVER['PHP_SELF']);
 $sql="select * from ez_holynote order by eh_order";
 $query=$mysqli->query($sql);
 $json=array();
 while($list=$query->fetch_assoc()){
 array_push($json,$list);
 }
 $count=mysqli_num_rows($query);
 echo "<input type='button' value='쓰기' onclick=\"location.href='./write.php'\">";
 echo "<table class='reference'>";
 
 $sql="select length(eh_content)!='' eh_is_data,count(*) cnt from ez_holynote group by eh_is_data;";
 $query2=$mysqli->query($sql);

 while($list2=$query2->fetch_assoc()){
 }
print('<div class="progress" style="width: 90%">');
printf('    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="%s" aria-valuemin="0" aria-valuemax="100" style="width: %s%%">',$percent,$percent);
printf('      총 %s항 中 %s항 완료 / 완료율 : %s%%',$count,$data_count,$percent);	
print('    </div>');

print('  </div>  ');
$where=empty($where)?"":$where;
if(!empty($keyword))
{
	$where = sprintf(" where wm_content like '%%%s%%' ",$keyword);
	$where = sprintf(" where wm_content like '%%%s%%' OR wm_relparse like '%%%s%%' ",$keyword,$keyword);
}
$sql="select * from ez_holynote ".$where." order by eh_no desc;";
$query=$mysqli->query($sql);
if(!empty($keyword))
{
printf('<input type="text" name="keyword" id="" value="%s">',$keyword);
echo '<input type="submit" value="검색">';
printf("<tr><td colspan='5' class='tac'>\"%s\"로 검색된 결과 %d개 검색 되었습니다.</td></tr>",$keyword,$query->num_rows);
}else{
print('<input type="text" name="keyword" id="" value="" placeholder="검색어를 입력 해 주세요.">');
echo '<input type="submit" value="검색">';
}
echo "<tr>";
echo "<th>eh_no</th>";
echo "<th>subject</th>";
echo "<th>modify</th>";
echo "<th>date</th>";
echo "</tr>";
while($list=$query->fetch_assoc())
{
	echo "<tr>";
	printf("<td>%s</td>",$list['eh_no']);
	echo "<td>";
	printf("<a href='./view.php?eh_no=%s'>%s</a>",$list['eh_no'],$list['eh_subject']);
	echo "</td><td>";
	printf("<a href='./modify.php?eh_no=%s'>수정</a>",$list['eh_no']);
	echo "</td><td>";
	echo date("Y-m-d",strtotime($list['eh_datetime']));
	echo "</td></tr>";
	if($query->num_rows==0)
	{
		printf("<tr><td colspan='5' class='tac'>\"%s\"로 검색된 결과가 없습니다.</td></tr>",$keyword);
	}
}
echo "</table>";

echo "<input type='button' value='쓰기' onclick=\"location.href='./write.php'\">";