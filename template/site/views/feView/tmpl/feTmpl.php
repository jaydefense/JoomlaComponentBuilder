<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$data = $this->data;
$link = JRoute::_( "index.php?option=com_!name!&view=!nameobject!&id={$data->!primaryKey!}" );
?>
<div>
!fieldlist!
</div>
