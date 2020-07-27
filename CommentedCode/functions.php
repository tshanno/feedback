<?php
/*
Created on Mon Oct 24 2018
PHP Functions File for CircSim Program
Based on Java CircSim program developed by T. Shannon & J. Michael (Rush University)

##Revision History
## 10/31/2018: Commented version
## 10/24/2018: Initial Scripting

@CodingAuthor: Brenden Hoff (Aeterna Holdings LLC; brendenhoff@aeternaholdings.com)
*/

require_once './problems.php'; //Load the problems so we can access the $problemlist variable
require_once './tutorial.php'; //Load the tutorial steps so we have access to the $tutorialsteps variable.

function LoadMenu() { //Populate the menu with problems to select.
	global $problemlist; //make $problemlist accessible to this function from the global environment
	$i=0; //initialize an iterator to keep track of the problem's index in the array
	foreach ($problemlist as $problem) { //loop through each problem in our problem list
		echo "<button class='problemselection' problemid='$i'>" . $problem['name'] . "</button>"; //for each one create an HTML button that Javascript will add to the webpage.
		$i++; //advance the iterator to properly index the next problem in our list
	}
}

function LoadProblem($problemid) { //Load a specific problem requested based on its ID number
	global $problemlist; //make $problemlist accessible to this function from the global environment

	$returndata = []; //Initialize an array of data to send back to javascript
	$problem = $problemlist[$problemid]; //Grab the specific problem from our problem list (based on its index)
	$returndata['name'] = $problem['name']; //Grab the problem name and add it to the array being sent back to javascript
	$returndata['stem'] = $problem['stem']; //Grab the problem stem and add it to the array being sent back to javascript
	$returndata['hint'] = $problem['hint']; //Grab the problem hint and add it to the array being sent back to javascript
	echo json_encode($returndata); //Convert the PHP array to a Javascript object, and write it out so Javascript can access it
}

function LookupProblemAnswers($problemid) {
	global $problemlist; //make $problemlist accessible to this function from the global environment
	$problem = $problemlist[$problemid]; //Grab the correct problem from the problem list (based on its index)
	return $problem; //Make that problem accessible to the calling function.
}

