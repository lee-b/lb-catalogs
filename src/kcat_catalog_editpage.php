<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_utils.php'));
require_once('kcat_config.php');
require_once('kcat_catalog_entry.php');
require_once('kcat_catalog_entry_editform.php');
require_once('kcat_catalog_entry_tablepage.php');

class KintassaCatalogEditPage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		$catalog_id = $_GET['id'];
		assert (KintassaUtils::isInteger($catalog_id));

		$this->catalog_id = $catalog_id;

		$this->editForm = new KintassaCatalogEditForm("kcat_edit", $catalog_id);
	}

	function images_subform() {
		$form_name = "kgallery_images";

		$col_map = array(
			"id"			=> null,
			"sort_pri"		=> "Sort Order",
			"filepath"		=> "Image",
			"name"			=> "Name",
			"description"	=> "Description"
		);

		$table_name = KintassaCatalogEntry::table_name();
		$pager = new KintassaCatalogEntryDBResultsPager(
			$table_name, $page_size = 10, $catalog_id=$this->catalog_id
		);

		$row_opts = KintassaCatalogEntryRowOptionsForm::All;
		$row_form_fac = new KintassaCatalogEntryRowOptionsFactory($row_opts);
		$images_table_form = new KintassaCatalogEntryTableForm($form_name, $col_map, $pager, $row_form_fac);
		$images_table_form->execute();
	}

	function add_options() {
		$add_image_args = array("mode" => "catalog_entry_add", "catalog_id" => $this->catalog_id);
		$add_image_link = KintassaUtils::admin_path("KintassaCatalogMenu", "mainpage", $add_image_args);

		$this->add_image_button = new KintassaLinkButton("Add Entry", $name="add_catalog_entry", $uri=$add_image_link);
		$this->add_image_button->render();
	}

	function content() {
		$this->editForm->execute();
		$this->images_subform();
		$this->add_options($this->editForm);
	}
}

?>