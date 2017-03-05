function getDummyTestDetail(testId) {
	//var response = JSON.parse(sampleTest);
	//console.log(sampleTest);
	for (var i = 0; i < sampleTest.questionIds.length; i++) {
		addTestForm(sampleTest.questionIds[i]);
		//console.log(sampleTest.questionIds[i].prompt);
	}
}

function submitDummyTest() {

	var elements = document.getElementById("testForm").elements;
	var answers = [];
	for (var i = 0; i < elements.length-1; i++) {
		var element = elements[i];
		var answer = {};
		answer.questionId = element.getAttribute("questionId");
		answer.answer = element.value;
		console.log("Question ID: " + answer.questionId);
		console.log("Answer: " + answer.answer);
		answers.push(answer);
	}
	
	var testSubmit = {};
	testSubmit.testId = getCookie("testId");
	testSubmit.userId = getCookie("userId");
	testSubmit.answers = answers;
	
	console.log(JSON.stringify(testSubmit));
}