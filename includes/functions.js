/*
Created on Mon Oct 24 2018
Javascript File for CircSim Program
Based on Java CircSim program developed by T. Shannon & J. Michael (Rush University)

##Revision History
## 10/24/2018: Initial Scripting
@CodingAuthor: Brenden Hoff (Aeterna Holdings LLC; brendenhoff@aeternaholdings.com)
*/

$(document).ready(function(){
	function LoadProblem(problemid) {
		$.post('./includes/functions.php?fn=LoadProblem',{ProblemID: problemid}).done(function(data){
			$("#problemid").val(problemid);
			$("#opensolution").attr('problemcomplete','');
			$("#feedback").empty();
			var results = JSON.parse(data);
			$("#problemname").html(results['name']);
			$("#problemstem").html(results['stem']);
			if(results['hint']!='') {
				$("#problemhint").html(results['hint']);
				$("#openhint").attr("disabled",false);
			}
			else {
				$("#problemhint").html("No hint available");
				$("#openhint").attr("disabled",true);
			}
			if ($("#problemid").val() < 7) {
				$("#circsimtable").load('./includes/cortisoltable.php',function(){});
			} else if ($("#problemid").val() < 14) {
				$("#circsimtable").load('./includes/thyroidtable.php')
			} else {
				$("#circsimtable").load('./includes/estrogentable.php')
			}
		});
	}	
		

	
	function EvaluateAnswers(ProblemID, DirectResponse, ReflexResponse, SteadyState, Attempts) {
		$.post("./includes/functions.php?fn=CheckAnswers", {ProblemID: ProblemID, DirectResponse: JSON.stringify(DirectResponse), ReflexResponse: JSON.stringify(ReflexResponse), SteadyState: JSON.stringify(SteadyState), Attempts: Attempts}).done(function(data){
			var results = JSON.parse(data);
			for (var response in results['CorrectAnswers']){
				for (var parameter in results['CorrectAnswers'][response]){
					if (results['CorrectAnswers'][response][parameter]) {
						$("#"+response+parameter).attr('class','answer');
					}
					else {
						$("#"+response+parameter).attr('class','wronganswer');
					}
				}
			}

			if (results['Complete']) {
				$("#opensolution").attr('disabled',false);
				$("#opensolution").attr('problemcomplete','1');
				$("#feedback").empty();
				$("#solutioncontent").html(results['Solution']);
				alert("All are correct, good job!");
				$("#solution").show();
			}
			else {
				$("#feedback").html(results['Feedback']['GenericWrong']);
				$("#feedback").append(results['Feedback']['InitialChange']);
				$("#feedback").append(results['Feedback']['dr']);
				$("#feedback").append(results['Feedback']['rr']);
				$("#feedback").append(results['Feedback']['ss']);
				
			}
		});
	}
		
	//This loads the list of problems	
	$("#menu").load('./includes/functions.php?fn=LoadMenu');
	
	//This loads the requested problem
	$(document).on('click',"button.problemselection",function() {
		var problemid = $(this).attr('problemid');
		var currentproblem = $("#problemid").val();
		var problemstatus = $("#opensolution").attr('problemcomplete');
		$("#checkanswers").attr("disabled",false);
		$("#opensolution").attr("disabled",true);
		$("#openhint").attr("disabled",true);
		if (problemid == currentproblem) {
		}
		else if (currentproblem!='' && problemstatus!='1') {
			var confirmnewproblem = confirm("You are about to switch problems without completing the current one. You will lose all progress on this problem. Continue?");
		}
		else {
			var confirmnewproblem = 1;
		}
		
		if (confirmnewproblem) {
			$("button.problemselection").attr('activeproblem',0);
			$(this).attr('activeproblem',1);
			LoadProblem(problemid);
		}
	});
	
	//This adjusts the answer value by clicking the button.
	$(document).on('click',"button.answer, button.wronganswer",function() {
		switch($(this).val()) {
			case "n":
				$(this).html("&uarr;");
				$(this).val("u");
				break;
			case "u":
				$(this).html("&darr;");
				$(this).val("d");
				break;
			case "d":
				$(this).html("0");
				$(this).val("n");
				break;
			default:
				alert("unknown error");
			
		}
	});
	
	//This submits the form data to the function php page for analyzing answers
	$(document).on('click',"#checkanswers",function(){
		var DirectResponse = new Object();
		var ReflexResponse = new Object();
		var SteadyState = new Object();
		var ProblemID = parseInt($("#problemid").val(),10);
		var Attempts = parseInt($("#checkanswers").attr("submitcount"),10);
		
		DirectResponse.is = $("#dris").val();
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
		
		
		EvaluateAnswers(ProblemID, DirectResponse, ReflexResponse, SteadyState, Attempts);
	});
		

	//This allows the popup box to open when clicked on
	$(document).on("click","input.openpopup",function(){
		var divid = $(this).attr("divid");
		$('#' + divid).show();
	});
	
	//These functions allows the popup box to close when exit is pressed.	
	$(document).on("click",".popupCloseButton", function() {
		var divid = $(this).attr("divid");
		$('#' + divid).hide();
	});
	
});