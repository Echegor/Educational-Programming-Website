function getDummyQuestionList(userId) {
	var response = JSON.parse(sampleQuestions);
	for (var i = 0; i < response.length; i++) {
		addQuestionButton(response[i]);
	}
}

function addDummyTest(testName, testDescription, creatorId) {
	console.log(JSON.stringify(questionsArray));
	var newTest;
}