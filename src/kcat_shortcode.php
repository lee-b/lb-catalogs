<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once('kcat_catalog.php');

class KintassaCatalogShortcode {
	function __construct() {
		add_shortcode('kintassa_catalog', array(&$this, 'render_shortcode'));
	}

	/***
	 * wordpress shortcode handler for kintassa galleries
	 */
	function render_shortcode($atts) {
		$known_attribs = array(
			"id" => null,
		);
		$parsed_atts = shortcode_atts(&$known_attribs, $atts);

		$id = $parsed_atts['id'];

		$cat = new KintassaCatalog($id);
		$rendered_catalog = $cat->render();

		return $rendered_catalog;
	}
}

?>