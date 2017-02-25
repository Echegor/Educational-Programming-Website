function getTestList(userId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.tests.length; i++) {
				addTestButton(response.tests[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getTestList.php?userId=" + userId, true);
	xmlhttp.send();
}

function proceedToTest(testId) {
	createCookie("testId", testId);
}