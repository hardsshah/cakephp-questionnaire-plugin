<?php
/**
 * MeioUpload Behavior 1.5
 * 
 * This behavior is based on Vincius Mendes' MeioUpload Behavior
 *  (http://www.meiocodigo.com/projects/meioupload/)
 * Which is in turn based upon Tane Piper's improved uplaod behavior
 *  (http://digitalspaghetti.tooum.net/switchboard/blog/2497:Upload_Behavior_for_CakePHP_12)
 * 
 * @author Jose Diaz-Gonzalez (support@savant.be)
 * @link http://josediazgonzalez.com
 * @filesource http://josediazgonzalez.com/code/thing-upload-behavior
 * @version 1.5
 * @lastmodified 2009-5-17
 * 
 * Usage:
 * 1) Download this behavior and place it in your models/behaviors/meio_upload.php
 * 2) If you require thumbnails for image generation, download the latest copy of 
 *     phpThumb and extract it into your vendors directory. Should end up like: /vendors/phpThumb/{files}.
 *    (http://phpthumb.sourceforge.net)
 * 3) Insert the following SQL into your database.  This is a basic model you can expand on:
 *		CREATE TABLE `images` (
 *			`id` int(8) unsigned NOT NULL auto_increment,
 *			`filename` varchar(255) default NULL,
 *			`dir` varchar(255) default NULL,
 *			`mimetype` varchar(255) NULL,
 *			`filesize` int(11) unsigned default NULL,
 *			`created` datetime default NULL,
 *			`modified` datetime default NULL,
 *			PRIMARY KEY  (`id`)
 *		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
 * 4) In your model that you want to have the upload behavior work, place the below code.  This example is for an Image model:
 * 
 *		var $actsAs = array(
 *			'MeioUpload' => array(
 *				'filename' => array(
 *					'dir' => 'files/images',
 *					'create_directory' => false,
 *					'max_size' => 2097152,
 *					'max_dimension' => 'w',
 *					'thumbnailQuality' => 50,
 *					'useImageMagick' => true,
 *					'imageMagickPath' => '/usr/bin/convert',
 *					'allowed_mime' => array( 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/png'),
 *					'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif'),
 *					'thumbsizes' => array(
 *						'small'  => array('width' => 100, 'height' => 100),
 *						'medium' => array('width' => 220, 'height' => 220),
 *						'large'  => array('width' => 800, 'height' => 600)
 *					),
 *				)
 *			)
 *		);
 *    The above code will save the uploaded file's name in the 'filename' field in database,
 *    it will not overwrite existing files, instead it will create a new filename based on the original
 *    plus a counter.
 *    Allowed mimetypes and extensions should be pretty explanatory.
 *    For thumbnails, when the file is uploaded, it will create 3 thumbnail sizes and prepend the name
 *    to the thumbnail files (i.e. image_001.jpg will produced thumb.small.image_001.jpg, thumb.medium.image_001.jpg, etc)
 * 
 * 5) Create your upload view, make sure it's a multipart/form-data form, and the filename field is of type $form->file. Ie
 *		<?
 *			echo $form->create('Upload', array('type' => 'file'));
 *			echo $form->input('filename', array('type' => 'file'));
 *			echo $form->input('dir', array('type' => 'hidden'));
 *			echo $form->input('mimetype', array('type' => 'hidden'));
 *			echo $form->input('filesize', array('type' => 'hidden'));
 *			echo $form->end('Submit');
 *		?>
 * 6) Make sure your directory is at least CHMOD 775, also check your php.ini MAX_FILE_SIZE is enough to support the filesizes you are uploading
 * 
 *    Version Details
 * 
 *    1.5
 *    + Replaced createthumb() with createThumbnail(), now uses phpThumb
 *    + Added option for whether model should use imageMagick and imageMagick path
 *    + Quality of thumbnails can now be set, default to 75 if not set
 *    + Allows user to set a max dimension (h or w)
 * 
 *    1.0.1
 *    + Fixed a bug in the create folder method
 *    + Now you can use the $validate var of the model to apply the changes to default validation rules;
 *    + Changed the my_array_merge function, now it's part of the behavior, name arrayMerge;
 *    + Allow use of {DS}, {model} and {field} constants in directory name and fields names;
 *    + Fixed a bug with the replacement of the default names.
 * 
 *    1.0
 *    + Initial release.
 */
