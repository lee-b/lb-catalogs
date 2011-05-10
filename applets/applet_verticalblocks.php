<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_micro_orm.php'));
require_once(kin_cat_inc('kcat_catalog_entry.php'));
require_once(kin_cat_inc('kcat_catalog_applet.php'));

/***
 * Gallery display applet using jQuery + Gallerific
 */
class KintassaVerticalBlocksApplet extends KintassaCatalogApplet {
	static function register() {
		KintassaCatalogApplet::register('KintassaVerticalBlocksApplet', 'verticalblocks', "Vertical blocks");
	}

	function classes() {
		$cls = parent::classes();
		$cls[] = "kintassa-applet-verticalblocks";
		return $cls;
	}

	function styles_attrib_str() {
		return "";
	}

	function render() {
		$applet = $this;

		$catalog = $this->catalog;
		$unique_id = $this->unique_id();
		$cls = $this->classes_attrib_str();
		$sty = $this->styles_attrib_str();
		$plugin_name = basename(dirname(dirname(__file__)));
		$divider_uri = plugins_url($plugin_name . "/static/divider.jpg", $plugin_name);

		$template = $this->template_path("verticalblocks", "render");

		ob_start();
		require($template);
		$template_html = ob_get_contents();
		ob_end_clean();

		return $template_html;
	}
}

KintassaVerticalBlocksApplet::register();

?>