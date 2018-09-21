<?php
/**
 * !Name! entry point file for !name! Component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 2.5
 * http://www.mmleoni.net/joomla-component-builder
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


// import joomla controller library
jimport('joomla.application.component.controller');


$ctrl='!Name!';
$input = JFactory::getApplication()->input;
// Require specific controller if requested
if($controller = $input->getWord('controller')) {
	$ctrl = $controller;
}else{
	// define default view if you need routing...
	//JRequest::setVar( 'view', '***' ); // insert here!! 
}
 
// Get an instance of the required controller
$controller = JControllerLegacy::getInstance($ctrl);
 
// Perform the Request task

$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();

?>
