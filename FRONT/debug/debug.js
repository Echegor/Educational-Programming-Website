function login(username, password) {
	createCookie("debugUsername", username);
	createCookie("debugPassword", password);
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
