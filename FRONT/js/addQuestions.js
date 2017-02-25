function addQuestion(name, weight, category, prompt, input, output) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			addQuestionCell(response);
		}
	};
	
	xmlhttp.open("POST", "php/addQuestion.php?name=" + name + "&weight=" + weight +
		"&category=" + category + "&prompt=" + prompt + "&input=" + input + "&output=" + output, true);
	xmlhttp.send();
}