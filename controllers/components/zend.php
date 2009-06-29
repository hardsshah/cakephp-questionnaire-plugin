<?php 
/**
 * Zend Framework Component
 * 
 * A simple component to use Zend_Loader in your Application.
 * It will modify the include path properly and provide wrapper
 * methods to the static Zend_Loader methods.
 * 
 * With this you can use any Zend Component by simply using loadClass
 * before you create instances.
 * 
 * Put the "Zend" folder into your /[app]/vendors/ folder
 * Requires PHP5 and so does Zend Framework itself! 
 * 
 * @example $this->Zend->loadClass('Zend_Gdata_Gbase');
 *		  $service = new Zend_Gdata_Gbase();
 *		  $query = $service->newSnippetQuery();
 *		  $query->setCategory('products');
 *
 * @version 0.1 
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @uses Zend_Loader
 * @package	app
 * @subpackage app.controller.components
 */
class ZendComponent extends Object 
{
	/**
	 * Controller Startup Initialisation
	 * Add APP/vendor to include path
	 * 
	 * @throws Exception
	 */
	public function startup() {
		$include = get_include_path();
		$include.= PATH_SEPARATOR. APP . 'vendors' . DS;
		$successful = set_include_path($include);
		
		if (!$successful) {
			throw new Exception('ZendComponent failed to set include path.', E_ERROR);
		}
		require_once('Zend/Loader.php');
	}

	/**
	 * Loads a class from a PHP file.  The filename must be formatted
	 * as "$class.php".
	 *
	 * @param string $class - The full class name of a Zend component.
	 * @param string|array $dirs - OPTIONAL Either a path or an array of paths to search.
	 * @return void
	 * @throws Zend_Exception
	 */	
	public function loadClass($class, $dirs = null){
		Zend_Loader::loadClass($class, $dirs);
	}

	/**
	 * Loads a PHP file.  This is a wrapper for PHP's include() function.
	 *
	 * $filename must be the complete filename, including any
	 * extension such as ".php".
	 * 
	 * @param  string $filename
	 * @param  string|array  $dirs - OPTIONAL either a path or array of paths to search.
	 * @param  boolean	   $once
	 * @return boolean
	 * @throws Zend_Exception
	 */
	public function loadFile($filename, $dirs = null, $once = false){
		Zend_Loader::loadFile($filename, $dirs, $once);
	}

	/**
	 * Returns TRUE if the $filename is readable, or FALSE otherwise.
	 * This function uses the PHP include_path, where PHP's is_readable()
	 * does not.
	 *
	 * @param string   $filename
	 * @return boolean
	 */
	public function isReadable($filename) {
		Zend_Loader::isReadable($filename);
	}
}?>