uses('folder');
class MeioUploadBehavior extends ModelBehavior {
	/**
	 * The default options for the behavior
	 */
	var $default_options = array(
		'dir' => '',
		'allowed_mime' => array(),
		'allowed_ext' => array(),
		'create_directory' => true,
		'max_size' => 2097152,
		'thumbsizes' => array(),
		'default' => false,
		'max_dimension' => null,
		'thumbnailQuality' => 75,
		'useImageMagick' => false,
		'imageMagickPath' => '/usr/bin/convert',
		'fields' => array(
			'dir' => 'dir',
			'filesize' => 'filesize',
			'mimetype' => 'mimetype'
		),
		'validations' => array(
			'FieldName' => array(
				'rule' => array('uploadCheckFieldName'),
				'check' => true,
				'message' => 'This field was not specified among the parameters of MeioUploadBehavior.'
			),
			'Dir' => array(
				'rule' => array('uploadCheckDir'),
				'check' => true,
				'message' => 'The directory where this file would be placed does not exist or is protected against writing.'
			),
			'Empty' => array(
				'rule' => array('uploadCheckEmpty'),
				'check' => true,
				'on' => 'create',
				'message' => 'This field cannot be empty.'
			),
			'UploadError' => array(
				'rule' => array('uploadCheckUploadError'),
				'check' => true,
				'message' => 'There were problems in uploading the file.'
			),
			'MaxSize' => array(
				'rule' => array('uploadCheckMaxSize'),
				'check' => true,
				'message' => 'The maximum file size was exceeded.'
			),
			'InvalidMime' => array(
				'rule' => array('uploadCheckInvalidMime'),
				'check' => true,
				'message' => 'Invalid file type.'
			),
			'InvalidExt' => array(
				'rule' => array('uploadCheckInvalidExt'),
				'check' => true,
				'message' => 'Invalid file extension.'
			)
		)
	);

	var $default_validations = array(
		'FieldName' => array(
			'rule' => array('uploadCheckFieldName'),
			'check' => true,
			'message' => 'This field was not specified among the parameters of MeioUploadBehavior.'
		),
		'Dir' => array(
			'rule' => array('uploadCheckDir'),
			'check' => true,
			'message' => 'The directory where this file would be placed does not exist or is protected against writing.'
		),
		'Empty' => array(
			'rule' => array('uploadCheckEmpty'),
			'check' => true,
			'on' => 'create',
			'message' => 'This field cannot be empty.'
		),
		'UploadError' => array(
			'rule' => array('uploadCheckUploadError'),
			'check' => true,
			'message' => 'There were problems in uploading the file.'
		),
		'MaxSize' => array(
			'rule' => array('uploadCheckMaxSize'),
			'check' => true,
			'message' => 'The maximum file size was exceeded.'
		),
		'InvalidMime' => array(
			'rule' => array('uploadCheckInvalidMime'),
			'check' => true,
			'message' => 'Invalid file type.'
		),
		'InvalidExt' => array(
			'rule' => array('uploadCheckInvalidExt'),
			'check' => true,
			'message' => 'Invalid file extension.'
		)
	);

	/**
	 * The message for move error.
	 */
	var $moveErrorMsg = 'A problem occured during copy.';

	/**
	 * The array that saves the $options for the behavior
	 */
	var $__fields = array();

	/**
	 * Patterns of reserved words
	 */
	var $patterns = array(
		"thumb",
		"default"
	);

	/**
	 * Words to replace the patterns of reserved words
	 */
	var $replacements = array(
		"t_umb",
		"d_fault"
	);

	/**
	 * Array of files to be removed on the afterSave callback
	 */
	var $__filesToRemove = array();

