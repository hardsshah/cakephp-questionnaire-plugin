<div class="span-22">
	<?php echo $form->create('CreateQuestionnaire'); ?>
	
		<h2>Questionnaire</h2>
		<fieldset>
			<legend>Create A Questionnaire</legend>
			<?php $form->input('SurveyQuestionnaire.title', array('label' => 'Name of Questionnaire', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestionnaire.welcome_message', array('label' => 'Welcome Message', 'type' => 'textarea')); ?>
			<?php $form->input('SurveyQuestionnaire.thank_you_message', array('label' => 'Thank You Message', 'type' => 'textarea')); ?>
		</fieldset>
		
	<?php echo $form->end(); ?>
</div>