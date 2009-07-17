<?php // $types = $questionnaireQuestionTypes; ?>
<div class="questionnaire">
	<?php echo $form->create('QuestionnaireQuestionnaires', array('plugin' => 'questionnaire', 'controller' => 'questionnaire_questionnaires', 'action' => 'fill')); ?>
	<h2>Questionnaire Title: <?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['title']; ?></h2>
	<fieldset>
		<div class="welcome"><?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['welcome_message']; ?></div>
		<?php
			//Begin the section printing...
			foreach ($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection'] as $section) {
				//echo each section's questions
				$currentQuestions = $questionnaireQuestionnaire['sectionQuestions'][$section['id']];
				echo "<div class=\"section\">";
					echo "<h3>" . $section['title'] . "</h3>";
					echo "<div class=\"description\">" . $section['title'] . "</div>";
					$i = 0;
					foreach ($currentQuestions as $question) {
						echo "<div class=\"question\">";
							$options = array('type' => $questionnaireQuestionTypes[$question['QuestionnaireQuestion']['questionnaire_question_type_id']]['title']);
							if ($questionnaireQuestionTypes[$question['QuestionnaireQuestion']['questionnaire_question_type_id']]['title'] == 'select') {
								//build Answer Array, grrr
								$answers = array();
								foreach($question['QuestionnaireAnswer'] as $answer){
									$answers['title'][] = $answer['title'];
								}
								$options['options'] = $answers;
								$options['type'] = "radio";
								$options['attributes'] = "<br />";
							}
							$options['label'] = "<strong>" . $i + 1 . ".</strong> " . $question['QuestionnaireQuestion']['title'];
							echo $form->input("QuestionnaireSurvey." . $i . ".questionnaire_question_id", array('value' => $question['QuestionnaireQuestion']['id'],'type' => 'hidden'));
							echo $form->input("QuestionnaireSurvey." . $i . ".title", $options) . "<br />";
							echo "Help Text:" . $question['QuestionnaireQuestion']['help'] . "<br />";
						echo "</div>";
						$i++;
					}
				echo "</div>";
			}
			echo $form->submit();
		?>
	</fieldset>
	<?php echo $form->end(); ?>
</div>