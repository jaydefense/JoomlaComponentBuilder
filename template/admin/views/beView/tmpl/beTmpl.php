<?php
	defined('_JEXEC') or die('Restricted access');
	if ($this->j3x){
		JHtml::_('bootstrap.tooltip');
		JHtml::_('behavior.formvalidation');
		JHtml::_('formbehavior.chosen', 'select');
	}else{
		jimport( 'joomla.html.editor' ); $editor = JFactory::getEditor(); 
		jimport( 'joomla.html.html' );
		JHtml::_('behavior.tooltip');
		JHtml::_('behavior.formvalidation');
	}; 

	// js validation only after mootools has been loaded
	$document = JFactory::getDocument();
	$document->addScript(JURI::root() . $this->script);
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == '!nameobject!.cancel' || document.formvalidator.isValid(document.id('!name!-form')))
		{
			Joomla.submitform(task, document.getElementById('!name!-form'));
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm" id="!name!-form" class="form-validate">
<?php if ($this->j3x): ?>
	<div class="form-horizontal">
		<div class="tab-content">
			<?php echo JText::_( 'JDETAILS' ); ?>
			<div class="tab-pane active" id="general">
				<div class="row-fluid">
					<div class="span12">
						<?php foreach($this->form->getFieldset('details') as $field): ?>
						<div class="control-group">
							<div class="control-label"><?php echo $field->label; ?></div>
							<div class="controls"><?php echo $field->input; ?></div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>	
		
		</div>
	</div>
<?php else: ?>
	<div class="col100">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'JDETAILS' ); ?></legend>
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('details') as $field): ?>
				<li><?php echo $field->label; echo $field->input;?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>
	</div>
<?php endif; ?>

<div class="clr"></div>

<input type="hidden" name="option" value="com_!name!" />
<input type="hidden" name="!primaryKey!" value="<?php echo $this->item->!primaryKey!; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="layout" value="edit">
<?php echo JHtml::_('form.token'); ?>

</form>
