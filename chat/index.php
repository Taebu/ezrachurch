<?php
$output=null;
$retval=null;
exec('java E:\\xampp\\htdocs\\chat\\UDPServer', $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);


$output = shell_exec('java E:\\xampp\\htdocs\\chat\\UDPServer');
echo "<pre>";
echo $output
echo "</pre>";