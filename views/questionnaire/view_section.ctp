<div class="section view">
	<div class="section-title"><strong>Section Title:</strong> <?php echo $questionnaireSection['QuestionnaireSection']['title']; ?></div>
	<div class="section-description"><strong>Description:</strong> <?php echo $questionnaireSection['QuestionnaireSection']['description']; ?></div>
	<div id="questions">
		<?php foreach($questionnaireSection['QuestionnaireQuestion'] as $question) : ?>
			<div class="question">
				<div class="question-title"><strong>Question:</strong> <?php echo $question['title']; ?></div>
				<div class="question-type"><strong>Type:</strong> <?php echo $questionTypes[$question['questionnaire_question_type_id']]; ?></div>
				<div class="question-help"><strong>Help Text:</strong> <?php echo $question['help']; ?></div>
				<div class="question-actions"><strong>Actions:</strong>
					<?php echo $html->link('View Question', array('action' => 'view_question', $question['id'])); ?>
					<?php echo $html->link('Edit Question', array('action' => 'edit_question', $question['id'])); ?>
					<?php echo $html->link('Delete Question', array('action' => 'delete_question', $question['id'])); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>