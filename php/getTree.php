<?php
$connect = new mysqli('localhost', 'root', '', 'db_evaluate_your_prof');
$stmt = $connect -> stmt_init();
$query = "SELECT p_id, p_lastname, p_forname, p_title FROM t_prof";
if ($connect -> connect_errno)
	echo "Failed to connect to MySQL: " . $connect -> connect_error;
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $stmt -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
	$prof[] = $row;
}
$stmt -> close();
echo "<ul>";
echo "\n";
$query = "SELECT t_course.c_id, c_name, c_university, u_name, c_credits FROM t_course INNER JOIN t_prof_course ON t_prof_course.c_id = t_course.c_id INNER JOIN t_university ON c_university = u_id WHERE p_id = ? ";
$stmt = $connect -> stmt_init();
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
foreach ($prof as $p) {
	echo "<li>" . $p["p_title"] . " " . $p["p_forname"] . " " . $p["p_lastname"];
	echo "\n";
	if (!($stmt -> bind_param("d", $p["p_id"]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
		$course[] = $row;
	}
	echo "<ul>";
	echo "\n";
	foreach ($course as $c) {
		echo "<li><a href='rate.html?course=" . $c["c_id"] . "&prof=" . $p["p_id"] . "&university=" . $c["c_university"] . "'>" . $c["u_name"] . " " . $c["c_name"] . " " . $c["c_credits"] . " CP" . "</a></li>";
		echo "\n";
	}
	echo "</ul>";
	echo "\n";
}
$stmt -> close();
echo "</li>";
echo "\n";
echo "</ul>";
echo "\n";
?>