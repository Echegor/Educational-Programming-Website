function submitInfo(ucid, password) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var rawResponse = this.responseText;
            var response = JSON.parse(rawResponse);
            if (response.NJIT == 1) {
                document.getElementById("njitPass").innerHTML = "NJIT LOGIN OK!";
                document.getElementById("njitPass").style.color = "green";
            } else {
                document.getElementById("njitPass").innerHTML = "NJIT LOGIN FAILED";
                document.getElementById("njitPass").style.color = "red";
            }
            if (response.BACKEND == 1) {
                document.getElementById("backendPass").innerHTML = "BACKEND LOGIN OK!";
                document.getElementById("backendPass").style.color = "green";
            } else {
                document.getElementById("backendPass").innerHTML = "BACKEND LOGIN FAILED";
                document.getElementById("backendPass").style.color = "red";
            }
        }
    };
    xmlhttp.open("POST", "network.php?ucid=" + ucid + "&password=" + password, true);
    xmlhttp.send();
}

function addQuestion(name, weight, category, prompt, input, output) {
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var rawResponse = this.responseText;
            var response = JSON.parse(rawResponse);
            addQuestionCell(response);
        }
    };
    
    xmlhttp.open("POST", "../php/addQuestion.php?name=" + name + "&weight=" + weight +
    	"&category=" + category + "&prompt=" + prompt + "&input=" + input + "&output=" + output, true);
    xmlhttp.send();
}