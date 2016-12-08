<?php
/**
* @class DocumentationUi
*
* This class manages the UI for the Documentation objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Documentation_Ui extends Ui{

	/**
	* Render the complete page of the Documentation.
	*/
	public function renderComplete() {
		return '<div class="document">
					<div class="documentMenu">
						'.DocumentationCategory_Ui::menu($this->object).'
					</div>
					<div class="documentContent">
						<h1>'.$this->object->getBasicInfo().'</h1>
						<div class="pageComplete">
							'.$this->object->get('description').'
						</div>
						'.$this->renderMore().'
					</div>
				</div>';
	}

	/**
	* Render the buttons to read more information.
	*/
	public function renderMore() {
		$category = DocumentationCategory::read($this->object->get('idDocumentationCategory'));
		$nextDocumentation = Documentation::readFirst(array('where'=>'ord > '.$this->object->get('ord').'
																	AND idDocumentationCategory="'.$this->object->get('idDocumentationCategory').'"',
																	'order'=>'ord'));
		$prevDocumentation = Documentation::readFirst(array('where'=>'ord < '.$this->object->get('ord').'
																	AND idDocumentationCategory="'.$this->object->get('idDocumentationCategory').'"',
																	'order'=>'ord DESC'));
		$nextDocumentationHtml = ($nextDocumentation->id()!='') ? '<div class="documentationMoreNext">'.$nextDocumentation->link().'</div>' : '';
		$prevDocumentationHtml = ($prevDocumentation->id()!='') ? '<div class="documentationMorePrev">'.$prevDocumentation->link().'</div>' : '';
		if ($nextDocumentationHtml=='') {
			$nextCategory = DocumentationCategory::readFirst(array('where'=>'ord > '.$category->get('ord'), 'order'=>'ord'));
			if ($nextCategory->id()!='') {
				$nextDocumentation = Documentation::readFirst(array('where'=>'idDocumentationCategory="'.$nextCategory->id().'"',
																	'order'=>'ord'));
				$nextDocumentationHtml = ($nextDocumentation->id()!='') ? '<div class="documentationMoreNext">'.$nextDocumentation->link().'</div>' : '';
			}
		}
		if ($prevDocumentationHtml=='') {
			$prevCategory = DocumentationCategory::readFirst(array('where'=>'ord < '.$category->get('ord'), 'order'=>'ord DESC'));
			if ($prevCategory->id()!='') {
				$prevDocumentation = Documentation::readFirst(array('where'=>'idDocumentationCategory="'.$prevCategory->id().'"',
																	'order'=>'ord DESC'));
				$prevDocumentationHtml = ($prevDocumentation->id()!='') ? '<div class="documentationMorePrev">'.$prevDocumentation->link().'</div>' : '';
			}
		}
		return '<div class="documentationMore">
					<div class="documentationMoreTitle">'.__('readMore').'</div>
					<div class="documentationMoreButtons">
						'.$prevDocumentationHtml.'
						'.$nextDocumentationHtml.'
					</div>
				</div>';
	}

}
?>