function getUngradedTestList(userId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("Raw Response: " + rawResponse);
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.ungradedTests.length; i++) {
				addUngradedTestButton(response.ungradedTests[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getUngradedTestList.php?userId=" + userId, true);
	xmlhttp.send();
}

function proceedToUngradedTest(testId) {
	createCookie("ungradedTestId", testId);
	window.location.href = "reviewTestFurther.html";
}

function getUngradedTestDetail(ungradedTestId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("Raw Response: " + rawResponse);
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.students.length; i++) {
				addUngradedTestButton(response.students[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getUngradedTestDetail.php?ungradedTestId=" + ungradedTestId, true);
	xmlhttp.send();
}

function proceedToUngradedTestFull(studentId) {
	createCookie("ungradedStudentId", studentId);
	window.location.href = "actuallyReview.html";
}

function correctStudentTest(studentId, testId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("Raw Response: " + rawResponse);
		}
	};
	
	var elements = document.getElementsByClassName("ungraded-test-form");
	var questions = [];
	for (var i = 0; i < elements.length; i++) {
		var element = elements[i];
		var question = {};
		question.questionId = element.querySelector(".questionId").value;
		question.studentGrade = element.querySelector(".studentGrade").value;
		question.remarks = element.querySelector(".remarks").value;
		console.log("Question ID: " + question.questionId);
		console.log("Student Grade: " + question.studentGrade);
		console.log("Remarks: " + question.remarks);
		questions.push(question);
	}
	
	xmlhttp.open("POST", "php/correctStudentTest.php?studentId=" + studentId + "&testId=" + testId + "&questions=" + JSON.stringify(questions), true);
	xmlhttp.send();
}










