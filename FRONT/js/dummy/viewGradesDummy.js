function getDummyGradedTest(studentId, userId) {
	var response = gradedTest;
	for (var i = 0; i < response.questions.length; i++) {
		addGradedTestForm(response.questions[i]);
	}
}