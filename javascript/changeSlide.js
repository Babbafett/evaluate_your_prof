$('#overall_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#overall').html(grade);
});
$('#contentual_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#contentual').html(grade);
});
$('#competence_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#competence').html(grade);
});
$('#eloquence_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#eloquence').html(grade);
});
$('#motivation_prof_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#motivation_prof').html(grade);
});
$('#motivation_before_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#motivation_before').html(grade);
});
$('#motivation_after_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#motivation_after').html(grade);
});
$('#test_requirements_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#test_requirements').html(grade);
});
$('#media_usage_slide').change(function() {
	var value = this.value;
	var grade = getGrade(value);
	$('#media_usage').html(grade);
});

function getGrade(value) {
	var grade;
	if (value == 1) {
		grade = 'F';
	} else if (value == 2) {
		grade = 'E';
	} else if (value == 3) {
		grade = 'D';
	} else if (value == 4) {
		grade = 'C';
	} else if (value == 5) {
		grade = 'B';
	} else if (value == 6) {
		grade = 'A';
	} else if (value == 7) {
		grade = 'A+';
	}
	return grade;
};

