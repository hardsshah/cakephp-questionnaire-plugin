<div class="section add">
	<?php echo $form->create('QuestionnaireQuestionnaires', array('action' => 'edit_question')); ?>
		<h2>Question</h2>
		<fieldset>
			<legend>Edit this Question</legend>
			<?php echo $form->input('QuestionnaireQuestion.id'); ?>
			<?php echo $form->input('QuestionnaireQuestion.title', array('label' => 'Question Title', 'type' => 'text')); ?>
			<?php echo $form->input('QuestionnaireQuestion.questionnaire_question_type_id', array('label' => 'Type of question')); ?>
			<?php echo $form->input('QuestionnaireQuestion.required', array('label' => 'Is This Question Required?', 'type' => 'checkbox')); ?>
			<?php echo $form->input('QuestionnaireQuestion.help', array('label' => 'Description For Help Box', 'type' => 'textarea')); ?>
		</fieldset>

		<p>You are only required to fill in answers for this question if you have selected "select" as a question type.</p>
		<fieldset>
			<legend>Add Answers to this Question</legend>
			<?php $i = 0; ?>
			<?php foreach ($this->data['QuestionnaireQuestion'] as $question) { ?>
				<?php echo $form->input("QuestionnaireAnswer." . $i .".id"); ?>
				<?php echo $form->input("QuestionnaireAnswer." . $i .".title", array('label' => 'Possible Answer', 'type' => 'text')); ?>
				<?php i++; ?>
			<?php } ?>
			<p>Should they be necessary, we have included some extra answer fields.</p>
			<?php echo $form->input("QuestionnaireAnswer." . $i .".id"); ?>
			<?php echo $form->input("QuestionnaireAnswer." . $i++ .".title", array('label' => 'Possible Answer', 'type' => 'text')); ?>
			<?php echo $form->input("QuestionnaireAnswer." . $i .".id"); ?>
			<?php echo $form->input("QuestionnaireAnswer." . $i++ .".title", array('label' => 'Possible Answer', 'type' => 'text')); ?>
		</fieldset>
	<?php echo $form->end(); ?>
</div>