	/**
	 * Setup the behavior. It stores a reference to the model, 
	 * merges the default options with the options for each 
	 * field, and setup the validation rules.
	 * 
	 * @author Vinicius Mendes
	 * @return null
	 * @param $model Object
	 * @param $config Array[optional]
	 */
	function setup(&$model, $config=array()) {
		$this->Folder = &new Folder;
		$this->__model = $model;
		$this->__fields = array();
		foreach($config as $field => $options) {
			// Check if given field exists
			if(!$model->hasField($field)) {
				trigger_error('MeioUploadBehavior Error: The field "'.$field.'" doesn\'t exists in the model "'.$model->name.'".', E_USER_WARNING);
			}
			// Merge given options with defaults
			$options = $this->arrayMerge($this->default_options, $options);
			// Including the default name to the replacements
			if($options['default']){
				if(!preg_match('/^.+\..+$/',$options['default'])){
					trigger_error('MeioUploadBehavior Error: The default option must be the filename with extension.', E_USER_ERROR);
				}
				$this->_includeDefaultReplacement($options['default']);
			}
			// Verifies if the thumbsizes names is alphanumeric
			foreach($options['thumbsizes'] as $name => $size){
				if(!preg_match('/^[0-9a-zA-Z]+$/',$name)){
					trigger_error('MeioUploadBehavior Error: The thumbsizes names must be alphanumeric.', E_USER_ERROR);
				}
			}
			// Process the max_size if it is not numeric
			$options['max_size'] = $this->sizeToBytes($options['max_size']);
			$this->__fields[$field] = $options;
			// Generate temporary directory if none provided
			if(empty($options['dir'])) {
				$this->__fields[$field]['dir'] = 'uploads' . DS . $model->name;
			// Else replace the tokens of the dir.
			} else {
				$this->__fields[$field]['dir'] = $this->replaceTokens($options['dir'],$field);
			}
			// Replace tokens in the fields names.
			foreach($this->__fields[$field]['fields'] as $fieldToken => $fieldName){
				$this->__fields[$field]['fields'][$fieldToken] = $this->replaceTokens($fieldName,$field);
			}
			// Check that the given directory does not have a DS on the end
			if($options['dir'][strlen($options['dir'])-1] == DS) {
				$options['dir'] = substr($options['dir'],0,strlen($options['dir'])-2);
			}
		}
	}

	/**
	 * Merges two arrays recursively
	 * 
	 * @author Vinicius Mendes
	 * @return Array
	 * @param $arr Array
	 * @param $ins Array
	 */
	function arrayMerge($arr, $ins) {
		if (is_array($arr)) {
			if (is_array($ins)) {
				foreach ($ins as $k=>$v) {
					if (isset($arr[$k])&&is_array($v)&&is_array($arr[$k])) {
						$arr[$k] = $this->arrayMerge($arr[$k],$v);
					}
					else $arr[$k] = $v;
				}
			}
		} elseif (!is_array($arr)&&(strlen($arr)==0||$arr==0)) {
			$arr=$ins;
		}
		return($arr);
	}

	/**
	 * Replaces some tokens. {model} to the underscore version
	 * of the model name, {field} to the field name, {DS}. / 
	 * or \ to DS constant value.
	 * 
	 * @author Vinicius Mendes
	 * @return String
	 * @param $string String
	 * @param $fieldName String
	 */
	function replaceTokens($string,$fieldName){
		return str_replace(array('{model}', '{field}', '{DS}','/','\\'),array(Inflector::underscore($this->__model->name),$fieldName,DS,DS,DS),$string);
	}

	/**
	 * Convert a size value to bytes. For example: 2 MB to 2097152.
	 * 
	 * @author Vinicius Mendes
	 * @return int
	 * @param $size String
	 */
	function sizeToBytes($size){
		if(is_numeric($size)) return $size;
		if(!preg_match('/^[1-9][0-9]* (kb|mb|gb|tb)$/i', $size)){
			trigger_error('MeioUploadBehavior Error: The max_size option format is invalid.', E_USER_ERROR);
			return 0;
		}
		list($size, $unit) = explode(' ',$size);
		if(strtolower($unit) == 'kb') return $size*1024;
		if(strtolower($unit) == 'mb') return $size*1048576;
		if(strtolower($unit) == 'gb') return $size*1073741824;
		if(strtolower($unit) == 'tb') return $size*1099511627776;
		trigger_error('MeioUploadBehavior Error: The max_size unit is invalid.', E_USER_ERROR);
		return 0;
	}

	/**
	 * Sets the validation for each field, based on the options.
	 * 
	 * @author Vinicius Mendes
	 * @return null
	 * @param $fieldName String
	 * @param $options Array
	 */
	function setupValidation($fieldName, $options){
		$options = $this->__fields[$fieldName];
		if(isset($this->__model->validate[$fieldName])){
			if(isset($this->__model->validate[$fieldName]['rule'])){
				$this->__model->validate[$fieldName] = array(
					'oldValidation' => $this->__model->validates[$fieldName]
				);
			}
		} else {
			$this->__model->validate[$fieldName] = array();
		}
		$this->__model->validate[$fieldName] = $this->arrayMerge($this->default_validations,$this->__model->validate[$fieldName]);
		$this->__model->validate[$fieldName] = $this->arrayMerge($options['validations'],$this->__model->validate[$fieldName]);
	}

