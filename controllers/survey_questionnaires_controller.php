<?php
class SurveyQuestionnairesController extends SurveyAppController{
	var $name = 'SurveyQuestionnaires';
	var $uses =  array('Survey.SurveyQuestionnaire');

	function index() {
		$this->paginate = array('contain' => false, 'fields' => array('SurveyQuestionnaire.id', 'SurveyQuestionnaire.title'));
		$this->set('roms', $this->paginate());
	}

	function view($id = null) {
		if($this->SurveyQuestionnaire->exists()) {
			$surveyQuestionnaire = $this->SurveyQuestionnaire->getQuestionnaire($id);
			$surveyQuestionTypes = $this->SurveyQuestions->SurveyQuestion->SurveyQuestionTypes->find("list");
			$this->set(compact('surveyQuestionnaire', 'surveyQuestionTypes'));
		} else {
			$this->Session->setFlash(__('Invalid Questionnaire.', true), 'messages/error');
			$this->redirect(array('action' => 'index'), 404, true);
		}
	}
	
	function fill($id = null) {
		if(empty($this->data)){
			if($this->SurveyQuestionnaire->exists()) {
				$surveyQuestionnaire = $this->SurveyQuestionnaire->getQuestionnaire($id);
				$surveyQuestionTypes = $this->SurveyQuestionnaire->SurveySection->SurveyQuestion->SurveyQuestionTypes->find("list");
				$this->set(compact('surveyQuestionnaire', 'surveyQuestionTypes'));
			} else {
				$this->Session->setFlash(__('Invalid Questionnaire.', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			}
		} else {
			if($this->SurveyQuestionnaire->SurveySection->SurveyQuestion->SurveySurvey->saveAll($this->data)){
				$this->Session->setFlash(__('You have successfully completed the survey.', true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__('Your survey answers could not be saved. Please, try again.', true));
			}
		}
	}
	function add() {
		if (!empty($this->data)) {
			$this->SurveyQuestionnaire->create();
			if ($this->SurveyQuestionnaire->saveAll($this->data, array('validate' => 'first'))) {
				$this->Session->setFlash(__('The Questionnaire has been saved', true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__('The Questionnaire could not be saved. Please, try again.', true), 'messages/error');
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if ($this->SurveyQuestionnaire->exists() == false){
				$this->Session->setFlash(__('Invalid Questionnaire', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			} else {
				$this->data = $this->SurveyQuestionnaire->read(null, $id);
			}
		} else {
			if ($this->SurveyQuestionnaire->save($this->data)) {
				$this->Session->setFlash(__('The Questionnaire has been saved', true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__('The Questionnaire could not be saved. Please, try again.', true));
			}
		}
	}

	function delete($id = null) {
		if ($this->SurveyQuestionnaire->exists() == false) {
			$this->Session->setFlash(__('Invalid id for Questionnaire', true), 'messages/error');
			$this->redirect(array('action' => 'index'), 404, true);
		}
		if ($this->SurveyQuestionnaire->delete($id)) {
			$this->Session->setFlash(__('Questionnaire deleted', true), 'messages/success');
			$this->redirect(array('action' => 'index'), 200, true);
		} else {
			$this->Session->setFlash(__('Questionnaire could not be deleted. Please try again', true), 'messages/error');
		}
	}

	function add_section($id = NULL) {
		if (!empty($this->data)) {
			if($this->SurveyQuestionnaire->exists()) {
				$this->data['SurveySection']['survey_questionnaire_id'] = $id;
				$this->SurveyQuestionnaire->SurveySection->create();
				if ($this->SurveyQuestionnaire->SurveySection->saveAll($this->data, array('validate' => 'first'))) {
					$this->Session->setFlash(__('The Section has been added', true), 'messages/success');
					$this->redirect(array('action' => 'index'), 200, true);
				} else {
					$this->Session->setFlash(__('The Section could not be added. Please, try again.', true), 'messages/error');
				}
			}
		}
		$survey_question_types = $this->SurveyQuestionnaire->SurveySection->SurveyQuestion->SurveyQuestionTypes->find("list");
		$this->set(compact('survey_question_types'));
	}

	function edit_section($sectionID = null) {
		if (empty($this->data)) {
			$this->SurveyQuestionnaire->SurveySection->id = $sectionID;
			if ($this->SurveyQuestionnaire->SurveySection->exists() == false){
				$this->Session->setFlash(__('Invalid Section', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			} else {
				$this->data = $this->SurveyQuestionnaire->SurveySection->find('first', array('contain' => array('SurveyQuestion')));
			}
		} else {
			if ($this->SurveyQuestionnaire->SurveySection->saveAll($this->data)) {
				$this->Session->setFlash(__("The Section and it's associated questions have been saved", true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__("The Section and it's associated questions could not be saved. Please, try again.", true));
			}
		}
		$survey_question_types = $this->SurveyQuestionnaire->SurveySection->SurveyQuestion->SurveyQuestionTypes->find("list");
		$this->set(compact('survey_question_types'));
	}

	function add_question($sectionID = NULL) {
		if (!empty($this->data)) {
			if($this->SurveyQuestionnaire->SurveySection->SurveyQuestion->exists()) {
				$this->data['SurveyQuestion']['survey_section_id'] = $sectionID;
				$this->SurveyQuestionnaire->SurveySection->SurveyQuestion->create();
				if ($this->SurveyQuestionnaire->SurveySection->SurveyQuestion->saveAll($this->data, array('validate' => 'first'))) {
					$this->Session->setFlash(__('The Question has been added', true), 'messages/success');
					$this->redirect(array('action' => 'index'), 200, true);
				} else {
					$this->Session->setFlash(__('The Section could not be added. Please, try again.', true), 'messages/error');
				}
			}
		}
		$survey_question_types = $this->SurveyQuestionnaire->SurveySection->SurveyQuestion->SurveyQuestionTypes->find("list");
		$this->set(compact('survey_question_types'));
	}

	function edit_question($questionID = null) {
		if (empty($this->data)) {
			$this->SurveyQuestionnaire->SurveySection->SurveyQuestion->id = $questionID;
			if ($this->SurveyQuestionnaire->SurveySection->SurveyQuestion->exists() == false){
				$this->Session->setFlash(__('Invalid Section', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			} else {
				$this->data = $this->SurveyQuestionnaire->SurveySection->SurveyQuestion->find('first', array('contain' => array('SurveyAnswer')));
			}
		} else {
			if ($this->SurveyQuestionnaire->SurveySection->SurveyQuestion->saveAll($this->data)) {
				$this->Session->setFlash(__("The Section and it's associated questions have been saved", true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__("The Section and it's associated questions could not be saved. Please, try again.", true));
			}
		}
		$survey_question_types = $this->SurveyQuestionnaire->SurveySection->SurveyQuestion->SurveyQuestionTypes->find("list");
		$this->set(compact('survey_question_types'));
	}
}
?>