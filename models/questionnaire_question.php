<?php
class QuestionnaireQuestion extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestion';

	var $validate = array(
		'title' => array('notempty'),
		'required' => array('boolean'),
		'help' => array('notempty')
	);

	var $hasMany = array(
		'QuestionnaireAnswer' => array(
			'className' => 'questionnaire.QuestionnaireAnswer',
			'dependent' => true
		),
		'QuestionnaireSurvey' => array(
			'className' => 'questionnaire.QuestionnaireSurvey',
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