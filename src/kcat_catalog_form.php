<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_form.php'));
require_once(kintassa_core('kin_utils.php'));
require_once('kcat_config.php');
require_once('kcat_catalog.php');
require_once('kcat_catalog_applet.php');

abstract class KintassaCatalogForm extends KintassaForm {
	function __construct($name, $default_vals) {
		parent::__construct($name);
		$this->add_widgets($default_vals);
	}

	function add_widgets($def) {
		$this->name_field = new KintassaTextField("Name", $name="name", $default_value = $def['name'], $required=true);
		$this->add_child($this->name_field);

		$this->display_mode_field = new KintassaRadioGroup(
			"Display method",
			$name="display_mode",
			$default_value=$def['display_mode']
		);

		$catalog_applets = KintassaCatalogApplet::available_applets();
		foreach ($catalog_applets as $applet_name) {
			$applet_info = KintassaCatalogApplet::applet_info($applet_name);
			$applet_pretty_name = $applet_info['pretty_name'];
			if ($applet_pretty_name != null) {
				$opt_el = new KintassaRadioButton($applet_pretty_name, $name=$applet_name);
				$this->display_mode_field->add_child($opt_el);
			}
		}
		$this->add_child($this->display_mode_field);

		$button_bar = new KintassaFieldBand("button_bar");
		$confirm_button = new KintassaButton("Confirm", $name="confirm", $primary = true);
		$button_bar->add_child($confirm_button);
		$this->add_child($button_bar);
	}

	function data() {
		$dat = array(
			"name"					=> $this->name_field->value(),
			"display_mode"			=> $this->display_mode_field->value(),
		);

		$catalog_applets = KintassaCatalogApplet::available_applets();

		$display_mode_ok = in_array($dat['display_mode'], $catalog_applets);
		if (!$display_mode_ok) {
			$dat['display_mode'] = 'invalid';
		}

		return $dat;
	}

	function data_format() {
		$fmt = array(
			"%s",
			"%s"
		);
		return $fmt;
	}

	/// update the record in the database, based on the form details
	abstract function update_record();

	function is_valid() {
		if (!parent::is_valid()) return false;

		$catalog_applets = KintassaCatalogApplet::available_applets();

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