<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once('kcat_catalog_entry_editform.php');

class KintassaCatalogEntryEditPage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		$catalog_entry_id = $_GET['id'];
		assert (KintassaUtils::isInteger($catalog_entry_id));

		$this->editForm = new KintassaCatalogEntryEditForm("kcatentry_edit", $catalog_entry_id);
	}

	function content() {
		$this->editForm->execute();
	}
}

?>
