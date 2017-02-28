function getTemplate(url) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", url, false);
    xmlhttp.send(null);
    // Source: http://stackoverflow.com/questions/2522422/converting-a-javascript-string-to-a-html-object
    var temp = document.createElement('div');
    temp.innerHTML = xmlhttp.responseText;
    var htmlObject = temp.firstChild;
    
    return htmlObject;
}


function addQuestionCell(item) {
	var questionCellHTML = getTemplate("templates/questionCell.html");
	questionCellHTML.querySelector(".title").innerHTML = item.title;
	document.getElementById("sidebar").innerHTML = document.getElementById("sidebar").innerHTML + questionCellHTML.innerHTML;
}


function addQuestionButton(item) {
	var questionButtonHTML = getTemplate("templates/questionButton.html");
	questionButtonHTML.querySelector(".title").innerHTML = item.title;
	questionButtonHTML.querySelector(".id").innerHTML = item.id;
	questionButtonHTML.getElementsByTagName("button")[0].setAttribute("value", item.id);
	document.getElementById("questionList").innerHTML = document.getElementById("questionList").innerHTML + questionButtonHTML.innerHTML;
}

function addTestButton(item) {
	var testCellHTML = getTemplate("templates/testButton.html");
	testCellHTML.querySelector(".title").innerHTML = item.title;
	testCellHTML.querySelector(".id").innerHTML = item.id;
	testCellHTML.getElementsByTagName("button")[0].setAttribute("value", item.id);
	document.getElementById("testList").innerHTML = document.getElementById("testList").innerHTML + testCellHTML.innerHTML;
}

function addTestForm(item) {
	var testFormHTML = getTemplate("templates/testForm.html");
	testFormHTML.querySelector(".prompt").innerHTML = item.prompt;
	testFormHTML.querySelector(".questionId").innerHTML = item.questionId;
	document.getElementById("testForm").innerHTML = testFormHTML.innerHTML + document.getElementById("testForm").innerHTML;
}