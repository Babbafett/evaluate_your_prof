<?php
require_once ('getConnection.php');
$stmt = $connect -> stmt_init();
$query = "INSERT into t_prof(p_title,p_forname,p_lastname,p_token) VALUES(?,?,?,?)";
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}

$token_part_one = substr($_POST['forname'], 0, 1);
$token_part_two = substr($_POST['lastname'], 0, 1);
$token = $token_part_one . $token_part_two;

if (!($stmt -> bind_param("ssss", $_POST["title"], $_POST["forname"], $_POST["lastname"], $token))) {
	echo "Bind failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
$stmt -> close();
echo "<h1>added Prof</h1>";
echo "\n";
echo '<p>' . $_POST['title'] . ' ' . $_POST['forname'] . ' ' . $_POST['lastname'] . '</p>';
echo "\n";
echo '<a href="admin_prof.html"><img src="../images/buttons/button_submit.jpg" alt="back" id="button" width = 300 height = 200/></a>';
echo "\n";
?>