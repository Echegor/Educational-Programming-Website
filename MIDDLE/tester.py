import requests
import json

myWeb = r'https://web.njit.edu/~lme4/submitTest.php'
code = r''

s = requests.Session()

#GET request  
# r = s.get(myWeb)
# print (r.text)
# text1=r.text


# #POST request
payload = {
	'prompt':r'int x,y,z; x=5; y=10; z=x+y;System.out.println("Z is:"+z);'
}
#headers = {'content-type': 'application/json'}


post = s.post(myWeb, data=json.dumps(payload))

print (post.text)
