<div class="section add">
	<?php echo $form->create('Question', array('action' => 'add_section')); ?>
		<h2>Question</h2>
		<fieldset>
			<legend>Add A Question To The Questionnaire</legend>
			<?php echo $form->input('SurveyQuestion.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('SurveyQuestion.survey_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('SurveyQuestion.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php echo $form->input('SurveyQuestion.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php echo $form->input('SurveyQuestion.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
		</fieldset>

		<p>You are only required to fill in answers for this question if you have selected "select" as a question type.</p>
		<fieldset>
			<legend>Add Answers to this Question</legend>
			<?php echo $form->input('SurveyAnswer.0.title', array('label' => '1st Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input('SurveyAnswer.1.title', array('label' => '2nd Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input('SurveyAnswer.2.title', array('label' => '3rd Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input('SurveyAnswer.3.title', array('label' => '4th Possible Answer', 'type' => 'text')); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>