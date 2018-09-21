<?php
/**
 * !Name! Model for !Name! Component
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

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * !Name! Model
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 */
class !Name!Controller!Nameobjectlist! extends JControllerLegacy{

	/**
	 * Parameters in config.xml.
	 *
	 * @var	object
	 * @access	protected
	 */
	protected $params = null;

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

	
}