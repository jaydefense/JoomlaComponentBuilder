<?php
/**
 * !Name! Model for !Name! Component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 2.5
 * http://www.mmleoni.net/joomla-component-builder
 *
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * !Name! Table
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 * libraries/joomla/database/table.php
 */
class !Name!Table!Nameobject! extends JTable{

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db){
		parent::__construct('#__!table!', '!primaryKey!', $db);
	}
	
	function check(){
		// write here data validation code
		return parent::check();
	}

	function bind($src, $ignore = array()){
		// source value is an array or object.
		return parent::bind($src, $ignore);
	}

	function store($updateNulls = false) {
		// $updateNulls: True to update fields even if they are null.
		return parent::store($updateNulls);
	}
}