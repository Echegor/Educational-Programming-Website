function getDummyUngradedTestList(userId) {
	var response = ungradedTests;
	for (var i = 0; i < response.ungradedTests.length; i++) {
		console.log(response.ungradedTests[i].ungradedTestName);
		addUngradedTestButton(response.ungradedTests[i]);
	}
}

function proceedToDummyUngradedTest(testId) {
	console.log("Proceeding with test ID: " + testId);
	window.location.href = "reviewTestFurther.html";
}

function getDummyUngradedTestDetail(ungradedTestId) {
	var response = studentsList;
	for (var i = 0; i < response.students.length; i++) {
		addUngradedTestDetailButton(response.students[i]);
	}
}

function proceedToDummyUngradedTestFull(studentId) {
	console.log("Proceeding with student ID: " + studentId);
	window.location.href = "actuallyReview.html";
}

function getDummyUngradedTestForStudent(studentId, ungradedTestId) {
	var response = ungradedTestFull;
	for (var i = 0; i < response.ungradedAnswers.length; i++) {
		addUngradedTestForm(response.ungradedAnswers[i]);
	}
}


function correctDummyStudentTest() {
	//var elements = document.getElementById("testForm").elements;
	var elements = document.getElementsByClassName("ungraded-test-form");
	//console.log("ELEMENT: " + JSON.stringify(elements[1].querySelector(".studentGrade").value));
	var answers = [];
	//console.log(JSON.stringify(elements));
	for (var i = 0; i < elements.length; i++) {
		var element = elements[i];
		var answer = {};
		answer.questionId = element.querySelector(".questionId").value;
		answer.studentGrade = element.querySelector(".studentGrade").value;
		answer.remarks = element.querySelector(".remarks").value;
		console.log("Question ID: " + answer.questionId);
		console.log("Student Grade: " + answer.studentGrade);
		console.log("Remarks: " + answer.remarks);
		answers.push(answer);
		//console.log("ELEMENT: " + JSON.stringify(elements[i]));
	}
	console.log("ENTIRE THING: ");
	console.log(JSON.stringify(answers));
	/*var testSubmit = {};
	testSubmit.testId = getCookie("testId");
	testSubmit.userId = getCookie("userId");
	testSubmit.answers = answers;
	
	console.log(JSON.stringify(testSubmit));*/
}









