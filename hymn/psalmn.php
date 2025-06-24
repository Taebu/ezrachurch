<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="./js/torrent.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<style>
		#hd_search{clear:both}
		#list{width: 48%;float: left;}
		#preview{width: 48%;float: left;}
	</style>
</head>
<body>
    <!-- 검색어를 입력할 input box 구현부분 -->
<pre>
	아래 검색 창에 CCM 제목을 검색해 주세요.
	새찬송가에 없는 내용을 CCM을 다 모아놨습니다.
	PPT 만드는법은 새찬송가 방법과 동일합니다.
	
	여기 없는 찬양가사는 저에게 문의 주시면 바로 추가해 넣도록 하겠습니다.
</pre>
	<input id="hd_search"  placeholder='ccm제목을 여기에 검색해주세요.'> <input type="button" value="ppt 초기 자막 생성하기" onclick="javascript:set_script()">
	<div style='clear:both'>
    <ul id="list"></ul>
	<div id="preview">#preview</div>
	</div>
<form action="makeppt.php" name="ppt_script" method="POST">
	<input type="hidden" name="files" id="files">
</form>

</body>
</html>

<script>
var files = [];

function del_list(id)
{
	$("#"+id).remove();

	// 원소 'b' 삭제
	for(let i = 0; i < files.length; i++) {
	  if(files[i].id === id)  {
		files.splice(i, 1);
		i--;
	  }
	}
	$("#files").val(JSON.stringify(files));

}

function preview(name)
{
  	$.ajax({
		url:"./get_name.php",
		data:"name="+name,
		dataType:"html",
		type:"POST",
		success:function(data){
			$("#preview").html(data);
		}
	});	
}

  $( function() {
/*
갱신시만 작동 2025-06-22 일요일 05:22:49 
  	$.ajax({
		url:"./js/torrent.js",
		data:"",
		dataType:"json",
		type:"POST",
		success:function(data){
			sampleSrc = data;
		}
	});
*/
  $("li").attr("draggable", "true");

  } );

function set_script()
{
	if(files.length==0)
	{
		alert("하나 이상 제목을 지정해 주세요.");
		return ;
	}
	document.forms['ppt_script'].submit();
}
const input = document.querySelector('#hd_search');

input.addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
    // 엔터키를 눌렀을 때 수행할 동작
    $("#hd_search").val("");
  }
});

// 이미 저장된 배열형태로 진행
/*
 var sampleSrc = [{"product_id": 1,   
                   "product_name": "신라면"},
                   {"product_id": 2,
                   "product_name": "진라면"},
                   {"product_id": 3,
                   "product_name": "열라면"},
                   {"product_id": 4,
                   "product_name": "삼양라면"},
                   {"product_id": 5,
                   "product_name": "불닭볶음면"},
                   {"product_id": 6,
                   "product_name": "라볶이"},
                   {"product_id": 7,
                   "product_name": "짜장라면"},
                  ];
*/


$("#hd_search").autocomplete({  //자동완성 시작
    source : function(request, response){
        var r = []; //자동완성의 응답값
        var q = request.term; //사용자의 input값을 받는다
        //배열의 형태가 복잡한 경우, 임의로 필터를 지정해줘야함
        $.each(sampleSrc, function(k, v){ 
            if (v.name.indexOf(q) != -1) {
                r.push({
                    label: v.name, //자동완성창에 표시되는 데이터
                    value: v.name, //선택했을때 input박스에 입력되는 데이터
                    "id": v.id, //추가정보를 핸들링하고 싶을때 추가
                })
            }
        });
        response(r.slice(0,10)); //자동완성 최대갯수 제한
    },  
    select : function(event, ui) {    //아이템 선택시
        console.log(ui.item);
        console.log(ui.item.value);
		if(!in_array(ui.item.id))
		{
			$("#list").append("<li id='"+ui.item.id+"'>"+ui.item.value+" <a href='javascript:del_list("+ui.item.id+")'>x</a></li>");
			files.push({'id':ui.item.id,'name':ui.item.value});
		}
		$("#files").val(JSON.stringify(files));
		preview(ui.item.value);
    },
    focus : function(event, ui) {    
        return false;
    },
    minLength: 1,// 최소 글자수
    autoFocus: true, //첫번째 항목으로 자동 포커스
    delay: 0,    //검색창에 글자 써지고 나서 autocomplete 창 뜰 때 까지 딜레이 시간(ms)
    close : function(event){    //자동완성창 닫아질때 호출
        //console.log(event);
    }
});

function in_array(id)
{
	var in_value = false;
	files.forEach(function(files) {
		if(files.id==id)
		{
			in_value = true;
		}
	});
	return in_value;

}
</script>