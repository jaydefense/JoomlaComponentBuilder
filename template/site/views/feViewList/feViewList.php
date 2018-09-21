<?php
/**
 * !Name! View for com_!name! Component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 1.6
 * http://www.mmleoni.net/joomla-component-builder
 *
 */

jimport( 'joomla.application.component.view');
jimport('joomla.application.component.model');

/**
 * HTML View class for the !Name! Component
 *
 * @package		!Name!
 * @subpackage	Components
 */
class !Name!View!Nameobjectlist! extends JViewLegacy{
	function display($tpl = null){
		$app = JFactory::getApplication();
		/*
		// load component parameters
		$params = JComponentHelper::getParams( 'com_!name!' );
		$params = $app->getParams( 'com_!name!' );	
		$dummy = $params->get( 'dummy_param', 1 ); 

		// load another model
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_!name!/models');
		$otherModel = JModelLegacy::getInstance( 'Record', 'RecordModel' );
		*/
	
		$data = $this->get('Data');
		$this->assignRef('data', $data);
		
		$pagination = $this->get('Pagination');
		$this->assignRef('pagination', $pagination);

		parent::display($tpl);
	}
}
?>