function CheckAnswers($problemid,$directresponse,$reflexresponse,$steadystate,$attempts) {
	$feedback = []; //Initialize an array to contain feedback about the submitted solution
	$feedback['GenericWrong'] = "Correct the following errors.  Correct the DR first, then the RR, then the SS.<br /><br />";
	//Initialize array for handling the submitted answers
	$submittedanswers = [];
	$submittedanswers['dr'] = $directresponse;
	$submittedanswers['rr'] = $reflexresponse;
	$submittedanswers['ss'] = $steadystate;
	
	//Lookup the correct answers
	$answerkey = LookupProblemAnswers($problemid);
	
	//Initialize array for tracking if answers are correct
	$CompleteSolution = 1; //Start out assuming they have everything correct, if something is wrong when we check answers, we will change this to FALSE.
	$responses = array('dr','rr','ss'); //here are the Responses we need to check over
	$parameters = array('is','cvp','sv','hr','co','tpr','map'); //Here are the parameters we need to check over
	$CorrectAnswers = []; //Initialize the array to keep track of each individual answer if its correct
	foreach ($responses as $response) { //Loop through each response
		foreach ($parameters as $parameter) { //And each parameter within the response
		$CorrectAnswers[$response][$parameter] = 1; //Assume they are correct until we check the answer, if wrong we will change that response/parameter pair to false
		}
	}
	
	//Check Initial Change
	$initialchange = $answerkey['initialchange']; //Check which variable was supposed to be changed first in the problem
	if ($submittedanswers['dr'][$initialchange] =='n') { //If the intial change parameter has not been changed (still 0, which we track as 'n' for no change)
		$feedback['InitialChange'] .= $feedback['InitialChange'] . "The initial change is " . strtoupper(${initialchange}) . ". <br /><br />"; //let them know what parameter needs to change first, add it to the feedback
		$CorrectAnswers['dr'][$initialchange] = 0; //Mark the direct response for the initial change parameter wrong
		$CompleteSolution = 0; //The solution is not completely correct.
	}
	else if ($submittedanswers['dr'][$initialchange] !='n' && $submittedanswers['dr'][$initialchange] != $answerkey['dr'][$initialchange]) { //If the initial change parameter has been changed (no longer 'n'), but it is not the correct change
		$feedback['InitialChange'] .= "The initial change is " . strtoupper(${initialchange}) . ". This value in the direct response is incorrect. <br /><br />"; //let them know it is wrong, add it to feedback
		$CorrectAnswers['dr'][$initialchange] = 0; //mark the direct response for the initial change parameter wrong
		$CompleteSolution = 0; //the solution is not correct
	}
	
	//Check each response/parameter pair to determine if correct, else provide feedback
	foreach ($response as $i){  //loop through each of the DR, RR, SS
		switch ($i) {
			case 'dr':
				$column = "DIRECT RESPONSE"; //If we're checking DR, put feedback with the DR feedback
				break;
			case 'rr':
				$column = "REFLEX RESPONSE"; //If we're checking RR, put feedback with the RR feedback
				break;
			case 'ss':
				$column = "STEADY STATE"; //If we're checking SS, put feedback with the SS feedback
				break;
		}
		//Check MAP, CO, TPR
		if ($submittedanswers[$i]['map'] != $submittedanswers[$i]['tpr'] && $submittedanswers[$i]['map'] != $submittedanswers[$i]['co']) { //Check if MAP/CO/TPR are changing in same direction
			$feedback[$i] .= $column . ": MAP=CO(TPR).  If MAP changes, either or both CO and TPR must change in the same direction.<br /><br />"; //else provide feedback
		}
	
		//Check CO, HR, SV
		if ($submittedanswers[$i]['co'] != $submittedanswers[$i]['hr'] && $submittedanswers[$i]['co'] != $submittedanswers[$i]['sv']) { //Check if CO/HR/SV are changing in same direction
			$feedback[$i] .= $column . ": CO=HR(SV).  If CO changes, either or both HR and SV must change in the same direction.<br /><br />"; //else provide feedback
		}
		
		//Check CVP
		if (($submittedanswers[$i]['cvp'] != $answerkey[$i]['cvp']) && (($i=='dr' && $initialchange != 'cvp') || ($i != 'dr'))) { //Check if the submitted CVP for this response doesn't match the answer key AND  EITHER {we are evalauating the DR, make sure that CVP wasn't the initial change [because thats already been checked] OR we aren't checking DR}
			$CorrectAnswers[$i]['cvp'] = 0; //CVP is wrong for the response we're checking
			$CompleteSolution = 0; //The solution isn't completely correct.
			if ($submittedanswers[$i]['co'] == $answerkey[$i]['co']) { //Check if they had CO correct , as that impacts CVP decision
				switch ($i) {
					case 'dr':
					case 'rr':
						$feedback[$i] .= $column . ": The CVP is incorrect.  Remember that the vascular function curve tells us that CVP changes in the opposite direction of CO.<br /><br />"; //IF CO correct, but CVP wrong, add this feedback if we were checking DR or RR
						break;
					case 'ss':
						$feedback[$i] .= $column . ": The CVP is incorrect.  If the DR and the RR are not the same, it can be helpful to remember that, unless there's an overriding reason not to do so, you can usually go with the direct response over the reflex response with this variable.<br /><br />"; //If CO correct, but CVP wron, add this feedback if we were checking SS.
						break;
				}
			}
			else { //CO was wrong too
				switch ($i) {
					case 'dr':
					case 'rr':
						$feedback[$i] .= $column . ": The CVP is incorrect.  This variable can be tricky.  Once you get the CO right it can be helpful to remember that the vascular function curve tells us that CVP changes in the opposite direction of CO.<br /><br />"; //CO wrong, and CVP wrong, add this feedback if we were checking DR or RR
						break;
					case 'ss':
						$feedback[$i] .= $column . ": The CVP is incorrect.      If the DR and the RR are not the same, it can be helpful to remember that, unless there's an overriding reason not to do so, you can usually go with the direct response over the reflex response with this variable.<br /><br />"; //CO wrong and CVP wrong, add this feedback if we were checking SS
						break;
				}
			}
		}
		
		//NOTE: The checks for the remaining parameters follow the same logic as CPV so I have NOT commented for every single one of them.
		
		//Check SV
		if (($submittedanswers[$i]['sv'] != $answerkey[$i]['sv']) && (($i=='dr' && $initialchange != 'sv') || ($i != 'dr'))) {
			$CorrectAnswers[$i]['sv'] = 0;
			$CompleteSolution = 0;
			switch ($i) {
				case 'dr':
				case 'rr':
					$feedback[$i] .= $column . ": The SV is incorrect.  Remember what the three things that determine SV are.  Which one is the strongest and which one is the weakest?  Also remember to check your causal relationship:  CO=HR(SV).  This can often tell you which way the SV went.<br /><br />";
					break;
				case 'ss':
					$feedback[$i] .= $column . ": The SV is incorrect.  Remember to check your causal relationship:  CO=HR(SV).  This can often tell you which way the SV went if the DR and the RR differ.  If it doesn't, you can often just go with the DR.<br /><br />";
					break;
			}
		}
		
		//Check TPR
		if (($submittedanswers[$i]['tpr'] != $answerkey[$i]['tpr']) && (($i=='dr' && $initialchange != 'tpr') || ($i != 'dr'))) {
			$CorrectAnswers[$i]['tpr'] = 0;
			$CompleteSolution = 0;
			switch ($i) {
				case 'dr':
					$feedback[$i] .= $column . ": The TPR is incorrect.  Remember that the TPR is dependent on how constricted the arterioles are.  This is usually dependent upon the baroreflex in the reflex response.  That is, its under neural control.  Think carefully about whether there is anything about the problem that would directly change this independent of the baroreflex.<br /><br />";
					break;
				case 'rr':
					$feedback[$i] .= $column . ": The TPR is incorrect.  Remember that the TPR is dependent on how constricted the arterioles are.  This is usually dependent upon the baroreflex in the reflex response.  That is, its under neural control.<br /><br />";
					break;
				case 'ss':
					$feedback[$i] .= $column . ": The TPR is incorrect.  Remember ot check your causal relationship:  MAP=CO(TPR).  This can often tell you which way the TPR went if the DR and the RR differ.  If it doesn't, you can often just go with the DR.<br /><br />";
					break;
			}
		}		
		
		//Check HR
		if (($submittedanswers[$i]['hr'] != $answerkey[$i]['hr']) && (($i=='dr' && $initialchange != 'hr') || ($i != 'dr'))) {
			$CorrectAnswers[$i]['hr'] = 0;
			$CompleteSolution = 0;
			switch ($i) {
				case 'dr':
				case 'rr':
					$feedback[$i] .= $column . ": The HR is incorrect.  Remember that the HR isusually dependent upon the baroreflex in the reflex response.  That is, it's under neural control.  Also remember that the HR should be consistent with your causal relationship:  CO=HR(SV).<br /><br />";
					break;
				case 'ss':
					$feedback[$i] .= $column . ": The HR is incorrect.  Remember to check your causal relationship:  CO=HR(SV).  This can often tell you which way the TPR if the DR and the RR differ.  If it doesn't, you can often just go with the DR in the absence of any overriding reason to do otherwise.<br /><br />";
					break;
			}
		}		
		
		//Check IS
		if (($submittedanswers[$i]['is'] != $answerkey[$i]['is']) && (($i=='dr' && $initialchange != 'is') || ($i != 'dr'))) {
			$CorrectAnswers[$i]['is'] = 0;
			$CompleteSolution = 0;
			switch ($i) {
				case 'dr':
					$feedback[$i] .= $column . ": The IS is incorrect.  Remember that the IS is usually dependent upon the baroreflex in the reflex response.  That is, it's under neural control.  Think carefully about whether or not there is something else about the problem that might directly change this independent of the baroreflex.<br /><br />";
					break;
				case 'rr':
					$feedback[$i] .= $column . ": The IS is incorrect.  Remember that the IS is usually dependent upon the baroreflex in the reflex response.  That is, it's under neural control.<br /><br />";
					break;
				case 'ss':
					$feedback[$i] .= $column . ": The IS is incorrect.  Remember that if the DR and the RR differ, you can often just go with the DR in the absence of any overriding reason to do otherwise.<br /><br />";
					break;
			}
		}
		
		//Check CO
		if (($submittedanswers[$i]['co'] != $answerkey[$i]['co']) && (($i=='dr' && $initialchange != 'co') || ($i != 'dr'))) {
			$CorrectAnswers[$i]['co'] = 0;
			$CompleteSolution = 0;
			switch ($i) {
				case 'dr':
				case 'rr':
					$feedback[$i] .= $column . ": The CO is incorrect.  The determinants of CO are SV and HR:  CO=HR(SV).  The dominant control variable is usually HR since it has the higher dynamic range.  Your answer should be consistent with this relationship.<br /><br />";
					break;
				case 'ss':
					$feedback[$i] .= $column . ": The CO is incorrect.  The determinants of CO are SV and HR:  CO=HR(SV).  Your answer should be consistent with this relationship.  Also remember that if the DR and the RR differ, you can often just go with the DR in the absence of any overriding reason to do otherwise.<br /><br />";
					break;
			}
		}
		
		//Check MAP
		if (($submittedanswers[$i]['map'] != $answerkey[$i]['map']) && (($i=='dr' && $initialchange != 'map') || ($i != 'dr'))) {
			$CorrectAnswers[$i]['map'] = 0;
			$CompleteSolution = 0;
			switch ($i) {
				case 'dr':
				case 'rr':
					$feedback[$i] .= $column . ": The MAP is incorrect.  The determinants of MAP are TPR and CO:  MAP=CO(TPR).  The dominant control variable is usually TPR since large changes result from small changes in arteriolar radius (Resistance is proportional to 1/r^4).  Your answer should be consistent with this relationship.<br /><br />";
					break;
				case 'ss':
					$feedback[$i] .= $column . ": The MAP is incorrect.  The determinants of MAP are TPR and CO:  MAP=CO(TPR).  Your answer should be consistent with this relationship.  The MAP is the regulated variable in the cardiovascular system.  Remember that the reflex response never quite completely compensates for the change in this variable the direct response.<br /><br />";
					break;
			}
		}
	}
	
	//HEY WE FINISHED CHECKING EVERYTHING and now have a list of what they answered correct/incorrect, as well as feedback	
	//END, send results to back to javascript for browser processing
	$returndata = []; //Initialize the array for data to send back to javascript
	$returndata['Complete'] = $CompleteSolution; //Tell javascript if they had teh complete solution or not
	$returndata['Feedback'] = $feedback; //Tell javascript what feedback they earned
	$returndata['CorrectAnswers'] = $CorrectAnswers; //Tell javascript which of their submitted answers were right/wrong, so we can change the button color. NOTE: this does not contain the full answer array, just if their answers were right or wrong
	if ($CompleteSolution) { //Check if they all their answers were completely correct
		$returndata['Solution'] = $answerkey['solution']; //If so give them the complete solution
	}
	else { //Their solution wasn't completely correct
		$returndata['Solution'] = ""; //No solution for them.
	}
	echo json_encode($returndata); //Convert the PHP data into a Javascript object and display it for javascript to pick up.
}

