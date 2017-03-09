import requests
import json

myWeb = r'https://web.njit.edu/~lme4/getQuestionList.php'
jamesWeb = r'https://web.njit.edu/~jjr27/getQuestionList.php'
testWeb = r'https://web.njit.edu/~lme4/submitTest.php'
vpnWeb = r'http://afsaccess2.njit.edu/~lme4/submitTest.php'

s = requests.Session()

#GET request  
# r = s.get(myWeb)
# print (r.text)
# text1=r.text

#lme4 userid = 13
# #POST request
#{"name":"intMax ","weight":".5","subjectId":"Loops","category":"Loops","prompt":"Write a public function called intMax that takes in three integers, a,b,c and returns the largest integer out of the three. ","input":"intMax(1, 2, 3)intMax(1, 3, 2)intMax(3, 2, 1)","output":"3,3,3","functionHeader":"public int intMax(int a, int b, int c)","createdBy":"13"}
#{"name":"sumDouble","weight":".5","subjectId":"conditional","category":"conditional","prompt":"Write a public function called sumDouble that takes in two integers, a,b  and returns their sum if a!=b otherwise, returns the sum doubled.","input":"sumDouble(1, 2),sumDouble(3, 2),sumDouble(2, 2)","output":"3,5,8","functionHeader":"public int sumDouble(int a, int b)","createdBy":"13"}
#{"name":"Not String","weight":".5","subjectId":"Strings","category":"Strings","prompt":"Declare a public function such that given a string, return a public function new string where \"not \" has been added to the front. However, if the string already begins with \"not\", return the string unchanged. Note: use .equals() to compare 2 strings.","input":"notString(\"candy\"),notString(\"x\"),notString(\"not bad\"),  ","output":"\"not candy\",\"not x\",\"not bad\"","functionHeader":"public String notString(String str)","createdBy":"13"}
answer1="""int intMax(int a, int b, int c)
{
	int max;

	// First check between a and b
	if (a > b) {
		max = a;
	} else {
		max = b;
	}

	// Now check between max and c
	if (c > max) {
		max = c;
	}

	return max;
}"""

answer2="""int sumDouble(int a, int b) {
  // Store the sum in a local variable
  int sum = a + b;
  
  // Double it if a and b are the same
  if (a == b) {
    sum = sum * 2;
  }
  
  return sum;
}"""
answer3="""String notString(String str) {
  if (str.length() >= 3 && str.substring(0, 3).equals("not")) {
    return str;
  }
  
  return "not " + str;
}"""

payload = {
	"testID":55,
	"studentId" : 13,
	"answers" : [
			{"questionID" : 22, "answer" : answer1} ,
			{"questionID" : 23, "answer" : answer2} ,
			{"questionID" : 24, "answer" : answer3} 
			], 
}
#headers = {'content-type': 'application/json'}


post = s.post(vpnWeb, data=json.dumps(payload))

print (post.text)
