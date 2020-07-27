/*
Created on Mon Oct 24 2018
Javascript File for CircSim Program
Based on Java CircSim program developed by T. Shannon & J. Michael (Rush University)

##Revision History
## 10/31/2018: Commented version
## 10/24/2018: Initial Scripting
@CodingAuthor: Brenden Hoff (Aeterna Holdings LLC; brendenhoff@aeternaholdings.com)
*/

/*
When going through this code, I recommend skipping over the "Function" blocks until you get to a line that calls that function. and then scrolling back up to see what the function is doing.
*/

/*
This wraps all the javascript code we will use. 
Essentially it tells javascript to be prepared to use any of the following code once the document has fully loaded. 
This is necessary for Javascript to monitor for HTML elements which might not be initially loaded on the webpage.
*/
$(document).ready(function(){
	
	function LoadProblem(problemid) {//This function loads the problem from the function.php page and takes the problemid as input
		$.post('./includes/functions.php?fn=LoadProblem',{ProblemID: problemid}).done(function(data){ //This is the post statement which sends the request to the functions.php page; $_GET['fn']=='LoadProblem'; $_POST['ProblemID']==problemid. The .done() appendage indicates once the functions.php page has finished loading to take the data it returns and do the next steps
			$("#problemid").val(problemid); //this updates the value of the HTML element w/ ID "problemid" to be the current problem number that has just loaded
			$("#opensolution").attr('problemcomplete','') //this updates the attribute "problemcomplete" of the HTML element w/ ID "opensolution" to be blank [because the problem isn't complete since we just loaded it!]
			$("#feedback").empty(); //this clears any content located in the HTML element with the ID of "feedback"
			var results = JSON.parse(data); //this converts the data, returned from posting to functions.php from a javascript object to a Javascript array called "results". We will next access this array via it's indexes
			$("#problemname").html(results['name']); //This replaces the content ("innerHTML") of the element w/ ID "problemname" with the content located in results under the "name" key [from PHP]. AKA problem name
			$("#problemstem").html(results['stem']); //This replaces the content ("innerHTML") of the element w/ ID "problemstem" with the content located in results under the "stem" key [from PHP]. AKA problem stem
			if(results['hint']!='') { //if the hint data from PHP is not blank
				$("#problemhint").html(results['hint']); //Replace the content ("innerHTML") of the element w/ ID "problemhint" with the content located in results under the "hint" key [from PHP]. AKA problem hint
				$("#openhint").attr("disabled",false); //Change the disabled attribute to false on the element w/ ID "openhint" [this is a button, and lets the user press it so they can view the hint]
			}
			else {
				$("#problemhint").html("No hint available");
				$("#openhint").attr("disabled",true); //Change the disabled attribute to true on the element w/ ID "openhint" [this is a button, and prevents the user from pressing the button as there is no hint.]
			}
			$("#circsimtable").load('./includes/circsimtable.php',function(){ //This replaces the content ("innerHTML") of the element w/ ID "circsimtable" with the content loaded from ./includes/circsimtable.php [THIS is the HTML of the circsim table]
				if ($("#tutorialmode").attr('tutorialactive')=='1') { //Check if the attribute "tutorialactive" is 1 on the element w/ ID "tutorialmode". IF SO, we are running tutorial mode and need to load the first step of the tutorial!
					$("button.answer").attr('disabled',true); //If so disable all the answer buttons on the circsim table
					$("button#drcvp").html("&darr;"); //Set the DR CVP button to display a downarrow - first step of tutorial
					$("button#drcvp").val("d"); //Set the value of the DR CVP button to 'd' for down - first step of tutorial
					$.post('./includes/functions.php?fn=TutorialStart').done(function(data){ //send a request to functions.php $_GET['fn']=='TutorialStart' and wait for the data to come back
						$("#feedback").html(data); //Use the returned data and replace the content ("innerHTML") of the element w/ ID "feedback" with the data that came back.
					});
				}			
			});
		});
	}	
	
	function StartTutorial() { //Lets start the tutorial
		$("#tutorialmode").attr('tutorialactive','1'); //update the attribute "tutorialactive" to 1 on the element w/ ID "tutorialmode". This lets us keep track of the fact we are currently doing the tutorial
		$("#tutorialmode").attr('disabled',true); //disable the element w/ ID "tutorialmode". This is a button and stops it from being pressed again since we are already in tutorial mode!
		$("#tutorialprogress").val(0); //set the element w/ ID "tutorialprogress" to have a value of 0. This element is keeping track of what step in the tutorial we are on. We start with step 0
		$("#checkanswers").attr("disabled",false); //Enable the check answers button (ID: checkanswers).
		$("#opensolution").attr("disabled",true); //disable the show solution button (ID: opensolution). Because the solution is not yet complete
		$("#openhint").attr("disabled",true); //Disable the hint button (ID: openhint) since there is no hint needed for the tutorial.
		LoadProblem(0); //Load the problem, which for the tutorial will always have an index in the problem array of 0.
	}
	
	function EvaluateTutorial(DirectResponse, ReflexResponse, SteadyState, Attempts) { //This function checks responses when the user is in the tutorial
		var TutorialStep = parseInt($("#tutorialprogress").val(),10); //Firest, figure out what step we are on. Check the value of the ID: "tutorialprogress" element. convert it from string->INT using base 10 numbering [parseInt(string,10)]
		$.post("./includes/functions.php?fn=TutorialProgress", {TutorialStep: TutorialStep, DirectResponse: JSON.stringify(DirectResponse), ReflexResponse: JSON.stringify(ReflexResponse), SteadyState: JSON.stringify(SteadyState), Attempts: Attempts}).done(function(data){ //Post the current responses to functions.php and use the TutorialProgress function to evaluate the posted data on PHP page. Wait until the functions.php page finishes before going to next step.
			var results = JSON.parse(data); //convert the returned javascript object into a javascript array accessible by index (results)
			if (results['StepComplete']) { //Check if the current step is complete
				$("#checkanswers").attr("submitcount",0); //If so, reset how many times an answer has been submitted to 0 (attribute "submitcount" of ID "checkanswers")
				$("#tutorialprogress").val(TutorialStep+1); //Update the value of ID "tutorialprogress" to the next TutorialStep
				$("button#"+results['currentfield']).attr('class','answer'); //Change the class attribute on the button w/ ID = field from the just completed step, to "answer"
				$("button#"+results['currentfield']).attr('disabled',true); //Disable the button they were just using, as that button is no longer needed to adjust for the next step.
				switch (results['correctchange']) { //Ensure the field for the step they just finished is updated to the correct value.
					case "n":
						$("button#"+results['currentfield']).html("0"); 
						$("button#"+results['currentfield']).val("n");
						break;
					case "u":
						$("button#"+results['currentfield']).html("&uarr;");
						$("button#"+results['currentfield']).val("u");
						break;
					case "d":
						$("button#"+results['currentfield']).html("&darr;");
						$("button#"+results['currentfield']).val("d");
						break;
				}
				if(results['nextfield']!=''){ //Check if the next field to work on is defined
					$("button#"+results['nextfield']).attr('disabled',false); //enable the button for that next parameter
				}
				$("#feedback").html(results['Feedback']); //Replace the content of the feedback DIV w/ the feedback received
				
				if (results['tutorialComplete']) { //Check if PHP said they were complete with the tutorial
					$.post("./includes/functions.php?fn=TutorialComplete").done(function(data){ //if so post to functions.php, GET the TutorialComplete function. Wait until functions.php completes before moving on
						$("#opensolution").attr('disabled',false); //Enable the open solution button
						$("#opensolution").attr('problemcomplete','1'); //Set the problem complete attribute to 1
						$("#checkanswers").attr('disabled',true); //Disable the evaluate button (no longer needed since the tutorial is complete)
						$("#solutioncontent").html(data); //Update the solutioncontent DIV w/ the solution returned from PHP
					});
				}
			}
			else { //THe current step is not complete
				$("#checkanswers").attr("submitcount",Attempts+1); //advance how many attempts they have made; store it in the submitcount attribute of ID checkanswers
				$("button#"+results['currentfield']).attr('class','wronganswer'); //change the button for the current parameter they are working on to have class "wronganswer". This gives it a red background
				$("#feedback").html(results['Feedback']); //Replace the feedback DIV content w/ the most recent feedback received.
			}
		});
	}
	
	function EvaluateAnswers(ProblemID, DirectResponse, ReflexResponse, SteadyState, Attempts) { //this evaluates the answers when a problem is being run outside of tutorial mode
		$.post("./includes/functions.php?fn=CheckAnswers", {ProblemID: ProblemID, DirectResponse: JSON.stringify(DirectResponse), ReflexResponse: JSON.stringify(ReflexResponse), SteadyState: JSON.stringify(SteadyState), Attempts: Attempts}).done(function(data){ //Post data to functions.php to be evaluated, requesting the CheckAnswers function. Wait until functions.php finished before continuing
			var results = JSON.parse(data); //convert Javascript Object returned from PHP to a javascript array, accessible via index
			for (var response in results['CorrectAnswers']){ //loop through the CorrectAnswers array, for each response (DR, RR, SS)
				for (var parameter in results['CorrectAnswers'][response]){ //Loop through each parameter within the array
					if (results['CorrectAnswers'][response][parameter]) { //If that parameter/response pair was correct (returned 1 from PHP)
						$("#"+response+parameter).attr('class','answer'); //change the class for that button to "answer" which gives it a normal background
					}
					else { //else that parameter/response pair was wrong
						$("#"+response+parameter).attr('class','wronganswer'); //change the class for that button to "wronganswer" which gives it a red background
					}
				}
			}

			if (results['Complete']) { //CHeck if the solution was complete
				$("#opensolution").attr('disabled',false); //if so, enable the solution button
				$("#opensolution").attr('problemcomplete','1'); //set the problemcomplete attribute to 1
				$("#feedback").empty(); //clear the feedback div of any content
				$("#solutioncontent").html(results['Solution']); //replace the ID "solutioncontent" div content w/ the solution to the problem
				alert("All are correct, good job!"); //let the user know they have succesfully completed the problem
				$("#solution").show(); //open the solution div, which contains "solutioncontent" within it, so the user can see the solution
			}
			else { //The solution wasn't complete
				$("#feedback").html(results['Feedback']['GenericWrong']); //Replace the content in the feedback div w/ the generic wrong answer feedback
				$("#feedback").append(results['Feedback']['InitialChange']); //Append to the feedback div any feedback about the initial change
				$("#feedback").append(results['Feedback']['dr']); //APpend regarding direct response
				$("#feedback").append(results['Feedback']['rr']); //Append regarding reflex response
				$("#feedback").append(results['Feedback']['ss']); //Append regarding steady state
				
			}
		});
	}
		
	//This loads the list of problems	
	$("#menu").load('./includes/functions.php?fn=LoadMenu'); //Load the content from functions.php GETTING function LoadMenu. This gets the list of problem names and populates it into the "menu" div.
	
	//This loads the requested problem
	$(document).on('click',"button.problemselection",function() { //when a button of class "problemselection" is clicked, do this
		var problemid = $(this).attr('problemid'); //check the "problemid" attribute for the button that was just clicked ($(this))
		var currentproblem = $("#problemid").val(); //get the value of the element "problemid", this tells us which problem, if any is currently being worked on
		var problemstatus = $("#opensolution").attr('problemcomplete') //check the "probelmstatus" attribute located in ID "opensolution" to see what the current progress is on the currently opened problem
		$("#checkanswers").attr("disabled",false); //Enable the "evaluate" button (ID: checkanswers). They are requesting a problem so we should make sure they can evaluate it...
		$("#opensolution").attr("disabled",true); //Disable the solution button (ID: opensolution). This is a new problem being loaded, so they aren't ready to check the final solution yet.
		$("#openhint").attr("disabled",true); //disable the hint button (ID: openhint). We don't know if there will be a hint yet, so lets disable the button for now.
		if (problemid == currentproblem) { //Check if the problem they clicked on the load, is the same as the problem that's currently loaded.
		} //If so, do nothing
		else if (currentproblem!='' && problemstatus!='1') { //Else check if they currently have a problem loaded, and have not yet completed it
			var confirmnewproblem = confirm("You are about to switch problems without completing the current one. You will lose all progress on this problem. Continue?"); //if so, confirm they want to load the new problem
		}
		else { //they are done with the current problem,
			var confirmnewproblem = 1;
		}
		
		if (confirmnewproblem) { //if they wanted to load a new problem			
			$("button.problemselection").attr('activeproblem',0); //set the activeproblem attribute to 0 for all problemselection buttons
			$(this).attr('activeproblem',1); //add the activeproblem attribute to the selected problem
			LoadProblem(problemid); //Go to the LoadProblem function, loading the ID of the problem clicked on
			$("#tutorialmode").attr('tutorialactive','0'); //set attribute "tutorialactive" of the ID: tutorialmode element to 0 (they didn't request tutorial mode)
			$("#tutorialmode").attr('disabled',false); //enable the tutorial button to ensure they can click it if they want to
		}
	});
	
	//This adjusts the answer value by clicking the button.
	$(document).on('click',"button.answer, button.wronganswer",function() { //when a button of class "answer" or "wronganswer" is clicked, do this
		switch($(this).val()) { // check the current value of the button (n=0, u=up, d=down)
			case "n": //if its currently "n"
				$(this).html("&uarr;"); //change to an up arrow display
				$(this).val("u"); //change the value to 'u'
				break;
			case "u": //if it's currently "u"
				$(this).html("&darr;"); //change to a down arrow display
				$(this).val("d"); //change the value to 'd'
				break;
			case "d": //if it's currently "d"
				$(this).html("0");  //change to zero display [no change]
				$(this).val("n"); //change value to 'n'
				break;
			default:
				alert("unknown error"); //Else something FUBAR. Give a popup error
			
		}
	});
	
	//This submits the form data to the function php page for analyzing answers
	$(document).on('click',"#checkanswers",function(){ //when the element w/ ID "checkanswers" is clicked [this is the Evaluate button]
		var DirectResponse = new Object(); 
		var ReflexResponse = new Object();
		var SteadyState = new Object();
		var ProblemID = parseInt($("#problemid").val(),10); //check the value stored in element w/ ID problemid. Convert Str-> Int using base 10 (ParseInt(string,10))
		var Attempts = parseInt($("#checkanswers").attr("submitcount"),10); //check how many  attempts have been made (stored in submitcount attribute of ID checkanswers)
		
		DirectResponse.is = $("#dris").val(); //get the value stored in the element w/ id "dris". This is the button corresponding to the direct response, inotropic state.. Store it in the direct response object...and so forth for the remaining parameters
		DirectResponse.cvp = $("#drcvp").val();
		DirectResponse.sv = $("#drsv").val();
		DirectResponse.hr = $("#drhr").val();
		DirectResponse.co = $("#drco").val();
		DirectResponse.tpr = $("#drtpr").val();
		DirectResponse.map = $("#drmap").val();

		ReflexResponse.is = $("#rris").val();
		ReflexResponse.cvp = $("#rrcvp").val();
		ReflexResponse.sv = $("#rrsv").val();
		ReflexResponse.hr = $("#rrhr").val();
		ReflexResponse.co = $("#rrco").val();
		ReflexResponse.tpr = $("#rrtpr").val();
		ReflexResponse.map = $("#rrmap").val();

		SteadyState.is = $("#ssis").val();
		SteadyState.cvp = $("#sscvp").val();
		SteadyState.sv = $("#sssv").val();
		SteadyState.hr = $("#sshr").val();
		SteadyState.co = $("#ssco").val();
		SteadyState.tpr = $("#sstpr").val();
		SteadyState.map = $("#ssmap").val();
		
		if ($("#tutorialmode").attr('tutorialactive')=='1') { //if they are currently in tutorial mode
			EvaluateTutorial(DirectResponse, ReflexResponse, SteadyState, Attempts); //submit to the EvaluateTutorial Function
		}
		
		else {
			EvaluateAnswers(ProblemID, DirectResponse, ReflexResponse, SteadyState, Attempts); //submit to the EvaluateAnswers function
		}
	});
		

	//This allows the popup box to open when clicked on
	$(document).on("click","input.openpopup",function(){ //when an input button of class "openpopup" is clicked
		var divid = $(this).attr("divid"); //check the divid attribute associated with the input that was just pushed ($(this))
		$('#' + divid).show(); //display the elment w/ ID that matches the divid of the button
	});
	
	//These functions allows the popup box to close when exit is pressed.	
	$(document).on("click",".popupCloseButton", function() { //when an element w/ class "popupCloseButton" is clicked
		var divid = $(this).attr("divid"); //check the divid attribute stored in that element
		$('#' + divid).hide(); //hide that element w/ matching divid
	});
	
	//This starts the tutorial mode for the first problem.
	$(document).on("click","#tutorialmode", function() { //when the element w/ ID tutorialmode is clicked (this is a button)
		var currentproblem = $("#problemid").val(); //check the value of the current problem
		if (currentproblem!='') { //if they currently have a problem open
			var confirmtutorial = confirm("This will start a guided walkthrough of problem #1. You will lose your progress on your current problem. Continue?"); //Confirm starting tutorial
		}
		else {
			var confirmtutorial = confirm("This will start a guided walkthrough of problem #1. Continue?"); //confirm starting tutorial
		}
		if (confirmtutorial) { //if they confirmed
			$("button.problemselection").attr('activeproblem',0); //set the activeproblem attribute to 0 for all problemselection buttons
			$("button.problemselection[problemid='0']").attr('activeproblem',1); //set the activeproblem attribute to 1 for the problemselection button w/ problemid='0' (tutorial problem)
			StartTutorial(); //start tutorial.
		}
	});
});