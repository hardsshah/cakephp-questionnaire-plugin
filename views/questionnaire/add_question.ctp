<div class="section add">
	<?php echo $form->create('QuestionnaireQuestionnaires', array('action' => 'add_section')); ?>
		<h2>Question</h2>
		<fieldset>
			<legend>Add A Question To The Questionnaire</legend>
			<?php echo $form->input('QuestionnaireQuestion.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php echo $form->input('QuestionnaireQuestion.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			<?php echo $form->submit(); ?>
		</fieldset>

		<p>You are only required to fill in answers for this question if you have selected "select" as a question type.</p>
		<fieldset>
			<legend>Add Answers to this Question</legend>
			<?php echo $form->input('QuestionnaireAnswer.0.title', array('label' => '1st Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireAnswer.1.title', array('label' => '2nd Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireAnswer.2.title', array('label' => '3rd Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireAnswer.3.title', array('label' => '4th Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->submit(); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>