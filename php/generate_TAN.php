<?php
if (isset($_POST['generate_tan'])) {
	$connect = mysqli_connect('localhost', 'root', '', 'db_evaluate_your_prof');
	if (mysqli_connect_errno($connect)) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$query = "SELECT c_token FROM t_course WHERE c_name = '$_POST[course]'";
	$result = mysqli_query($connect, $query);
	if (!$result) {
		printf("Error: %s\n", mysqli_error($connect));
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$course_token = $row['c_token'];
		}
	}
	mysqli_free_result($result);

	$prof = explode(" ", $_POST[prof]);
	$forname = $prof[0];
	$lastname = $prof[1];

	$query = "SELECT p_token FROM t_prof WHERE p_forname = '$forname' AND p_lastname = '$lastname'";
	$result = mysqli_query($connect, $query);
	if (!$result) {
		printf("Error: %s\n", mysqli_error($connect));
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$prof_token = $row['p_token'];
		}
	}
	mysqli_free_result($result);

	$query = "SELECT t_tan FROM t_tan";
	$result = mysqli_query($connect, $query);
	if (!$result) {
		printf("Error: %s\n", mysqli_error($connect));
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$generated_tans[] = $row['t_tan'];
		}
	}
	mysqli_free_result($result);

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