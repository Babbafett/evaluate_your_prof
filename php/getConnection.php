<?php
$connect = new mysqli('localhost', 'root', 's', 'db_evaluate_your_prof');
if ($connect -> connect_errno) {
	echo "Failed to connect to MySQL: " . $connect -> connect_error;
}
?>