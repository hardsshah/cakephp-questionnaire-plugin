<div class="span-22">
	<?php echo $form->create('AddSection', array('action' => $this->here)); ?>
	
		<h2>Questionnaire</h2>
		<fieldset>
			<legend>Add A Section To The Questionnaire</legend>
			<?php $form->input('SurveySection.title', array('label' => 'Name of Section', 'type' => 'text')); ?>
			<?php $form->input('SurveySection.description', array('label' => 'Description of Section', 'type' => 'textarea')); ?>
		</fieldset>

		<fieldset>
			<legend>Add Questions To This Section</legend>
			<?php $form->input('SurveyQuestion.0.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestion.0.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php $form->input('SurveyQuestion.0.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestion.0.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			
			<?php $form->input('SurveyQuestion.1.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestion.1.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php $form->input('SurveyQuestion.1.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestion.1.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			
			<?php $form->input('SurveyQuestion.2.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestion.2.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php $form->input('SurveyQuestion.2.number_of_characters', array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
			<?php $form->input('SurveyQuestion.2.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			</fieldset>
			
	<?php echo $form->end(); ?>
</div>