function TutorialProgress($step,$directresponse,$reflexresponse,$steadystate,$attempts) { //They are progressing through the tutorial and we need to check if they have completed this step succesfully
	global $tutorialsteps; //make $tutorialsteps available to the function from the global environment.
	$stepcomplete = 0; //Initialize the variable to say they have not completed the current step. We will change this later if they have completed the step
	$currentstep = $tutorialsteps[$step]; //Grab the step they are currently working on
	$response = $currentstep['response']; //Check which response is being adjusted on the current step
	$parameter = $currentstep['parameter']; //Check which parameter is being adjusted on the current step
	
	//Initialize array for submitted answers
	$submittedanswers = [];
	$submittedanswers['dr'] = $directresponse;
	$submittedanswers['rr'] = $reflexresponse;
	$submittedanswers['ss'] = $steadystate;
	
	if ($submittedanswers[$response][$parameter] == $currentstep['correctchange'] || $attempts=='2') { //Check if they properly adjusted the parameter OR if this is their third attempt at this step (attempts start at zero)
		$feedback = $currentstep['correctFeedback'] . "<br /><br /> " . $currentstep['nextPrompt']; //If so, provide the feedback that is correct for this step and the prompt for the next step
		$stepcomplete = 1; //Set that the step is complete
	}
	else {
		switch ($attempts) { //Else vary feedback based on which attempt this was
			case 0: //This was the first attempt
				$feedback = $currentstep['secondtryFeedback']; //Provide feedback for their second try of the current step
				break;
			case 1: //This was the second attempt
				$feedback = $currentstep['thirdtryFeedback']; //Provide feedback for their third try of the current step
				break;
		}
	}
	
	//END, send results back to javascript to process
	$returndata = []; //Initialize array for returning data to javascript
	$returndata['Feedback'] = $feedback; //Populate feedback of the return array based on what was decided above
	$returndata['StepComplete'] = $stepcomplete; //Let javascript know if they have completed the current step
	$returndata['currentfield'] = $currentstep['currentfield']; //Let javascript know the current field that was being worked on
	$returndata['correctchange'] = $currentstep['correctchange']; //Let javascript know the correct change of the current field
	$returndata['nextfield'] = $currentstep['nextfield']; //Let javascript know the next field that should be worked on [This is only used if they finished the current step]
	$returndata['tutorialComplete'] = $currentstep['tutorialComplete']; //Let javascript know if they have completed the tutorial.
	
	echo json_encode($returndata); //Convert the PHP data into a Javascript object and display it for javascript to pick up.
}

