function getUngradedTestDetail(testId, studentId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.ungradedAnswers.length; i++) {
				addUngradedTestForm(response.ungradedAnswers[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getUngradedTestForStudent.php?ungradedTestId=" + testId + "&studentId=" + studentId, true);
	xmlhttp.send();
}