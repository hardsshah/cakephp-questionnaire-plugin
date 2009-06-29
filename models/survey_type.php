<?php
class SurveyType extends SurveyAppModel{
	var $name = 'SurveyType';

	var $hasMany = array(
		'SurveyQuestion' => array(
			'className' => 'Survey.SurveyQuestion',
			'dependent' => true
		)
	);
}
?>