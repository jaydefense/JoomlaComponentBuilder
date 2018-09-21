<?php
/**
 * !Name! Controller for !Name! Component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 2.5 & 3.x
 * http://www.mmleoni.net/joomla-component-builder
 *
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
/**
 * !Name! Controller
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 */
class !Name!Controller!Nameobject! extends JControllerForm{
	/**
	 * Parameters in config.xml.
	 *
	 * @var	object
	 * @access	protected
	 */
	protected $params = null;
	
	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $view_item = '!nameobject!';

	/**
	 * The URL view list variable.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $view_list = '!nameobjectlist!';	

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct(){
		parent::__construct();
		
		// Set reference to parameters
		$this->params = JComponentHelper::getParams( 'com_!name!' );
		//$dummy = $this->params->get('parm_text');

	}
	
	/**MMLBE: Example of override of common task
	function edit($key = null, $urlVar = null) {
		$ret=parent::edit($key, $urlVar);
		return $ret;
	}
	MMLBE*/
	
	/**MMLBE: Example of override of common task
	function save($key = null, $urlVar = null) {
		$ret = parent::save($key, $urlVar);
		return $ret;
	}
	MMLBE*/
	
	/**MMLBE: Example of override of common task
	function cancel($key = null) {
		$ret = parent::cancel($key);
		return $ret;
	}
    MMLBE*/
	

}