/*This is the code which gets processed anytime a request is made of the functions page
First we check if a FUNCTION was passed in the url ($_GET['fn'])
If one is set, we check which FUNCTION we want to do, and then proceed to that function
*/

if (isset($_GET['fn'])) {
	if ($_GET['fn']=='LoadMenu') {
		LoadMenu(); //We just loaded the webpage, Javascript is asking for the problem list. Go to the LoadMenu function to retrieve the problem names.
	}
	
	if($_GET['fn']=='LoadProblem') {
		LoadProblem($_POST['ProblemID']); //We are requesting to solve a specific problem. Lets get the information for that problem using the LoadProblem function. Javascript provided us with the ProblemID to load
	}
	
	if ($_GET['fn']=='CheckAnswers') { //We are  submitting the circsim table. First lets convert the POSTED responses form a Javascript object to a PHP array (json_decode). Then send that data to the CheckAnswers function to evaluate if they are correct.
		$directresponse = json_decode($_POST['DirectResponse'],true);
		$reflexresponse = json_decode($_POST['ReflexResponse'],true);
		$steadystate = json_decode($_POST['SteadyState'],true);
		CheckAnswers($_POST['ProblemID'],$directresponse,$reflexresponse,$steadystate,$_POST['Attempts']);
	}
	
	if ($_GET['fn']=='TutorialStart') { //We are starting the tutorial. We need to provide initial feedback for the tutorial progression.
		$initialinstructions = "First we will do the direct response.  Remember that this is the response that the system would have if there were no reflexes present (we will do the reflex response next).<br /><br />
		Recall that most of the blood in the body is located in the venous system. Loss of blood would, therefore, result in a decrease in central blood volume (CBV).  Recall that compliance is equal to volume/pressure.  
		Assuming the compliance doesn't change, the pressure should therefore decrease in proportion to the decrease in volume.  Central venous pressure (CVP) therefore decreases.  This is what we call the 'initial change'.  
		So the first variable in our table above which we have changed is the CVP.<br /><br />
		Press the 'Evaluate' button in the toolbar.  This checks to make sure the value entered is correct and allows you to either correct the value if it is incorrect or to proceed to the next variable if it is.";
		echo $initialinstructions;
	}
	
	if ($_GET['fn']=='TutorialProgress') { //They are moving on to the next step of the tutorial. Lets convert the POSTED responses from Javascript object to PHP array (json_decode). THen sent it to the TutorialProgress function to make sure they made the correct change to advance.
		$directresponse = json_decode($_POST['DirectResponse'],true);
		$reflexresponse = json_decode($_POST['ReflexResponse'],true);
		$steadystate = json_decode($_POST['SteadyState'],true);
		TutorialProgress($_POST['TutorialStep'],$directresponse,$reflexresponse,$steadystate,$_POST['Attempts']);
	}
	
	if ($_GET['fn']=='TutorialComplete') { //They completed the tutorial succesfully! Lets return the full solution
		echo LookupProblemAnswers(0)['solution'];
	}

}

?>