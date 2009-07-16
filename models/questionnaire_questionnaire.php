<?php
class QuestionnaireQuestionnaire extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestionnaire';
	
	var $hasMany = array(
		'QuestionnaireSection' => array(
			'className' => 'Questionnaire.QuestionnaireSection',
			'dependent' => true
		)
	);
	
	function getQuestionnaire($id){
		$this->id = $id;
		$questionnaireQuestionnaire = $this->find('first', array('contain' => array('QuestionnaireSection')));
		/*
		* Find all Questions in one go
		* May do this if we decide that Selects 
		* are not cheaper than PHP manipulation, but it should be :)
		* Should edit because questions no longer belong to questionnaires
		* $questionnaireQuestions = $this->QuestionnaireQuestion->find('all',
			array(
				'conditions' => array(
					'QuestionnaireQuestion.questionnaire_questionnaire_id' => 
						$questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id']),
				'contain' => array('QuestionnaireAnswer')
			)
		);
		*/
		$questionnaireQuestions = array();
		foreach($questionnaireQuestionnaire['QuestionnaireSection'] as $questionnaireSection){
			$questionnaireQuestions[$questionnaireSection['id']] = $this->QuestionnaireQuestion->find('all',
				array(
					'conditions' => array(
						'QuestionnaireQuestion.questionnaire_section_id' => $questionnaireSection['id']),
					'contain' => array('QuestionnaireAnswer')
				)
			);
		}
		$questionnaireTypes = $this->QuestionnaireQuestion->QuestionnaireQuestionType->find('all');
		return array('questionnaire' => $questionnaireQuestionnaire, 'sectionQuestions' => $questionnaireQuestions);
	}
}
?>