<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

$_PLUGIN_ROOT = dirname(dirname(__file__));
require_once($_PLUGIN_ROOT . DIRECTORY_SEPARATOR . "src/kcat_catalog_applet.php");

/***
 * Dummy renderer used for error messages when the requested renderer
 * doesn't exist
 */
class KintassaInvalidCatalogApplet extends KintassaCatalogApplet {
	static function register() {
		KintassaCatalogApplet::register('KintassaInvalidCatalogApplet', 'invalid', null);
	}

	function classes() {
		$cls = parent::classes();
		$cls[] = "kintassa-applet-invalid";
		return $cls;
	}

	function render() {
		$applet = $this;

		$catalog = $this->catalog;

		$unique_id = $this->unique_id();

		$cls = $this->classes_attrib_str();
		$sty = $this->styles_attrib_str();

		$not_avail_msg = __("This catalog cannot be displayed. Please check the catalog ID exists, (re)install the necessary CatalogApplets for its display method, or change the display method to one that's currently available.");

		$template = $this->template_path("invalid", "render");
		require($template);
	}
}

KintassaInvalidCatalogApplet::register();

?>
