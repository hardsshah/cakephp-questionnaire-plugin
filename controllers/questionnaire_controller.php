<?php
class QuestionnaireController extends QuestionnaireAppController{
	var $name = 'Questionnaire';
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

	function fill($id = null) {
		if (empty($this->data)){
			$questionnaireQuestionnaire = $this->QuestionnaireQuestionnaire->getQuestionnaire($id);
			if (!empty($questionnaireQuestionnaire)) {
				$questionnaireQuestionTypes = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
				$this->set(compact('questionnaireQuestionnaire', 'questionnaireQuestionTypes'));
			} else {
				$this->Session->setFlash(__('Invalid Questionnaire.', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
			}
		} else {
			if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireSurvey->saveAll($this->data['QuestionnaireSurvey'], array('validate' => false))){
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
			$this->data = $this->QuestionnaireQuestionnaire->read(null, $id);
			if (empty($this->data)){
				$this->Session->setFlash(__('Invalid Questionnaire', true), 'messages/error');
				$this->redirect(array('action' => 'index'), 404, true);
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

	function view_section($sectionID = null) {
		if (!$sectionID) {
			$this->Session->setFlash(__('Invalid Questionnaire Section.', true), 'messages/error');
			$this->redirect(array('action' => 'index'));
		}
		$this->QuestionnaireQuestionnaire->QuestionnaireSection->id = $sectionID;
		$questionnaireSection = $this->QuestionnaireQuestionnaire->QuestionnaireSection->find('first', array('contain' => ('QuestionnaireQuestion')));
		if (isset($questionnaireSection['QuestionnaireSection']) and !empty($questionnaireSection['QuestionnaireSection'])) {
			$questionTypes = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->QuestionnaireQuestionType->find('list');
			$this->set(compact('questionnaireSection', 'questionTypes'));
		} else {
			$this->Session->setFlash(__('Invalid Questionnaire Section.', true), 'messages/error');
			$this->redirect(array('action' => 'index'));
		}
	}

	function add_section($id = null) {
		if (!empty($this->data)) {
			$questionnaireQuestionnaire = $this->QuestionnaireQuestionnaire->find('first');
			if (!empty($questionnaireQuestionnaire)) {
				$this->data['QuestionnaireSection']['questionnaire_questionnaire_id'] = $this->data['QuestionnaireQuestionnaire']['id'];
				$i = 0;
				foreach ($this->data['QuestionnaireQuestion'] as $question) {
					if (!isset($question['title']) or empty($question['title'])) {
						unset($this->data['QuestionnaireQuestion'][$i]);
					}
					$i++;
				}
				if (!isset($this->data['QuestionnaireQuestion']) or empty($this->data['QuestionnaireQuestion'])) {
					unset($this->data['QuestionnaireQuestion']);
				}
				$this->QuestionnaireQuestionnaire->QuestionnaireSection->create();
				if ($this->QuestionnaireQuestionnaire->QuestionnaireSection->saveAll($this->data, array('validate' => 'first'))) {
					$this->Session->setFlash(__('The Section has been added', true), 'messages/success');
					$this->redirect(array('action' => 'index'), 200, true);
				} else {
					$this->Session->setFlash(__('The Section could not be added. Please, try again.', true), 'messages/error');
				}
			}
		}
		if (empty($this->data)) {
			$this->data = $this->QuestionnaireQuestionnaire->read(null, $id);
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

	function view_question($questionID = null) {
		if (!is_integer($questionID)) {
			$this->Session->setFlash(__('Invalid Questionnaire questionnaireQuestion.', true), 'messages/error');
			$this->redirect(array('action' => 'index'));
		}
		$this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->id = $questionID;
		$questionnaireQuestion = $this->QuestionnaireQuestionnaire->QuestionnaireSection->QuestionnaireQuestion->find('first');
		if (isset($questionnaireQuestion['QuestionnaireQuestion']) and !empty($questionnaireQuestion['QuestionnaireQuestion'])) {
			$this->set(compact('questionnaireQuestion'));
		} else {
			$this->Session->setFlash(__('Invalid Questionnaire Question.', true), 'messages/error');
			$this->redirect(array('action' => 'index'));
		}
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
}
?>