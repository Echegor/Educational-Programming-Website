<?php

//IN
/*
 “testID”:int,
“studentId” : int,
“answers” : 
{ [ “questionID” : int, 
	“answer” : “string” ] ,
 [ “questionID” : int, “answer” : “string” ] ,
 [ “questionID” : int, “answer” : “string” ] }

 //OUT

*/
 	require_once "util.php";
	$url = "https://web.njit.edu/~jjr27/submitTest.php";
	$questionUrl = "https://web.njit.edu/~jjr27/getQuestionDetail.php";   
	
	$parsedInput = processInput(file_get_contents('php://input'),__FILE__);

	foreach ($parsedInput['answers'] as $question){
		$postfields = json_encode(array("questionID" => $question['questionID']));
		$questionDetail = postFromMiddle($postfields,$questionUrl);
		gradeQuestion($questionDetail,$question);
		//TODO merge the two arrays
	}




	function gradeQuestion($questionDetail,$question){
		//QuestionDetail holds [“name” : string, “weight” : string,“subjectId” : int,“prompt” : string,“Input” : string,“output” : string,“functionHeader” : string,“createdBy” : int]
		//Question holds [ “questionID” : int, “answer” : “string” ]
		// $arguments = $parsedInput['testCaseInputs'];
		// foreach ($arguments as $value) {
 		//    	$input = $input . " $value";
		// }

		//TODO parse and compare headers
		$code = injectCode($question['answer']);
		$compileResult = shell_exec("javac CodeGrader.java 2>&1");
		if(empty($compileResult)){
			echo "Executing\n";
			$runResult =  shell_exec("java CodeGrader" . $input);
			echo "Run result is:\n$runResult\n";
		}
		else{
			echo "ERROR: $compileResult\n";
		}
	}

	function injectCode($code){
		$code = "public class CodeGrader{\n\t" 						. 
					"public static void main(String [] args)\n\t{"	. 
						"\n//INJECTED CODE START\n"					. 
							$code									. 
						"\n//INJECTED CODE END\n\t"					. 
					"}\n"											. 
				"}\n";
		//echo "$code";
		return $code;
	}
	function writeToFile($inText)
	{
		$myfile = fopen("CodeGrader.java", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,$inText);
		fclose($myfile);
	}
?>