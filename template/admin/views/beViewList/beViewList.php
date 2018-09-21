<?php
/**
 * !Name! View for !Name! Component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 1.6
 * http://www.mmleoni.net/joomla-component-builder
 *
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * !Name! View
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 */
class !Name!View!Nameobjectlist! extends JViewLegacy
{
	/**
	 * !Nameobjectlist! view display method
	 * @return void
	 **/
	function display($tpl = null){
		$app = JFactory::getApplication();
		$this->user  = JFactory::getUser();

		// Get data from the model; method is getItems() in J2.5+
		$this->rows = $this->get( 'Items');
		$this->state = $this->get( 'State');
		$this->pagination = $this->get('Pagination');	
		$this->j3x = version_compare( JVERSION, '3.0', '>=' ); // is Joomla 3+

		
		// draw menu
		//'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete'
		JToolBarHelper::title( JText::_( 'com_!name!_MENU_!nameobjectlist!' ), 'generic.png' );
		if($this->user->authorise('core.edit', 'com_!name!')) JToolBarHelper::editList('!nameobject!.edit');
		if($this->user->authorise('core.create', 'com_!name!')) JToolBarHelper::addNew('!nameobject!.add');
		if($this->user->authorise('core.delete', 'com_!name!')) JToolBarHelper::deleteList('', '!nameobjectlist!.delete');
		
		if( (isset($this->rows[0]->published)) && ($this->user->authorise('core.edit', 'com_!name!')) ){
			JToolBarHelper::divider();
			JToolBarHelper::publish('!nameobjectlist!.publish');
			JToolBarHelper::unpublish('!nameobjectlist!.unpublish');
		}
		
		// configuration editor for config.xml
		if($this->user->authorise('core.admin', 'com_!name!')){
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_!name!');
		}
		

		// SORTING get the user state of order and direction
		//  ** J1.5 now in $this->state object
		//$default_order_field = '!primaryKey!';
		//$lists['order_Dir'] = $app->getUserStateFromRequest('com_!name!filter_order_Dir', 'filter_order_Dir', 'ASC');
		//$lists['order'] = $app->getUserStateFromRequest('com_!name!filter_order', 'filter_order', $default_order_field);
		//$lists['search'] = $app->getUserStateFromRequest('com_!name!search', 'search', '');

		parent::display($tpl);
	}
	
	protected function auth($area){
		//echo '<pre>' . print_r(JAccess::getActions('com_!name!','!nameobject!'),true).'</pre>';die();
		$aclLocal = array();
		foreach(JAccess::getActions('com_!name!', '!nameobject!') as $ar) $aclLocal[] = $ar->name;
		if(in_array($area, $aclLocal)){
			return $this->user->authorise($area, 'com_!name!', '!nameobject!');
		}else{
			$aclGlobal = array();
			foreach(JAccess::getActions('com_!name!') as $ar) $aclGlobal[] = $ar->name;
			if(in_array($area, $aclGlobal)){
				if(!empty($aclLocal)) JFactory::getApplication()->enqueueMessage('Undefined authorization area: ' . $area . ' -- fall back on component acl', 'Warning');
				return $this->user->authorise($area, 'com_!name!');
			}else{
				JFactory::getApplication()->enqueueMessage('Undefined authorization area: ' . $area . ' -- NO fall back found', 'Error');
				return true;
			}
		}
		
	}
	
}