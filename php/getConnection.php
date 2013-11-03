<?php
$connect = new mysqli('localhost', 'root', '6g33SeYtEX', 'db_evaluate_your_prof');
if ($connect -> connect_errno) {
	echo "Failed to connect to MySQL: " . $connect -> connect_error;
}
?>