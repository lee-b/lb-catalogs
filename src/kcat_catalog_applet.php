<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_applet.php'));
require_once('kcat_config.php');
require_once('kcat_image_finder.php');

$GLOBALS['registered_kintassa_catalog_applets'] = array();

abstract class KintassaCatalogApplet extends KintassaApplet {
	static function register($applet_class, $name, $pretty_name) {
		if (array_key_exists($applet_class, $GLOBALS['registered_kintassa_catalog_applets'])) return;
		$GLOBALS['registered_kintassa_catalog_applets'][$name] = array(
			'class'			=> $applet_class,
			'pretty_name'	=> $pretty_name,
		);
	}

	function __construct($catalog, $image_width, $image_height) {
		parent::__construct();
		$this->image_width = $image_width;
		$this->image_height = $image_height;
		$this->catalog = $catalog;
		$this->finder = new KintassaCatalogEntryImageFinder(KCAT_CACHE_PATH, $image_width, $image_height);
	}

	function template_path($applet_name, $template_name) {
		$template_dir = dirname(dirname(__file__)) . DIRECTORY_SEPARATOR . "templates";
		$fname = basename("applet_" . $applet_name . "__" . $template_name . ".php");
		$template = $template_dir . DIRECTORY_SEPARATOR . $fname;
		return $template;
	}

	static function available_applets() {
		return array_keys($GLOBALS['registered_kintassa_catalog_applets']);
	}

	static function is_valid_applet($applet_name) {
		return array_key_exists($applet_name, $GLOBALS['registered_kintassa_catalog_applets']);
	}

	static function applet_info($applet_name) {
		return $GLOBALS['registered_kintassa_catalog_applets'][$applet_name];
	}

	function unique_id() {
		return "kintassa-catalog-{$this->catalog->id}";
	}

	function classes() {
		return array("kintassa-catalog-app");
	}

	function classes_attrib_str() {
		return "class=\"" . implode(" ", $this->classes()) . "\"";
	}

	function styles() {
		$sty = array();
		return $sty;
	}

	function styles_attrib_str() {
		$style_str = "style=\"";
		$styles = $this->styles();
		foreach($styles as $k => $v) {
			$style_str .= "{$k}: {$v};";
		}
		$style_str .= "\"";
		return $style_str;
	}
}

?>