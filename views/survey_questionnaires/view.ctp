<?php
	// Define stuff for the view
	$questionnaire = $surveyQuestionnaire['questionnaire']['SurveyQuestionnaire'];
	$sections = $surveyQuestionnaire['questionnaire']['SurveySection'];
	$sectionQuestions = $surveyQuestionnaire['sectionQuestions'];
	// $types = $surveyQuestionTypes;
	//Now we can work on this in relative peace...
	
	//Echo things for the questionnaire
?>
<div class="questionnaire">
<h2>Questionnaire Title: <?php echo $questionnaire['title']; ?></h4>
<div class="welcome"><?php echo $questionnaire['welcome_message']; ?></div>
<?php
	//Begin the section printing...
	foreach($sections as $section){
		//echo each section's questions
	}
?>
</div>