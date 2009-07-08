<?php // $types = $surveyQuestionTypes; ?>
<div class="questionnaire">
	<h2>Questionnaire Title: <?php echo $surveyQuestionnaire['questionnaire']['SurveyQuestionnaire']['title']; ?></h4>
	<div class="welcome"><?php echo $surveyQuestionnaire['questionnaire']['SurveyQuestionnaire']['welcome_message']; ?></div>
	<?php
		//Begin the section printing...
		foreach ($surveyQuestionnaire['questionnaire']['SurveySection'] as $section) {
			//echo each section's questions
			$currentQuestions = $surveyQuestionnaire['sectionQuestions'][$section['id']];
			echo "<div class=\"section\">";
				echo "<h3>" . $section['title'] . "</h3>";
				echo "<div class=\"description\">" . $section['title'] . "</div>";
				$i = 1;
				foreach ($currentQuestions as $question) {
					echo "<div class=\"question\">";
						echo "<strong>" . $i . ".</strong> " . $question['Question']['title'];
						$options = array('type' => $surveyQuestionTypes[$question['survey_question_type_id']]['title']);
						if ($surveyQuestionTypes[$question['survey_question_type_id']]['title'] == 'select') {
							//build Answer Array, grrr
							$answers = array();
							foreach($question['SurveyAnswer'] as $answer){
								$answers['title'] => $answer['title'];
							}
							$options['options'] = $answers;
							$options['type'] = "radio";
							$options['attributes'] = "<br />";
						}
						echo $form->input("SurveySurvey." . $i . ".survey_question_id", array('type' => 'hidden'));
						echo $form->input("SurveySurvey." . $i . ".title", $options) . "<br />";
						echo "Help Text:" . echo $question['SurveyQuestion']['help'] . "<br />";
					echo "</div>";
					$i++;
				}
			echo "</div>";
		}
	?>
</div>