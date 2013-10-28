<?php
if (isset($_POST['generate_tan'])) {
	$connect = new mysqli('localhost', 'root', '', 'db_evaluate_your_prof');
	if ($connect -> connect_errno) {
		echo "Failed to connect to MySQL: " . $connect -> connect_error;
	}
	$stmt = $connect -> stmt_init();
	$query = "SELECT c_token FROM t_course WHERE c_name = ?";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("s", $_POST["course"]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_NUM)) {
		$course_token = $row[0];
	}
	$stmt -> close();
	$prof = explode(" ", $_POST[prof]);
	$forname = $prof[0];
	$lastname = $prof[1];
	$stmt = $connect -> stmt_init();
	$query = "SELECT p_token FROM t_prof WHERE p_forname = ? AND p_lastname = ?";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("ss", $forname, $lastname))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_NUM)) {
		$prof_token = $row[0];
	}
	$stmt -> close();
	$stmt = $connect -> stmt_init();
	$query = "SELECT t_tan FROM t_tan";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_NUM)) {
		$generated_tans[] = $row[0];
	}
	$stmt -> close();
	do {
		$TAN = generate($prof_token, $course_token);
		$pruef = in_array($TAN, $generated_tans);
	} while ($pruef);
	mysqli_close($connect);
	function generate($token1, $token2) {
		$token = rand(100000, 999999);
		$TAN = $token1 . $token . $token2;
		return $TAN;
	};
}
?>