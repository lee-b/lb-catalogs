<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_form.php'));
require_once('kcat_config.php');
require_once('kcat_catalog.php');

abstract class KintassaCatalogEntryForm extends KintassaForm {
	function __construct($name, $default_vals) {
		parent::__construct($name);
		$this->add_widgets($default_vals);
	}

	function add_widgets($def) {
		$this->sort_pri_field = new KintassaIntegerField(
			"Sort Priority", $name="sort_pri",
			$default_value=$def['sort_pri'], $required=true
		);
		$this->add_child($this->sort_pri_field);

		$this->name_band = new KintassaFieldBand("nameband");
		$this->name_field = new KintassaTextField(
			"Name", $name="name",
			$default_value = $def['name'], $required=true
		);
		$this->name_band->add_child($this->name_field);
		$this->add_child($this->name_band);

		$this->image_band = new KintassaFieldBand("imageband");
		$this->image_field = new KintassaImageUploadField(
			"Image", $name="filepath",
			$default_value = $def['filepath'], $required=true, $upload_path = KCAT_UPLOAD_PATH
		);
		$this->image_band->add_child($this->image_field);
		$this->add_child($this->image_band);

		$this->catalog_id_field = new KintassaHiddenField(
			"Catalog ID", $name="catalog_id",
			$default_value = $def['catalog_id'], $required=true
		);

		$this->desc_band = new KintassaFieldBand("descriptionband");
		$this->description_field = new KintassaTextAreaField(
			"Description", $name="description",
			$default_value = $def['description'], $required = false
		);
		$this->desc_band->add_child($this->description_field);
		$this->add_child($this->desc_band);

		$this->link_band = new KintassaFieldBand("linkband");
		$this->link_field = new KintassaLinkField(
			"Link", $name="link",
			$default_value = $def['link'], $required = false
		);
		$this->link_band->add_child($this->link_field);
		$this->add_child($this->link_band);

		$button_bar = new KintassaFieldBand("button_bar");
		$confirm_button = new KintassaButton(
			"Confirm", $name="confirm", $primary = true
		);
		$button_bar->add_child($confirm_button);
		$this->add_child($button_bar);
	}

	function catalog_return_link() {
		$edit_args = array("mode" => "catalog_edit", "id" => $this->catalog_id_field->value());
		$edit_uri = KintassaUtils::admin_path("KintassaCatalogMenu", "mainpage", $edit_args);
		echo ("<a href=\"$edit_uri\">" . __("Return to catalog") . "</a>");
	}

	function data() {
		$dat = array(
			"sort_pri"				=> $this->sort_pri_field->value(),
			"filepath"				=> $this->image_field->value(),
			"name"					=> $this->name_field->value(),
			"catalog_id"			=> $this->catalog_id_field->value(),
			"description"			=> $this->description_field->value(),
			"link"					=> $this->link_field->value(),
		);

		return $dat;
	}

	function data_format() {
		$fmt = array(
			"%s",
			"%s",
			"%s",
			"%d",
			"%s",
			"%s"
		);
		return $fmt;
	}

	/// update the record in the database, based on the form details
	abstract function update_record();

	function render($as_sub_el = false) {
		parent::render($as_sub_el);

		$this->catalog_return_link();
	}

	function is_valid() {
		if (!parent::is_valid()) return false;
		return $this->buttons_submitted(array('confirm')) != null;
	}

	function handle_submissions() {
		$res = $this->update_record();
		if ($res) {
			$this->render_success();
		}

		return $res;
	}
}

?>