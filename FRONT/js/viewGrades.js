function getGradedTest(studentId, testId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("RAW RESPONSE: " + rawResponse);
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.questions.length; i++) {
				addGradedTestForm(response.questions[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getGradedTest.php?studentId=" + studentId + "&testId=" + testId, true);
	xmlhttp.send();
}