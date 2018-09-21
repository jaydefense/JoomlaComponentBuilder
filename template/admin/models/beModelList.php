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

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.modellist' );

/**
 * !Name! Model
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 */
class !Name!Model!Nameobjectlist! extends JModelList{

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */

	protected function populateState($ordering = null, $direction = null){
		parent::populateState($ordering, $direction);
		
		// Adjust the context to support modal layouts.
		if ($layout = JFactory::getApplication()->input->get('layout', '', 'CMD')) {
			$this->context .= '.'.$layout;
		}
		
		$filter_order = $this->getUserStateFromRequest($this->context . '.filter.ordering', 'filter_order', '!primaryKey!');
		$this->setState('filter.ordering', $filter_order);
		
		$filter_order_Dir = strtoupper($this->getUserStateFromRequest($this->context . '.filter.direction', 'filter_order_Dir', 'ASC'));
		$this->setState('filter.direction', $filter_order_Dir);
		
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search', '');
		$this->setState('filter.search', $search);
		
		$dummy = $this->getUserStateFromRequest($this->context.'.filter.param1', 'filter_param2', '');
		$this->setState('filter.param1', $dummy);
		
		$dummy = $this->getUserStateFromRequest($this->context.'.filter.param2', 'filter_param2', '');
		$this->setState('filter.param2', $dummy);
		
	}

	/**
	 * Returns the table prefix and the field name
	 * @return array The table prefix and the field name to be used to retrieve the rows from the database
	 */
	protected function getPrefix($fieldName){
	
		if(preg_match("/^t\d___/", $fieldName)){
			return explode ('___', $fieldName, 2);
		}
		
		switch ($fieldName){
			case 'field1FromTable2':
			case 'field2FromTable2':
				$prefix = 't2';
				break;
			case 'field1FromTable3':
			case 'field2FromTable3':
				$prefix = 't3';
				break;
			default:
				$prefix = 't1';
				break;
		}	
		return array($prefix, $fieldName);
	}

	/**
	 * Returns the 'order by' part of the query
	 * @return string the order by''  part of the query
	 */
	private function _buildQueryOrderBy() {
	    $app = JFactory::getApplication();

		// default field for records list
		$default_order_field = '!primaryKey!'; 
		// Array of orderable fields
	    $allowedOrders = explode(',', '!fieldList!'); 

		// retrive ordering info
		$filter_order = $this->getState('filter.ordering');
		$filter_order_Dir = strtoupper($this->getState('filter.direction'));

	    // validate the order direction, must be ASC or DESC
	    if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC') {
			$filter_order_Dir = 'ASC';
	    }

	    // if order column is unknown use the default
	    if ((isSet($allowedOrders)) && !in_array($filter_order, $allowedOrders)){
			$filter_order = $default_order_field;
	    }

		list($prefix, $filter_order) = $this->getPrefix($filter_order);

	    // return the ORDER BY clause        
	    return " ORDER BY `{$prefix}`.`{$filter_order}` {$filter_order_Dir}";
	}	
	
	
	private function _buildQueryWhere() {
		$db = JFactory::getDBO();
		$search = $this->getState('filter.search');
		
		$whereSearch = '';
		$whereCond='';
		
	    if ($search){
			$sa = array();
			// Array of searchable fields
			$allowedSearch = explode(',', '!fieldSearchList!');
			foreach($allowedSearch as $field){
				if (!$field) return '';
				list($prefix, $field) = $this->getPrefix($field);
				$sa[] = "(`{$prefix}`.`{$field}` LIKE " . $db->quote('%' . $search . '%') . ")";
			}
			if(count($sa)) $whereSearch = " AND (" .implode(" OR ", $sa) .")";
		}		
		
		if(false){
			$condA = array();
			if($param1=$this->getState('filter.param1')){
				$field = 'field1FromTable2';
				list($prefix, $field) = $this->getPrefix($field);
				$param2 = $db->quote($param1);
				$condA[]= " (`{$prefix}`.`{$field}` = {$param1}) ";
			}
			if($param2=$this->getState('filter.param2')){
				$field = 'field1FromTable3';
				list($prefix, $field) = $this->getPrefix($field);
				$param2 = $db->quote($param2);
				$condA[]= " (`{$prefix}`.`{$field}` = {$param2}) ";
			}
			if(count($condA))$whereCond = " AND (" .implode(" AND ", $condA) .")";
		}
		
	    return " WHERE (1=1) {$whereSearch} {$whereCond}";		
	}
	
	
	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	protected function getListQuery(){
		//$db = JFactory::getDBO();
		$query = 'SELECT `t1`.* !fieldsJoin! FROM `#__!table!` `t1` !tablesJoin! ' . $this->_buildQueryWhere() . $this->_buildQueryOrderBy();
		return $query;
	}
	
		
	/**
	 * Methods to get records data for specific fields
	 * use returned recorset to populate view in specific
	 * select to manage related tables
	 * @return object list with options array
	 */
	public function getGenericFieldName($fieldName){
		$db = JFactory::getDBO();
		$db->setQuery( 'SELECT !primaryKey! AS value `$fieldName` AS text FROM `#__!table!` ORDER BY `$fieldName`');
		$options = array();
		foreach( $db->loadObjectList() as $r){
			$options[] = JHTML::_('select.option',  $r->value, $r->text );
        }
		return $options;

	}
	
!fieldGetData!	

	
}