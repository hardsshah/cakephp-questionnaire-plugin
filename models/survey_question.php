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
		'SurveyQuestionnaire' => array(
			'className' => 'Survey.SurveyQuestionnaire',
			'foreignKey' => 'survey_questionnaire_id'
		),
		'SurveySection' => array(
			'className' => 'Survey.SurveySection',
			'foreignKey' => 'survey_section_id'
		),
		'SurveyType' => array(
			'className' => 'Survey.SurveyType',
			'foreignKey' => 'survey_type_id'
		)
	);
	
	function beforeSave(){
		if (!empty($this->data['SurveyQuestion']['survey_section_id'])){
			$surveySection = $this->SurveySection->find('first', array(
				'conditions' => array(
					'SurveySection.id' => 
						$this->data['SurveyQuestion']['survey_section_id']
					),
				'contain' => false));
			$questionnaireID = $surveySection['SurveySection']['survey_questionnaire_id'];
			$this->data['SurveyQuestion']['survey_questionnaire_id'] = $questionnaireID;
			return true;
		}
		return false;
	}
}
?>