<?php
class QuestionnaireQuestionType extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestionType';
	var $useTable = false;
	var $primaryKey = 'id';
	var $_schema = array(
		'id' => array('type' => 'string', 'length' => 11),
		'title' => array('type' => 'string', 'length' => 255)
	);

	var $hasMany = array(
		'QuestionnaireQuestion' => array(
			'className' => 'questionnaire.QuestionnaireQuestion',
			'dependent' => true
		)
	);
	
	function find($type = "all", $options = array()){
		// "first" array is a lookup on the array below
		// "count" is simply a count of the above array. Hardcoded to 4
		$countQuestionnaireQuestionTypes = 4;
		//Construct the "all" array
		$allQuestionnaireQuestionTypes = array(
			'0' => array(
				'id' => '1',
				'title' => 'select'
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
		$listQuestionnaireQuestionTypes = array(
			'1' => 'select',
			'2' => 'checkbox',
			'3' => 'textarea',
			'4' => 'text'
		);
		// Since we aren't using a table and merely a php array
		switch ($type) {
			case "first":
				$recordID = $this->id - 1;
				return $allQuestionnaireQuestionTypes[$recordID];
			case "count":
				return $countQuestionnaireQuestionTypes;
			case "all":
				return $allQuestionnaireQuestionTypes;
			case "list":
				return $listQuestionnaireQuestionTypes;
			default:
				return $allQuestionnaireQuestionTypes;
		}
		return $allQuestionnaireQuestionTypes;
	}
}
?>