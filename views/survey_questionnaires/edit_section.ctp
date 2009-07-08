<div class="section add">
	<?php echo $form->create('Section', array('action' => 'edit_section')); ?>
		<h2>Questionnaire</h2>
		<fieldset>
			<legend>Add A Section To The Questionnaire</legend>
			<?php echo $form->input('SurveySection.id'); ?>
			<?php echo $form->input('SurveySection.survey_questionnaire_id', array('type' => 'hidden')); ?>
			<?php echo $form->input('SurveySection.title', array('label' => 'Name of Section', 'type' => 'text')); ?>
			<?php echo $form->input('SurveySection.description', array('label' => 'Description of Section', 'type' => 'textarea')); ?>
		</fieldset>

		<p>Please note that you are not required to fill in any questions, but this is here for your convenience.</p>
		<fieldset>
			<legend>Edit all Questions associated with this Section</legend>
			<?php $i = 0; ?>
			<?php foreach ($this->data['SurveyQuestion'] as $question) { ?>
				<?php echo $form->input("SurveyQuestion." . $i . ".title", array('label' => 'Question Title', 'type' => 'text')); ?>
				<?php echo $form->input("SurveyQuestion." . $i . ".survey_question_type_id", array('label' => 'Type of question')); ?>
				<?php echo $form->input("SurveyQuestion." . $i . ".required", array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
				<?php echo $form->input("SurveyQuestion." . $i . ".number_of_characters", array('label' => 'How Many Characters Are Allowed For This Field?', 'type' => 'text')); ?>
				<?php echo $form->input("SurveyQuestion." . $i . ".help", array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
			<?php } ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>