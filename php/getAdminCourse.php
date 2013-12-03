<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_POST)) {
	if (isset($_POST["password"])) {
		require_once ('getConnectionAuth.php');
		$stmt = $connect -> stmt_init();
		$query = "SELECT a_password FROM t_auth where a_username = ?";
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!($stmt -> bind_param("s", $_POST["password"]))) {
			echo "Bind failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
			$auth = $row;
		}
		$stmt -> close();
		$password = $auth['a_password'];
		if ($password == hash('sha256', $_POST['password'])) {
			$_SESSION['Login'] = 1;
		}
	}

}
if (isset($_SESSION['Login'])) {
	if (isset($_POST['add_course_y']) == FALSE and isset($_POST['add_course_x']) == FALSE) {
		if ($_SESSION['Login'] == 1) {
			require_once ('getConnection.php');
			$stmt = $connect -> stmt_init();
			$query = "SELECT p_id, p_title, p_forname, p_lastname FROM t_prof ";
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
			echo "<h1>Add Course</h1>";
			echo "\n";
			echo '<form name="add_prof" action="admin_course.html" method="POST">';
			echo "\n";
			echo "<h2>title</h2>";
			echo "\n";
			echo '<select name="prof" size="1" style="width: 215px">';
			echo "\n";
			foreach ($prof as $p) {
				echo '<option value ="' . $p['p_id'] . '">' . $p['p_title'] . ' ' . $p['p_forname'] . ' ' . $p['p_lastname'] . '</option>';
				echo "\n";
			}
			echo "</select>";
			echo "\n";
			echo "<h2>course name</h2>";
			echo "\n";
			echo '<input required name="course_name" type="text" size="30" maxlength="30">';
			echo "\n";
			echo "<h2>university</h2>";
			echo "\n";
			echo '<input required name="university" type="text" size="30" maxlength="30">';
			echo "\n";
			echo "<h2>Credit Points</h2>";
			echo "\n";
			echo '<input required name="cp" type="number" size="30" maxlength="2">';
			echo "\n";
			echo '<input type="image" name="add_course" src="../images/buttons/button_submit.jpg" alt="submit" id="button" width="250" height="150">';
			echo "\n";
			echo '</form>';
			echo "\n";

		}
	} else {
		if ($_SESSION['Login'] == 1) {
			require_once ('addCourse.php');
		}
	}

} else {
	echo '<form id="login" action="admin.html" method="POST">';
	echo "\n";
	echo "<p>Username:</p>";
	echo "\n";
	echo '<input name="username" type="text" size="30" maxlength="30">';
	echo "\n";
	echo "<p>Password:</p>";
	echo "\n";
	echo '<input name="password" type="password" size="30" maxlength="30">';
	echo "\n";
	echo '<input type="image" name="insert_rate" src="../images/buttons/button_submit.jpg" alt="submit" id="button" width="250" height="150">';
	echo "\n";
	echo "</form>";
}
?>