<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once('kcat_catalog_entry_addform.php');

class KintassaCatalogEntryAddPage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		if (!isset($_GET['catalog_id']) || !KintassaUtils::isInteger($_GET['catalog_id'])) {
			echo("<div class=\"error\">Error: invalid catalog id specified</div>");
			return;
		} else {
			$gallery_id = $_GET['catalog_id'];
		}

		$default_vals = array(
			"sort_pri"		=> 0,
			"filepath"		=> null,
			"name"			=> null,
			"description"	=> "",
			"catalog_id"	=> $catalog_id,
		);
		$this->addForm = new KintassaCatalogEntryAddForm("kcatentry_add", $default_vals);
	}

	function content() {
		$this->addForm->execute();
	}
}

?>
