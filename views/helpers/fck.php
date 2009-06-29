<?php
/**
 * FCKHelper is a helper for FCKEditor.
 * This helper REQUIRES the FCKEditor.
 *
 * @author: Jonathan Bossenger
 * @version: 2.0
 * @email: psykro AT gmail DOT com
 * @site: http://www.psykro.za.net/
 * @link: http://bakery.cakephp.org/articles/view/simple-fck-editor-helper
 */
App::import('Vendor', 'fckeditor');
class FckHelper extends AppHelper {
	/**
	* creates an fckeditor textarea
	*
	* @param array $namepair - used to build textarea name for views, array('Model', 'fieldname')
	* @param stirng $basepath - base path of project/system
	* @param string $content
	* @param string $toolbarSet - allows you to set a custom toolbar set [Optional]
	* @param string $skin - allows you to set a custom skin, requires setting a toolbar set [Optional]
	*/
	function fckeditor($namepair = array(), $basepath = '', $content = '', $toolbarSet = null, $skin = null){ 
		$editor_name = 'data';
		foreach ($namepair as $name){
			$editor_name .= "[" . $name . "]";
		}
		$oFCKeditor = new FCKeditor($editor_name);
		$oFCKeditor->BasePath = $basepath . "/js/fckeditor/" ; 
		$oFCKeditor->Value = $content;
		if ($toolbarSet != null) {
			$oFCKeditor->ToolbarSet = $toolbarSet;
		} else {
			$oFCKeditor->ToolbarSet = 'Minimal';
		}
		if ($skin != null) {
			$oFCKeditor->ToolbarSet = "/js/fckeditor/editor/skins/" . $skin . "/";
		} else {
			$oFCKeditor->Config['SkinPath'] = '/js/fckeditor/editor/skins/silvernarrow/';
		}
		$oFCKeditor->Create();
	}
}
?>