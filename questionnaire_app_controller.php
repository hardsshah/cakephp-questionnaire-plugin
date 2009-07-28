<?php
class QuestionnaireAppController extends AppController {

	public $components = array('Acl', 'Auth');
	
	function beforeFilter() {
		$this->Auth->allowedActions = array('*');
	}
}
?>