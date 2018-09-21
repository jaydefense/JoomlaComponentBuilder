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
jimport('joomla.application.component.modeladmin');

/**
 * !Name! Model
 *
 * @package    Joomla.Components
 * @subpackage 	!Name!
 */
class !Name!Model!Nameobject! extends JModelAdmin{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct(){
		parent::__construct();

		//$array = JRequest::getVar('cid',  0, '', 'array');
		$array = JFactory::getApplication()->input->server->get('cid', 0, 'INT');
		$this->setId((int)$array[0]);
	}


	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_!name!.!nameobject!.'.((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}
	
	/**
	 * Prepare and sanitise the table data prior to saving.
	 * @param   JTable  &$table  A reference to a JTable object.
	 * @return  void
	 * @since   11.1
	 */	
    protected function prepareTable($table){
		/* define which columns can have NULL values */
        $nullable ='!nullableFieldList!';
		if(!$nullable) return;
        foreach (explode(',', $nullable) as $val){
            /* define the rules when the value is set NULL */
            if (!strlen($table->$val)) $table->$val = NULL;
        }
    }	
	
	
	/** Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = '!Nameobject!', $prefix = '!Name!Table', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_!name!.!nameobject!', '!nameobject!', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string	Script files
	 */
	public function getScript() 
	{
		return 'administrator/components/com_!name!/models/forms/!nameobject!.js';
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_!name!.edit.!nameobject!.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	
	/**
	 * Method to validate the form data.
	 * @since   12.2
	 *
	 * set default value for unchecked checkbox
	 * works on j3+ only, don't use in j2.5
	 */	
	/**
	public function validate($form, $data, $group = null){
		$data =  parent::validate($form, $data, $group = null);
		if (version_compare( JVERSION, '3.0', '<' )) return $data; 
		
		foreach($form->getFieldsets() as $fset){
			foreach($form->getFieldset($fset->name) as $f){
				if ( (JString::strcasecmp($f->type, 'Checkbox') == 0) && !isset($data[$f->fieldname]) ) {
					$data[$f->fieldname] = $f->getAttribute('unchecked', '0');
				}
			}
		}
		return $data;
	}
	*/
	
	
	/**
	 * Method to set the identifier for the record
	 *
	 * @access	public
	 * @param	int primary key identifier
	 * @return	void
	 */
	public function setId($id){
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	
	/**MMLBE: Example of override of common task
    public function save($data){
        $app	= JFactory::getApplication();
        $jinput = $app->input;
        $aVarCheck  = $jinput->post->get('aVarCheck', '', 'word');
        if($aVarCheck != $data['aVar']){
                JFactory::getApplication()->enqueueMessage(JText::_('ERROR: aVarCheck != aVar'), 'error');
                return false;
            }
        }

        if(!parent::save($data)) return false;		

        return true;
    }
	MMLBE*/
	
	
	
	/**MMLBE: Example of task working on list; see doTaskList() in contoller for object list
	public function doTaskList(&$pks) {
		$table = $this->getTable();
        $pks = (array) $pks;
		$status = true;

        foreach ($pks as $i => $pk) {
            $table->reset();
            $table->load($pk);
			// do something with table ...
            $status = $table->store(true); // pass true to save NULL values

			// do something with another table ...
            $anotherTable = JTable::getInstance('anotherTable', '!Name!Table', array());
			$fields = array();
            $date= new JDate();
            $fields['afield'] = $date->toSql();
            $transactionTable->bind($fields);
            if(!$anotherTable->store(true)){
                JFactory::getApplication()->enqueueMessage('ERROR in anotherTable', 'warning');
            }
            
        }
 
        // Clear the component's cache
        $this->cleanCache();
        return $status;
    }    
	MMLBE*/	

	/**
	 * Methods to get options arrays for specific fields
	 * @return object with data
	 */
	public function &getGenericFieldName(){
		$options = array(
            JHTML::_('select.option',  'val1', 'text 1' ),
            JHTML::_('select.option',  'val2', 'text 2' )
        );    
		return $options;
	}
	
	
!fieldGetDataSelect!	


}