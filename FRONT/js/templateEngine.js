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
	document.getElementById("questionList").innerHTML = document.getElementById("questionList").innerHTML + questionCellHTML.innerHTML;
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
	testCellHTML.querySelector(".testName").innerHTML = item.ungradedTestName;
	testCellHTML.querySelector(".ungradedTestId").setAttribute("value", item.ungradedTestId);
	document.getElementById("ungradedTestList").innerHTML = document.getElementById("ungradedTestList").innerHTML + testCellHTML.innerHTML;
}

function addGradedTestButton(item) {
	var testCellHTML = getTemplate("templates/gradedTestButton.html");
	testCellHTML.querySelector(".testName").innerHTML = item.testName;
	testCellHTML.querySelector(".gradedTestId").setAttribute("value", item.gradedTestId);
	document.getElementById("testList").innerHTML = document.getElementById("testList").innerHTML + testCellHTML.innerHTML;
}

function addUngradedTestDetailButton(item) {
	var testCellHTML = getTemplate("templates/ungradedTestDetailButton.html");
	testCellHTML.querySelector(".studentName").innerHTML = item.studentName;
	testCellHTML.querySelector(".studentId").setAttribute("value", item.studentId);
	document.getElementById("ungradedTestList").innerHTML = document.getElementById("ungradedTestList").innerHTML + testCellHTML.innerHTML;
}

function addTestForm(item) {
	var testFormHTML = getTemplate("templates/testForm.html");
	testFormHTML.querySelector(".prompt").innerHTML = item.prompt;
	testFormHTML.querySelector(".questionId").innerHTML = item.questionId;
	testFormHTML.querySelector(".answer").setAttribute("questionId", item.questionId);
	document.getElementById("testForm").innerHTML = testFormHTML.innerHTML + document.getElementById("testForm").innerHTML;
}

function addUngradedTestForm(item) {
	var testFormHTML = getTemplate("templates/ungradedTestForm.html");
	testFormHTML.querySelector(".questionPrompt").innerHTML = item.questionPrompt;
	testFormHTML.querySelector(".questionId").setAttribute("value", item.questionId);
	//testFormHTML.querySelector(".studentAnswer").setAttribute("value", item.studentAnswer);
	testFormHTML.querySelector(".studentAnswer").innerHTML = item.studentAnswer;
	testFormHTML.querySelector(".questionWeight").setAttribute("value", item.questionWeight);
	testFormHTML.querySelector(".studentGrade").setAttribute("value", item.studentGrade);
	document.getElementById("testForm").innerHTML =  testFormHTML.innerHTML + document.getElementById("testForm").innerHTML;
}

function addGradedTestForm(item) {
	var testFormHTML = getTemplate("templates/gradedTestForm.html");
	testFormHTML.querySelector(".questionPrompt").innerHTML = item.questionPrompt;
	testFormHTML.querySelector(".questionId").setAttribute("value", item.questionId);
	testFormHTML.querySelector(".studentAnswer").innerHTML = item.studentAnswer;
	testFormHTML.querySelector(".questionWeight").setAttribute("value", item.questionWeight);
	testFormHTML.querySelector(".studentGrade").setAttribute("value", item.studentGrade);
	testFormHTML.querySelector(".remarks").innerHTML = item.remarks;
	document.getElementById("testForm").innerHTML =  testFormHTML.innerHTML + document.getElementById("testForm").innerHTML;
}












