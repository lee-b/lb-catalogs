<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once('kcat_catalog_entry_form.php');

class KintassaCatalogEntryAddForm extends KintassaCatalogEntryForm {
	function render_success() {
		$page_args = array("mode" => "catalog_entry_edit", "id" => $this->id);
		$edit_uri = KintassaUtils::admin_path('KintassaCatalogMenu', 'mainpage', $page_args);

		echo("<h2>" . __("Entry Added") . "</h2>");
		echo("<p>" . __("Your catalog entry has been added.  Thank you.") . "</p>");

		$this->catalog_return_link();
	}

	function update_record() {
		// create and populate the db record in one step
		global $wpdb;

		$dat = $this->data();
		$fmt = $this->data_format();

		$wpdb->insert(KintassaCatalogEntry::table_name(), $dat, $fmt);
		$this->id = $wpdb->insert_id;

		return true;
	}
}

?>