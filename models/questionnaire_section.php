<?php
class QuestionnaireSection extends QuestionnaireAppModel{
	var $name = 'QuestionnaireSection';

	var $hasMany = array(
		'QuestionnaireQuestion' => array(
			'className' => 'Questionnaire.QuestionnaireQuestion',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'QuestionnaireQuestionnaire' => array(
			'className' => 'Questionnaire.QuestionnaireQuestionnaire',
			'foreignKey' => 'questionnaire_questionnaire_id'
		)
	);
}
?>