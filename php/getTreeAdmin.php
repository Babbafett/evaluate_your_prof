<?php
require_once ('getConnection.php');
$stmt = $connect -> stmt_init();
$query = "SELECT p_id, p_lastname, p_forname, p_title FROM t_prof";
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
echo "<h1>Navigate your Course</h1>";
echo "\n";
echo '<ul class = "rate_1">';
echo "\n";
$query = "SELECT t_course.c_id, c_name, c_university, u_name, c_credits FROM t_course INNER JOIN t_prof_course ON t_prof_course.c_id = t_course.c_id INNER JOIN t_university ON c_university = u_id WHERE p_id = ? ";
$stmt = $connect -> stmt_init();
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
foreach ($prof as $p) {
	unset($course);
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
	$count = 0;
	if (!empty($course)) {
		$count++;
		echo "<li><h2>" . $p["p_title"] . " " . $p["p_forname"] . " " . $p["p_lastname"] . '</h2>';
		echo "\n";
		echo '<ul class = "rate_2">';
		echo "\n";
		foreach ($course as $c) {
			$count++;
			echo "<li><a href='admin_tan.html?course=" . $c["c_id"] . "&prof=" . $p["p_id"] . "&university=" . $c["c_university"] . "'>" . $c["u_name"] . " " . $c["c_name"] . " " . $c["c_credits"] . " CP" . "</a></li>";
			echo "\n";
		}
		echo "</ul>";
		echo "\n";
		echo "</li>";
		echo "\n";
	}
}
$count = 140 + ($count * 45);
$stmt -> close();
echo "</li>";
echo "\n";

echo "</ul>";
echo "\n";
echo '<script type="text/javascript">';
echo "\n";
echo 'if ($( ".wrapper-main" ).height() <= ' . $count . ') {';
echo "\n";
$count += 50;
echo '$( ".wrapper-main" ).height("' . $count . 'px");';
echo "\n";
echo "}";
echo "else{";
echo "\n";
echo '$( ".wrapper-main" ).height("70%");';
echo "\n";
echo "}";
echo "\n";
echo '</script>';
?>