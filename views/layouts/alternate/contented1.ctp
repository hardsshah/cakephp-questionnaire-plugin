<?php
/*
  default.thtml design for CakePHP (http://www.cakephp.org)
  ported from http://contenteddesigns.com/ (open source template)
  ported by Shunro Dozono (dozono :@nospam@: gmail.com)
  2006/7/6
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $html->charset(); ?>
		<title>
			<?php __('CakePHP: the rapid development php framework:'); ?>
			<?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $html->meta('icon');

			echo $html->css('cake/cake.forms');
			echo $html->css('alternate/contented1');

			echo $scripts_for_layout;
		?>
	</head>
	<body>
		<div id="header">
			<div id="title"><?php echo Configure::read('Settings.title'); ?></div>
			<div id="contact">
				<a href="#">CONTACT US</a>
			</div>
			<div id="slogan"><?php echo Configure::read('Settings.slogan'); ?></div>
		</div>
		<div id="nav">
			<a class="selected" href="http://cakephp.org">CakePHP Home</a> <a href="http://api.cakephp.org/">API</a> <a href="http://book.cakephp.org/">Docs</a> <a href="http://bakery.cakephp.org">Bakery</a> <a href="http://live.cakephp.org">Live</a> <a href="https://trac.cakephp.org">Trac</a> <a href="http://cakeforge.org">Forge</a> <a href="http://thechaw.com/">The Chaw</a>
		</div>
		<div id="content">
			<div id="maincontent">
				<?php if ($session->check('Message.flash')) {$session->flash();} ?>
				<?php echo $content_for_layout ?>
			</div>
			<div id="sidecontent">
				<h1>
					News
				</h1>Use this sidebar for recent news, press releases, upcoming events, notes.
				<p>
					<a href="#">This is a link to a page describing a news item.</a> (2006-04-02)
				</p>
				<p>
					<a href="#">This is a link to a page describing a news item.</a> (2006-04-01)
				</p>
			</div>
		</div>
		<div id="footer">
			<div id="copyrightdesign">
				Copyright © 2006 Your Name | Design by <a href="http://ContentedDesigns.com">Contented Designs</a>
			</div>
			<div id="footercontact">
				<a href="#">Contact Us</a>
			</div>
		</div>
		<p>
			CakePHP : <a href="http://www.cakefoundation.org/pages/copyright/">© 2006 Cake Software Foundation, Inc.</a>
		</p>
		<p>
			<a href="http://www.w3c.org/" ><?php echo $html->image('w3c_css.png', array('alt'=>"valid css", 'border'=>"0"))?></a> <a href="http://www.w3c.org/" ><?php echo $html->image('w3c_xhtml10.png', array('alt'=>"valid xhtml", 'border'=>"0"))?></a> <a href="http://www.cakephp.org/" ><?php echo $html->image('cake.power.png', array('alt'=>"CakePHP : Rapid Development Framework", 'border'=>"0"))?></a> <?php echo $cakeDebug;?>
		</p>
		<?php echo $cakeDebug; ?>
	</body>
</html>