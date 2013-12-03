<?php
require_once ('getConnection.php');
$stmt = $connect -> stmt_init();
$query = "SELECT u_id FROM t_university where u_name = ?";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($stmt -> bind_param("s", $_POST["university"]))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $stmt -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
	$uni = $row;
}
$stmt -> close();
if (empty($uni)) {
	unset($uni);
	$stmt = $connect -> stmt_init();
	$query = "INSERT INTO t_university(u_name) VALUES(?)";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("s", $_POST["university"]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	$stmt -> close();

	$stmt = $connect -> stmt_init();
	$query = "SELECT u_id FROM t_university where u_name = ?";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("s", $_POST["university"]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
		$uni = $row;
	}
}

$stmt = $connect -> stmt_init();
$query = "SELECT c_id FROM t_course where c_name = ?";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($stmt -> bind_param("s", $_POST["course_name"]))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $stmt -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
	$course = $row;
}

if (empty($course)) {
	unset($course);
	$token = substr($_POST['course_name'], 0, 2);
	$stmt = $connect -> stmt_init();
	$query = "INSERT INTO t_course(c_name,c_credits,c_university, c_token) VALUES(?,?,?,?)";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("ssds", $_POST["course_name"], $_POST['cp'], $uni['u_id'], $token))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	$stmt -> close();

	$stmt = $connect -> stmt_init();
	$query = "SELECT c_id FROM t_course where c_name = ?";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("s", $_POST["course_name"]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
		$course = $row;
	}

}

$stmt = $connect -> stmt_init();
$query = "INSERT INTO t_prof_course(c_id,p_id) VALUES(?,?)";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($stmt -> bind_param("dd", $course['c_id'], $_POST['prof']))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
$stmt -> close();

$stmt = $connect -> stmt_init();
$query = "SELECT p_title, p_forname, p_lastname FROM t_prof where p_id = ?";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($stmt -> bind_param("d", $_POST["prof"]))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $stmt -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
	$prof = $row;
}

echo "<h1>added Course</h1>";
echo "\n";
echo '<p>' . $_POST['university'] . ' ' . $_POST['course_name'] . ' ' . $_POST['cp'] . ' CP';
echo "\n";
echo "<h2> for Prof</h2>";
echo "\n";
echo '<p>' . $prof['p_title'] . ' ' . $prof['p_forname'] . ' ' . $prof['p_lastname'] . '</p>';
echo "\n";
echo '<a href="admin_course.html"><img src="../images/buttons/button_submit.jpg" alt="back" id="button" width = 300 height = 200/></a>';
echo "\n";
?>