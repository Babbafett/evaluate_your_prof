<?php

if (isset($_POST['insert_rate'])) {
	$connect = new mysqli('localhost', 'root', '', 'db_evaluate_your_prof');
	if ($connect -> connect_errno)
		echo "Failed to connect to MySQL: " . $connect -> connect_error;
}
$course = $_POST[course];
$prof = explode(" ", $_POST[prof]);
$forname = $prof[0];
$lastname = $prof[1];

if (!($query = $connect -> prepare("SELECT t_tan FROM t_tan INNER JOIN t_prof ON p_id = t_prof INNER JOIN t_course ON c_id = t_course WHERE p_forname = ? AND p_lastname = ? AND c_name = ?"))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($query -> bind_param("sss", $forname, $lastname, $course))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$query -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $query -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_NUM)) {
	foreach ($row as $r) {
		$tan[] = $r;
	}
}

if (!($query = $connect -> prepare("SELECT p_id FROM t_prof WHERE p_forname = ? AND p_lastname = ?"))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($query -> bind_param("ss", $forname, $lastname))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$query -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $query -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_NUM)) {
	foreach ($row as $r) {
		$prof_id = $r;
	}
}

if (!($query = $connect -> prepare("SELECT c_id FROM t_course WHERE c_name = ?"))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!($query -> bind_param("s", $course))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$query -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $query -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_NUM)) {
	foreach ($row as $r) {
		$course_id = $r;
	}
}

if (in_array($_POST[TAN], $tan)) {
	if (!($query = $connect -> prepare("INSERT into t_evaluation(e_course, e_prof, e_overall, e_contentual,e_competence, e_eloquence, e_motivation_prof, e_motivation_before, e_motivation_after, e_test_requirements, e_media_usage, e_soft_skills, e_hot, e_comment_positive, e_comment_negative, e_comment) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"))) {
		echo "Prepare failed: " . $connect -> errno . $connect -> error;
	}
	if (!($query -> bind_param("ssssssssssssssss", $course_id, $prof_id, $_POST[overall], $_POST[contentual], $_POST[competence], $_POST[eloquence], $_POST[motivation_prof], $_POST[motivation_before], $_POST[motivation_after], $_POST[test_requirements], $_POST[media_usage], $_POST[soft_skills], $_POST[hot], $_POST[comment_positive], $_POST[comment_negative], $_POST[comment]))) {
		echo "Bind failed: " . $connect -> errno . $connect -> error;
	}
	if (!$query -> execute()) {
		echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
	}
} else {
	echo "TAN Eingabe falsch";
}
?>