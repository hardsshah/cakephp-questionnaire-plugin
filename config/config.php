<?php
$config['Settings'] = Configure::read('Settings');
 
$config['Settings'] = Set::merge(ife(empty($config['Settings']), array(), $config['Settings']), array(
    'developer' => 'Your Name Here',
    'company' => 'Your Company Here',
    'title' => 'CakePHP: the rapid development php framework:',
    'slogan' => 'the rapid development php framework',
	'editor' => 'form',
	'errors' => 'example@example.com',
	'software' => 'Your Company CMS',
	'revision' => '0.1',
	'url' => 'http://example.com/example'
));
?>