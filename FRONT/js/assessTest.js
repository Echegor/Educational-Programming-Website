function getUngradedTestList(userId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.tests.length; i++) {
				addUngradedTestButton(response.tests[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getUngradedTestList.php?userId=" + userId, true);
	xmlhttp.send();
}

function proceedToUngradedTest(testId) {
	createCookie("ungradedTestId", testId);
}