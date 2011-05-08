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
			"id"			=> null,
			"image_width"	=> "200",
			"image_height"	=> "200",
		);
		$parsed_atts = shortcode_atts(&$known_attribs, $atts);

		$id = $parsed_atts['id'];
		if (!KintassaUtils::isInteger($id)) {
			echo ("(invalid catalog id requested)");
			return;
		}

		$image_width = (int) $parsed_atts['image_width'];
		$image_height = (int) $parsed_atts['image_height'];

		if (!KintassaUtils::isInteger($image_width)) {
			echo ("(invalid image_width requested)");
			return;
		}
		if (!KintassaUtils::isInteger($image_height)) {
			echo ("(invalid image_height requested)");
			return;
		}

		$image_width = (int) $image_width;
		$image_height = (int) $image_height;

		$cat = new KintassaCatalog($id);
		$template_html = $cat->render($image_width, $image_height);

		return $template_html;
	}
}

?>