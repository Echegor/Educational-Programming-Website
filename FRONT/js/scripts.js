function login(username, password) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
			
			createCookie("userId", response.userId);
			createCookie("firstName", response.firstName);
			createCookie("lastName", response.lastName);
			createCookie("roleId", response.roleId);
			
			if (response.roleId == 1) { // Student
				window.location.href = "studentLanding.html";
			} else if (response.roleId == 2) { // Instructor
				window.location.href = "instructorLanding.html";
			} else {
				console.log("Couldn't resolve roleId!");
				document.getElementById("errors").innerHTML = "Couldn't resolve roleId!";
			}
		}
	};
	xmlhttp.open("POST", "php/login.php?username=" + username + "&password=" + password, true);
	xmlhttp.send();
}

function register(username, password, accountType) {
	 var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var rawResponse = this.responseText;
			var response = JSON.parse(rawResponse);
		}
	};
	xmlhttp.open("POST", "php/register.php?username=" + username + "&password=" + password + "&accountType" + accountType, true);
	xmlhttp.send();
}

function createCookie(cookieName, cookieValue) {
	document.cookie = cookieName + "=" + cookieValue + "; path=/";
}


function getCookie(cname) {
	// source: https://www.w3schools.com/js/js_cookies.asp
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}