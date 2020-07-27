<?php
//$problemlist = [];
$problemlist = array();
$uparrow = "&uarr;";
$downarrow = "&darr;";
$rightarrow = "&rarr;";

function CreateProblem ($name, $stem, $initialchange, $dranswer, $rranswer, $ssanswer, $hint, $solution) {
	//$problem = [];
	$problem['name'] = $name;
	$problem['stem'] = $stem;
	$problem['initialchange'] = $initialchange;
	$problem['dr'] = $dranswer;
	$problem['rr'] = $rranswer;
	$problem['ss'] = $ssanswer;
	$problem['hint'] = $hint;
	$problem['solution'] = $solution;
	
	return $problem;
}

//Problem #1 
$ProblemName = "1.  Stab wound";
$ProblemStem = "You are presented who has a stab wound.";
$InitialChange = "is";
$DirectResponse = array('is'=>'u','cvp'=>'u','sv'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'u');
$Hint = "";
$Solution = "The initial change is $uparrow CRH because the stab wound is a form of stress.<br /><br />
The stress causes the hypothalamus to release CRH.  The increased CRH causes the anterior pituitary to release ACTH.  The increased ACTH causes the adrenal gland to release cortisol as part of the stress response.<br /><br />
FR:  ACTH and cortisol feed back negatively upon the hypothalamus to decrease the release of CRH back towards normal.  The cortisol also feeds back upon the anterior pituitary.  This, along with the reduction in CRH leads to less ACTH release.  The reduced ACTH leads to less cortisol release.<br /><br />
SS:  The negative feedback decreases the release of all three hormones but the levels never get back to normal.  Therefore the levels of all three hormone levels are still high, just not as high as you would have expected minus the feedback response.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);
	
