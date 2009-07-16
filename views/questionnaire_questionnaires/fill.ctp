<?php // $types = $questionnaireQuestionTypes; ?>
<div class="questionnaire">
	<h2>Questionnaire Title: <?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['title']; ?></h4>
	<div class="welcome"><?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['welcome_message']; ?></div>
	<?php
		//Begin the section printing...
		foreach ($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection'] as $section) {
			//echo each section's questions
			$currentQuestions = $questionnaireQuestionnaire['sectionQuestions'][$section['id']];
			echo "<div class=\"section\">";
				echo "<h3>" . $section['title'] . "</h3>";
				echo "<div class=\"description\">" . $section['title'] . "</div>";
				$i = 1;
				foreach ($currentQuestions as $question) {
					echo "<div class=\"question\">";
						echo "<strong>" . $i . ".</strong> " . $question['Question']['title'];
						$options = array('type' => $questionnaireQuestionTypes[$question['questionnaire_question_type_id']]['title']);
						if ($questionnaireQuestionTypes[$question['questionnaire_question_type_id']]['title'] == 'select') {
							//build Answer Array, grrr
							$answers = array();
							foreach($question['QuestionnaireAnswer'] as $answer){
								$answers['title'] => $answer['title'];
							}
							$options['options'] = $answers;
							$options['type'] = "radio";
							$options['attributes'] = "<br />";
						}
						echo $form->input("QuestionnaireQuestionnaire." . $i . ".questionnaire_question_id", array('type' => 'hidden'));
						echo $form->input("QuestionnaireQuestionnaire." . $i . ".title", $options) . "<br />";
						echo "Help Text:" . echo $question['QuestionnaireQuestion']['help'] . "<br />";
					echo "</div>";
					$i++;
				}
			echo "</div>";
		}
	?>
</div>