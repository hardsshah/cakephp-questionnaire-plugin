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
	foreach ($sections as $section) {
		//echo each section's questions
		$sectionID = $section['id'];
		$currentQuestions = $sectionQuestions[$sectionID];
		echo "<div class=\"section\">";
		echo "<h3>" . $section['title'] . "</h3>";
		$i = 1;
		foreach ($currentQuestions as $question) {
			echo "<div class=\"question\">";
			echo "<h4>Section #" . $i . " - " . $question['Question']['title'] . "</h4>";
			echo "Question Type: " . $surveyQuestionTypes[$question['SurveyQuestion']['survey_question_type_id']] . "<br />";
			echo "Character Limit: " . echo $question['SurveyQuestion']['number_of_characters'] . "<br />";
			echo "Is this required? : ";
				echo ($question['SurveyQuestion']['survey_question_type_id'] == 1) ? "Yes" : "No";
				echo "<br />"
			echo "Help Text:" . echo $question['SurveyQuestion']['help'];
			if (!empty($question['Answers'])) {
				$j = 1;
				foreach ($question['Answers'] as $answer){
					echo $j . ". " $answer['title'] . "<br />";
					if ($answer['default'] == 1){
						echo "<strong>This is the default answer.</strong>";
					}
					$j++;
				}
			}
			echo "</div>";
			$i++;
		}
		echo "</div>";
	}
?>
</div>