//Problem #2
$ProblemName = "2.  CRH secreting tumor";
$ProblemStem = "You are presented with a patient who has a tumor which is secreting CRH.";
$InitialChange = "is";
$DirectResponse = array('is'=>'u','cvp'=>'u','sv'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'u');
$Hint = "Although the tumor is usually not in the hypothalamus in these cases, the CRH should be accounted for as part of the \"endocrine response\"";
$Solution = "The initial change is the $uparrow CRH from the tumor.<br /><br />
FR:  ACTH and cortisol feed back negatively upon the hypothalamus to decrease the release of CRH back towards normal.  The cortisol also feeds back upon the anterior pituitary.  This, along with the reduction in CRH leads to less ACTH release.  The reduced ACTH leads to less cortisol release.<br /><br />
SS:  The negative feedback decreases the release of all three hormones but the levels never get back to normal.  Therefore the levels of all three hormone levels are still high, just not as high as you would have expected minus the feedback response.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #3
$ProblemName = "3.  Pituitary adenoma";
$ProblemStem = "3.  You are presented with a patient who has a pituitary adenoma.";
$InitialChange = "cvp";
$DirectResponse = array('is'=>'n','cvp'=>'u','sv'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'u','sv'=>'u');
$Hint = "";
$Solution = "The initial change is the $uparrow ACTH from the tumor.<br /><br />
FR:  ACTH and cortisol feed back negatively upon the hypothalamus to decrease the release of CRH back towards normal.  The cortisol also feeds back upon the anterior pituitary.  This, along with the reduction in CRH leads to less ACTH release.  The reduced ACTH leads to less cortisol release.<br /><br />
Note that the CRH was unchanged in the direct response  becasue the ACTH is secreted from the tumor not in response to incresaed CRH.  This means that the CRH is down in the steady-state due to the feedback response.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #4a
$ProblemName = "4a.  Adrenal cortical tumor";
$ProblemStem = "You are presented with a patient with a functioning tumor of the adrenal cortex.";
$InitialChange = "sv";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'d','sv'=>'u');
$Hint = "";
$Solution = "The tumor secretes cortisol (the initial change) which feeds back upon the pituitary and the hypothalamus in the feedback response.<br /><br />
Note that both the ACTH and CRH are down in the steady-state due to the feedback response which takes place in an effort to moderate the effect of the tumor and to decrease the cortisol back towards normal.  It remains high, however, due to the tumor.";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #4b
$ProblemName = "4b.  Adrenal cortical tumor with dexamethozone treatment";
$ProblemStem = "This problem picks up where the last problem left off.  The patient has a functioning adrenal tumor and is at the new steady-state.  All changes are relative to this new steady-state.\n\n 
You administer dexamethoazone.";
$InitialChange = "none";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'n');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'d','sv'=>'d');
$Hint = "The hypothalamus and the pituitary recognize dexamethazone as \"cortisol\" and react appropriately.";
$Solution = "The dexamethasone feeds back negatively upon both the hypothalamus and the pituitary, thus decreasing the secretion of all three hormones.<br /><br />
Note that a low dose of dexamethasone is frequently given to patients to diagnose hypercortisolism.  This is known as the 'dexamethasone suppression test'.  In a normal patient, dexamethasone should suppress cortisol secretion and plasma levels should drop.  If they are normal of high after the administration of dexamethazone, it is an indication that the patient may have Cushing’s disease.
";
$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #4c
$ProblemName = "4c.  Adrenal cortical tumor with cortisol receptor blockade";
$ProblemStem = "This problem picks up where 4a left off.  The patient has a functioning adrenal tumor and is at the new steady-state.  All changes are relative to this new steady-state.\n\n 
You administer cortisol receptor blocker.";
$InitialChange = "none";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'n');
$ReflexResponse = array('is'=>'u','cvp'=>'u','sv'=>'u');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'u');
$Hint = "This problem starts where problem 4a ends.  All changes are relative to the steady-state achieved in the presence of the adrenal cortical tumor.";
$Solution = "The cortisol receptor blocker prevents cortisol from binding in the tissues but also blocks binding to both the hypothalamus and the pituitary.  This relieves the feedback inhibition and all of the hormones increase.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #5
$ProblemName = "5.  Adrenal hemorrhage";
$ProblemStem = "You have a patient with an adrenal hemorrhage.";
$InitialChange = "sv";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'d');
$ReflexResponse = array('is'=>'u','cvp'=>'u','sv'=>'u');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'d');
$Hint = "";
$Solution = "The initial change is the drop is cortisol due to the decreased adrenal function.  Note that because the cortisol drops, the tonic feedback inhibition is relieved and the hormones rise in the feedback response.";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #6
$ProblemName = "6.  Decreased body temperature";
$ProblemStem = "An individual is exposed to a sudden drop in temperature.";
$InitialChange = "is";
$DirectResponse = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'d');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$Hint = "";
$Solution = "The drop in temperature is sensed and the hypothalamus responds by increasing thyroid releasing hormone.  This leads to $uparrow release of TSH which increases T3 and T4. 
Among other things, thyroid hormone increases heat production by brown fat.  Therefore body temperature is brought back towards normal.";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #7a
$ProblemName = "7a.  Chronic lymphocytic thyroiditis";
$ProblemStem = "You have a patient who is affected by an autoimmune disease that is causing chronic lymphocytic thyroiditis.";
$InitialChange = "sv";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'d','hr'=>'d');
$ReflexResponse = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'d','hr'=>'d');
$Hint = "";
$Solution = "The patient has Hashimoto's thyroiditis.  The destruction of the thyroid gland causes reduced production and release of T3/T4.  
Recall that T4 is the form that is primarily released.  Some T3 is also released although most is produced from T4 in the tissues.  Either way both are decreased in the endocrine response.
The tonic negative feedback of T3/T4 upon the hypothalamus and the pituitary is relieved leading to higher TRH and TSH in the steady-state.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #7b
$ProblemName = "7b.  Chronic lymphocytic thyroiditis treatment with Armour Thyroid";
$ProblemStem = "This problem picks up where the last problem left off.  The patient is at a new steady-state at the beginning of this problem and all changes are relative to that new steady-state.  You treat the patient with Armour Thyroid.";
$InitialChange = "sv";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'u','hr'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'d','sv'=>'u','hr'=>'u');
$Hint = "";
$Solution = "Levothyroxine and Armour Thyroid are both preparations of T4.  Because T3 is produced from T4 in the tissues, the plasma concentrations of both T3 and T4 increase.  
The increased circulating concentrations of these hormones will feed back to inhibit the release of both TRH and TSH.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

