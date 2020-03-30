<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>로드뷰에 마커와 인포윈도우 올리기</title>
    <style>
    .screen_out {display:block;overflow:hidden;position:absolute;left:-9999px;width:1px;height:1px;font-size:0;line-height:0;text-indent:-9999px}
    .wrap_content {overflow:hidden;height:500px}
    .wrap_map {width:50%;height:500px;float:left;position:relative}
    .wrap_roadview {width:50%;height:500px;float:left;position:relative}
    .wrap_button {position:absolute;left:15px;top:12px;z-index:2}
    .btn_comm {float:left;display:block;width:70px;height:27px;background:url(//t1.daumcdn.net/localimg/localimages/07/mapapidoc/sample_button_control.png) no-repeat}
    .btn_linkMap {background-position:0 0;}
    .btn_resetMap {background-position:-69px 0;}
    .btn_linkRoadview {background-position:0 0;}
    .btn_resetRoadview {background-position:-69px 0;}
</style>
</head>
<body>
<div class="wrap_content">
    <div class="wrap_map">
        <div id="map" style="width:100%;height:100%"></div> <!-- 지도를 표시할 div 입니다 -->
        <div class="wrap_button">
            <a href="javascript:;" class="btn_comm btn_linkMap" target="_blank" onclick="moveDaumMap(this)"><span class="screen_out">지도 크게보기</span></a> <!-- 지도 크게보기 버튼입니다 -->
            <a href="javascript:;" class="btn_comm btn_resetMap" onclick="resetDaumMap()"><span class="screen_out">지도 초기화</span></a> <!-- 지도 크게보기 버튼입니다 -->
        </div>
    </div>
    <div class="wrap_roadview">
        <div id="roadview" style="width:100%;height:100%"></div> <!-- 로드뷰를 표시할 div 입니다 -->
        <div class="wrap_button">
            <a href="javascript:;" class="btn_comm btn_linkRoadview" target="_blank" onclick="moveDaumRoadview(this)"><span class="screen_out">로드뷰 크게보기</span></a> <!-- 로드뷰 크게보기 버튼입니다 -->
            <a href="javascript:;" class="btn_comm btn_resetRoadview" onclick="resetRoadview()"><span class="screen_out">로드뷰 크게보기</span></a> <!-- 로드뷰 리셋 버튼입니다 -->
        </div>
    </div>
</div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=f0be7c9de3845a5ed3e477d9f53da689"></script>
<script>
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new kakao.maps.LatLng(37.535043, 126.897380), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };

var map = new kakao.maps.Map(mapContainer, mapOption);

// 마커가 표시될 위치입니다 
var markerPosition  = new kakao.maps.LatLng(37.535043, 126.897380); 

// 마커를 생성합니다
var marker = new kakao.maps.Marker({
    position: markerPosition
});

// 마커가 지도 위에 표시되도록 설정합니다
marker.setMap(map);

var iwContent = '<div style="padding:5px;max-width:200px">서울에스라 교회<br> 서울시 영등포구 선유로 252 지하1층<br><a href="https://map.kakao.com/link/map/서울에스라 교회,37.535043, 126.897380" style="color:blue" target="_blank">큰지도보기</a> <a href="https://map.kakao.com/link/to/서울에스라 교회,37.535043, 126.897380" style="color:blue" target="_blank">길찾기</a></div>', // 인포윈도우에 표출될 내용으로 HTML 문자열이나 document element가 가능합니다
    iwPosition = new kakao.maps.LatLng(37.535043, 126.897380); //인포윈도우 표시 위치입니다

// 인포윈도우를 생성합니다
var infowindow = new kakao.maps.InfoWindow({
    position : iwPosition, 
    content : iwContent 
});
  
// 마커 위에 인포윈도우를 표시합니다. 두번째 파라미터인 marker를 넣어주지 않으면 지도 위에 표시됩니다
infowindow.open(map, marker); 
/* */
var roadviewContainer = document.getElementById('roadview'); //로드뷰를 표시할 div
var roadview = new kakao.maps.Roadview(roadviewContainer); //로드뷰 객체
var roadviewClient = new kakao.maps.RoadviewClient(); //좌표로부터 로드뷰 파노ID를 가져올 로드뷰 helper객체

var position = new kakao.maps.LatLng(37.535043, 126.897380);
var viewpoint = new kakao.maps.Viewpoint(20, 10, 0);

var rvResetValue = {} //로드뷰의 초기화 값을 저장할 변수

// 특정 위치의 좌표와 가까운 로드뷰의 panoId를 추출하여 로드뷰를 띄운다.
roadviewClient.getNearestPanoId(position, 50, function(panoId) {
    roadview.setPanoId(panoId, position); //panoId와 중심좌표를 통해 로드뷰 실행
    rvResetValue.panoId = panoId;
   
	//각 뷰포인트 값을 초기화를 위해 저장해 놓습니다.
    rvResetValue.pan = 20;
});
    roadview.setViewpoint({
        pan: 120, tilt: 0, zoom:0
    });

</script>

