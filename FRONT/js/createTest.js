function getQuestionList(userId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
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
	questionsArray.push(questionId);
}

function addTest() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
		}
	};
	xmlhttp.open("POST", "php/addTest.php?questionList=" + JSON.parse(questionsArray), true);
	xmlhttp.send();
}