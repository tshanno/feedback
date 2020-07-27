<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
<!DOCTYPE html>
<html>
<head>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src='./includes/functions.js'></script>
	<link rel="stylesheet" href="./includes/stylesheet.css">
	<title>FEEDBACK</title>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<p class='alignleft'>
			<span class='label'>FEEDBACK</span>
			<input type='submit' class='openpopup' id='openabout' value='About' divid='about' />
			</p>
			<p class='alignright'>
			<input type='submit' class='openpopup' id='opendirections' value='Directions' divid='directions' />
			<input type='submit' class='openpopup' id='openconcept' value='Concept Map' divid='conceptmap' />
			<input type='submit' class='openpopup' id='openhint' value='Hint' divid='hint' disabled />
			<input type='submit' class='openpopup' id='opensolution' value='Solution' divid='solution' problemcomplete='0' disabled />
			<input type='submit' id='checkanswers' value='Evaluate' submitcount='0' disabled />
			</p>
			<div style="clear: both;"></div>
		</div>
		<div id="menu"></div>
		<div id="main">
			<input type='hidden' id='problemid' value='' />
			<div id='problemname'></div>
			<div id='problemstem'></div>
			<div id='circsimtable'></div>
			<div id='feedback'></div>
			<div class='hover_popup' id='solution'>
				<span class='popup_helper'></span>
				<div>
					<div class='popupCloseButton' divid='solution'>X</div>
					<div id='solutioncontent'></div>
				</div>
			</div>
			<div class='hover_popup' id='hint'>
				<span class='popup_helper'></span>
				<div>
					<div class='popupCloseButton' divid='hint'>X</div>
					<div id='problemhint'></div>
				</div>
			</div>
			<div class='hover_popup' id='conceptmap'>
				<span class='popup_helper'></span>
				<div>
					<div class='popupCloseButton' divid='conceptmap'>X</div>
					<img src='./images/conceptmap.PNG' />
				</div>
			</div>
			<div class='hover_popup' id='directions'>
				<span class='popup_helper'></span>
				<div>
					<div class='popupCloseButton' divid='directions'>X</div>
					In order to get started, please choose a problem on the left.<br /><br />
					Each problem describes a situation in which a patient's initial state is perturbed.<br /><br />
					Each row in the table represents a endocrine variable which you should be able to easily recognize.<br /><br />
					Click on the "Evaluate" button to see how you did.  Incorrect answers will be in red.  Press the red buttons to change your answers.  The "FEEDBACK" text box will give you hints about what to correct.<br /><br />
					The "Concept Map" button gives you a flow diagram which you can use to follow along to help solve the problem (Note, however, that for hormones which you have had in your self-study that this will <span class='bold'>not</span> be available to you on the exam).<br /><br />
					The problems are similar to the CIRCSIM problems which you had earlier in the curriculum.<br /><br />
					Fill out the prediction table for each hormone.<br /><br />
					ER = direction of change of the hormones due to the direct response and the endocrine response independent of feedback<br />
					FR = direction of change of the feedback response<br />
					SS = the final steady-state hormone levels relative to where the patient started.
				</div>
			</div>
			<div class='hover_popup' id='about'>
				<span class='popup_helper'></span>
				<div>
					<div class='popupCloseButton' divid='about'>X</div>
					FEEDBACK<br />
					version 0.1<br /><br />
					Designed and written by:<br /><br />
					Thomas R. Shannon<br />
					Rush University<br />
					Chicago, IL
				</div>
			</div>
		</div>
	</div>
</body>
</html>