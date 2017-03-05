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
	questionButtonHTML.querySelector("form").name = item.id;
	questionButtonHTML.querySelector(".questionName").innerHTML = item.name;
	questionButtonHTML.querySelector(".questionId").setAttribute("value", item.id);
	document.getElementById("questionList").innerHTML = document.getElementById("questionList").innerHTML + questionButtonHTML.innerHTML;
}

function addTestButton(item) {
	var testCellHTML = getTemplate("templates/testButton.html");
	testCellHTML.querySelector(".testName").innerHTML = item.name;
	testCellHTML.querySelector(".description").innerHTML = item.description;
	testCellHTML.querySelector(".testId").setAttribute("value", item.testId);
	document.getElementById("testList").innerHTML = document.getElementById("testList").innerHTML + testCellHTML.innerHTML;
}

function addUngradedTestButton(item) {
	var testCellHTML = getTemplate("templates/ungradedTestButton.html");
	testCellHTML.querySelector(".title").innerHTML = item.title;
	testCellHTML.querySelector(".id").innerHTML = item.id;
	document.getElementById("ungradedTestList").innerHTML = document.getElementById("ungradedTestList").innerHTML + testCellHTML.innerHTML;
}

function addTestForm(item) {
	var testFormHTML = getTemplate("templates/testForm.html");
	testFormHTML.querySelector(".prompt").innerHTML = item.prompt;
	testFormHTML.querySelector(".questionId").innerHTML = item.questionId;
	testFormHTML.querySelector(".answer").setAttribute("questionId", item.questionId);
	document.getElementById("testForm").innerHTML = testFormHTML.innerHTML + document.getElementById("testForm").innerHTML;
}