	/**
	 * Checks if the field was declared in the MeioUpload Behavior setup
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckFieldName(&$model, $data, $other){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['FieldName']['check']) return true;
			if(isset($this->__fields[$fieldName])){
				return true;
			} else {
				$this->log('UploadBehavior Error: The field "'.$fieldName.'" wasn\'t declared as part of the UploadBehavior in model "'.$model->name.'".');
				return false;
			}
		}
		return true;
	}

	/**
	 * Checks if the folder exists or can be created or writable.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckDir(&$model, $data){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['Dir']['check']) return true;
			$options = $this->__fields[$fieldName];
			if(empty($field['remove']) || empty($field['name'])){
				// Check if directory exists and create it if required
				if(!is_dir($options['dir'])) {
					if($options['create_directory']){
						if(!$this->Folder->mkdir($options['dir'])) {
							trigger_error('UploadBehavior Error: The directory '.$options['dir'].' does not exist and cannot be created.', E_USER_WARNING);
							return false;
						}
					} else {
						trigger_error('UploadBehavior Error: The directory'.$options['dir'].' does not exist.', E_USER_WARNING);
						return false;
					}
				}
				// Check if directory is writable
				if(!is_writable($options['dir'])) {
					trigger_error('UploadBehavior Error: The directory '.$options['dir'].' isn\'t writable.', E_USER_WARNING);
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Checks if the filename is not empty.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckEmpty(&$model, $data){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['Empty']['check']) return true;
			if(empty($field['remove'])){
				if(!is_array($field) || empty($field['name'])){
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Checks if errors occured in the upload.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckUploadError(&$model, $data){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['UploadError']['check']) return true;
			if(!empty($field['name']) && $field['error'] > 0){
				return false;
			}
		}
		return true;
	}

	/**
	 * Checks if the file isn't bigger then the max file size option.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckMaxSize(&$model, $data){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['MaxSize']['check']) return true;
			$options = $this->__fields[$fieldName];
			if(!empty($field['name']) && $field['size'] > $options['max_size']) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Checks if the file is of an allowed mime-type.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckInvalidMime(&$model, $data){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['InvalidMime']['check']) return true;
			$options = $this->__fields[$fieldName];
			if(!empty($field['name']) && count($options['allowed_mime']) > 0 && !in_array($field['type'], $options['allowed_mime'])) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Checks if the file has an allowed extension.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $model Object
	 * @param $data Array
	 */
	function uploadCheckInvalidExt(&$model, $data){
		foreach($data as $fieldName => $field){
			if(!$this->__model->validate[$fieldName]['InvalidExt']['check']) return true;
			$options = $this->__fields[$fieldName];
			if(!empty($field['name'])){
				if(count($options['allowed_ext']) > 0) {
					$matches = 0;
					foreach($options['allowed_ext'] as $extension) {
						if(substr($field['name'],-strlen($extension)) == $extension) {
							$matches++;
						}
					}
					if($matches == 0) {
						return false;
					}
				}
			}
		}
		return true;
	}

	/**
	 * Set a file to be removed in afterSave callback
	 * 
	 * @author Vinicius Mendes
	 * @return null
	 * @param $fieldName String
	 */
	function setFileToRemove($fieldName){
		$filename = $this->__model->field($fieldName);
		if(!empty($filename) && $filename != $this->__fields[$fieldName]['default']){
			$this->__filesToRemove[] = array(
				'dir' => $this->__fields[$fieldName]['dir'],
				'name' => $filename
			);
		}
	}

	/**
	 * Include a pattern of reserved word based on a filename, and it's replacement.
	 * 
	 * @author Vinicius Mendes
	 * @return null
	 * @param $default String
	 */
	function _includeDefaultReplacement($default){
		$replacements = $this->replacements;
		list($newPattern, $ext) = $this->splitFilenameAndExt($default);
		if(!in_array($newPattern, $this->patterns)){
			$this->patterns[] = $newPattern;
			$newReplacement = $newPattern;
			if(isset($newReplacement[1])){
				if($newReplacement[1] != '_'){
					$newReplacement[1] = '_';
				} else {
					$newReplacement[1] = 'a';
				}
			} elseif($newReplacement != '_') {
				$newReplacement = '_';
			} else {
				$newReplacement = 'a';
			}
			$this->replacements[] = $newReplacement;
		}
	}

