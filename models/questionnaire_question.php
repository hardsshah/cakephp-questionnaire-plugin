<?php
class QuestionnaireQuestion extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestion';

	var $hasMany = array(
		'QuestionnaireAnswer' => array(
			'className' => 'questionnaire.QuestionnaireAnswer',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'QuestionnaireSection' => array(
			'className' => 'questionnaire.QuestionnaireSection',
			'foreignKey' => 'questionnaire_section_id'
		),
		'QuestionnaireQuestionType' => array(
			'className' => 'questionnaire.QuestionnaireQuestionType',
			'foreignKey' => 'questionnaire_type_id'
		)
	);
}
?>