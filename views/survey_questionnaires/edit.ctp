<div class="span-22">
	<?php echo $form->create('EditQuestionnaire'); ?>
	
		<h2>Questionnaire</h2>
				<h3>Edit A Questionnaire</h3>
				<?php $form->input('SurveyQuestionnaire.id'); ?>
				<?php $form->input('SurveyQuestionnaire.title', array('label' => 'Name of Questionnaire', 'type' => 'text')); ?>
				<?php $form->input('SurveyQuestionnaire.welcome_message', array('label' => 'Welcome Message', 'type' => 'textarea')); ?>
				<?php $form->input('SurveyQuestionnaire.thank_you_message', array('label' => 'Thank You Message', 'type' => 'textarea')); ?>

		<?php echo $form->end(); ?>
</div>