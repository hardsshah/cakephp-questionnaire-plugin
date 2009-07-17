<?php
class QuestionnaireSection extends QuestionnaireAppModel{
	var $name = 'QuestionnaireSection';

	var $validate = array(
		'title' => array('notempty'),
		'description' => array('notempty')
	);

	var $hasMany = array(
		'QuestionnaireQuestion' => array(
			'className' => 'questionnaire.QuestionnaireQuestion',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'QuestionnaireQuestionnaire' => array(
			'className' => 'questionnaire.QuestionnaireQuestionnaire',
			'foreignKey' => 'questionnaire_questionnaire_id'
		)
	);
}
?>