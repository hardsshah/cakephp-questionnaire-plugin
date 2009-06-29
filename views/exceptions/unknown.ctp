<div>
	<p><img src="/img/logo.png"/></p>
	<h1><?php __('-views-exceptions-unknown-header') ?></h1>
	<p><?php __('-views-exceptions-unknown-text-short_term'); ?></p>
	<p><?php __('-views-exceptions-unknown-text-long_term'); ?></p>
	<div id="debug" class="cake-exception-log">
	<table><?php 
		if (Configure::read() >= 1) {
			foreach ($info as $name => $value) {
				echo '<tr><th>'.$name.':</th><td id="'.$name.'">'.$value.'</td></tr>';
			}
		}
	?></table>
	</div>
</div>