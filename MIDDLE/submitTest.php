<?php

//IN
/*
 “testID”:int,
“studentId” : int,
“answers” : 
{ [ “questionID” : int, “answer” : “string” ] ,
 [ “questionID” : int, “answer” : “string” ] ,
 [ “questionID” : int, “answer” : “string” ] }

 //OUT
“testID”:int,
“studentId” : int,
“answers” : 
{ [ “questionID” : int, “answer” : “string”,”grade”:int,”gradeExplanation”:”string” ] ,
 [ “questionID” : int, “answer” : “string”,”grade”:int,”gradeExplanation”:”string” ] , 
[ “questionID” : int, “answer” : “string”,”grade”:int,”gradeExplanation”:”string” ] , }
*/
	require_once "util.php";

	// $question1=array(
	// 	"name"=>"intMax",
	// 	"weight"=>".5",
	// 	"subjectId"=>"Loops",
	// 	"category"=>"Loops",
	// 	"prompt"=>"Write a public function called intMax that takes in three integers, a,b,c and returns the largest integer out of the three. ",
	// 	"input"=>"intMax(1, 2, 3);intMax(1, 3, 2);intMax(3, 2, 1)",
	// 	"output"=>"3;3;3",
	// 	"functionHeader"=>"int intMax(int a, int b, int c)",
	// 	"createdBy"=>"13"
	// 	);
	// $question2=array(
	// 	"name"=>"sumDouble",
	// 	"weight"=>".5",
	// 	"subjectId"=>"conditional",
	// 	"category"=>"conditional",
	// 	"prompt"=>"Write a public function called sumDouble that takes in two integers, a,b  and returns their sum if a!=b otherwise, returns the sum doubled.",
	// 	"input"=>"sumDouble(1, 2);sumDouble(3, 2);sumDouble(2, 2)",
	// 	"output"=>"3;5;8",
	// 	"functionHeader"=>"int sumDouble(int a, int b)",
	// 	"createdBy"=>"13"
	// 	);
	// $question3=array(
	// 	"name"=>"Not String",
	// 	"weight"=>".5",
	// 	"subjectId"=>"Strings",
	// 	"category"=>"Strings",
	// 	"prompt"=>"Declare a public function such that given a string, return a public function new string where \"not \" has been added to the front. However, if the string already begins with \"not\", return the string unchanged.",
	// 	"input"=>"notString(\"candy\");notString(\"x\");notString(\"not bad\")",
	// 	"output"=>"\"not candy\";\"not x\";\"not bad\"",
	// 	"functionHeader"=>"String notString(String str)",
	// 	"createdBy"=>"13"
	// 	);
	$inputQuestions = array($question1,$question2,$question3);

	$url = "https://web.njit.edu/~jjr27/submitTest.php";
	$questionUrl = "https://web.njit.edu/~jjr27/getQuestionDetail.php";   
	
	$parsedInput = processInput(file_get_contents('php://input'),__FILE__);

	// foreach ($parsedInput['answers'] as $question){
	// 	$postfields = json_encode(array("questionID" => $question['questionID']));
	// 	$questionDetail = postFromMiddle($postfields,$questionUrl);
	// 	gradeQuestion($questionDetail,$question);
	// 	//TODO merge the two arrays
	// }
	for($j=0 ,$size = count($parsedInput['answers']); $j < $size ; ++$j){
		$postfields = json_encode(array("questionID" => $question['questionID']));
		$questionDetail = postFromMiddle($postfields,$questionUrl);
		//echo "size:$size, j:$j\n";
		$parsedInput['answers'][$j] = gradeQuestion($questionDetail,$parsedInput['answers'][$j]);
		//var_dump($parsedInput['answers'][$j]);
	}
	// for($j=0 ,$size = count($parsedInput['answers']); $j < $size ; ++$j){
	// 	//echo "size:$size, j:$j\n";
	// 	$parsedInput['answers'][$j] = gradeQuestion($inputQuestions[$j],$parsedInput['answers'][$j]);
	// 	var_dump($parsedInput['answers'][$j]);
	// }
	echo json_encode($parsedInput);

	function gradeQuestion($questionDetail,$question){
		//QuestionDetail holds [“name” : string, “weight” : string,“subjectId” : int,“prompt” : string,“Input” : string,“output” : string,“functionHeader” : string,“createdBy” : int]
		//Question holds [ “questionID” : int, “answer” : “string” ]
		//NEED TO ADD ”grade”:int,”gradeExplanation”:”string” ] 

		$testCases = explode(";", $questionDetail['input']);
		$outputCases = explode(";", $questionDetail['output']);

		//TODO parse and compare headers
		// echo "Dumping questionDetail";
		// var_dump($questionDetail);
		// echo "Dumping question";
		// var_dump($question);
		// echo "done dump";
		// echo "Dumping test";
		// var_dump($testCases);
		// echo "done dump";
		// echo "Dumping output";
		// var_dump($outputCases);
		// echo "done dump\n";

		$question['grade'] = 0.0;
		$question['gradeExplanation'] = "";
		$numberRight = 0;
		$testCaseNumber = count($testCases);
		for($i=0;$i<$testCaseNumber;$i++){
			$code = injectCode($question['answer'],$testCases[$i]);
			//echo "Code is \n$code\n";
			echo "Working on $testCases[$i]\n";
			unlink("CodeGrader.java");
			writeToFile($code);
			$compileResult = shell_exec("javac CodeGrader.java 2>&1");
			if(empty($compileResult)){
				$runResult = parseRunResult($questionDetail['functionHeader'],$outputCases[$i],$testCases[$i]);
				echo "Run result\n";
				var_dump($runResult);
				echo "done\n";
				$question['gradeExplanation'] .= $runResult[0];
				echo "New explanation " .  $question['gradeExplanation'] . "\nDONE\n";
				if($runResult[1]===1){
					echo "increasing number right";
					$numberRight++;
				}
			}
			else{
				$question['grade'] = 0;
				$question['gradeExplanation'] .= $compileResult;
				return $question;
			}
		}

		$question['grade'] = $numberRight*100/$testCaseNumber;
		return $question;

	}

	function injectCode($function,$testCase){
		$code = "public class CodeGrader{\n\t" 						. 
					"public static void main(String [] args)\n\t{"	. 
						"\n\t\t//INJECTED CODE START\n"				. 
						"\t\tSystem.out.print($testCase);\n"	  	.
						"\n\t\t//INJECTED CODE END\n\t"				. 
					"}\n"											.
					"public static $function\n"						. 
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

	function parseRunResult($header,$output,$input){
		echo "Executing\n";
		$runResult =  shell_exec("java CodeGrader");
		echo "Run result is:\n$runResult\n";
		if (preg_match('#^String#', $header) === 1) {
			if($runResult===$output||"\"$runResult\""===$output){
				return array("Good job, for your input $input, you got \"$runResult\". The correct answer was $output \n",1);
			}
			else{
				return array("You got a bad String $runResult, the correct answer was $output\n",0);		
			}
		}
		if (preg_match('#^int#', $header) === 1) {
			if($runResult===$output){
				return array("Good job, for your input $input, you got $runResult. The correct answer was $output \n",1);
			}
			else{
				return array("You got $runResult, the correct answer was $output\n",0);		
			}		
		}
		echo "Bad Parse\n";

	}
?>