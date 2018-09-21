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
 * @package	Joomla.Components
 * @subpackage	!Name!
 */
class !Name!View!Nameobject! extends JViewLegacy{
	function display($tpl = null){
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
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
			return false;
		}
		
		parent::display($tpl);
	}
}
?>
