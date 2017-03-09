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

	$inputQuestions = array($question1,$question2,$question3);

	$url = "https://web.njit.edu/~jjr27/submitTest.php";
	$questionUrl = "https://web.njit.edu/~jjr27/getQuestionDetail.php";   
	
	$parsedInput = processInput(file_get_contents('php://input'),__FILE__);


	for($j=0 ,$size = count($parsedInput['answers']); $j < $size ; ++$j){
		$postfields = array(
						"questionID" => $parsedInput['answers'][$j]['questionId'],
						);
		$questionDetail = postFromMiddle($postfields,$questionUrl);

		$parsedInput['answers'][$j] = gradeQuestion($questionDetail,$parsedInput['answers'][$j]);

	}

	
	$backend = postFromMiddle($parsedInput,$url);
	echo json_encode($backend);

	function gradeQuestion($questionDetail,$question){
		//QuestionDetail holds [“name” : string, “weight” : string,“subjectId” : int,“prompt” : string,“Input” : string,“output” : string,“functionHeader” : string,“createdBy” : int]
		//Question holds [ “questionID” : int, “answer” : “string” ]
		//NEED TO ADD ”grade”:int,”gradeExplanation”:”string” ] 

		$testCases = explode("|", $questionDetail['input']);
		$outputCases = explode("|", $questionDetail['output']);

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

		$question['grade'] = 0;
		$question['gradeExplanation'] = "";
		$numberRight = 0;
		$testCaseNumber = count($testCases);
		$studentCode = $question['answer'];
		$header = $questionDetail['QstFunctionHeader'];
		$studentArray = getArrayFromHeader(getStudentHeader($studentCode));
		$instructorArray = getArrayFromHeader($header);
		// debugLog($studentArray);
		// debugLog($instructorArray);

		//TODO REPLACE TEST CASES
		$studentFunctionName = $studentArray["functionName"];
		$studentRawCode = getStudentCode($studentCode);
		$fixedFunctionArguments = fixArgumentTypes($instructorArray['argumentsArray'],$studentArray['argumentsArray']);
		$goodHeader = generateGoodHeader($instructorArray['returnType'],$studentFunctionName,$fixedFunctionArguments);
		$mergedTestCases = mergeTestCases($testCases,$studentFunctionName);
		$code = injectCode($goodHeader,$studentRawCode,$mergedTestCases);
		unlink("CodeGrader.java");
		unlink("CodeGrader.class");
		writeToFile($code);
		$compileResult = shell_exec("javac CodeGrader.java 2>&1");

		if(empty($compileResult)){
				$runResult = parseRunResult($header,$outputCases,$testCases);
				//echo "Run result\n";
				//var_dump($runResult);
				//echo "done\n";
				$question['gradeExplanation'] .= $runResult[0];
				$numberRight = $runResult[1];

			}
		else{
			$question['grade'] = 0;
			$question['gradeExplanation'] .= $compileResult;
			return $question;
		}

		$deductedPoints = compareHeaderArrays($instructorArray,$studentArray);
		//debugLog($deductedPoints);

		$question['grade'] = intval($numberRight*100/$testCaseNumber - $deductedPoints[0]);
		$question['gradeExplanation'] .= $deductedPoints[1];
		return $question;

	}

	function injectCode($functionHeader,$studentCode,$testCase){
		$code = "public class CodeGrader{\n\t" 								. 
					"public static void main(String [] args)\n\t{"			. 
						"\n\t\t//INJECTED TEST CODE START\n"				. 
						"\t\tSystem.out.print($testCase);"	  				.
						"\n\t\t//INJECTED TEST CODE END\n\t"				. 
					"}\n"													.
					"public static " . $functionHeader . " $studentCode\n"	. 
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
		//echo "Executing\n";
		$runResult =  shell_exec("java CodeGrader");
		$runOutput = explode("%delim%", $runResult);
		//debugLog($output,"Run output split is");

		$numberRight =0;
		$gradeExplanation = "";


		//TODO WHY ARE YOU CHECKING THE HEADER EVERY ITERATTON
		for($i = 0, $size = count($output);$i<$size;$i++){
			if (preg_match('#^String#', $header) === 1) {
				if($runOutput[$i]===$output||"\"$runOutput[$i]\""===$output[$i]){
					$numberRight++;
					$gradeExplanation.="Good job, for your input $input[$i], you got \"$runOutput[$i]\". The correct answer was $output[$i] \n";
				}
				else{
					$gradeExplanation.="You got a bad String $runOutput[$i], the correct answer was $output[$i]\n";		
				}
			}
			else if (preg_match('#^int#', $header) === 1) {
				if($runOutput[$i]===$output[$i]){
					$numberRight++;
					$gradeExplanation.="Good job, for your input $input[$i], you got $runOutput[$i]. The correct answer was $output[$i] \n";
				}
				else{
					$gradeExplanation.="You got $runOutput[$i], the correct answer was $output[$i]\n";	
				}		
			}
			else {
				debugLog($runOutput[$i],"Bad parse in parseRunResult");
			}
		}

		return array($gradeExplanation,$numberRight);

	}
	function getStudentHeader($studentCode){
		//^int\s*maxInt\(\s*int\s*x\s*,\s*int\s*y\s*\)
		$codeBegin = strpos($studentCode,"{");
		if($codeBegin===FALSE){
			debugLog("student code does not have bracket { in submitTest.php getStudentHeader()");
			exit("error no bracket in student code");
		}
		//debugLog(substr($studentCode, 0, $codeBegin));
		//NOTE FOR FUTURE SELF I AM DELIBERATELY REMOVING ')'
		return substr($studentCode, 0, $codeBegin-1);
	}
	function getStudentCode($studentCode){
		//^int\s*maxInt\(\s*int\s*x\s*,\s*int\s*y\s*\)
		$codeBegin = strpos($studentCode,"{");
		if($codeBegin===FALSE){
			debugLog("student code does not have bracket { in submitTest.php getStudentCode()");
			exit("error no bracket in student code");
		}
		//debugLog(substr($studentCode, $codeBegin));
		//NOTE FOR FUTURE SELF I AM DELIBERATELY REMOVING ')'
		return substr($studentCode, $codeBegin);
	}
	//int    maxInt   (   int x   ,   int   y
	//int maxInt & int x, int y
	//int    maxInt
	//int x, 
	//int y
	function getArrayFromHeader($input){
		$input = preg_replace('/\s{2,}/', ' ', $input);
		$split = explode("(", trim($input));
		$fNameandRType = explode(" ", trim($split[0]));
		$argumentsArray = explode(",", trim($split[1]));

		for($i = 0, $size = count($argumentsArray) ; $i<$size;$i++){
			$argumentsArray[$i] = trim($argumentsArray[$i]);
		}

		$returnType = $fNameandRType[0];
		$functionName = $fNameandRType[1];
		$returnArray = array(
								"returnType" => $returnType,
								"functionName" => $functionName,
								"argumentsArray" => $argumentsArray
							);
		return $returnArray;

	}
	function compareHeaderArrays($instructor,$student){
		//debugLog($instructor,"instructor");
		//debugLog($student,"student");
		$points = 0;
		$explanation = "";
		if($student['returnType']!==$instructor['returnType']){
			$points +=5;
			$explanation .="-5 Wrong return type: ". $student['returnType'] ."\n";
		}

		if($student['functionName']!==$instructor['functionName']){
			$points +=5;
			$explanation .="-5Wrong function name: " . $student['functionName'] . "\n";
		}
		for($i=0,$size = count($instructor['argumentsArray']) ; $i<$size ; $i++){
			$iSplit = explode(" ", $instructor['argumentsArray'][$i]);
			$sSplit = explode(" ", $student['argumentsArray'][$i]);
		//	debugLog($iSplit,"iSplit");
		//	debugLog($sSplit,"sSplit");
			if($iSplit[0]!==$sSplit[0]){
				$points +=5;
				$explanation .="-5 Wrong function argument type: " . $sSplit[0] . "\n";
			}
		}
		return array($points,$explanation);

	}

	function replaceFunctionName($fName,$input){
		$input = explode("(",trim($input));

		//debugLog($fName . "(" . $input[1]);
		return $fName . "(" . $input[1];
	}
	function fixArgumentTypes($instructor,$student){
		$arguments = "";
		for($i=0,$size = count($instructor) ; $i<$size ; $i++){
			$iSplit = explode(" ", $instructor[$i]);
			$sSplit = explode(" ", $student[$i]);
			$arguments .= $iSplit[0] . " " . $sSplit[1] . ",";
			//$student[$i] = $iSplit[0] . $sSplit[1]
		}
		$arguments = substr($arguments, 0, -1);
		//debugLog("Fixed Arg " . $arguments);
		return $arguments;
	}
	function generateGoodHeader($returnType,$studentFunctionName,$fixedFunctionArguments){
		return $returnType . " " . $studentFunctionName . "(" . $fixedFunctionArguments . ")";
	}
	function mergeTestCases($input,$studentFunctionName){
		$testCaseString = "";
		for($i=0,$size=count($input);$i<$size;$i++){
			if($i!=$size-1){
				$testCaseString.=replaceFunctionName($studentFunctionName,$input[$i]) . "+\"%delim%\"+";
			}
			else{
				$testCaseString.=replaceFunctionName($studentFunctionName,$input[$i]);
			}
		}
		//debugLog($testCaseString,"Test Case String:");
		return $testCaseString;
	}
?>