//Problem #7c
$ProblemName = "7c.  Chronic lymphocytic thyroiditis treatment with liothyronine";
$ProblemStem = "This problem picks up where the last problem left off.  The patient is at a new steady-state at the beginning of this problem and all changes are relative to that new steady-state.  You treat the patient with liothyronine.";
$InitialChange = "hr";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'n','hr'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'u');
$Hint = "";
$Solution = "Liothyronine as a T3 analogue and thus will inhibit everything else up the chain.  Note that most T4 is converted to T3 in the tissues.  Therefore no additional T4 appears with treatment and, in fact, the plasma T4 will go down due to feedback inhibition induced by increased T3.  The patient still improves because T3 is the most active form of thyroid hormone.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);


$ProblemName = "8.  Head trauma";
$ProblemStem = "You have a patient who has been in an automobile accident and has sustained damage to her pituitary.";
$InitialChange = "cvp";
$DirectResponse = array('is'=>'n','cvp'=>'d','sv'=>'d','hr'=>'d');
$ReflexResponse = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$SteadyState = array('is'=>'u','cvp'=>'d','sv'=>'d','hr'=>'d');
$Hint = "";
$Solution = "The damage to the anterior pituitary reduces release of TSH (along with a multitude of other hormones).  This $downarrow T3/T4.  The normal tonic negative feedback is relieved increasing all of the hormones.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

$ProblemName = "9a.  Insomnia";
$ProblemStem = "You have a patient who has an autoimmune disease which causes her to suffer from insomnia and hyperactivity.";
$InitialChange = "sv";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'u','hr'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'d','sv'=>'u','hr'=>'u');
$Hint = "";
$Solution = "The patient has Grave’s Disease.  The antibodies are thought to bind to and stimulate the TSH receptors in the thyroid gland, thus increasing secretion of T3/T4.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

$ProblemName = "9b.  Insomnia treated with methimazole";
$ProblemStem = "This problem picks up where the last problem left off.  The patient is at a new steady-state at the beginning of this problem.  You treat the patient with methimazole.";
$InitialChange = "sv";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'d','hr'=>'d');
$ReflexResponse = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'d','hr'=>'d');
$Hint = "";
$Solution = "Methimazole, propylthiouracil, Lugol and K Iodine are compounds that inhibit synthesis of T3 and T4.  Administering them to a patient would result in lower release of T4 and T3 which would cause a stimulation of both TRH and TSH through relief of negative feedback.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

$ProblemName = "10a.  Post-menstruation";
$ProblemStem = "Just after menstruation in women, more estrogen is produced by the ovary via a complex mechanism that will be described later in the curriculum.  
Predict the changes in the hormones as this process takes place.";
$InitialChange = "hr";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'n','hr'=>'u');
$ReflexResponse = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'d');
$SteadyState = array('is'=>'d','cvp'=>'d','sv'=>'d','hr'=>'u');
$Hint = "";
$Solution = "The increased estrogen decreases release of GnRH and the gonadotropins (LH and FSH).  This is what happens in women during the first part of the mistral cycle as they proceed towards ovulation.  We will talk about this much more later in the curriculum.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

$ProblemName = "10b.  Ovulation";
$ProblemStem = "The estrogen has stopped increasing and plasma concentration is sustained at a high level.  The patient is at a new steady-state and all changes are relative to that new steady-state.

The negative feedback of estrogen upon the HPO axis reverses and turns into positive feedback.  Predict the changes.
";
$InitialChange = "none";
$DirectResponse = array('is'=>'n','cvp'=>'n','sv'=>'n','hr'=>'n');
$ReflexResponse = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$SteadyState = array('is'=>'u','cvp'=>'u','sv'=>'u','hr'=>'u');
$Hint = "";
$Solution = "The increased estrogen decreases release of GnRH and the gonadotropins (LH and FSH).  This is what happens in women during the first part of the mistral cycle as they proceed towards ovulation.

The ovarian cycle is considerably more complicated than is depicted by this simple concept map.  This is only an introduction to the topic.  We will talk about this much more later in the curriculum.
";

$NewProblem = CreateProblem($ProblemName, $ProblemStem, $InitialChange,$DirectResponse,$ReflexResponse,$SteadyState,$Hint,$Solution);
array_push($problemlist,$NewProblem);

?>