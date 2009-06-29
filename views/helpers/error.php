<?php
/**
 * Error Helper class file.
 * 
 * @filesource
 * @author Jose Diaz-Gonzalez
 * @link http://josediazgonzalez/code/errorhelper/
 * @version .6
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.views.helpers
 */

/**
 * View Helper to support custom error validation generation
 *
 * @package app
 * @subpackage app.views.helpers
 */
class ErrorHelper extends AppHelper {


	/**
	* Prints out a jQuery enhanced list of validation errors
	* 
	* @param array $data Array of all possible errors for all models being validated
	* @param integer $type Integer indicating the css id of the error
	* @param boolean $flash Boolean indicating whether this is a flash message
	* @access public
	*/
	function validationErrors($data, $id, $flash = false){
		$errors = $this->getArray($data);
		if ($errors != array()){
			echo $this->jqueryList(array_values($errors), $id, $flash);
		}
	}

	/**
	* Prints out a jQuery enhanced list of validation errors
	* 
	* @param array $data Array of all possible errors
	* @param integer $type Integer indicating the css id of the error
	* @param boolean $flash Boolean indicating whether this is a flash message
	* @return string String of Javascript/HTML containing list of errors
	* @access public
	*/
	function jqueryList($data, $type, $flash) {
		$temp = $this->getList($data, $flash);
		$id = $this->getType($type);
		if ($flash){
			$output = "<div id=\"". $id ."\" class=\"flash\"style=\"display: none\">Error Message:<br />{$temp}</div>
				<script type=\"text/javascript\">
					jQuery(document).ready(function() {
						$ (\".flash\").fadeIn(\"slow\");
					});
				</script>";
		} else {
			$output = "<div id=\"". $id ."\" class=\"flash\"style=\"display: none\">Reasons for error:<br />{$temp}</div>
				<script type=\"text/javascript\">
					jQuery(document).ready(function() {
						$ (\".flash\").fadeIn(\"slow\");
					});
				</script>";
		}

		return $output;
	}

	/**
	* Used in conjunction with jQueryList
	* Returns the id of the notice
	* 
	* @param integer $data Integer referencing an error type
	* @return string String assigned to an error
	* @access public
	*/
	function getType($data){
		$output = "";
		switch ($data) {
			case 0:
				$output = "error";
				break;
			case 1:
				$output = "success";
				break;
			case 2:
				$output = "notice";
				break;
			case 3:
				$output = "reasons";
				break;
			default:
				$output = "notice";
				break;
		}
		return $output;
	}

	/**
	* Returns a list of items, each wrapped in an <li></li>
	* 
	* @param array $data Array of all possible items
	* @param boolean $flash Boolean indicating whether this is a flash message
	* @return string String containing a <li></li> wrapped list of items
	* @access public
	*/
	function getList($data, $flash){
		$output = '';
		if (is_array($data)){
			if($flash){
				$output .= "<li>{$data['0']}</li>";
			} else {
				foreach($data as $item){
					$output .= "<li>{$item}</li>";
				}
			}
		}
		else {
			$output .= "<li>{$data}</li>";
		}
		return "<ul>".$output."</ul>";
	}

	/**
	* Returns an Array of items that are nested within some other array
	* 
	* @param array $data Array of items which may be arrays themselves
	* @return array Array of items which remove one layer of nesting
	* @access public
	*/
	function getArray($data){
		$arrayValues = array_values($data);
		$output = array();
		foreach($arrayValues as $value){
			$output += $value;
		}
		return $output;
	}
}
?>