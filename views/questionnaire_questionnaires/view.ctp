<?php // $types = $questionnaireQuestionTypes; ?>
<div class="questionnaire">
	<h2>Questionnaire Title: <?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['title']; ?></h4>
	<div class="welcome"><?php echo $questionnaireQuestionnaire['questionnaire']['QuestionnaireQuestionnaire']['welcome_message']; ?></div>
	<?php
		//Begin the section printing...
		if(isset($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection']) && !empty($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection'])) {
			foreach ($questionnaireQuestionnaire['questionnaire']['QuestionnaireSection'] as $section) {
				//echo each section's questions
				$currentQuestions = $questionnaireQuestionnaire['sectionQuestions'][$section['id']];
				echo "<div class=\"section\">";
					echo "<h3>" . $section['title'] . "</h3>";
					echo "<div class=\"description\">" . $section['title'] . "</div>";
					$i = 1;
					if (isset($currentQuestions) && !empty($currentQuestions)) {
						foreach ($currentQuestions as $question) {
							echo "<div class=\"question\">";
								echo "<h4>Question #" . $i . " - " . $question['Question']['title'] . "</h4>";
								echo "Question Type: " . $questionnaireQuestionTypes[$question['QuestionnaireQuestion']['questionnaire_question_type_id']] . "<br />";
								echo "Character Limit: " . $question['QuestionnaireQuestion']['number_of_characters'] . "<br />";
								echo "Is this required? : ";
									echo ($question['QuestionnaireQuestion']['questionnaire_question_type_id'] == 1) ? "Yes" : "No";
									echo "<br />";
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
</div>