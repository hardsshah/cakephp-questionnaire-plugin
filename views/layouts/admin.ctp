<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xsi:schemaLocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd"
     xml:lang="en" >
	<head>
		<?php echo $html->charset(); ?>
		<title>
			<?php echo Configure::read('Settings.title'); ?>: <?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $html->meta('icon');
			echo $html->css('admin/debug', 'stylesheet', array('media' => 'screen'));
			echo $html->css('blueprint/screen', 'stylesheet', array('media' => 'screen')); 
			echo $html->css('blueprint/print', 'stylesheet', array('media' => 'print'));
			echo $html->css('admin/styles', 'stylesheet', array('media' => 'screen')); 

			echo "<!--[if IE]>";
			echo $html->css('blueprint/ie', 'stylesheet', array('media' => 'screen'));
			echo "<![endif]-->";
			echo "<!--[if lt IE 8]>";
			echo $javascript->link('fix/ie8.js');
			echo "<![endif]-->";

			echo $javascript->link('jquery/jquery.js');
			echo $scripts_for_layout;
		?>
	</head>
	<body>
		<div id="container" class="container">
			<div id="header" class="span-24 last">
				<div id="site-title" class="span-12">
					<?php echo $html->link(Configure::read('Settings.title'), array('controller' => 'dashboards', 'action' => 'index')); ?>
				</div>
				<div id="site-links" class="span-10 last">
					You are currently logged. <span class="separator">|</span> <?php echo $html->link('Log Out', array('controller' => 'users', 'action' => 'logout')); ?> <span class="separator">|</span> <?php echo $html->link('View Site', array('controller' => 'dashboards', 'action' => 'index', 'admin' => false)); ?>
				</div>
			</div>
			<div id="navigation" class="span-24 last">
				<div id="leftnavigation" class="span-16">
					<ul>
						<li><?php echo $html->link('Dashboard', array('controller' => 'dashboards', 'action' => 'index')); ?></li>
					</ul>
				</div>
				<div id="rightnavigation" class="span-8 last">
					<ul>
						<?php if (Configure::read('debug') != 1) { ?>
							<li class="right"><?php echo $html->link('Groups', array('controller' => 'groups', 'action' => 'index')); ?></li>
						<?php } ?>
						<li class="right"><?php echo $html->link('Users', array('controller' => 'users', 'action' => 'index')); ?></li>
					</ul>
				</div>
			</div>
			<div id="content" class="span-24 last">
				<div class="span-24 last">
					<p> </p>
				</div>
				<div class="normalcontent span-24 last">
					<?php
						if ($session->check('Message.flash')): $session->flash(); endif;
						$session->flash('auth');
						$error->validationErrors($this->validationErrors, 3);
					?>
				</div>
				<div class="span-24 last">
					<?php echo $content_for_layout;?>
				</div>
				<div class="span-24 last">
					<p> </p>
				</div>
			</div>
			<div id="footer" class="span-24 last">
				<?php if (Configure::read('Settings.showDisclaimer')) :?>
					<p>
						Thank you for using <?php echo $html->link(Configure::read('Settings.software'), Configure::read('Settings.url')); ?> <?php echo Configure::read('Settings.revision');?> | <?php echo $html->link('Feedback', Configure::read('Settings.url')."/feedback", array('target' => '_blank')); ?>
					</p>
				<?php endif;?>
			</div>
			<div id="extra" class="span-24 last">
				<?php echo $cakeDebug; ?>
			</div>
		</div>
	</body>
</html>