<?php
/**
 * !Namefield! Form Field Rule class for the !Name! component
 * 
 * @package    !Name!
 * @subpackage com_!name!
 * @license  !license!
 *
 * Created with Marco's Component Creator for Joomla! 2.5
 * http://www.mmleoni.net/joomla-component-builder
 *
 */ 
defined('_JEXEC') or die('Restricted access');
jimport('joomla.form.formrule');
 
/**
 * Form Rule class for the Joomla Framework.
 */
class JFormRule!Namefield! extends JFormRule{
	/**
	 * The regular expression.
	 *
	 * @access	protected
	 * @var		string
	 * @since	1.6
	 */
	protected $regex;

	/**
	 * Method to test the value.
	 *
	 * @param   object  &$element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed   $value     The form field value to validate.
	 * @param   string  $group     The field name group control value. This acts as as an array container for the field.
	 *                             For example if the field has name="foo" and the group value is set to "bar" then the
	 *                             full field name would end up being "bar[foo]".
	 * @param   object  &$input    An optional JRegistry object with the entire data set to validate against the entire form.
	 * @param   object  &$form     The form object for which the field is being tested.
	 *
	 * @return  boolean  True if the value is valid, false otherwise.
	 *
	 * @since   11.1
	 * @throws  JException on invalid rule.
	 */
	public function test(&$element, $value, $group = null, &$input = null, &$form = null){
		return true;
	}
	
}
