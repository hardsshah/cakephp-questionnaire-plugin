<?php
class QuestionnaireQuestionnaire extends QuestionnaireAppModel{
	var $name = 'QuestionnaireQuestionnaire';

	var $validate = array(
		'title' => array('notempty'),
		'welcome_message' => array('notempty'),
		'thank_you_message' => array('notempty')
	);

	var $hasMany = array(
		'QuestionnaireSection' => array(
			'className' => 'questionnaire.QuestionnaireSection',
			'dependent' => true
		)
	);
	
	function getQuestionnaire($id){
		$this->id = $id;
		$questionnaireQuestionnaire = $this->find('first', array('contain' => array('QuestionnaireSection')));
		$questionnaireQuestions = array();
		foreach($questionnaireQuestionnaire['QuestionnaireSection'] as $questionnaireSection){
			$questionnaireQuestions[$questionnaireSection['id']] = $this->QuestionnaireSection->QuestionnaireQuestion->find('all',
				array(
					'conditions' => array(
						'QuestionnaireQuestion.questionnaire_section_id' => $questionnaireSection['id']),
					'contain' => array('QuestionnaireAnswer')
				)
			);
		}
		return array('questionnaire' => $questionnaireQuestionnaire, 'sectionQuestions' => $questionnaireQuestions);
	}
}
?>