<div class="section add">
	<?php echo $form->create('QuestionnaireQuestionnaires', array('action' => 'add_section')); ?>
		<h3>Section</h3>
		<fieldset>
			<legend>Add A Section To The Questionnaire</legend>
			<?php echo $form->input('QuestionnaireQuestionnaire.id')?>
			<?php echo $form->input('QuestionnaireSection.title', array('label' => 'Name of Section', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireSection.description', array('label' => 'Description of Section', 'type' => 'textarea')); ?>
			<?php echo $form->submit(); ?>
		</fieldset>

		<p>Please note that you are not required to fill in any questions, but this is here for your convenience.</p>
		<p>You will have to edit the questions after this submission in order to add any answers if necessary.</p>
		<fieldset>
			<legend>Add Questions to this Section</legend>
			<?php echo $form->input('QuestionnaireQuestion.0.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.0.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.0.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>

			<hr />

			<?php echo $form->input('QuestionnaireQuestion.1.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.1.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.1.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>

			<hr />

			<?php echo $form->input('QuestionnaireQuestion.2.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.2.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.2.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			<?php echo $form->submit(); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>