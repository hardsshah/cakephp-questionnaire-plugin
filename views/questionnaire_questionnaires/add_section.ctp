<div class="section add">
	<?php echo $form->create('Section', array('action' => 'add_section')); ?>
		<h2>Questionnaire</h2>
		<fieldset>
			<legend>Add A Section To The Questionnaire</legend>
			<?php echo $form->input('QuestionnaireSection.title', array('label' => 'Name of Section', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireSection.description', array('label' => 'Description of Section', 'type' => 'textarea')); ?>
		</fieldset>

		<p>Please note that you are not required to fill in any questions, but this is here for your convenience.</p>
		<p>You will have to edit the questions after this submission in order to add any answers if necessary.</p>
		<fieldset>
			<legend>Add Questions to this Section</legend>
			<?php echo $form->input('QuestionnaireQuestion.0.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.0.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.0.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php echo $form->input('QuestionnaireQuestion.0.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.0.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>

			<?php echo $form->input('QuestionnaireQuestion.1.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.1.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.1.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php echo $form->input('QuestionnaireQuestion.1.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.1.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>

			<?php echo $form->input('QuestionnaireQuestion.2.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.2.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.2.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php echo $form->input('QuestionnaireQuestion.2.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.2.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>