<?php
class QuestionnaireQuestionnairesController extends QuestionnaireAppController{
	var $name = 'QuestionnaireQuestionnaires';
	var $uses =  array('Questionnaire.QuestionnaireQuestionnaire');

	function index() {
		$this->paginate = array('contain' => false, 'fields' => array('QuestionnaireQuestionnaire.id', 'QuestionnaireQuestionnaire.title'));
		$questionnaireQuestionnaires = $this->paginate();
		$this->set(compact('questionnaireQuestionnaires'));
	}

	function view($id = null) {
		$questionnaireQuestionnaire = $this->QuestionnaireQuestionnaire->getQuestionnaire($id);
		if(!empty($questionnaireQuestionnaire)) {
			$questionnaireQuestionTypes = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
			$this->set(compact('questionnaireQuestionnaire', 'questionnaireQuestionTypes'));
		} else {
			$this->Session->setFlash(__('Invalid Questionnaire.', true), 'messages/error');
			$this->redirect(array('action' => 'index'), 404, true);
		}
	}
	
	/*
	function fill($id = null) {
		if(empty($this->data)){
			if($this->QuestionnaireQuestionnaire->exists()) {
				$questionnaireQuestionnaire = $this->QuestionnaireQuestionnaire->getQuestionnaire($id);
				$questionnaireQuestionnaireQuestionTypes = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
				$this->set(compact('questionnaireQuestionnaire', 'questionnaireQuestionnaireQuestionTypes'));
			} else {
				$this->Session->setFlash(__('Invalid Questionnaire.', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			}
		} else {
			if($this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionnaire->saveAll($this->data)){
				$this->Session->setFlash(__('You have successfully completed the questionnaire.', true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__('Your questionnaire answers could not be saved. Please, try again.', true));
			}
		}
	}
	function add() {
		if (!empty($this->data)) {
			$this->QuestionnaireQuestionnaire->create();
			if ($this->QuestionnaireQuestionnaire->saveAll($this->data, array('validate' => 'first'))) {
				$this->Session->setFlash(__('The Questionnaire has been saved', true), 'messages/success');
				$this->redirect(array('controller' => 'questionnaireQuestionnaires', 'action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__('The Questionnaire could not be saved. Please, try again.', true), 'messages/error');
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if ($this->QuestionnaireQuestionnaire->exists() == false){
				$this->Session->setFlash(__('Invalid Questionnaire', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			} else {
				$this->data = $this->QuestionnaireQuestionnaire->read(null, $id);
			}
		} else {
			if ($this->QuestionnaireQuestionnaire->save($this->data)) {
				$this->Session->setFlash(__('The Questionnaire has been saved', true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__('The Questionnaire could not be saved. Please, try again.', true));
			}
		}
	}

	function delete($id = null) {
		if ($this->QuestionnaireQuestionnaire->exists() == false) {
			$this->Session->setFlash(__('Invalid id for Questionnaire', true), 'messages/error');
			$this->redirect(array('action' => 'index'), 404, true);
		}
		if ($this->QuestionnaireQuestionnaire->delete($id)) {
			$this->Session->setFlash(__('Questionnaire deleted', true), 'messages/success');
			$this->redirect(array('action' => 'index'), 200, true);
		} else {
			$this->Session->setFlash(__('Questionnaire could not be deleted. Please try again', true), 'messages/error');
		}
	}

	function add_section($id = NULL) {
		if (!empty($this->data)) {
			if($this->QuestionnaireQuestionnaire->exists()) {
				$this->data['QuestionnaireSection']['questionnaire_questionnaire_id'] = $id;
				$this->QuestionnaireQuestionnaire->QuestionnaireSection->create();
				if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->saveAll($this->data, array('validate' => 'first'))) {
					$this->Session->setFlash(__('The Section has been added', true), 'messages/success');
					$this->redirect(array('action' => 'index'), 200, true);
				} else {
					$this->Session->setFlash(__('The Section could not be added. Please, try again.', true), 'messages/error');
				}
			}
		}
		$questionnaire_question_types = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
		$this->set(compact('questionnaire_question_types'));
	}

	function edit_section($sectionID = null) {
		if (empty($this->data)) {
			$this->QuestionnaireQuestionnaire->QuestionnaireSection->id = $sectionID;
			if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->exists() == false){
				$this->Session->setFlash(__('Invalid Section', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			} else {
				$this->data = $this->QuestionnaireQuestionnaire->QuestionnaireSection->find('first', array('contain' => array('QuestionnaireQuestion')));
			}
		} else {
			if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->saveAll($this->data)) {
				$this->Session->setFlash(__("The Section and it's associated questions have been saved", true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__("The Section and it's associated questions could not be saved. Please, try again.", true));
			}
		}
		$questionnaire_question_types = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
		$this->set(compact('questionnaire_question_types'));
	}

	function add_question($sectionID = NULL) {
		if (!empty($this->data)) {
			if($this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->exists()) {
				$this->data['QuestionnaireQuestion']['questionnaire_section_id'] = $sectionID;
				$this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->create();
				if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->saveAll($this->data, array('validate' => 'first'))) {
					$this->Session->setFlash(__('The Question has been added', true), 'messages/success');
					$this->redirect(array('action' => 'index'), 200, true);
				} else {
					$this->Session->setFlash(__('The Section could not be added. Please, try again.', true), 'messages/error');
				}
			}
		}
		$questionnaire_question_types = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
		$this->set(compact('questionnaire_question_types'));
	}

	function edit_question($questionID = null) {
		if (empty($this->data)) {
			$this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->id = $questionID;
			if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->exists() == false){
				$this->Session->setFlash(__('Invalid Section', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			} else {
				$this->data = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->find('first', array('contain' => array('QuestionnaireAnswer')));
			}
		} else {
			if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->saveAll($this->data)) {
				$this->Session->setFlash(__("The Section and it's associated questions have been saved", true), 'messages/success');
				$this->redirect(array('action' => 'index'), 200, true);
			} else {
				$this->Session->setFlash(__("The Section and it's associated questions could not be saved. Please, try again.", true));
			}
		}
		$questionnaire_question_types = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find("list");
		$this->set(compact('questionnaire_question_types'));
	}
	*/
}
?>