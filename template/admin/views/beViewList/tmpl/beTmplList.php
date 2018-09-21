<?php 
	defined('_JEXEC') or die('Restricted access');
	if($this->j3x){
		JHtml::_('bootstrap.tooltip');
	}else{
		JHtml::_('behavior.tooltip');
	} 
?>


<?php
	$numCols = 0; // number of td tag... ie does not support colspan="0" :(
	$this->lists['order_Dir'] = $this->escape($this->state->get('filter.direction'));
	$this->lists['order'] = $this->escape($this->state->get('filter.ordering', '!primaryKey!'));// default order is primary key
	$this->lists['search'] = $this->escape($this->state->get('filter.search'));
	$this->lists['published'] = $this->escape($this->state->get('filter.published'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_!name!'); ?>" method="post" name="adminForm" id="adminForm">
<?php if($this->j3x): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo JHtmlSidebar::render(); ?>
	</div>
<?php endif; ?>
<div <?php echo ($this->j3x?'id="j-main-container" class="span10"':'id="editcell"'); ?>>
<?php if($this->j3x): ?>
	<div class="js-stools clearfix">
		<div class="clearfix">

			<div class="js-stools-container-bar">
				
				<div class="btn-wrapper input-append">
					<label  class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
					<input class="js-stools-search-string" type="text" name="filter_search" id="filter_search" value="<?php echo $this->lists['search']; ?>" placeholder="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>" />
					<button class="btn hasTooltip" onclick="alert('remember to update _buildQueryWhere funcion in model!!');" type="submit" data-original-title="<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>"><i class="icon-search"></i></button>
				</div>
				<div class="btn-wrapper">
					<!--
					<button class="btn hasTooltip js-stools-btn-clear" type="button" data-original-title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
					-->
				</div>
				
			</div>
			<div class="js-stools-container-list hidden-phone hidden-tablet shown">
				<!--select name="filter_published" class="inputbox" onchange="this.form.submit()">
					<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
					<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->lists['published'], true);?>
				</select-->
			</div>

		</div>
	</div>
<?php else: ?>
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->lists['search']; ?>" title="" />
			<button class="btn" onclick="alert('remember to update _buildQueryWhere funcion in model!!');this.form.submit();"><?php echo JText::_( 'JSEARCH_FILTER_SUBMIT' ); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			<!--select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->lists['published'], true);?>
			</select-->
		</div>
	</fieldset>
	<div class="clr"> </div>
<?php endif; ?>

	<table class="adminlist table table-striped">
	<thead>
		<tr>
			<th width="20" class="jcb_fieldDiv jcb_fieldLabel"><?php $numCols++; ?>
			<?php if ($this->j3x): ?>
				<?php echo JHtml::_('grid.checkall'); ?>
			<?php else: ?>
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
			<?php endif; ?>
			</th>
			<th class="jcb_fieldDiv jcb_fieldLabel"><?php $numCols++; ?>
				Edit
			</th>
			<!-- Joomla! Component Builder - begin code  -->
!fieldheaderlist!
			<!-- Joomla! Component Builder - end code  -->
			<?php if(isset($this->rows[0]->ordering)): ?>
			<th width="20" class="jcb_fieldDiv jcb_fieldLabel nowrap"><?php $numCols++; ?>
				<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $this->lists['order_Dir'], $this->lists['order']); ?>
				<?php if ($this->auth('core.edit') && ($this->lists['order']=='ordering')): ?>
					<?php echo JHtml::_('grid.order',  $this->rows, 'filesave.png', '!nameobjectlist!.saveorder'); ?>
				<?php endif;?>				
			</th>
			<?php endif; ?>
			<?php if(isset($this->rows[0]->published)): ?>
			<th class="jcb_fieldDiv jcb_fieldLabel"><?php $numCols++; ?>
				<?php echo JHTML::_('grid.sort', 'JSTATUS', 'published', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="<?php echo $numCols; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	
	<?php
	$k = 1;
	for ($i=0, $n=count( $this->rows ); $i < $n; $i++)	{
		$row = &$this->rows[$i];
		$checked = JHTML::_('grid.id', $i, $row->!primaryKey!);
		$link = JRoute::_( 'index.php?option=com_!name!&task=!nameobject!.edit&!primaryKey!='. $row->!primaryKey!);
		$k = 1 - $k;
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<?php if (isset($row->checked_out) && ($row->checked_out)) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, 'someone...', $row->checked_out_time, '!nameobjectlist!.', $this->auth('!nameobject!.checkin')); ?>
				<?php endif; ?>				
				<!-- You can use $link var for link edit controller -->
				<a href="<?php echo $link; ?>">[edit]</a>
			</td>
			<!-- Joomla! Component Builder - begin code  -->
!fieldlist!
			<!-- Joomla! Component Builder - end code  -->
			<?php if(isset($row->ordering)): ?>
			<td class="order nowrap">
            	<?php 
					$page = new JPagination( $n, 1, $n );
					$up = JString::strtolower($this->lists['order_Dir'])=='asc'?'orderup':'orderdown';
					$down=JString::strtolower($this->lists['order_Dir'])=='asc'?'orderdown':'orderup';
					$enable = $this->auth('core.edit') && ($this->lists['order']=='ordering');
				?>
					<span><?php echo $page->orderUpIcon( $i, $i>0, '!nameobjectlist!.'.$up, JText::_( 'JLIB_HTML_MOVE_UP' ), $enable ); ?></span>
					<span><?php echo $page->orderDownIcon( $i, $n, $i<$n, '!nameobjectlist!.'.$down, JText::_( 'JLIB_HTML_MOVE_DOWN' ), $enable ); ?></span>					
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text-area-order input-mini" <?php echo ($enable?'':'disabled="true"'); ?> />
			</td>
			<?php endif; ?>
			<?php if(isset($row->published)): ?>
			<td>
				<?php if($this->j3x): ?>
					<?php echo JHtml::_('jgrid.published', $row->published, $i, '!nameobjectlist!.', true); ?>
				<?php else: ?>
					<?php echo JHTML::_('grid.published', $row, $i, 'tick.png', 'publish_x.png', '!nameobjectlist!.'); ?>
				<?php endif; ?>
			</td>
			<?php endif; ?>
		</tr>
	<?php
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_!name!" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="view" value="!nameobjectlist!" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>
