<?php
class QuestionnaireAnswer extends QuestionnaireAppModel{
	var $name = 'QuestionnaireAnswer';

	var $belongsTo = array(
		'QuestionnaireQuestion' => array(
			'className' => 'Questionnaire.QuestionnaireQuestion',
			'foreignKey' => 'questionnaire_question_id'
		)
	);
	var $hasMany = array(
		'QuestionnaireQuestionnaire' => array(
			'className' => 'Questionnaire.QuestionnaireQuestionnaire',
			'dependent' => true
		)
	);

}
?>