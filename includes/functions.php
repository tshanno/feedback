<?php
/*
Created on Mon Oct 24 2018
PHP Functions File for CircSim Program
Based on Java CircSim program developed by T. Shannon & J. Michael (Rush University)

##Revision History
## 10/24/2018: Initial Scripting

@CodingAuthor: Brenden Hoff (Aeterna Holdings LLC; brendenhoff@aeternaholdings.com)
*/



require_once './problems.php';

function LoadMenu() {
	global $problemlist;
	$i=0;
	foreach ($problemlist as $problem) {
		echo "<button class='problemselection' problemid='$i'>" . $problem['name'] . "</button>";
		$i++;
	}
}

function LoadProblem($problemid) {
	global $problemlist;

	// ß$returndata = [];
	$problem = $problemlist[$problemid];
	$returndata['name'] = $problem['name'];
	$returndata['stem'] = $problem['stem'];
	$returndata['hint'] = $problem['hint'];
	echo json_encode($returndata);
}

function LookupProblemAnswers($problemid) {
	global $problemlist;
	$answers = $problemlist[$problemid];
	return $answers;
}

function CheckAnswers($problemid,$directresponse,$reflexresponse,$steadystate,$attempts) {
	// $feedback = [];
	$initialchangestring = strtoupper(${initialchange});
	$feedback['GenericWrong'] = "Correct the following errors.  Correct the ER first, then the FR, then the SS.<br /><br />";
	//Initialize array for handling the submitted answers
	//$submittedanswers = [];
	$submittedanswers['dr'] = $directresponse;
	$submittedanswers['rr'] = $reflexresponse;
	$submittedanswers['ss'] = $steadystate;
	
	//Lookup the correct answers
	$answerkey = LookupProblemAnswers($problemid);
	
	//Initialize array for tracking if answers are correct
	$CompleteSolution = 1;
	$responses = array('dr','rr','ss');
	$parameters = array('is','cvp','sv','hr','co','tpr','map');
	//$CorrectAnswers = [];
	foreach ($responses as $response) {
		foreach ($parameters as $parameter) {
		$CorrectAnswers[$response][$parameter] = 1;
		}
	}
	

	//Check Initial Change
	//Refactor
	$initialchange = $answerkey['initialchange'];
	if ($problemid < 7) {
		
		switch ($initialchange) {
			case 'is';
				$initialchangestring = "CRH";
				break;
			case 'cvp';
				$initialchangestring = "ACTH";
				break;
			case 'sv';
				$initialchangestring = "cortisol";
				break;
		}
	} else if ($problemid < 14) {

		switch ($initialchange) {
			case 'is';
				$initialchangestring = "TRH";
				break;
			case 'cvp';
				$initialchangestring = "TSH";
				break;
			case 'sv';
				$initialchangestring = "T4";
				break;
			case 'hr';
				$initialchangestring = "T3";
				break;
		}
	} else {

		switch ($initialchange) {
			case 'is';
				$initialchangestring = "GnRH";
				break;
			case 'cvp';
				$initialchangestring = "FSH";
				break;
			case 'sv';
				$initialchangestring = "LH";
				break;
			case 'hr';
				$initialchangestring = "estrogen";
				break;
		}
	}
	
	if ($submittedanswers['dr'][$initialchange] =='n') { //If the intial change parameter has not been changed (still 0, which we track as 'n' for no change)
		$feedback['InitialChange'] .= $feedback['InitialChange'] . "The initial change is " . $initialchangestring . ". <br /><br />"; //let them know what parameter needs to change first, add it to the feedback
		$CorrectAnswers['dr'][$initialchange] = 0; //Mark the direct response for the initial change parameter wrong
		$CompleteSolution = 0; //The solution is not completely correct.
	}
	else if ($submittedanswers['dr'][$initialchange] !='n' && $submittedanswers['dr'][$initialchange] != $answerkey['dr'][$initialchange]) { //If the initial change parameter has been changed (no longer 'n'), but it is not the correct change
		$feedback['InitialChange'] .= "The initial change is " . $initialchangestring . ". This value in the direct response is incorrect. <br /><br />"; //let them know it is wrong, add it to feedback
		$CorrectAnswers['dr'][$initialchange] = 0; //mark the direct response for the initial change parameter wrong
		$CompleteSolution = 0; //the solution is not correct
	}


	//Check MAP, CO, TPR
	foreach ($responses as $i){
		switch ($i) {
			case 'dr':
				$column = "ENDOCRINE RESPONSE";
				break;
			case 'rr':
				$column = "FEEDBACK RESPONSE";
				break;
			case 'ss':
				$column = "STEADY STATE";
				break;
		}

		if ($problemid < 7) {
			$row1 = 'CRH';
			$row2 = 'ACTH';	
			$row3 = 'cortisol';
	
			//Check CRH
			if (($submittedanswers[$i]['is'] != $answerkey[$i]['is'])) {
				$CorrectAnswers[$i]['is'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
					break;
					case 'rr':
						$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Check the feedback loops to make sure this variable is changing in the proper direction.<br /><br />";
						break;
					case 'ss':
						if (($submittedanswers['dr']['is'] != 'n') && ($submittedanswers['dr']['is'] != $submittedanswers['rr']['is'])) {
							$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}

				
			}

			//Check ACTH
			if ($submittedanswers[$i]['cvp'] != $answerkey[$i]['cvp']) {
				$CorrectAnswers[$i]['cvp'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['cvp'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row2 . ".  These have to go in the same direction.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['cvp'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row2 . ".  These have to go in the same direction.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['cvp'] != 'n') && ($submittedanswers['dr']['cvp'] != $submittedanswers['rr']['cvp'])) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}

			//Check Cortisol
			if ($submittedanswers[$i]['sv'] != $answerkey[$i]['sv']) {
				$CorrectAnswers[$i]['sv'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['sv'] != $submittedanswers[$i]['cvp']) && ($submittedanswers[$i]['cvp'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that " . $row2 . " causes the release of " . $row3 . ".  These have to go in the same direction.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['sv'] != $submittedanswers[$i]['cvp']) && ($submittedanswers[$i]['cvp'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that " . $row2 . " causes the release of " . $row3 . ".  These have to go in the same direction.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['sv'] != 'n') && ($submittedanswers['dr']['sv'] != $submittedanswers['rr']['sv'])) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}
		} else if ($problemid < 14) { 
			$row1 = 'TRH';
			$row2 = 'TSH';
			$row3 = 'T4';
			$row4 = "T3";
	
			//Check TRH
			if (($submittedanswers[$i]['is'] != $answerkey[$i]['is'])) {
				$CorrectAnswers[$i]['is'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
					break;
					case 'rr':
						$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Check the feedback loops to make sure this variable is changing in the proper direction.<br /><br />";
						break;
					case 'ss':
						if (($submittedanswers['dr']['is'] != 'n') && ($submittedanswers['dr']['is'] != $submittedanswers['rr']['is'])) {
							$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}

				
			}

			//Check TSH
			if ($submittedanswers[$i]['cvp'] != $answerkey[$i]['cvp']) {
				$CorrectAnswers[$i]['cvp'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['cvp'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row2 . ".  These have to go in the same direction.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['cvp'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row2 . ".  These have to go in the same direction.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['cvp'] != 'n') && ($submittedanswers['dr']['cvp'] != $submittedanswers['rr']['cvp'])) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}

			//Check T4
			if ($submittedanswers[$i]['sv'] != $answerkey[$i]['sv']) {
				$CorrectAnswers[$i]['sv'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['sv'] != $submittedanswers[$i]['cvp']) && ($submittedanswers[$i]['cvp'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that " . $row2 . " causes the release of " . $row3 . ".  These have to go in the same direction.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['sv'] != $submittedanswers[$i]['cvp']) && ($submittedanswers[$i]['cvp'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that " . $row2 . " causes the release of " . $row3 . ".  These have to go in the same direction.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['sv'] != 'n') && ($submittedanswers['dr']['sv'] != $submittedanswers['rr']['sv'])) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}
			
			//Check T3
			if ($submittedanswers[$i]['hr'] != $answerkey[$i]['hr']) {
				$CorrectAnswers[$i]['hr'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['hr'] != $submittedanswers[$i]['sv']) && ($submittedanswers[$i]['sv'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row4 . " is incorrect.  Remember that " . $row2 . " causes the release of minor amounts of " . $row4 . ".  However, most of it is made from " . $row3 . " in the peripheral tissues.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['hr'] != $submittedanswers[$i]['sv']) && ($submittedanswers[$i]['sv'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row4 . " is incorrect.  Remember that " . $row2 . " causes the release of minor amounts of " . $row4 . ".  However, most of it is made from " . $row3 . " in the peripheral tissues.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['hr'] != 'n') && ($submittedanswers['dr']['hr'] != $submittedanswers['rr']['hr'])) {
							$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}

		} else {
			$row1 = 'GnRH';
			$row2 = 'FSH';
			$row3 = 'LH';
			$row4 = "estrogen";
	
			//Check GnRH
			if (($submittedanswers[$i]['is'] != $answerkey[$i]['is'])) {
				$CorrectAnswers[$i]['is'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
					break;
					case 'rr':
						$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Check the feedback loops to make sure this variable is changing in the proper direction.<br /><br />";
						break;
					case 'ss':
						if (($submittedanswers['dr']['is'] != 'n') && ($submittedanswers['dr']['is'] != $submittedanswers['rr']['is'])) {
							$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}

			//Check FSH
			if ($submittedanswers[$i]['cvp'] != $answerkey[$i]['cvp']) {
				$CorrectAnswers[$i]['cvp'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['cvp'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row2 . ".  These have to go in the same direction.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['cvp'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row2 . ".  These have to go in the same direction.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['cvp'] != 'n') && ($submittedanswers['dr']['cvp'] != $submittedanswers['rr']['cvp'])) {
							$feedback[$i] .= $column . ": The " . $row2 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}

			//Check LH
			if ($submittedanswers[$i]['sv'] != $answerkey[$i]['sv']) {
				$CorrectAnswers[$i]['sv'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  (($submittedanswers[$i]['sv'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row3 . ".  These have to go in the same direction.<br /><br />";
						}
					break;
					case 'rr':
						if  (($submittedanswers[$i]['sv'] != $submittedanswers[$i]['is']) && ($submittedanswers[$i]['is'] != 'n')) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that " . $row1 . " causes the release of " . $row3 . ".  These have to go in the same direction.<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['sv'] != 'n') && ($submittedanswers['dr']['sv'] != $submittedanswers['rr']['sv'])) {
							$feedback[$i] .= $column . ": The " . $row3 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}

			//Check Estrogen
			if ($submittedanswers[$i]['hr'] != $answerkey[$i]['hr']) {
				$CorrectAnswers[$i]['hr'] = 0;
				$CompleteSolution = 0;
				switch ($i) {
					case 'dr':
						if  ((($submittedanswers[$i]['hr'] != $submittedanswers[$i]['cvp']) && ($submittedanswers[$i]['hr'] != $submittedanswers[$i]['sv'])) && (($submittedanswers[$i]['cvp'] != 'n') && ($submittedanswers[$i]['sv'] != 'n'))) {
							$feedback[$i] .= $column . ": The " . $row4 . " is incorrect.  Remember that " . $row2 . " & " . $row3 . " cause the release of " . $row4 . ".  At least one of these must go in the same direction as " . row4 .".<br /><br />";
						}
					break;
					case 'rr':
						if  ((($submittedanswers[$i]['hr'] != $submittedanswers[$i]['cvp']) && ($submittedanswers[$i]['hr'] != $submittedanswers[$i]['sv'])) && (($submittedanswers[$i]['cvp'] != 'n') && ($submittedanswers[$i]['sv'] != 'n'))) {
							$feedback[$i] .= $column . ": The " . $row4 . " is incorrect.  Remember that " . $row2 . " & " . $row3 . " cause the release of " . $row4 . ".  At least one of these must go in the same direction as " . row4 .".<br /><br />";
						}
						break;
					case 'ss':
						if (($submittedanswers['dr']['hr'] != 'n') && ($submittedanswers['dr']['hr'] != $submittedanswers['rr']['hr'])) {
							$feedback[$i] .= $column . ": The " . $row1 . " is incorrect.  Remember that the endocrine response dominates over the feedback response.<br /><br />";
						}
				}
			}
		}
		
	}
	
	//END, send results to back to javascript for browser processing
	//$returndata = [];
	$returndata['Complete'] = $CompleteSolution;
	$returndata['Feedback'] = $feedback;
	$returndata['CorrectAnswers'] = $CorrectAnswers;
	if ($CompleteSolution) {
		$returndata['Solution'] = $answerkey['solution'];
	}
	else {
		$returndata['Solution'] = "";
	}
	echo json_encode($returndata);
}


if (isset($_GET['fn'])) {
	if ($_GET['fn']=='LoadMenu') {
		LoadMenu();
	}
	
	if($_GET['fn']=='LoadProblem') {
		LoadProblem($_POST['ProblemID']);
	}
	
	if ($_GET['fn']=='CheckAnswers') {
		$directresponse = json_decode($_POST['DirectResponse'],true);
		$reflexresponse = json_decode($_POST['ReflexResponse'],true);
		$steadystate = json_decode($_POST['SteadyState'],true);
		CheckAnswers($_POST['ProblemID'],$directresponse,$reflexresponse,$steadystate,$_POST['Attempts']);
	}
	
	if ($_GET['fn']=='TutorialStart') {
		$initialinstructions = "First we will do the direct response.  Remember that this is the response that the system would have if there were no reflexes present (we will do the reflex response next).<br /><br />
		Recall that most of the blood in the body is located in the venous system. Loss of blood would, therefore, result in a decrease in central blood volume (CBV).  Recall that compliance is equal to volume/pressure.  
		Assuming the compliance doesn't change, the pressure should therefore decrease in proportion to the decrease in volume.  Central venous pressure (CVP) therefore decreases.  This is what we call the 'initial change'.  
		So the first variable in our table above which we have changed is the CVP.<br /><br />
		Press the 'Evaluate' button in the toolbar.  This checks to make sure the value entered is correct and allows you to either correct the value if it is incorrect or to proceed to the next variable if it is.";
		echo $initialinstructions;
	}
	
	if ($_GET['fn']=='TutorialComplete') {
		//echo LookupProblemAnswers(0)['solution'];
		echo LookupProblemAnswers(0);
	}
	
	if ($_GET['fn']=='TutorialProgress') {
		$directresponse = json_decode($_POST['DirectResponse'],true);
		$reflexresponse = json_decode($_POST['ReflexResponse'],true);
		$steadystate = json_decode($_POST['SteadyState'],true);
		TutorialProgress($_POST['TutorialStep'],$directresponse,$reflexresponse,$steadystate,$_POST['Attempts']);
	}
}

?>