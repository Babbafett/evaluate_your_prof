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
		if (!empty($auth)) {
			$password = $auth['a_password'];
			if ($password == hash('sha256', $_POST['password'])) {
				$_SESSION['Login'] = 1;
			}
		}
	}
}
if (isset($_SESSION['Login'])) {
	if ($_SESSION['Login'] == 1) {
		require_once("../php/logout.php");
		echo '<a class = "button" href="admin_tan.html"><img src="../images/buttons/button_tan.jpg" alt="tan_generate" id="button" width = 300 height = 150/></a>';
		echo "\n";
		echo '<a class = "button" href="admin_prof.html"><img src="../images/buttons/button_add_prof.jpg" alt="admin_prof" id="button" width = 300 height = 150/></a>';
		echo "\n";
		echo '<a class = "button" href="admin_course.html"><img src="../images/buttons/button_add_course.jpg" alt="admin_course" id="button" width = 300 height = 150/></a>';
		echo "\n";
		echo '<form id="login" action="admin.html" method="POST">';
		echo "\n";
		echo '<input type="image" name="logout" src="../images/buttons/button_logout.jpg" alt="submit" id="button" width="250" height="100">';
		echo "\n";
		echo "</form>";
	} else {

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
	echo '<input type="image" name="login" id="login" src="../images/buttons/button_login.jpg" alt="submit" id="button" width="250" height="100">';
	echo "\n";
	echo "</form>";
}
?>