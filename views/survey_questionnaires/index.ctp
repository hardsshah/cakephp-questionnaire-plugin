<div class="survey_questionnaire index">
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
		foreach ($surveyQuestionnaires as $surveyQuestionnaire):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $surveyQuestionnaire['SurveyQuestionnaire']['id']; ?></td>
			<td><?php echo $surveyQuestionnaire['SurveyQuestionnaire']['title']; ?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('action'=>'view', $surveyQuestionnaire['SurveyQuestionnaire']['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>