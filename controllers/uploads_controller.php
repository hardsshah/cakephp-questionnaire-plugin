<?php  
class UploadsController extends AppController {

	var $name = 'Uploads';
	var $helpers = array('Form');
	var $components = array('FileUpload');

	function add() {
		if(!empty($this->data)){
			if($this->FileUpload->success){
				$this->set('photo', $this->FileUpload->finalFile);
			} else {
				$this->Session->setFlash($this->FileUpload->showErrors());
			}
		}
	}

	function admin_add() {
		if(!empty($this->data)){
			if($this->FileUpload->success){
				$this->set('photo', $this->FileUpload->finalFile);
			} else {
				$this->Session->setFlash($this->FileUpload->showErrors());
			}
		}
	}
}
?>