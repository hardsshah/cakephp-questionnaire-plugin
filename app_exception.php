<?php
/**
  * Aplication wide exception handler class.
  *
  * Installation: 
  * 1) Copy file in to the app directory;
  * 2) Add to bootstrap.ctp folowing lines:
  * require_once(APP.'app_exception.php');
  * set_exception_handler(array('AppExceptionHandler', 'handleException'));
  * 3) Add default view to render exceptions in /exceptions/unknown.ctp, 
  * view has access to $info variable
  *
  * References:
  * http://www.mt-soft.com.ar/2007/12/21/handling-exceptions-in-cakephp-12/
  */
class AppExceptionHandler extends Object {  
 
	static function handleException($exception) {
		$parsed = new AppExceptionParser($exception);
		$instance = new AppExceptionHandler();
		$instance->renderException($parsed->getInfo());
		$instance->logException($parsed->getInfo());
		$instance->emailException($parsed);
		exit;
	}

	function renderException($info = array()) {
		$Controller = new Controller();
		$Controller->viewPath = 'exceptions';
		$Controller->layout = 'exception';
		$Dispatcher = new Dispatcher();
		$Controller->base = $Dispatcher->baseUrl();
		$Controller->webroot = $Dispatcher->webroot;
		$Controller->set(compact('info'));
		$View = new View($Controller);
		$view = @$info['type'];
		if (!file_exists(VIEWS.'exceptions'.DS.$view.'.ctp')) {
			$view = 'unknown';
		}
		//header('HTTP/1.0 500 Internal Server Error');
		$out = $View->render($view);
		$Controller->afterFilter();  
		echo $out;
	}

	function logException($info) {
		$this->log(serialize($info), LOG_ERROR);
	}

	function emailException($message) {
		App::import('Core', 'Email');
		$email = new EmailComponent;
		$email->from = Configure::read('Settings.title');
		$email->to = 'dev@example.com';
		$email->sendAs = 'text';
		$email->subject = 'Exception notification';
		$email->send($message);
	}
}

/**
  * Application exception info synthetic class.
  */
class AppExceptionParser extends Object {

	var $exception = null;

	function __construct($exception) {
		$this->exception = $exception;
	}
 
    public function __toString() {
		return print_r($this->getInfo(), true);
    }

	function getInfo() {
		return array_merge(
			array(
				'type' => $this->getType(),
				'message' => $this->getMessage()
			),
			$this->where(),
			$this->context()
		);
	}

	function getType() {
		if (get_class($this->exception) == 'AppException' || is_subclass_of($this->exception, 'AppException')) {
			return $this->exception->getType();
		}
		else return 'unknown';
	}

	function getMessage() {
		return $this->exception->getMessage();
	}

	function where() {
		return array(
			'function' => $this->getClass().'::'.$this->getFunction(),
			'file' => $this->exception->getFile(),
			'line' => $this->exception->getLine(),
			'url' => $this->getUrl()
			);
	}

	function getUrl($full = true) {
		return Router::url(array('full_base' => $full));
	}

	function getClass() {
		$trace = $this->exception->getTrace();
		return $trace[0]['class'];
	}

	function getFunction() {
		$trace = $this->exception->getTrace();
		return $trace[0]['function'];
	}

	function context() {
		return array(
			'remoteAddr' => $this->getRemoteAddr(),
			'requestMethod' => $this->getRequestMethod(),
			'httpUserAgent' => $this->getHttpUserAgent(),
			'httpAcceptLangage' => $this->getHttpAcceptLanguage(),
			'httpReferer' => $this->getHttpReferer(),
			'sessionAuth' => $this->getSessionAuth()
			);
	}

	function getRemoteAddr() {
		return $_SERVER['REMOTE_ADDR'];
	}

	function getRequestMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}

	function getHttpUserAgent() {
		return $_SERVER['HTTP_USER_AGENT'];
	}

	function getHttpAcceptLanguage() {
		return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}

	function getHttpReferer() {
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'None';
	}

	function getSessionAuth() {
		return isset($_SESSION['Auth']) ? print_r($_SESSION['Auth'], true) : 'Anonymous';
	}
}

/**
  * Application base exception class. The $info['type'] stores name of the view file in /views/exceptions/, without .ctp.
  * Default view is /views/exceptions/unknown.ctp
  */
class AppException extends Exception {

	var $type = null;

	function __construct($message, $type = 'unknown') {
		parent::__construct($message);
		$this->type = $type;
	}

	function getType() {
		return $this->type;
	}
}
?>