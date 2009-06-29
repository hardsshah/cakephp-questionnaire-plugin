<?php
class SurveyAnswer extends SurveyAppModel{
	var $name = 'SurveyAnswer';

	var $belongsTo = array(
		'SurveyQuestion' => array(
			'className' => 'Survey.SurveyQuestion',
			'foreignKey' => 'survey_question_id'
		)
	);
}
?>