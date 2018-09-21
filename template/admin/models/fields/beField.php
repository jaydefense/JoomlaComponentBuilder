<?php
/**
 * !Namefield! Form Field class for the !Name! component
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

class JFormField!Namefield! extends JFormField{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = '!Namefield!';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput(){
		$onclick	= ' onclick="document.id(\''.$this->id.'\').value=\'0\';"';

		return '<input style="border:0;" type="text" name="'.$this->name.'" id="'.$this->id.'" value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'" readonly="readonly" /><input type="button"'.$onclick.' value="'.JText::_('COM_!name!_!Namefield!').'" class="button"/>';
	}
}
