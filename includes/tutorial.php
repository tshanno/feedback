<?php

/*  This file is actually obsolete.  I decided not to bother with the tutorial because students will ahve already done CIRCSIM by the time they get to this.  
	I'm only keeping it in case I want to try to add something back later.
*/

//$tutorialsteps = [];
$tutorialsteps = array();

function CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete) {
	//$step = [];
	$step['response'] = $response;
	$step['parameter'] = $parameter;
	$step['currentfield'] = $response . $parameter;
	$step['correctchange'] = $correctchange;
	$step['nextfield'] = $nextfield;
	$step['secondtryFeedback'] = $secondtryFeedback;
	$step['thirdtryFeedback'] = $thirdtryFeedback;
	$step['correctFeedback'] = $correctFeedback;
	$step['nextPrompt'] = $nextPrompt;
	$step['tutorialComplete'] = $tutorialComplete;	
	return $step;
}

//Step 0
$response = "dr";
$parameter = "cvp";
$correctchange = "d";
$nextfield = "drsv";
$secondtryFeedback = "";
$thirdtryFeedback = "";
$correctFeedback = "The value is correct.  The CVP drops when blood volume is decreased.";
$nextPrompt = "Click on the SV button to predict the effect upon stroke volume.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 1
$response = "dr";
$parameter = "sv";
$correctchange = "d";
$nextfield = "drco";
$secondtryFeedback = "This is incorrect.  What are the 3 determinants of stroke volume?  Try again.  Click the red box to change the value.";
$thirdtryFeedback = "The three determinants of stroke volume in order of strength of effect are preload, inotropic state and afterload.  The preload has dropped so the SV should also drop.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The three determinants of stroke volume in order of strength of effect are preload, inotropic state and afterload.  The preload has dropped so the SV should also drop.";
$nextPrompt = "Predict the effect upon cardiac output (CO)";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 2
$response = "dr";
$parameter = "co";
$correctchange = "d";
$nextfield = "drmap";
$secondtryFeedback = "This is incorrect.  What are the determinants of cardiac output?  Try again.   Click the red box to change the value.";
$thirdtryFeedback = "The determinants of CO are HR and SV:  CO=HR(SV).  The stroke volume has dropped so the CO will drop.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct. The determinants of CO are HR and SV:  CO=HR(SV).  The stroke volume has dropped so the CO will drop.";
$nextPrompt = "Predict the effect upon MAP.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);
   
//Step 3
$response = "dr";
$parameter = "map";
$correctchange = "d";
$nextfield = "drtpr";
$secondtryFeedback = "This is incorrect.  What are the determinants of MAP?  Try again.   Click the red box to change the value.";
$thirdtryFeedback = "This is incorrect.  The determinants of MAP are TPR and CO: MAP=CO(TPR).  The CO has dropped so the MAP should drop.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The determinants of MAP are TPR and CO: MAP=CO(TPR).  The CO has dropped so the MAP should drop.";
$nextPrompt = "Predict what the effect will be upon TPR.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);
       
