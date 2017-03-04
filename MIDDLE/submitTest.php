<?php
/*
	“id” : “string”				// The ID of the test
	“username” : “string”			// Name of the student who took this test
	“answers” : “array of JSON(GradedQuestion)”
	“totalGrade” : “integer”
*/
	$url = "https://web.njit.edu/~jjr27/submitTest.php";

	require_once "util.php";

	$parsedInput = processInput(file_get_contents('php://input'),__FILE__);
	// echo "DUMP BEGIN";
	// var_dump($parsedInput);
	// echo "DUMP END";
	$arguments = $parsedInput['testCaseInputs'];
	$input = "";
	foreach ($arguments as $value) {
    	$input = $input . " $value";
	}

	echo "Inputs are: $input\n";
	$code = "public class CodeGrader{\n\t" 						. 
				"public static void main(String [] args)\n\t{"	. 
					"\n//INJECTED CODE START\n"					. 
						$parsedInput['prompt']					. 
					"\n//INJECTED CODE END\n\t"					. 
				"}\n"											. 
			"}\n";

	echo "$code";

	unlink("CodeGrader.java");
	writeToFile($code);

	$compileResult = shell_exec("javac CodeGrader.java 2>&1");
	if(empty($compileResult)){
		echo "Executing\n";
		$runResult =  shell_exec("java CodeGrader" . $input);
		echo "Run result is:\n$runResult\n";
	}
	else{
		echo "ERROR: $compileResult\n";
	}
	
	

	function writeToFile($inText)
	{
		$myfile = fopen("CodeGrader.java", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,$inText);
		fclose($myfile);
	}
?>