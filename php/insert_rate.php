<?php
if(isset($_POST['insert_rate_y'])==TRUE and isset($_POST['insert_rate_x'])==TRUE) {
	session_start();
$connect=new mysqli('localhost','root','6g33SeYtEX','db_evaluate_your_prof');
if($connect->connect_errno) {
echo "Failed to connect to MySQL: ".$connect->connect_error;
}
$query="SELECT t_tan FROM t_tan WHERE t_prof = ? AND t_course = ?";
$stmt=$connect->stmt_init();
if(!($stmt->prepare($query))) {
echo "Prepare failed: ".$connect->errno.$connect->error;
}
if(!($stmt->bind_param("dd",$_SESSION["prof"],$_SESSION["course"]))) {
echo "Bind failed: ".$connect->errno.$connect->error;
}
if(!$stmt->execute()) {
echo "Execute failed: (".$connect->errno.") ".$connect->error;
}
if(!($result=$stmt->get_result())) {
echo "Result failed: (".$connect->errno.") ".$connect->error;
}
while($row=$result->fetch_array(MYSQLI_NUM)) {
$tan[]=$row[0];
}
$stmt->close();
$stmt=$connect->stmt_init();
$query="Insert into t_evaluation(e_course,e_prof,e_overall,e_contentual,e_competence,e_eloquence,e_motivation_prof,e_motivation_before,e_motivation_after,e_test_requirement,e_media_usage,e_soft_skills,e_hot,e_comment_positive,e_comment_negative,e_comment) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
if(in_array($_POST['TAN'],$tan)) {
if(!($stmt->prepare($query))) {
echo "Prepare failed: ".$connect->errno.$connect->error;
}
if(!($stmt->bind_param("iissssssssssssss",$_SESSION["course"],$_SESSION["prof"],$_POST['overall'],$_POST['contentual'],$_POST['competence'],$_POST['eloquence'],$_POST['motivation_prof'],$_POST['motivation_before'],$_POST['motivation_after'],$_POST['test_requirements'],$_POST['media_usage'],$_POST['soft_skills'],$_POST['hot'],$_POST['comment_positive'],$_POST['comment_negative'],$_POST['comment']))) {
echo "Bind failed: ".$connect->errno.$connect->error;
}
if(!$stmt->execute()) {
echo "Execute failed: (".$connect->errno.") ".$connect->error;
}
$_SESSION["Insert"] = "1";
$stmt->close();
header("Location: ../html/forward.html");
} else {
$_SESSION["Insert"] = "0";
header("Location: ../html/rate.html?course=".$_SESSION["course"]."&prof=".$_SESSION["prof"]."&university=".$_SESSION["university"]);
}

}

?>
