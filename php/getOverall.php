<?php
require_once ('getConnection.php');
$stmt = $connect -> stmt_init();
$query = 'SELECT count(e_id) from t_evaluation';
if (!($stmt -> prepare($query))) {
	echo "Prepare failed: " . $connect -> errno . $connect -> error;
}
if (!$stmt -> execute()) {
	echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
}
if (!($result = $stmt -> get_result())) {
	echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
}
while ($row = $result -> fetch_array(MYSQLI_NUM)) {
	$count = $row;
}

if ($count[0] != 0) {
	$stmt -> close();
	$stmt = $connect -> stmt_init();
	$query = 'SELECT avg(e_overall) as overall, avg(e_contentual) as contentual,avg(e_competence) as competence, avg(e_eloquence) as eloquence, avg(e_motivation_prof) as motivation_prof, avg(e_test_requirement) as test_requirements, avg(e_hot) as hot, avg(e_soft_skills) as soft_skills, avg(e_media_usage) as media_usage,( (avg(e_overall) + avg(e_contentual) + avg(e_competence) + avg(e_eloquence) + avg(e_motivation_prof) + avg(e_test_requirement) + avg(e_media_usage) + avg(e_soft_skills))/8) as overall_all, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall_all desc limit 3';
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
	if (!empty($prof[0]) && !empty($prof[1]) && !empty($prof[2])) {
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["contentual","competence","eloquence","motivation prof", "test requirements","media usage","soft skills"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#69D2E7",';
		echo "\n";
		echo 'strokeColor : "rgba(151,187,205,1)",';
		echo "\n";
		echo 'pointColor : "rgba(151,187,205,1)",';
		echo "\n";
		echo 'pointStrokeColor : "#fff",';
		echo "\n";
		echo 'data : [' . $prof[0]['contentual'] . ',' . $prof[0]['competence'] . ',' . $prof[0]['eloquence'] . ',' . $prof[0]['motivation_prof'] . ',' . $prof[0]['test_requirements'] . ',' . $prof[0]['media_usage'] . ',' . $prof[0]['soft_skills'] . ']';
		echo "\n";
		echo '},';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#E0E4CC",';
		echo "\n";
		echo 'strokeColor : "#A4A795",';
		echo "\n";
		echo 'pointColor : "#A4A795",';
		echo "\n";
		echo 'pointStrokeColor : "#fff",';
		echo "\n";
		echo 'data : [' . $prof[1]['contentual'] . ',' . $prof[1]['competence'] . ',' . $prof[1]['eloquence'] . ',' . $prof[1]['motivation_prof'] . ',' . $prof[1]['test_requirements'] . ',' . $prof[1]['media_usage'] . ',' . $prof[1]['soft_skills'] . ']';
		echo "\n";
		echo '},';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#F38630",';
		echo "\n";
		echo 'strokeColor : "#996600",';
		echo "\n";
		echo 'pointColor : "#996600",';
		echo "\n";
		echo 'pointStrokeColor : "#fff",';
		echo "\n";
		echo 'data : [' . $prof[2]['contentual'] . ',' . $prof[2]['competence'] . ',' . $prof[2]['eloquence'] . ',' . $prof[2]['motivation_prof'] . ',' . $prof[2]['test_requirements'] . ',' . $prof[2]['media_usage'] . ',' . $prof[2]['soft_skills'] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '};';
		echo "\n";
		echo 'var ctx = $("#overall_all").get(0).getContext("2d");';
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
		echo '$(".legend_rank_1").text("' . $prof[0]['p_title'] . ' ' . $prof[0]['p_forname'] . ' ' . $prof[0]['p_lastname'] . '");';
		echo "\n";
		echo '$(".legend_rank_2").text("' . $prof[1]['p_title'] . ' ' . $prof[1]['p_forname'] . ' ' . $prof[1]['p_lastname'] . '");';
		echo "\n";
		echo '$(".legend_rank_3").text("' . $prof[2]['p_title'] . ' ' . $prof[2]['p_forname'] . ' ' . $prof[2]['p_lastname'] . '");';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_overall) as overall, count(e_id) as count, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc limit 3';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][2] . ' ' . $prof[0][3] . ' ' . $prof[0][4] . '","' . $prof[1][2] . ' ' . $prof[1][3] . ' ' . $prof[1][4] . '","' . $prof[2][2] . ' ' . $prof[2][3] . ' ' . $prof[2][4] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FF3300",';
		echo "\n";
		echo 'strokeColor : "#993300",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#overall").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'select p_title, p_forname, p_lastname, e_prof as prof ,( select count(e_hot) from t_evaluation where e_hot = 1 and e_prof = prof group by e_prof ) as count_hot, ( select count(e_hot) from t_evaluation where e_hot = 2 and e_prof = prof group by e_prof ) as count_not, round((( select count(e_hot) from t_evaluation where e_hot = 1 and e_prof = prof group by e_prof ) * (100/(select count(e_id) from t_evaluation where e_prof = prof))),0) as hot from t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname, prof order by hot desc;';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][0] . ' ' . $prof[0][1] . ' ' . $prof[0][2] . '","' . $prof[1][0] . ' ' . $prof[1][1] . ' ' . $prof[1][2] . '","' . $prof[2][0] . ' ' . $prof[2][1] . ' ' . $prof[2][2] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][6] . ',' . $prof[1][6] . ',' . $prof[2][6] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#hot").get(0).getContext("2d");';
		echo "\n";
		echo 'var options = {';
		echo "\n";
		echo 'scaleOverride : true,';
		echo "\n";
		echo 'scaleSteps : 10,';
		echo "\n";
		echo 'scaleStepWidth : 10,';
		echo "\n";
		echo 'scaleStartValue : 0';
		echo "\n";
		echo '};';
		echo "\n";
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_contentual) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#contentual").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_competence) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#competence").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_eloquence) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#eloquence").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_motivation_prof) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#motivation_prof").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_test_requirement) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#test_requirements").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_soft_skills) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#soft_skills").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		unset($prof);
		$stmt = $connect -> stmt_init();
		$query = 'SELECT avg(e_media_usage) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$prof[] = $row;
		}
		$stmt -> close();
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = {';
		echo "\n";
		echo 'labels : ["' . $prof[0][1] . ' ' . $prof[0][2] . ' ' . $prof[0][3] . '","' . $prof[1][1] . ' ' . $prof[1][2] . ' ' . $prof[1][3] . '","' . $prof[2][1] . ' ' . $prof[2][2] . ' ' . $prof[2][3] . '"],';
		echo "\n";
		echo 'datasets : [';
		echo "\n";
		echo '{';
		echo "\n";
		echo 'fillColor : "#FFFF00",';
		echo "\n";
		echo 'strokeColor : "#999900",';
		echo "\n";
		echo 'data : [' . $prof[0][0] . ',' . $prof[1][0] . ',' . $prof[2][0] . ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo ']';
		echo "\n";
		echo '}';
		echo "\n";
		echo 'var ctx = $("#media_usage").get(0).getContext("2d");';
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
		echo 'var chart = new Chart(ctx).Bar(data,options);';
		echo "\n";
		echo '</script>';
		echo "\n";
		$stmt = $connect -> stmt_init();
		$query = 'SELECT count(e_id) as rating from t_evaluation where e_overall = 7 or e_overall = 6';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$count_good = $row;
		}
		$stmt -> close();
		$stmt = $connect -> stmt_init();
		$query = 'SELECT count(e_id) as rating from t_evaluation where e_overall = 2 or e_overall = 1';
		if (!($stmt -> prepare($query))) {
			echo "Prepare failed: " . $connect -> errno . $connect -> error;
		}
		if (!$stmt -> execute()) {
			echo "Execute failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		if (!($result = $stmt -> get_result())) {
			echo "Result failed: (" . $connect -> errno . ") " . $connect -> error;
		}
		while ($row = $result -> fetch_array(MYSQLI_NUM)) {
			$count_bad = $row;
		}
		$stmt -> close();
		$count_mid = $count[0] - ($count_good[0] + $count_bad[0]);
		echo '<script type="text/javascript">';
		echo "\n";
		echo 'var data = [';
		echo "\n";
		echo "{";
		echo "\n";
		echo "value:" . $count_bad[0] * 100 / $count[0] . ",";
		echo 'color: "#F38630"';
		echo "\n";
		echo "},";
		echo "\n";
		echo "{";
		echo "\n";
		echo "value:" . $count_good[0] * 100 / $count[0] . ",";
		echo 'color: "#69D2E7"';
		echo "\n";
		echo "},";
		echo "\n";
		echo "{";
		echo "\n";
		echo "value:" . $count_mid * 100 / $count[0] . ",";
		echo 'color: "#E0E4CC"';
		echo "\n";
		echo "},";
		echo "\n";
		echo "]";
		echo "\n";
		echo 'var ctx = $("#good_bad").get(0).getContext("2d");';
		echo "\n";
		echo 'var chart = new Chart(ctx).Pie(data);';
		echo "\n";
		echo '</script>';
		echo "\n";
	} else {
		echo '<script type="text/javascript">';
		echo "\n";
		echo '$( ".wrapper-main" ).height("70%");';
		echo "\n";
		echo '$( ".content" ).replaceWith( "<p>not enough Data to create Statistic</p>");';
		echo "\n";
		echo '</script>';
	}

} else {
	echo '<script type="text/javascript">';
	echo "\n";
	echo '$( ".wrapper-main" ).height("70%");';
	echo "\n";
	echo '$( ".content" ).replaceWith( "<p>no Data exists</p>");';
	echo "\n";
	echo '</script>';
}
?>