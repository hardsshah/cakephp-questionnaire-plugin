<?php
class SurveySection extends SurveyAppModel{
	var $name = 'SurveySection';

	var $hasMany = array(
		'SurveyQuestion' => array(
			'className' => 'Survey.SurveyQuestion',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'SurveyQuestionnaire' => array(
			'className' => 'Survey.SurveyQuestionnaire',
			'foreignKey' => 'survey_questionnaire_id'
		)
	);
}
?>