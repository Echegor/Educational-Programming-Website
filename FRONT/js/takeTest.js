function getTestDetail(testId) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.questionIds.length; i++) {
				addTestForm(response.questionIds[i]);
			}
			
		}
	};
	xmlhttp.open("POST", "php/getTestDetail.php?testId=" + testId, true);
	xmlhttp.send();
}

function submitTest() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			console.log("Raw Response: " + rawResponse);
			console.log("Redirect as needed.");
		}
	};
	
	var elements = document.getElementById("testForm").elements;
	var answers = [];
	for (var i = 0; i < elements.length-1; i++) {
		var element = elements[i];
		var answer = {};
		answer.questionId = element.getAttribute("questionId");
		answer.answer = element.value;
		answers.push(answer);
	}
	
	xmlhttp.open("POST", "php/submitTest.php?testId=" + getCookie("testId") + "&userId=" + getCookie("userId") + "&answers=" + JSON.stringify(answers), true);
	xmlhttp.send();
}

/*function submitTest() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			
			for (var i = 0; i < response.questions.length; i++) {
				addTestForm(response.questions[i]);
			}
			
		}
	};
	
	var elements = document.getElementById("testForm").elements;
	var answers = [];
	for (var i = 0; i < elements.length-1; i++) {
		var element = elements[i];
		if (element.type === "text" && element.name === "answer") {
			var answer;
			answer.questionId = element.querySelector(".questionId").innerHTML;
			answer.answer = element.getElementById("answer").value;
			answers.push(answer);
		}
	}
	
	var testSubmit;
	//testSubmit.testId = getTestDetail(getCookie("testId"));
	testSubmit.testId = getCookie("testId");
	testSubmit.userId = getCookie("userId");
	testSubmit.answers = answers;
	
	xmlhttp.open("POST", "php/submitTest.php?testId=" + getCookie("testId") + "&userId=" + getCookie("userId") + "&answers=" + JSON.parse(testSubmit.answers), true);
	xmlhttp.send();
}*/