<?php
/**
* @class ContactUi
*
* This class manages the UI for the Contact objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Contact_Ui extends Ui{
	
	/**
	* Renders the contact page.
	*/
	static public function intro($options=array()) {
		$values = (isset($options['values'])) ? $options['values'] : array();
		$errors = (isset($options['errors'])) ? $options['errors'] : array();
		$form = new Contact_Form($values, $errors);
		$formHtml = $form->createPublic();
		return '<div class="contact">
					<div class="contactTop">'.Page::show('contact').'</div>
					<div class="contactBottom">'.$formHtml.'</div>
				</div>';
	}

}
?>