<?php
require_once ('getConnection.php');
$stmt = $connect -> stmt_init();
$query = 'SELECT avg(e_overall) as overall, p_title, p_forname, p_lastname FROM t_evaluation INNER JOIN t_prof on e_prof = p_id group by p_title, p_forname, p_lastname order by overall desc';
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
echo 'fillColor : "rgba(220,220,220,0.5)",';
echo "\n";
echo 'strokeColor : "rgba(220,220,220,1)",';
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
?>