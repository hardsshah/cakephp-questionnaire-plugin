<?php
class QuestionnaireAppModel extends AppModel {
	var $recursive = -1;
	var $actsAs = array('Containable');
	var $useDbConfig = 'questionnaire';
}
?>