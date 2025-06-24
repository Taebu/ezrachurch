<?php
session_start();
include 'db.php';

// 로그인 체크
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit(); // 이후 코드 실행을 중단합니다.
}

// 사용자 정보에 맞는 아이템 데이터 가져오기ㄷ
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$houseItems = [];
for ($i = 1; $i <= 10; $i++) {
    if (!empty($row["house_item$i"])) {
        // items 테이블에서 해당 아이템의 이미지 경로를 가져옵니다.
        $itemId = $row["house_item$i"]; // house_item1~10 컬럼에서 아이템 ID를 가져옵니다.
        $itemQuery = "SELECT image_path FROM items WHERE id = ?";
        $itemStmt = $conn->prepare($itemQuery);
        $itemStmt->bind_param("i", $itemId);
        $itemStmt->execute();
        $itemResult = $itemStmt->get_result();
        $itemData = $itemResult->fetch_assoc();

        // 위치 정보 가져오기 (JSON 형식이라면)
// 위치 정보 가져오기
$position = isset($row["house_item_position$i"]) && !is_null($row["house_item_position$i"])
    ? json_decode($row["house_item_position$i"], true)
    : ['x' => 0, 'y' => 0]; // NULL인 경우 기본값으로 (0, 0) 설정

$top = $position['y'];
$left = $position['x'];


        $houseItems[] = [
            'src' => $itemData['image_path'], // items 테이블에서 가져온 이미지 경로 사용
            'id' => "item$i",
            'top' => $top,  // 위치 정보가 없으면 기본값 0을 사용
            'left' => $left, // 위치 정보가 없으면 기본값 0을 사용
            'position' => $position // 위치 정보 전체를 담아서 확인 가능
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>하우스 - 온누리온</title>
  <style>
    body {
      margin: 0;
      background-color: black; /* 배경색을 검정색으로 설정 */
      overflow: hidden;
      height: 100vh;
      position: relative;
    }

    .image-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    .image-container img {
      position: absolute;
      top: 0;
      left: 0;
      width: 50%;  /* 이미지 크기를 32px로 설정 */
      height: auto; /* 이미지 크기를 32px로 설정 */
      object-fit: cover;
    }

    .image-container img#imageContainer {
      position: absolute;
      top: 0;
      left: 0;
      width: 32px;  /* 이미지 크기를 32px로 설정 */
      height: 32px; /* 이미지 크기를 32px로 설정 */
      object-fit: cover;
    }

    .message {
      color: white;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 20px;
      text-align: center;
    }

    .save-btn {
      position: absolute;
      bottom: 10%;
      left: 50%;
      transform: translateX(-50%);
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .save-btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="image-container" id="imageContainer">
    <!-- 이미지들이 동적으로 삽입될 곳 -->
  </div>

  <!-- 위치 정보가 없으면 메시지를 보여줄 영역 -->
  <div class="message" id="messageContainer">
    <!-- 위치 정보 없으면 안내 메시지 출력 -->
  </div>

  <!-- 저장 버튼 -->
  <button class="save-btn" id="saveButton">위치 저장</button>

  <script>
  // PHP에서 전달한 데이터로 houseItems 배열을 가져옵니다.
  const houseItems = <?php echo json_encode($houseItems); ?>;

  const imageContainer = document.getElementById('imageContainer');
  const messageContainer = document.getElementById('messageContainer');
  const saveButton = document.getElementById('saveButton');

  // 기본 이미지들 추가
  const imageFiles = [
    'images/comm1 entrance.png',
    'images/comm1 floor.png',
    'images/comm1 wall left.png',
    'images/comm1 wall right.png',
    'images/comm1 wall mid.png'
  ];

  // 기본 이미지들 동적으로 추가
  imageFiles.forEach(imageFile => {
    const img = document.createElement('img');
    img.src = imageFile;
    imageContainer.appendChild(img);
  });

  let isAnyItemWithoutPosition = false;

  // 구매한 아이템들을 동적으로 추가
  houseItems.forEach(item => {
    const draggableImg = document.createElement('img');
    draggableImg.src = item.src;
    draggableImg.id = item.id;
    draggableImg.classList.add('draggable');
    draggableImg.style.position = 'absolute';

    // 위치 정보가 없으면 메시지를 보여줌
    if (item.top === null || item.left === null) {
      isAnyItemWithoutPosition = true;
    } else {
      draggableImg.style.top = `${item.top}px`;
      draggableImg.style.left = `${item.left}px`;
    }

    draggableImg.setAttribute('draggable', 'true');

    // 이미지 크기를 32px로 설정
    draggableImg.style.width = '32px';
    draggableImg.style.height = '32px';

    // 드래그 시작 이벤트 처리
    draggableImg.addEventListener('dragstart', function(e) {
      e.dataTransfer.setData('text', item.id);  // 드래그한 아이템의 id를 저장
    });

    // 이미지 컨테이너에 드래그 가능한 아이템 추가
    imageContainer.appendChild(draggableImg);
  });

  // 위치 정보가 없으면 메시지를 표시
  if (isAnyItemWithoutPosition) {
    messageContainer.innerHTML = "위치 정보가 없습니다. 아이템 목록 드롭다운을 클릭하여 드래그 후 위치 정보를 저장하세요.";
  } else {
    messageContainer.style.display = 'none';  // 위치 정보가 있으면 메시지 숨기기
  }

  // 드래그 할 때 위치 이동
  imageContainer.addEventListener('dragover', function(e) {
    e.preventDefault(); // 기본 동작을 막아서 드래그 할 수 있도록 함
  });

  imageContainer.addEventListener('drop', function(e) {
    e.preventDefault();
    const x = e.clientX;  // 드래그한 위치의 x좌표
    const y = e.clientY;  // 드래그한 위치의 y좌표

    // 드래그한 아이템의 id를 통해 해당 아이템을 찾고 위치 설정
    const draggedItemId = e.dataTransfer.getData('text');
    const draggedItem = document.getElementById(draggedItemId);

    // 아이템의 크기를 동적으로 가져오기
    const itemWidth = draggedItem.width;  // 아이템의 너비
    const itemHeight = draggedItem.height; // 아이템의 높이

    // 중앙 정렬을 위한 위치 조정
    const adjustedX = x - itemWidth / 2;
    const adjustedY = y - itemHeight / 2;

    draggedItem.style.left = `${adjustedX}px`;
    draggedItem.style.top = `${adjustedY}px`;

    // 위치 정보를 업데이트 배열에 저장
    houseItems.forEach(item => {
      if (item.id === draggedItemId) {
        item.top = adjustedY;
        item.left = adjustedX;
      }
    });
  });

  saveButton.addEventListener('click', function() {
  const positions = houseItems.map(item => ({
    id: item.id,
    position: { x: item.left, y: item.top }
  }));

  fetch('update_position.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ positions: positions })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('위치가 저장되었습니다!');
    } else {
      alert('위치 저장 실패: ' + data.message);
    }
  })
  .catch(error => {
    console.error('위치 저장 중 오류 발생:', error);
  });
});


  // 화살표 키를 누르면 game.php로 이동
  document.addEventListener('keydown', function(event) {
    if (event.key === "ArrowDown") {
      window.location.href = 'game.php';  // game.php로 이동
    }
  });
</script>

</body>
</html>
