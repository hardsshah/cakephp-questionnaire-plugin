<?php
class SurveyQuestionType extends SurveyAppModel{
	var $name = 'SurveyQuestionType';
	var $useTable = false;

	var $hasMany = array(
		'SurveyQuestion' => array(
			'className' => 'Survey.SurveyQuestion',
			'dependent' => true
		)
	);
	
	function find($type = "all", $options = array()){
		// "first" array is a lookup on the array below
		// "count" is simply a count of the above array. Hardcoded to 4
		$countSurveyQuestionTypes = 4;
		//Construct the "all" array
		$allSurveyQuestionTypes = array(
			'0' => array(
				'id' => '1',
				'title' => 'multiple'
			),
			'1' => array(
				'id' => '2',
				'title' => 'checkbox'
			),
			'2' => array(
				'id' => '3',
				'title' => 'textarea'
			),
			'3' => array(
				'id' => '4',
				'title' => 'text'
			)
		);
		// Construct the "list" array
		$listSurveyQuestionTypes = array(
			'1' => 'multiple',
			'2' => 'checkbox',
			'3' => 'textarea',
			'4' => 'text'
		)
		// Since we aren't using a table and merely a php array
		switch ($type) {
			case "first":
				$recordID = $this->id - 1;
				return $allSurveyQuestionTypes[$recordID];
			case "count":
				return = $countSurveyQuestionTypes;
			case "all":
				return $allSurveyQuestionTypes;
			case "list":
				return $listSurveyQuestionTypes;
			default:
				return $allSurveyQuestionTypes;
		}
		return $allSurveyQuestionTypes;
	}
}
?>