<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_page.php'));
require_once('kcat_config.php');
require_once('kcat_catalog_editpage.php');
require_once('kcat_catalog_addpage.php');
require_once('kcat_catalog_tablepage.php');
require_once('kcat_catalog_entry_addpage.php');
require_once('kcat_catalog_entry_editpage.php');

class KintassaCatalogMainPage extends KintassaPage {
	function content() {
		$recognised_modes = array(
			"catalog_list"			=> array("KintassaCatalogTablePage", __("Kintassa Catalog")),
			"catalog_add"			=> array("KintassaCatalogAddPage", __("Add Catalog")),
			"catalog_edit"			=> array("KintassaCatalogEditPage", __("Edit Catalog")),
			"entry_add"				=> array("KintassaCatalogImageAddPage", __("Add Entry")),
			"entry_edit"			=> array("KintassaCatalogImageEditPage", __("Edit Entry"))
		);

		// determine appropriate mode from web request
		$mode = 'catalog_list';	// default mode
		if (isset($_GET['mode'])) {
			$given_mode = $_GET['mode'];

			if (array_key_exists($given_mode, $recognised_modes)) {
				$mode = $given_mode;
			}
		}

		// determine the correct function handler for the mode, and call it
		$handler_details = $recognised_modes[$mode];
		$page_handler_class = $handler_details[0];
		$page_title = $handler_details[1];

		$page_handler = new $page_handler_class($page_title);
		$page_handler->execute();
	}
}

?>