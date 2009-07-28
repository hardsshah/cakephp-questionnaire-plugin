<div class="span-22">
	<?php echo $form->create('QuestionnaireQuestionnaires', array('plugin' => 'questionnaire', 'controller' => 'questionnaire_questionnaires', 'action' => 'add')); ?>
		<h2>Questionnaire</h2>
		<fieldset>
			<legend>Create A Questionnaire</legend>
			<?php echo $form->input('QuestionnaireQuestionnaire.title', array('label' => 'Name of Questionnaire', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestionnaire.welcome_message', array('label' => 'Welcome Message', 'type' => 'textarea')); ?>
			<?php echo $form->input('QuestionnaireQuestionnaire.thank_you_message', array('label' => 'Thank You Message', 'type' => 'textarea')); ?>
			<?php echo $form->submit(); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>