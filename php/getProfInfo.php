<?php
if (isset($_GET["prof"])) {
	require_once ('getConnection.php');
	$stmt = $connect -> stmt_init();
	$query = 'SELECT e_prof, AVG(e_hot) AS hot, AVG(e_overall) AS overall, AVG(e_contentual) AS contentual,AVG(e_competence) AS competence,AVG(e_eloquence) AS eloquence,AVG(e_motivation_prof) AS motivation_prof,AVG(e_motivation_before) AS motivation_before,AVG(e_motivation_after) AS motivation_after, AVG(e_test_requirement) AS test_requirements, AVG(e_media_usage) AS media_usage,AVG(e_soft_skills) AS soft_skills FROM t_evaluation WHERE e_prof = ? GROUP BY e_prof';
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
	echo '<script type="text/javascript">';
	echo "\n";
	echo 'var data = {';
	echo "\n";
	echo 'labels : ["contentual","competence","eloquence","motivation prof", "motivation before","motivation after", "test requirements","media usage","soft skills"],';
	echo "\n";
	echo 'datasets : [';
	echo "\n";
	echo '{';
	echo "\n";
	echo 'fillColor : "rgba(151,187,205,0.5)",';
	echo "\n";
	echo 'strokeColor : "rgba(151,187,205,1)",';
	echo "\n";
	echo 'pointColor : "rgba(151,187,205,1)",';
	echo "\n";
	echo 'pointStrokeColor : "#fff",';
	echo "\n";
	echo 'data : [' . $prof['contentual'] . ',' . $prof['competence'] . ',' . $prof['eloquence'] . ',' . $prof['motivation_prof'] . ',' . $prof['motivation_before'] . ',' . $prof['motivation_after'] . ',' . $prof['test_requirements'] . ',' . $prof['media_usage'] . ',' . $prof['soft_skills'] . ']';
	echo "\n";
	echo '}';
	echo "\n";
	echo ']';
	echo "\n";
	echo '};';
	echo "\n";
	echo 'var ctx = $("#chart").get(0).getContext("2d");';
	echo "\n";
	echo 'var options = {';
	echo "\n";
	echo 'scaleOverride : true,';
	echo "\n";
	echo 'scaleSteps : 6,';
	echo "\n";
	echo 'scaleStepWidth : 1,';
	echo "\n";
	echo 'scaleStartValue : 1';
	echo "\n";
	echo '};';
	echo "\n";
	echo 'var chart = new Chart(ctx).Radar(data,options);';
	echo "\n";
	getGradeImage($prof['overall']);
	echo '</script>';
}

function getGradeImage($value) {
	if (($value <= 7) && ($value > 6.5)) {
		echo '$("#content_left_top").attr("src","../images/grades/a+_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/a+_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/a+_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/a+_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	} elseif (($value <= 6.5) && ($value > 5.5)) {
		echo '$("#content_left_top").attr("src","../images/grades/a_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/a_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/a_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/a_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	} elseif (($value <= 5.5) && ($value > 4.5)) {
		echo '$("#content_left_top").attr("src","../images/grades/b_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/b_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/b_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/b_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	} elseif (($value <= 4.5) && ($value > 3.5)) {
		echo '$("#content_left_top").attr("src","../images/grades/c_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/c_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/c_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/c_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	} elseif (($value <= 3.5) && ($value > 2.5)) {
		echo '$("#content_left_top").attr("src","../images/grades/d_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/d_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/d_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/d_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	} elseif (($value <= 2.5) && ($value > 1.5)) {
		echo '$("#content_left_top").attr("src","../images/grades/e_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/e_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/e_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/e_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	} elseif (($value <= 1.5) && ($value >= 1)) {
		echo '$("#content_left_top").attr("src","../images/grades/f_left.gif");';
		echo "\n";
		echo '$("#content_left_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_top").attr("src","../images/grades/f_right.gif");';
		echo "\n";
		echo '$("#content_right_top").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_left_bottom").attr("src","../images/grades/f_left.gif");';
		echo "\n";
		echo '$("#content_left_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
		echo '$("#content_right_bottom").attr("src","../images/grades/f_right.gif");';
		echo "\n";
		echo '$("#content_right_bottom").delay(1000).fadeIn(1500);';
		echo "\n";
	}
}
?>