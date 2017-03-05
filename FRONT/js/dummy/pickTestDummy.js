function getDummyTestList(userId) {
	var response = JSON.parse(sampleTests);
	for (var i = 0; i < response.length; i++) {
		addTestButton(response[i]);
	}
}

function proceedToDummyTest(testId) {
	console.log(testId);
	window.location.href = "takeTest.html";
}