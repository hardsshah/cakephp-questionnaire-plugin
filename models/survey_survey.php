<?php
class SurveySurvey extends SurveyAppModel{
	var $name = 'SurveySurvey';

	var $belongsTo = array(
		'SurveyQuestion' => array(
			'className' => 'Survey.SurveyQuestion',
			'foreignKey' => 'survey_question_id'
		)
	);
}
?>