<?php
class QuestionnaireQuestion extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestion';

	var $hasMany = array(
		'QuestionnaireAnswer' => array(
			'className' => 'Questionnaire.QuestionnaireAnswer',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'QuestionnaireSection' => array(
			'className' => 'Questionnaire.QuestionnaireSection',
			'foreignKey' => 'questionnaire_section_id'
		),
		'QuestionType' => array(
			'className' => 'Questionnaire.QuestionnaireQuestionType',
			'foreignKey' => 'questionnaire_type_id'
		)
	);
}
?>