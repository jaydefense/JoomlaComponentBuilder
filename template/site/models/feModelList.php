<?php
/**
 * !Name! Model for !Name! Component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 1.6
 * http://www.mmleoni.net/joomla-component-builder
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * !Name! Model
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 */
class !Name!Model!Nameobjectlist! extends JModelLegacy{
	
	/**
	 * !Nameobjectlist! data array for tmp store
	 *
	 * @var array
	 */
	private $_data;

	/**
	* Pagination object
	* @var object
	*/
	private $_pagination = null;

	/*
	 * Constructor
	 *
	 */
	function __construct(){
		parent::__construct();

		$app = JFactory::getApplication();

        // Get pagination request variables
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);

	}

	
	/**
	 * Gets the data
	 * @return mixed The data to be displayed to the user
	 */
	public function getData(){
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data )){
			//$recordSet =& $this->getTable('!nameobject!');
			$db = JFactory::getDBO();
			//$query = 'SELECT * FROM `#__!table!` WHERE ' . (isset($recordSet->published)?'`published`':'1') . ' = 1 ORDER BY `!primaryKey!` ';
			$query = 'SELECT * FROM `#__!table!` WHERE 1 ORDER BY `!primaryKey!` ';
			$this->_data = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_data;
	}

	/**
	 * Gets the number of published records
	 * @return int
	 */
	public function getTotal(){
		$db = JFactory::getDBO();
		//$recordSet =& $this->getTable('!nameobject!');
		//$db->setQuery( 'SELECT COUNT(*) FROM `#__!table!` WHERE ' . (isset($recordSet->published)?'`published`':'1') . ' = 1' );
		$db->setQuery( 'SELECT COUNT(*) FROM `#__!table!` WHERE 1' );
		return $db->loadResult();
	}
	
	/**
	 * Gets the Pagination Object
	 * @return object JPagination
	 */
	public function getPagination(){
		// Load the content if it doesn't already exist
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	
}
