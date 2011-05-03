<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_utils.php'));
require_once('kcat_config.php');
require_once('kcat_catalog_entry_form.php');
require_once('kcat_catalog_entry.php');

class KintassaCatalogEntryEditForm extends KintassaCatalogEntryForm {
	function __construct($name, $cat_entry_id) {
		$this->id = $cat_entry_id;
		$img = new KintassaCatalogEntry($cat_entry_id);

		$default_vals = array(
			"name"				=> $img->name,
			"sort_pri"			=> $img->sort_pri,
			"filepath"			=> $img->filepath,
			"description"		=> $img->description,
			"mimetype"			=> $img->mimetype,
			"catalog_id"		=> $img->catalog_id,
		);
		parent::__construct($name, $default_vals);

		$this->id_field = new KintassaHiddenField('id', $name='id', $default_val = $cat_entry_id);
		$this->add_child($this->id_field);
	}

	function render_success() {
		echo("<p>" . __("Your catalog entry changes have been saved.  Thank you.") . "</p>");

		$this->gallery_return_link();
	}

	function update_record() {
		global $wpdb;

		$dat = $this->data();
		$fmt = $this->data_format();

		$where_dat = array("id"	=> $this->id);
		$where_fmt = array("%d");

		$res = $wpdb->update(KintassaCatalogEntry::table_name(), $dat, $where_dat, $fmt, $where_fmt);
		if (!$res) return false;

		return true;
	}
}

?>