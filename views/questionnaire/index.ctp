<div class="questionnaire_questionnaire index">
	<h2><?php __('Questionnaires');?></h2>
	<p><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></p>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $paginator->sort('id');?></th>
			<th><?php echo $paginator->sort('title');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($questionnaireQuestionnaires as $questionnaireQuestionnaire):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<?php echo "<tr" . $class . ">";?>
			<td><?php echo $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id']; ?></td>
			<td><?php echo $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['title']; ?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('action' => 'view', $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('action' => 'edit', $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('action' => 'delete', $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id'])); ?>
				<?php echo $html->link(__('Fill', true), array('action' => 'fill', $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id'])); ?>
				<?php echo $html->link(__('Add Section', true), array('action' => 'add_section', $questionnaireQuestionnaire['QuestionnaireQuestionnaire']['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('plugin' => 'questionnaire', 'class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<?php echo $html->link('Add a Questionnaire', array('plugin' => 'questionnaire', 'controller' => 'questionnaireQuestionnaires', 'action' => 'add')); ?>
</div>