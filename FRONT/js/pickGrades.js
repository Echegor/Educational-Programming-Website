function getGradedTestList(userId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("Raw Response: " + rawResponse);
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.gradedTests.length; i++) {
				addGradedTestButton(response.gradedTests[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getGradedTestList.php?userId=" + userId, true);
	xmlhttp.send();
}

function proceedToGradedTest(testId) {
	createCookie("ungradedTestId", testId);
	window.location.href = "viewGrades.html";
}









