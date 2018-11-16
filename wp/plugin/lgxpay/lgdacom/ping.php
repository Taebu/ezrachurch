<?php

	$configPath = "C:/lgdacom"; //LG���÷������� ������ ȯ������("/conf/lgdacom.conf") ��ġ ����. 

    /*
     * [LG���÷��� ���� Ȯ�� ������]
     *
     * ���������� LG���÷������� ������ �׽�Ʈ �ϴ� ������ �Դϴ�.(�������� ������.)
     */
    $CST_PLATFORM   = $HTTP_POST_VARS["CST_PLATFORM"];
    $CST_MID        = $HTTP_POST_VARS["CST_MID"]; // 't'�� �߰����� ���� ���Կ�û�� ���̵� �Է¹ٶ��ϴ�.
    $LGD_MID        = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
    
    if( $CST_PLATFORM == null || $CST_PLATFORM == "" ) {
        echo "[TX_PING error] �Ķ���� ����<br>";
        return;
    }
    if( $LGD_MID == null || $LGD_MID == "" ) {
        echo "[TX_PING error] �Ķ���� ����<br>";
        return;
    }

    require_once("./XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM);
    $xpay->Init_TX($LGD_MID);

    $xpay->Set("LGD_TXNAME", "Ping");
    $xpay->Set("LGD_RESULTCNT", "3");

    if ($xpay->TX()) {
        echo "response code = " . $xpay->Response_Code() . "<br>";
        echo "response msg = " . $xpay->Response_Msg() . "<br>";
        echo "response count = " . $xpay->Response_Count() . "<p>";

        $keys = $xpay->Response_Names();
        for ($i = 0; $i < $xpay->Response_Count(); $i++) {
            echo "count = " . $i . "<br>";
            foreach($keys as $name) {
                echo $name . " = " . $xpay->Response($name, $i) . "<br>";
            }
        }
    }
    else {
        echo "[TX_PING error] <br>";
        echo "response code = " . $xpay->Response_Code() . "<br>";
        echo "response msg = " . $xpay->Response_Msg() . "<p>";
    }
?>
