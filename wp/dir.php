<?php
$row = exec('dir ',$output,$error);
while(list(,$row) = each($output)){

$row=iconv("EUC-KR", "UTF-8", $row);
echo $row."<BR>";
}
