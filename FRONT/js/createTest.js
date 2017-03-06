function getQuestionList(userId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("Response: " + rawResponse);
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.questions.length; i++) {
				addQuestionButton(response.questions[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getQuestionList.php?userId=" + userId, true);
	xmlhttp.send();
}

var questionsArray = [];

function addQuestionToTest(questionId) {
	console.log("Question ID Added: " + questionId);
	questionsArray.push(questionId);
	var response = {};
	response.title = "Question " + questionId;
	addQuestionCell(response);
}

function addTest(testName, testDescription, creatorId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
		}
	};
	console.log("Adding test with questions: " + JSON.stringify(questionsArray));
	xmlhttp.open("POST", "php/addTest.php?questionList=" + JSON.stringify(questionsArray) + "&testName=" + testName + "&testDescription=" + testDescription + "&creatorId=" + creatorId, true);
	xmlhttp.send();
}