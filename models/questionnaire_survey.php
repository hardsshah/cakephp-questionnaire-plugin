<?php
class QuestionnaireQuestionnaire extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestionnaire';

	var $belongsTo = array(
		'QuestionnaireQuestion' => array(
			'className' => 'Questionnaire.QuestionnaireQuestion',
			'foreignKey' => 'questionnaire_question_id'
		)
	);
}
?>