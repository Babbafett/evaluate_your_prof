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
		if ($_POST['password'] == $auth['a_password']) {
			session_start();
			$_SESSION['Login'] = 1;

		}
	}

}
if (isset($_SESSION['Login'])) {
	if ($_SESSION['Login'] == 1) {
		require_once ('getConnection.php');
		$stmt = $connect -> stmt_init();
		$query = "SELECT p_forname, p_lastname, p_title FROM t_prof";
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
		echo '<form name="generateTAN" action="../php/generateTAN.php" method="POST">';
		echo "\n";

		echo "<p>Dozent</p>";
		echo "\n";
		echo '<select name="prof" size="1" style="width: 215px">';
		foreach ($prof as $p) {
			echo '<option>' . $p['p_title'] . ' ' . $p['p_forname'] . ' ' . $p['p_lastname'] . '</option>';
		}
		echo "</select>";
		echo "\n";
		echo "<br>";
		echo "\n";
		echo "<p>Course</p>";
		echo "\n";

		echo '<select name="couse" size="1" style="width: 215px">';
		echo "\n";
		echo '<option>Projektmanagement 2</option>';
		echo "\n";
		echo '<option>Internet Basistechnologien</option>';
		echo "\n";
		echo '</select>';
		echo "\n";
		echo "<br>";
		echo "\n";
		echo "<p>Count TANs</p>";
		echo "\n";
		echo '<input name="tans" type="text" size="30" maxlength="3">';
		echo "\n";
		echo "<br>";
		echo "\n";
		echo '<label>';
		echo "\n";
		echo '<input type="image" name="insert_rate" src="../images/buttons/button_submit.jpg" alt="submit" id="button" width="250" height="150">';
		echo "\n";
		echo '</label>';
		echo "\n";
		echo '</form>';
		echo "\n";
	} else {

	}
} else {
	echo '<form action="admin_tan.html" method="POST">';
	echo "\n";
	echo '<input name="username" type="text" size="30" maxlength="30">';
	echo "\n";
	echo '<input name="password" type="password" size="30" maxlength="30">';
	echo "\n";
	echo '<input type="image" name="insert_rate" src="../images/buttons/button_submit.jpg" alt="submit" id="button" width="250" height="150">';
	echo "\n";
	echo "</form>";
}
?>