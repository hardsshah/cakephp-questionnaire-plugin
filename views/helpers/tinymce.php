<?php
/**
 * TinyMCEHelper is a helper for TinyMCE
 * This helper REQUIRES the TinyMCE.
 *
 * @author: David Boyer
 * @version: 1.0
 * @link: http://bakery.cakephp.org/articles/view/tinymce-helper-1
 */
class TinyMceHelper extends AppHelper {
	// Take advantage of other helpers
	var $helpers = array('Javascript', 'Form');
	// Check if the tiny_mce.js file has been added or not
	var $_script = false;

	/**
	 * Adds the tiny_mce.js file and constructs the options
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string JavaScript code to initialise the TinyMCE area
	 */
	function _build($fieldName, $tinyoptions = array()) {
		if (!$this->_script) {
			// We don't want to add this every time, it's only needed once
			$this->_script = true;
			$this->Javascript->link('/js/tiny_mce/tiny_mce.js', false);
		}
		// Ties the options to the field
		$tinyoptions['mode'] = 'textareas';
		$tinyoptions['elements'] = $this->__name($fieldName);
		return $this->Javascript->codeBlock('tinyMCE.init(' . $this->Javascript->object($tinyoptions) . ');');
	}

	/**
	 * Creates a TinyMCE textarea.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $options Array of HTML attributes.
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string An HTML textarea element with TinyMCE
	 */
	function textarea($fieldName, $options = array(), $tinyoptions = array()) {
		return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
	}
	/**
	 * Creates a TinyMCE textarea.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $options Array of HTML attributes.
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string An HTML textarea element with TinyMCE
	 */
	function textarea($fieldName, $selector, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textareas';
		$tinyoptions = array(
			'editor_selector' => $selector,
			'mode' => "specific_textareas"
		);
		if(isset($options['class'])){
			$options['class'] = $options['class'].$selector;
		} else {
			$options['class'] = $selector;
		}
		return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
	}

	/**
	 * Creates a TinyMCE textarea.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $options Array of HTML attributes.
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string An HTML textarea element with TinyMCE
	 */
	function input($fieldName, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textarea';
		return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
	}
}
?>