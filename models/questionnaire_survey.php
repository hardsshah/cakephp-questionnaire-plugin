<?php
class QuestionnaireSurvey extends QuestionnaireAppModel{
	var $name = 'QuestionnaireSurvey';

	var $belongsTo = array(
		'QuestionnaireQuestion' => array(
			'className' => 'Questionnaire.QuestionnaireQuestion',
			'foreignKey' => 'questionnaire_question_id'
		)
	);
}
?>