	/**
	 * Removes the bad characters from the $filename and replace
	 * reserved words. It updates the $model->data.
	 * 
	 * @author Vinicius Mendes
	 * @return null
	 * @param $fieldName String
	 */
	function fixName($fieldName){
		// updates the filename removing the keywords thumb and default name for the field.
		list($filename, $ext) = $this->splitFilenameAndExt($this->__model->data[$this->__model->name][$fieldName]['name']);
		$filename = str_replace($this->patterns,$this->replacements,$filename);
		$filename = Inflector::slug($filename);
		$i = 0;
		$newFilename = $filename;	
		while(file_exists($this->__fields[$fieldName]['dir'].DS.$newFilename.'.'.$ext)){
			$newFilename = $filename.$i;
			$i++;
		}
		$this->__model->data[$this->__model->name][$fieldName]['name'] = $newFilename.'.'.$ext;
	}

	/**
	 * Splits a filename in two parts: the name and the extension.
	 * Returns an array with it respectively.
	 * 
	 * @author Vinicius Mendes
	 * @return Array
	 * @param $filename String
	 */
	function splitFilenameAndExt($filename){
		$parts = explode('.',$filename);
		$ext = $parts[count($parts)-1];
		unset($parts[count($parts)-1]);
		$filename = implode('.',$parts);
		return array($filename,$ext);
	}

	/**
	 * Sets the validation rules for each field.
	 * 
	 * @return true 
	 * @param $model Object
	 */
	function beforeValidate(&$model) {
		foreach($this->__fields as $fieldName=>$options){
			$this->setupValidation($fieldName, $options);
		}
		return true;
	}

