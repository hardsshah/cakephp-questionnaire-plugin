<div class="section add">
	<?php echo $form->create('QuestionnaireQuestionnaires', array('action' => 'edit_section')); ?>
		<h2>Questionnaire</h2>
		<fieldset>
			<legend>Add A Section To The Questionnaire</legend>
			<?php echo $form->input('QuestionnaireSection.id'); ?>
			<?php echo $form->input('QuestionnaireSection.questionnaire_questionnaire_id', array('type' => 'hidden')); ?>
			<?php echo $form->input('QuestionnaireSection.title', array('label' => 'Name of Section', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireSection.description', array('label' => 'Description of Section', 'type' => 'textarea')); ?>
		</fieldset>

		<p>Please note that you are not required to fill in any questions, but this is here for your convenience.</p>
		<fieldset>
			<legend>Edit all Questions associated with this Section</legend>
			<?php $i = 0; ?>
			<?php foreach ($this->data['QuestionnaireQuestion'] as $question) { ?>
				<?php echo $form->input("QuestionnaireQuestion." . $i . ".id"); ?>
				<?php echo $form->input("QuestionnaireQuestion." . $i . ".title", array('label' => 'Question Title', 'type' => 'text')); ?>
				<?php echo $form->input("QuestionnaireQuestion." . $i . ".questionnaire_question_type_id", array('label' => 'Type of question')); ?>
				<?php echo $form->input("QuestionnaireQuestion." . $i++ . ".help", array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			<?php } ?>
			<p>Should they be necessary, we have included some extra question fields.</p>
			<?php echo $form->input("QuestionnaireQuestion." . $i . ".id"); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i . ".title", array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i . ".questionnaire_question_type_id", array('label' => 'Type of question')); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i++ . ".help", array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i . ".id"); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i . ".title", array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i . ".questionnaire_question_type_id", array('label' => 'Type of question')); ?>
			<?php echo $form->input("QuestionnaireQuestion." . $i++ . ".help", array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>