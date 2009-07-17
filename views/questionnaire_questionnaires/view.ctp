<?php // $types = $questionnaireQuestionTypes; ?>
<div class="questionnaire">
	<h2>Questionnaire Title: <?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['title']; ?></h2>
	<div class="welcome"><?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['welcome_message']; ?></div>
	<?php
		//Begin the section printing...
		if(isset($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection']) && !empty($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection'])) {
			foreach ($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection'] as $section) {
				//echo each section's questions
				$currentQuestions = $questionnaireQuestionnaire['sectionQuestions'][$section['id']];
				echo "<div class=\"section\">";
					echo "<h3>" . $section['title'] . "</h3>";
					echo "<div class=\"description\">" . $section['description'] . "</div>";
					echo "<div class=\"section-actions\">";
						echo $html->link('View Section', array('action' => 'view_section', $section['id']));
					echo "</div>";
					$i = 1;
					if (isset($currentQuestions) && !empty($currentQuestions)) {
						foreach ($currentQuestions as $question) {
							echo "<div class=\"question\">";
								echo "<h4>Question #" . $i . " - " . $question['QuestionnaireQuestion']['title'] . "</h4>";
								echo "Question Type: " . $questionnaireQuestionTypes[$question['QuestionnaireQuestion']['questionnaire_question_type_id']] . "<br />";
								echo "Help Text:" . $question['QuestionnaireQuestion']['help'];
								if (!empty($question['Answers'])) {
									$j = 1;
									foreach ($question['Answers'] as $answer){
										echo $j . ". " . $answer['title'] . "<br />";
										if ($answer['default'] == 1){
											echo "<strong>This is the default answer.</strong>";
										}
										$j++;
									}
								}
							echo "</div>";
							$i++;
						}
					}
				echo "</div>";
			}
		}
	?>
	<div class="thank-you"><?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['thank_you_message']; ?></div>
</div>