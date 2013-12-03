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
	if (isset($_POST['generate_tan_y']) == FALSE and isset($_POST['generate_tan_x']) == FALSE) {
		if (isset($_GET['course']) && isset($_GET['prof'])) {
			if ($_SESSION['Login'] == 1) {
				require_once ('getConnection.php');
				$stmt = $connect -> stmt_init();
				$query = "SELECT p_id, p_forname, p_lastname, p_title FROM t_prof where p_id = ?";
				if (!($stmt -> prepare($query))) {
					echo "Prepare failed: " . $connect -> errno . $connect -> error;
				}
				if (!($stmt -> bind_param("d", $_GET["prof"]))) {
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
				$stmt -> close();
				echo "<h1>TAN generate</h1>";
				echo "\n";
				echo '<form name="generateTAN" action="admin_tan.html" method="POST">';
				echo "\n";

				echo "<h2>" . $prof['p_title'] . ' ' . $prof['p_forname'] . ' ' . $prof['p_lastname'] . "</h2>";
				echo "\n";
				echo '<input type = "hidden" name = "prof" value = "' . $_GET['prof'] . '">';
				echo "\n";
				$stmt = $connect -> stmt_init();
				$query = "SELECT t_course.c_id, c_name, c_university, u_name, c_credits FROM t_course INNER JOIN t_prof_course ON t_prof_course.c_id = t_course.c_id INNER JOIN t_university ON c_university = u_id WHERE p_id = ? AND t_course.c_id = ? ";
				if (!($stmt -> prepare($query))) {
					echo "Prepare failed: " . $connect -> errno . $connect -> error;
				}
				if (!($stmt -> bind_param("dd", $_GET["prof"], $_GET["course"]))) {
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
				$stmt -> close();

				echo "<h2>" . $course['u_name'] . ' ' . $course['c_name'] . ' ' . $course['c_credits'] . ' CP' . "</h2>";
				echo "\n";
				echo '<input type = "hidden" name = "course" value = "' . $_GET['course'] . '">';
				echo "\n";
				echo "<h2>Count TANs:</h2>";
				echo "\n";
				echo '<input required name="count_tan" type="number" size="2" maxlength="2">';
				echo "\n";
				echo "<br>";
				echo "\n";
				echo '<label>';
				echo "\n";
				echo '<input type="image" name="generate_tan" src="../images/buttons/button_submit.jpg" alt="submit" id="button" width="250" height="150">';
				echo "\n";
				echo '</label>';
				echo "\n";
				echo '</form>';
				echo "\n";

			} else {

			}
		} else {
			require_once ('../php/getTreeAdmin.php');
		}
	} else {
		require_once ('../php/generateTAN.php');
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