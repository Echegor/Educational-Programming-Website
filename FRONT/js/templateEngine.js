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
	var questionCellHTML = getTemplate("../templates/questionCell.html");
	questionCellHTML.querySelector(".title").innerHTML = item.name;
	document.getElementById("sidebar").innerHTML = document.getElementById("sidebar").innerHTML + questionCellHTML.innerHTML;
}