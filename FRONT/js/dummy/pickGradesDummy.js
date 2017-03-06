function getDummyGradedTestList(userId) {
	var response = gradedTest;
	for (var i = 0; i < response.gradedTests.length; i++) {
		addGradedTestButton(response.gradedTests[i]);
	}
}

function proceedToDummyGradedTest(testId) {
	console.log("Proceeding with test ID: " + testId);
	window.location.href = "viewGrades.html";
}