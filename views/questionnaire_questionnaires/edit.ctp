<div class="span-22">
	<?php echo $form->create('EditQuestionnaire'); ?>
	
		<h2>Questionnaire</h2>
				<h3>Edit A Questionnaire</h3>
				<?php $form->input('QuestionnaireQuestionnaire.id'); ?>
				<?php $form->input('QuestionnaireQuestionnaire.title', array('label' => 'Name of Questionnaire', 'type' => 'text')); ?>
				<?php $form->input('QuestionnaireQuestionnaire.welcome_message', array('label' => 'Welcome Message', 'type' => 'textarea')); ?>
				<?php $form->input('QuestionnaireQuestionnaire.thank_you_message', array('label' => 'Thank You Message', 'type' => 'textarea')); ?>

		<?php echo $form->end(); ?>
</div>