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
		'QuestionnaireType' => array(
			'className' => 'Questionnaire.QuestionnaireType',
			'foreignKey' => 'questionnaire_type_id'
		)
	);
}
?>