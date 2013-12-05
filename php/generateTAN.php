<?php
require_once ('getConnection.php');
$stmt = $connect -> stmt_init();
$query = "SELECT c_token FROM t_course WHERE c_id = ?";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($stmt -> bind_param("d", $_POST["course"]))) {
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

$stmt = $connect -> stmt_init();
$query = "SELECT p_token FROM t_prof WHERE p_id = ?";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($stmt -> bind_param("d", $_POST['prof']))) {
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

for ($i = 1; $i <= $_POST['count_tan']; $i++) {
	do {
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
		$tan_pruef = generate($prof_token, $course_token);
		if (!empty($generated_tans)) {
			$pruef = in_array($tan_pruef, $generated_tans);
		} else {
			$pruef = false;
		}
	} while ($pruef);
	$tan[] = $tan_pruef;
}
echo "<h1>generated TANs</h1>";
echo "\n";
foreach ($tan as $t) {
	$stmt = $connect -> stmt_init();
	$query = "INSERT into t_tan(t_course, t_prof,t_tan) VALUES(?,?,?)";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("dds", $_POST['course'], $_POST['prof'], $t))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	$stmt -> close();
	echo '<p>' . $t . '</p>';
	echo "\n";

}
unset($_POST);
echo '<a href="admin_tan.html"><img src="../images/buttons/button_back.jpg" alt="back" id="button" width = 300 height = 150/></a>';
echo "\n";

mysqli_close($connect);

function generate($token1, $token2) {
	$token = rand(100000, 999999);
	$TAN = $token1 . $token . $token2;
	return $TAN;
};
?>