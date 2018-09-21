<?php
/**
 * !Namefield! Form Field List class for the !Name! component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 2.5
 * http://www.mmleoni.net/joomla-component-builder
 *
 */
defined('_JEXEC') or die;
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 

class JFormField!Namefield! extends JFormFieldList{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = '!Namefield!';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('`!foreignTablePK!` as `key`, `!foreignTableValue!` as `value`');
		$query->from('`#__!foreignTable!`');
		$query->order('`!foreignTableValue!`');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$options = array();
		if ($rows){
			foreach($rows as $row){
				$options[] = JHtml::_('select.option', $row->key, $row->value);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
