function addQuestion(name, weight, subjectId, prompt, input, output, functionHeader, createdBy) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			addQuestionCell(response);
		}
	};
	
	xmlhttp.open("POST", "php/addQuestion.php?name=" + name + "&weight=" + weight +
		"&subjectId=" + subjectId + "&prompt=" + prompt + "&input=" + input + "&output=" + output + "&functionHeader=" + functionHeader + "&createdBy=" + createdBy, true);
	xmlhttp.send();
}