	/**
	 * Uploads the files before saving the record.
	 * 
	 * @author Jose Diaz-Gonzalez
	 * @param $model Object
	 */
	function beforeSave(&$model) {
		foreach($this->__fields as $fieldName=>$options){
			// if the file is marked to be deleted, use the default or set the field to null
			if(!empty($model->data[$model->name][$fieldName]['remove'])){
				if($options['default']){
					$model->data[$model->name][$fieldName] = $options['default'];
				} else {
					$model->data[$model->name][$fieldName] = null;
				}

				//if the record is already saved in the database, set the existing file to be removed after the save is sucessfull
				if(!empty($model->data[$model->name][$model->primaryKey])){
					$this->setFileToRemove($fieldName);
				}
				continue;
			}

			// If no file has been upload, then unset the field to avoid overwriting existant file 
			if(!isset($model->data[$model->name][$fieldName]) || !is_array($model->data[$model->name][$fieldName]) || empty($model->data[$model->name][$fieldName]['name'])){
				if(!empty($model->data[$model->name][$model->primaryKey]) || !$options['default']){
					unset($model->data[$model->name][$fieldName]);
				} else {
					$model->data[$model->name][$fieldName] = $options['default'];
				}
				continue;
			}

			//if the record is already saved in the database, set the existing file to be removed after the save is sucessfull
			if(!empty($model->data[$model->name][$model->primaryKey])){
				$this->setFileToRemove($fieldName);
			}

			// Fix the filename, removing bad characters and avoiding from overwriting existing ones
			$this->_includeDefaultReplacement($options['default']);
			$this->fixName($fieldName);
			$saveAs = $options['dir'].DS.$model->data[$model->name][$fieldName]['name'];
			// Attempt to move uploaded file
			if(!move_uploaded_file($model->data[$model->name][$fieldName]['tmp_name'], $saveAs)){
				$model->validationErrors[$field] = $moveErrorMsg;
				return false;
			}

			// It the file is an image, try to make the thumbnails
			if (count($options['allowed_ext']) > 0 && in_array($model->data[$model->name][$fieldName]['type'], array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png'))) {
				foreach ($options['thumbsizes'] as $key => $value) {
					// If a 'normal' thumbnail is set, then it will overwrite the original file
					if($key == 'normal'){
						$thumbSaveAs = $saveAs;
					// Otherwise, set the thumb filename to thumb.$key.$filename.$ext
					} else {
						$thumbSaveAs = $options['dir'].DS.'thumb.'.$key.'.'.$model->data[$model->name][$fieldName]['name'];
					}
					if (isset($value['max_dimension'])) {
						$this->createThumbnail($saveAs, $thumbSaveAs, $fieldName, array('thumbWidth' => $value['width'], 'thumbHeight' => $value['height'], 'maxDimension' => $value['max_dimension']));
					} else {
						$this->createThumbnail($saveAs, $thumbSaveAs, $fieldName, array('thumbWidth' => $value['width'], 'thumbHeight' => $value['height']));
					}
				}
			}
			// Update model data
			$model->data[$model->name][$options['fields']['dir']] = $options['dir'];
			$model->data[$model->name][$options['fields']['mimetype']] =  $model->data[$model->name][$fieldName]['type'];            
			$model->data[$model->name][$options['fields']['filesize']] = $model->data[$model->name][$fieldName]['size'];
			$model->data[$model->name][$fieldName] = $model->data[$model->name][$fieldName]['name'];
		}
		return true;
	}

	/**
	 * Deletes the files marked to be deleted in the save method.
	 * A file can be marked to be deleted if it is overwritten by
	 * another or if the user mark it to be deleted.
	 * 
	 * @author Vinicius Mendes 
	 * @param $model Object
	 */
	function afterSave(&$model) {
		foreach($this->__filesToRemove as $file){
			if($file['name'])
				$this->_deleteFiles($file['name'], $file['dir']);			
		}
		// Reset the filesToRemove array
		$this->__filesToRemove = array();
	}

	/**
	 * Deletes all files associated with the record beforing delete it.
	 * 
	 * @author Vinicius Mendes 
	 * @param $model Object
	 */   
	function beforeDelete(&$model) {
		$model->read(null, $model->id);
		if(isset($model->data)) {
			foreach($this->__fields as $field=>$options) {
				$file = $model->data[$model->name][$field];
				if($file && $file != $options['default'])
					$this->_deleteFiles($file, $options['dir']);
			}
		}
		return true;
	}

	/**
	 * Delete the $filename inside the $dir and the thumbnails.
	 * Returns true if the file is deleted and false otherwise.
	 * 
	 * @author Vinicius Mendes
	 * @return boolean
	 * @param $filename Object
	 * @param $dir Object
	 */
	function _deleteFiles($filename, $dir){
		$saveAs = $dir . DS . $filename;
		if(is_file($saveAs) && !unlink($saveAs))
		{
			return false;
		}
		$folder = &new Folder($dir);
		$files = $folder->find('thumb\.[a-zA-Z0-9]+\.'.$filename);
		foreach($files as $f) unlink($dir.DS.$f);
		return true;
	}

	/**
	 * Function to create Thumbnail images
	 * This will ACTUALLY USE phpThumb, as opposed to just saying it will
	 * Will convert more than just JPG/JPEG/PNG (hopefully)
	 * 
	 * @author Jose Diaz-Gonzalez
	 * @param String source file name (without path)
	 * @param String target file name (without path)
	 * @param String path to source and destination (no trailing DS)
	 */
	function createThumbnail($source, $target, $fieldName, $params = array()) {
		$params = array_merge(
			array(
				'thumbWidth' => 150, 
				'thumbHeight' => 225, 
				'maxDimension' => ''), 
				$params);
		// Import phpThumb class
		App::import('Vendor','phpthumb', array('file' => 'phpThumb'.DS.'phpthumb.class.php'));
		// Configuring thumbnail settings
		$thumbNail = new phpthumb;
		$thumbNail->setSourceFilename($source);
		if (($params['maxDimension'] != 'h') | ($params['maxDimension'] != 'w')) {
			$thumbNail->w = $params['thumbWidth'];
			$thumbNail->h = $params['thumbHeight'];
		} else {
			if ($params['maxDimension'] == 'w') {
				$thumbNail->w = $params['thumbWidth'];
			} else if ($params['maxDimension'] == 'h') {
				$thumbNail->h = $params['thumbHeight'];
			}
		}
		$thumbNail->q = $this->__fields[$fieldName]['thumbnailQuality'];

		$imageArray = explode(".", $source);
		$thumbNail->config_output_format = $imageArray[1];
		unset($imageArray);

		$thumbNail->config_prefer_imagemagick = $this->__fields[$fieldName]['useImageMagick'];
		$thumbNail->config_imagemagick_path = $this->__fields[$fieldName]['imageMagickPath'];

		// Setting whether to die upon error
		$thumbNail->config_error_die_on_error = true;

		// Creating thumbnail
		if ($thumbNail->GenerateThumbnail()) {
			if (!$thumbNail->RenderToFile($target)) {
				$this->addError('Could not render image to: '.$target);
			}
		}
	}
}
?>