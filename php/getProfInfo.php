<?php
if (isset($_GET["prof"])) {
	require_once ('getConnection.php');
	$stmt = $connect -> stmt_init();
	$query = 'SELECT e_prof, AVG(e_hot) AS hot, AVG(e_overall) AS overall, AVG(e_contentual) AS contentual,AVG(e_competence) AS competence,AVG(e_eloquence) AS eloquence,AVG(e_motivation_prof) AS motivation_prof,AVG(e_motivation_before) AS motivation_before,AVG(e_motivation_after) AS motivation_after, AVG(e_test_requirement) AS test_requirements, AVG(e_media_usage) AS media_usage,AVG(e_soft_skills) AS soft_skills,( (avg(e_overall) + avg(e_contentual) + avg(e_competence) + avg(e_eloquence) + avg(e_motivation_prof) + avg(e_test_requirement) + avg(e_media_usage) + avg(e_soft_skills))/8) as overall_all FROM t_evaluation WHERE e_prof = ? GROUP BY e_prof';
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
	if (!empty($prof)) {

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
		echo 'scaleSteps : 7,';
		echo "\n";
		echo 'scaleStepWidth : 1,';
		echo "\n";
		echo 'scaleStartValue : 0';
		echo "\n";
		echo '};';
		echo "\n";
		echo 'var chart = new Chart(ctx).Radar(data,options);';
		echo "\n";
		getGradeImage($prof['overall_all']);
		echo '</script>';
		echo "\n";
	} else {
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
		echo 'data : [0,0,0,0,0,0,0,0,0]';
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
		echo 'scaleSteps : 7,';
		echo "\n";
		echo 'scaleStepWidth : 1,';
		echo "\n";
		echo 'scaleStartValue : 0';
		echo "\n";
		echo '};';
		echo "\n";
		echo 'var chart = new Chart(ctx).Radar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
	}
	unset($prof);
	$stmt = $connect -> stmt_init();
	$query = 'SELECT count(e_id) as count FROM t_evaluation where e_prof = ?';
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

	$count = $prof['count'];

	echo '<p> Ratings in Total:</p>';
	echo "\n";
	echo '<p>' . $count . '</p>';
	echo "\n";
	echo '<br></br>';
	echo "\n";

	unset($prof);
	$stmt = $connect -> stmt_init();
	$query = 'SELECT p_id ,p_lastname, p_forname, p_title FROM t_prof WHERE p_id = ?';
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
		$prof[] = $row;
	}
	$stmt -> close();

	echo '<h1>' . $prof[0]['p_title'] . ' ' . $prof[0]['p_forname'] . ' ' . $prof[0]['p_lastname'] . '</h1>';
	echo "\n";

	$stmt = $connect -> stmt_init();
	$query = 'SELECT t_prof.p_id as prof_id, t_course.c_id as course_id, u_id,  p_lastname, p_forname, p_title, c_name,  c_credits, u_name  FROM t_prof INNER JOIN t_prof_course ON t_prof.p_id = t_prof_course.p_id INNER JOIN t_course ON t_prof_course.c_id = t_course.c_id INNER JOIN t_university ON c_university = u_id WHERE t_prof.p_id = ?';
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
		$course[] = $row;
	}
	$stmt -> close();
	if (!empty($course)) {
		echo '<h3> Courses </h3>';
		echo "\n";
		echo '<ul class="course">';
		echo "\n";
		$count_course = 0;
		foreach ($course as $p) {
			$count_course++;
			echo "<li><a href='rate.html?course=" . $p["course_id"] . "&prof=" . $p["prof_id"] . "&university=" . $p["u_id"] . "'>" . $p['u_name'].' '.$p['c_name'].' '.$p['c_credits']. ' CP' . "</a></li>";
		}
		$count_course = 1560 + ($count_course * 40);
		echo "\n";
		echo '</ul>';
		echo "\n";
		
		$random = rand(0, ($count - 1));
		unset($prof);
		unset($prof_list);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT e_comment_positive FROM t_evaluation WHERE e_prof = ?';
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
		while ($row = $result -> fetch_assoc()) {
			$prof[] = $row['e_comment_positive'];
		}
		$stmt -> close();
		if (!empty($prof)) {
			echo '<h3> random positive Comment </h3>';
			echo "\n";
			echo '<ul class="comment">';
			echo "\n";
		for ($i=0; $i <= $random ; $i++) {
			$prof_list = $prof[$i];
		}
		echo '<li><p>' . $prof_list . "</p></li>";
		echo "\n";
		echo "</ul>";

		echo '<h3> random negative Comment </h3>';
		echo "\n";
		echo '<ul class="comment">';
		echo "\n";
		$random = rand(0, ($count - 1));
		unset($prof);
		unset($prof_list);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT e_comment_negative FROM t_evaluation WHERE e_prof = ?';
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
		while ($row = $result -> fetch_assoc()) {
			$prof[] = $row['e_comment_negative'];
		}
		$stmt -> close();
		for ($i=0; $i <= $random ; $i++) { 
			$prof_list = $prof[$i];
		}
		echo '<li><p>' . $prof_list . "</p></li>";
		echo "\n";
		echo "</ul>";

		echo '<h3> random Comment </h3>';
		echo "\n";
		echo '<ul class="comment">';
		echo "\n";
		$random = rand(0, ($count - 1));
		unset($prof);
		unset($prof_list);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT e_comment FROM t_evaluation WHERE e_prof = ?';
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
		while ($row = $result -> fetch_assoc()) {
			$prof[] = $row['e_comment'];
		}
		$stmt -> close();
		for ($i=0; $i <= $random ; $i++) { 
			$prof_list = $prof[$i];
		}
			
		echo '<li><p>' . $prof_list . "</p></li>";
		echo "\n";
		echo "</ul>";
		}
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'if ($( ".wrapper-main" ).height() <= ' . $count_course . ') {';
		echo "\n";
		echo '$( ".wrapper-main" ).height("' . $count_course . 'px");';
		echo "\n";
		echo "}";
		echo "else{";
		echo "\n";
		echo '$( ".wrapper-main" ).height("1600px");';
		echo "\n";
		echo "}";
		echo "\n";
		echo '</script>';
	}
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