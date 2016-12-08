<?php
/**
* @class DocumentationCategoryUi
*
* This class manages the UI for the DocumentationCategory objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class DocumentationCategory_Ui extends Ui{

	/**
	* Render the menu of the categories.
	*/
	static public function menu($category) {
		$items = DocumentationCategory::readList(array('order'=>'ord'));
		$html = '';
		foreach ($items as $item) {
			$itemsIns = Documentation::readList(array('where'=>'idDocumentationCategory="'.$item->id().'"',
												'order'=>'ord'));
			$htmlIns = '';
			foreach ($itemsIns as $itemIns) {
				$classSelected = ($itemIns->id()==$category->id()) ? 'menuInsSelected' : '';
				$htmlIns .= '<div class="menuIns '.$classSelected.'">'.$itemIns->link().'</div>';
			}
			$classSelected = ($item->id()==$category->get('idDocumentationCategory')) ? 'menuItemSelected' : '';
			$html .= ($htmlIns!='') ? '<div class="menuItem '.$classSelected.'">
											<div class="menuItemTitle">'.$item->getBasicInfo().'</div>
											<div class="menuItems">'.$htmlIns.'</div>
										</div>' : '';
		}
		return $html;
	}

}
?>