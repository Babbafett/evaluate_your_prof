<?php
session_start();
unset($_SESSION["prof"]);
unset($_SESSION["course"]);
unset($_SESSION["university"]);
if (isset($_GET["course"]) == TRUE and isset($_GET["prof"]) == TRUE and isset($_GET["university"]) == TRUE) {
	$_SESSION["prof"] = $_GET["prof"];
	$_SESSION["course"] = $_GET["course"];
	$_SESSION["university"] = $_GET["university"];
	if (isset($_SESSION["Insert"])) {
		if ($_SESSION["Insert"] == 0) {
			unset($_SESSION['Insert']);
			echo "<script type =text/javascript> alert('TAN was already used or wrong TAN, please use a right TAN'); </script>";
		}
	}
	require_once ('getConnection.php');
	$stmt = $connect -> stmt_init();
	$query = "SELECT c_name,c_credits,u_name,p_lastname,p_forname,p_title FROM t_prof INNER JOIN t_prof_course ON t_prof.p_id = t_prof_course.p_id INNER JOIN t_course ON t_prof_course.c_id = t_course.c_id INNER JOIN t_university ON c_university = u_id WHERE t_prof.p_id = ? AND t_course.c_id = ? AND u_id = ?";
	if (!($stmt -> prepare($query))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($stmt -> bind_param("ddd", $_GET["prof"], $_GET["course"], $_GET["university"]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$stmt -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	if (!($result = $stmt -> get_result())) {
		echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
	}
	while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
		$header = $row;
	}
	$stmt -> close();
	echo "<h1 name ='prof_name'>" . $header["p_title"] . " " . $header["p_forname"] . " " . $header["p_lastname"] . "</h1>";
	echo "\n";
	echo "<h2 name ='courses'>" . $header["u_name"] . " " . $header["c_name"] . " " . $header["c_credits"] . ' CP' . "</h2>";
}
?>