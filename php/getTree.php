<?php
if (isset($_GET['view'])) {
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
	if ($_GET['view'] == 'rate') {
		echo '<ul class = "rate_1">';
		echo "\n";
		$query = "SELECT t_course.c_id, c_name, c_university, u_name, c_credits FROM t_course INNER JOIN t_prof_course ON t_prof_course.c_id = t_course.c_id INNER JOIN t_university ON c_university = u_id WHERE p_id = ? ";
		$stmt = $connect -> stmt_init();
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		foreach ($prof as $p) {
			unset($course);
			echo "<li>" . $p["p_title"] . " " . $p["p_forname"] . " " . $p["p_lastname"];
			echo "\n";
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
			echo '<ul class = "rate_2">';
			echo "\n";
			foreach ($course as $c) {
				echo "<li><a href='rate.html?course=" . $c["c_id"] . "&prof=" . $p["p_id"] . "&university=" . $c["c_university"] . "'>" . $c["u_name"] . " " . $c["c_name"] . " " . $c["c_credits"] . " CP" . "</a></li>";
				echo "\n";
			}
			echo "</ul>";
			echo "\n";
			echo "</li>";
			echo "\n";
		}
		$stmt -> close();
		echo "</li>";
		echo "\n";
	} elseif ($_GET['view'] == 'prof') {
		echo '<ul class = "prof">';
		echo "\n";
		foreach ($prof as $p) {
			echo "<li class='test'><a href='prof.html?prof=" . $p["p_id"] . "'>" . $p["p_title"] . " " . $p["p_forname"] . " " . $p["p_lastname"] . "</a></li>";
		}
	}
	echo "</ul>";
	echo "\n";
	if ($_GET['view'] == 'rate') {
		echo '<script type="text/javascript">';
		echo "\n";
		echo '$("link[rel=stylesheet]").attr({href: "../css/style_overview_rate.css"});';
		echo "\n";
		echo '</script>';
	} elseif ($_GET['view'] == 'prof') {
		echo '<script type="text/javascript">';
		echo "\n";
		echo '$("link[rel=stylesheet]").attr({href: "../css/style_overview_prof.css"});';
		echo "\n";
		echo '</script>';
	}
}
?>