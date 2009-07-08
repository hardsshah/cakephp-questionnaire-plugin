<?php
class SurveyQuestion extends SurveyAppModel{
	var $name = 'SurveyQuestion';

	var $hasMany = array(
		'SurveyAnswer' => array(
			'className' => 'Survey.SurveyAnswer',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'SurveySection' => array(
			'className' => 'Survey.SurveySection',
			'foreignKey' => 'survey_section_id'
		),
		'SurveyType' => array(
			'className' => 'Survey.SurveyType',
			'foreignKey' => 'survey_type_id'
		)
	);
}
?>