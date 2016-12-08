<?php
/**
* @class BrandUi
*
* This class manages the UI for the Brand objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Brand_Ui extends Ui{

	/**
	* Render a simple logo brand.
	*/
    public function renderPublic() {
        return '<div class="brand">'.$this->object->getImage('image', 'thumb').'</div>';
    }

    /**
	* Render the intro logos.
	*/
	static public function intro() {
		$items = new ListObjects('Brand', array('order'=>'ord'));
		if (!$items->isEmpty()) {
			return '<div class="brands">'.$items->showList().'</div>';
		}
    }

}

?>