//Step 4
$response = "dr";
$parameter = "tpr";
$correctchange = "n";
$nextfield = "drhr";
$secondtryFeedback = "The TPR is determined by the state of the arterioles.  The smooth muscle in the arterioles is under neural control.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "The arterioles are under the control of the sympathetic nervous system.  The state of the SNS usually changes with the reflex response.  It has not changed here.  Therefore the TPR should not change.  Try again.";
$correctFeedback = "The value in the table is correct.  The state of the SNS usually changes with the reflex response.  It has not changed here.  Therefore the TPR should not change.";
$nextPrompt = "Predict what the effect will be upon HR.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 5
$response = "dr";
$parameter = "hr";
$correctchange = "n";
$nextfield = "dris";
$secondtryFeedback = "The HR is determined by the state of the SA node.  The SA node in the heart is under neural control.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "The SA node under the control of the autonomic nervous system.  The state of the ANS usually changes with the reflex response.  It has not changed here.  Therefore the HR should not change.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The state of the ANS usually changes with the reflex response.  It has not changed here.  Therefore the HR should not change.";
$nextPrompt = "Predict what the effect will be upon IS.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 6
$response = "dr";
$parameter = "is";
$correctchange = "n";
$nextfield = "rrtpr";
$secondtryFeedback = "The IS is determined by the state of the cardiac muscle.  The IS of the cardiac muscle is under neural control.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "The IS of the cardiac muscle is under the control of the autonomic nervous system.  The state of the ANS usually changes with the reflex response.  It has not changed here.  Therefore IS should not change.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The state of the ANS usually changes with the reflex response.  It has not changed here.  Therefore IS should not change.";
$nextPrompt = "Now let's move on to the reflex response.<br /><br /> Predict the effects upon TPR.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 7
$response = "rr";
$parameter = "tpr";
$correctchange = "u";
$nextfield = "rrmap";
$secondtryFeedback = "The TPR is determined by the state of the arterioles.  The smooth muscle in the arterioles is under neural control.  Try again.   Click the red box to change the value.";
$thirdtryFeedback = "The arterioles are under the control of the sympathetic nervous system.  The state of the SNS usually changes with the reflex response.  In this case the sympathetic tone in increasing as part of the baroreflex.  Therefore arteriolar constriction is taking place leading to an increase in the TPR.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The arterioles are under the control of the sympathetic nervous system.  The state of the SNS usually changes with the reflex response.  In this case the sympathetic tone in increasing as part of the baroreflex.  Therefore arteriolar constriction is taking place leading to an increase in the TPR.";
$nextPrompt = "Predict the effects upon MAP";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 8
$response = "rr";
$parameter = "map";
$correctchange = "u";
$nextfield = "rrhr";
$secondtryFeedback = "This is incorrect.  What are the determinants of MAP?  Try again.   Click the red box to change the value.";
$thirdtryFeedback = "This is incorrect.  The determinants of MAP are TPR and CO: MAP=CO(TPR).  The TPR is generally the stronger effect of the two (resistance is inversely proportional to the radius to the 4th power). Since the TPR has gone up, we expect the MAP to rise as well.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The determinants of MAP are TPR and CO: MAP=CO(TPR).  The TPR is generally the stronger effect of the two (resistance is inversely proportional to the radius to the 4th power). Since the TPR ahs gone up, we expect the MAP to rise as well.";
$nextPrompt = "Predict the effects upon HR";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 9
$response = "rr";
$parameter = "hr";
$correctchange = "u";
$nextfield = "rrco";
$secondtryFeedback = "The HR is determined by the state of the SA node.  The SA node in the heart is under neural control.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "The SA node under the control of the autonomic nervous system.  The state of the ANS usually changes with the reflex response.  As part of the baroreflex, the sympathetic tone has risen and the parasympathetic tone has decreased.  Therefore we expect the HR to rise.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The SA node under the control of the autonomic nervous system.  The state of the ANS usually changes with the reflex response.  As part of the baroreflex, the sympathetic tone has risen and the parasympathetic tone has decreased.  Therefore we expect the HR to rise.";
$nextPrompt = "Predict the effects upon CO";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 10
$response = "rr";
$parameter = "co";
$correctchange = "u";
$nextfield = "rrcvp";
$secondtryFeedback = "This is incorrect.  What are the determinants of cardiac output?  Try again.   Click the red box to change the value.";
$thirdtryFeedback = "The determinants of CO are HR and SV:  CO=HR(SV).  Of the two, HR has the strongest influence on cardiac output (the HR can increase a great deal whereas the SV can only increase to 1.5 times the resting value).  The HR has risen.  Therefore we expect the CO to rise.   Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct. The determinants of CO are HR and SV:  CO=HR(SV).  Of the two, HR has the strongest influence on cardiac output (the HR can increase a great deal whereas the SV can only increase to 1.5 times the resting value).  The HR has risen.  Therefore we expect the CO to rise.";
$nextPrompt = "Predict the effects upon CVP";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 11
$response = "rr";
$parameter = "cvp";
$correctchange = "d";
$nextfield = "rrsv";
$secondtryFeedback = "This is incorrect.  There is a relationship between CO and CVP which is defined by the vascular function curve.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "This is incorrect.  The vascular function curve tells us that CVP drops when CO rises.  Try again.";
$correctFeedback = "The value in the table is correct.    The vascular function curve tells us that CVP drops when CO rises.";
$nextPrompt = "Predict the effects upon SV";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 12
$response = "rr";
$parameter = "sv";
$correctchange = "d";
$nextfield = "rris";
$secondtryFeedback = "The three determinants of stroke volume in order of strength of effect are preload, inotropic state and afterload.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "The three determinants of stroke volume in order of strength of effect are preload, inotropic state and afterload.  The the effect of preload is defined by the cardiac (or ventricular) function curve.  The preload (the CVP) has dropped so the SV should also drop.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The three determinants of stroke volume in order of strength of effect are preload, inotropic state and afterload.  The the effect of preload is defined by the cardiac (or ventricular) function curve.  The preload (the CVP) has dropped so the SV should also drop.";
$nextPrompt = "Predict the effects upon IS";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 12
$response = "rr";
$parameter = "is";
$correctchange = "u";
$nextfield = "ssmap";
$secondtryFeedback = "The IS is determined by the state of the cardiac muscle.  The IS of the cardiac muscle is under neural control.  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "The IS of the cardiac muscle is under the control of the autonomic nervous system.  The state of the ANS usually changes with the reflex response.  Since the sympathetic tone has risen (and, if we are talking about the atria,  The parasympathetic tone has dropped) the IS should rise.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The state of the ANS usually changes with the reflex response.  Since the sympathetic tone has risen (and, if we are talking about the atria,  The parasympathetic tone has dropped) the IS should rise.";
$nextPrompt = "OK.  Let's go on to determine what the steady-state values are.  Remember that the steady-state is achieved when the response is over and the variables are no longer changing due to the direct and reflex responses.\n\nFirst let's look at MAP.  Predict the value.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 13
$response = "ss";
$parameter = "map";
$correctchange = "d";
$nextfield = "ssis";
$secondtryFeedback = "Incorrect.  The MAP is the regulated variable in this system.  The direct response went down.  What does this tell you about the steady-state?  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "Incorrect.  The MAP is the regulated variable in this system.  The regulated variable never quites get back to where it began.  Therefore the MAP is still slightly down despite the effect of the reflex response.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The MAP is the regulated variable in this system.  The regulated variable never quites get back to where it began.  Therefore the MAP is still slightly down despite the effect of the reflex response.";
$nextPrompt = "Predict the value for IS.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 14
$response = "ss";
$parameter = "is";
$correctchange = "u";
$nextfield = "sscvp";
$secondtryFeedback = "Incorrect.  IS didn't change in the DR but it did in the RR.  There's only one direction to go with this.";
$thirdtryFeedback = "Incorrect.  IS didn't change in the DR but it rose in the RR.  Therefore it must be up at steady-state.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  IS didn't change in the DR but it rose in the RR.  Therefore it must be up at steady-state.";
$nextPrompt = "Predict the value for CVP.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 15
$response = "ss";
$parameter = "cvp";
$correctchange = "d";
$nextfield = "sssv";
$secondtryFeedback = "That's incorrect.  The CVP dropped in both the DR and the RR.  I think you know where to go with this.";
$thirdtryFeedback = "Incorrect, again.  The CVP dropped in the DR, then decreased further in the RR.  So it wouldn't make much sense if it increased or didn't change.  It decreases.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The CVP dropped in the DR, then decreased further in the RR.  So it must be decreased in thesteady-state.";
$nextPrompt = "Predict the change in SV.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 16
$response = "ss";
$parameter = "sv";
$correctchange = "d";
$nextfield = "sshr";
$secondtryFeedback = "That's incorrect.  The SV dropped in both the DR and the RR.  I think you know where to go with this.";
$thirdtryFeedback = "Incorrect, again.  The SV dropped in the DR, then decreased further in the RR.  So it wouldn't make much sense if it increased or didn't change.  It decreases.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The SV dropped in the DR, then decreased further in the RR.  So it must be decreased in thesteady-state.";
$nextPrompt = "Predict the value for HR.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 17
$response = "ss";
$parameter = "hr";
$correctchange = "u";
$nextfield = "sstpr";
$secondtryFeedback = "Incorrect.  HR didn't change in the DR but it did in the RR.  There's only one direction to go with this.";
$thirdtryFeedback = "Incorrect.  HR didn't change in the DR but it rose in the RR.  Therefore it must be up at steady-state.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  HR didn't change in the DR but it rose in the RR.  Therefore it must be up at steady-state.";
$nextPrompt = "Predict the value for TPR.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 18
$response = "ss";
$parameter = "tpr";
$correctchange = "u";
$nextfield = "ssco";
$secondtryFeedback = "Incorrect.  TPR didn't change in the DR but it did in the RR.  There's only one direction to go with this.";
$thirdtryFeedback = "Incorrect.  TPR didn't change in the DR but it rose in the RR.  Therefore it must be up at steady-state.  Try again.    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  TPR didn't change in the DR but it rose in the RR.  Therefore it must be up at steady-state.";
$nextPrompt = "Predict the steady-state CO.";
$tutorialComplete = 0;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);

