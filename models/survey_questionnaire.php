<?php
class SurveyQuestionnaire extends SurveyAppModel{
	var $name = 'SurveyQuestionnaire';
	
	var $hasMany = array(
		'SurveySection' => array(
			'className' => 'Survey.SurveySection',
			'dependent' => true
		)
	);
}
?>