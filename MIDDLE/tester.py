import requests
import json

myWeb = r'https://web.njit.edu/~lme4/getQuestionList.php'
jamesWeb = r'https://web.njit.edu/~jjr27/getQuestionList.php'

s = requests.Session()

#GET request  
# r = s.get(myWeb)
# print (r.text)
# text1=r.text


# #POST request
payload = {
	"userid":"13"
}
#headers = {'content-type': 'application/json'}


post = s.post(myWeb, data=json.dumps(payload))

print (post.text)
