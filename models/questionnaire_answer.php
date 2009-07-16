<?php
class QuestionnaireAnswer extends QuestionnaireAppModel{
	var $name = 'QuestionnaireAnswer';

	var $belongsTo = array(
		'QuestionnaireQuestion' => array(
			'className' => 'questionnaire.QuestionnaireQuestion',
			'foreignKey' => 'questionnaire_question_id'
		)
	);
	var $hasMany = array(
		'QuestionnaireQuestionnaire' => array(
			'className' => 'questionnaire.QuestionnaireQuestionnaire',
			'dependent' => true
		)
	);

}
?>