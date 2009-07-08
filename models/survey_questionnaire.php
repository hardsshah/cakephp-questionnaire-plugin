<?php
class SurveyQuestionnaire extends SurveyAppModel{
	var $name = 'SurveyQuestionnaire';
	
	var $hasMany = array(
		'SurveySection' => array(
			'className' => 'Survey.SurveySection',
			'dependent' => true
		)
	);
	
	function getQuestionnaire($id){
		$this->id = $id;
		$surveyQuestionnaire = $this->find('first', array('contain' => array('SurveySection')));
		/*
		* Find all Questions in one go
		* May do this if we decide that Selects 
		* are not cheaper than PHP manipulation, but it should be :)
		* Should edit because questions no longer belong to questionnaires
		* $surveyQuestions = $this->SurveyQuestion->find('all',
			array(
				'conditions' => array(
					'SurveyQuestion.survey_questionnaire_id' => 
						$surveyQuestionnaire['SurveyQuestionnaire']['id']),
				'contain' => array('SurveyAnswer')
			)
		);
		*/
		$surveyQuestions = array();
		foreach($surveyQuestionnaire['SurveySection'] as $surveySection){
			$surveyQuestions[$surveySection['id']] = $this->SurveyQuestion->find('all',
				array(
					'conditions' => array(
						'SurveyQuestion.survey_section_id' => $surveySection['id']),
					'contain' => array('SurveyAnswer')
				)
			);
		}
		$surveyTypes = $this->SurveyQuestion->SurveyQuestionType->find('all');
		return array('questionnaire' => $surveyQuestionnaire, 'sectionQuestions' => $surveyQuestions);
	}
}
?>