//Step 19
$response = "ss";
$parameter = "co";
$correctchange = "d";
$nextfield = "";
$secondtryFeedback = "That's not correct.  The CO decreased in the DR but it increased in the RR.  So determining the direction of change in the steady-state is tricky.  The key to solving this problem often lies in checking for consistency with our causal relationships.  Which of these can we use here?  Try again.    Click the red box to change the value.";
$thirdtryFeedback = "Incorrect again.  The values in each response must be consistent with the causal relationships.  In this case, that means: MAP=CO(TPR).  The TPR is up.  So we know that the CO must be down.  Otherwise there's no way the MAP could be down.  Try again    Click the red box to change the value.";
$correctFeedback = "The value in the table is correct.  The values in each response must be consistent with the causal relationships.  In this case, that means: MAP=CO(TPR).  The TPR is up.  So we know that the CO must be down.  Otherwise there's no way the MAP could be down.";
$nextPrompt = "Congratulations.  You have completed your first exercise.  Press 'Solution' to see the solution to this problem explained.  After that, please pick another problem to the left.  When you do that one, fill out the entire table, then press 'Evaluate'.  Correct the answers from there and 'Evaluate' as often as you like.";
$tutorialComplete = 1;
$NewStep = CreateStep ($response, $parameter, $correctchange, $nextfield, $secondtryFeedback, $thirdtryFeedback, $correctFeedback, $nextPrompt, $tutorialComplete);
array_push($tutorialsteps,$NewStep);
    
?>