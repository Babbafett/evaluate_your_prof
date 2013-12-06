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
	if (isset($_POST['add_prof_y']) == FALSE and isset($_POST['add_prof_x']) == FALSE) {
		if ($_SESSION['Login'] == 1) {
			echo "<h1>Add Prof</h1>";
			echo "\n";
			echo '<form name="add_prof" action="admin_prof.html" method="POST">';
			echo "\n";
			echo "<h2>title</h2>";
			echo "\n";
			echo '<select name="title" size="1" style="width: 215px">';
			echo "\n";
			echo '<option>Prof.</option>';
			echo "\n";
			echo '<option>Prof.Dr.</option>';
			echo "\n";
			echo '<option>Prof.Dr.rer.</option>';
			echo "\n";
			echo '<option>Prof.Dr.rer.nat.</option>';
			echo "\n";
			echo '<option>Prof.Dr.med.</option>';
			echo "\n";
			echo '<option>Prof.Dr.med.nat.</option>';
			echo "\n";
			echo '<option>Prof.Dr.ing.</option>';
			echo "\n";
			echo '<option>Prof.ing.nat.</option>';
			echo "\n";
			echo "</select>";
			echo "\n";
			echo "<h2>forename</h2>";
			echo "\n";
			echo '<input required name="forname" type="text" size="30" maxlength="30">';
			echo "\n";
			echo "<h2>lastname</h2>";
			echo "\n";
			echo '<input required name="lastname" type="text" size="30" maxlength="30">';
			echo "\n";
			echo '<input type="image" name="add_prof" src="../images/buttons/button_add.jpg" alt="submit" id="button" width="250" height="100">';
			echo "\n";
			echo '</form>';
			echo "\n";

		}
	} else {
		if ($_SESSION['Login'] == 1) {
			require_once ('addProf.php');
		}
	}

} else {
	echo '<p id="login">please Login on Admin Site first</p>';
}
?>