<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_image_filter.php'));
require_once('kcat_config.php');
require_once('kcat_catalog_entry.php');
require_once('kcat_catalog.php');

class KintassaCatalogEntryImageFinder extends KintassaMappedImageFinder {
	function uri_from_id($id) {
		return WP_PLUGIN_URL . "/" . basename(dirname(dirname(__file__))) . "/content/image.php?id={$id}";
	}

	function image_path_from_id($id) {
		$ent = new KintassaCatalogEntry($id);

		if($ent->is_dirty()) {
			echo("Couldn't load entry (id: $id)");
			return null;
		}

		$orig_path = $ent->file_path();
		$args = array();

		$catalog_id = $ent->catalog_id();
		$cat = new KintassaCatalog($catalog_id);
		if ($cat->is_dirty()) {
			echo("Couldn't load catalog (id: $catalog_id).");
			return null;
		}

		$orig_img = new KintassaResizeableImage($orig_path);
		$filtered_path = $orig_img->filtered_path($this->cache_root, $args);
		$res = $orig_img->ensure_cached($filtered_path, $args);
		if (!$res) {
			return null;
		}

		return $filtered_path;
	}
}

class KintassaCatalogThumbnailFinder extends KintassaImageFinder {
	function __construct($width, $height) {
		parent::__construct(KCAT_CACHE_PATH);
		$this->width = $width;
		$this->height = $height;
	}

	function uri_from_fname($fname) {
		$encoded_path = escapeuri($fname);
		return WP_PLUGIN_URL . "/" . basename(dirname(dirname(__file__))) . "/content/thumb.php?width={$this->width}&height={$this->height}&fname={$encoded_fname}";
	}

	function resized_path_to($full_path) {
		if (!file_exists($full_path)) {
			return null;
		}
		$resizeable_image = new KintassaResizeableImage($full_path);
		$args = array(
			"width"	=>	$this->width,
			"height"=>	$this->height,
		);
		$output_fname = $resizeable_image->filtered_path($this->cache_root, $args);
		$ok = $resizeable_image->ensure_cached($output_fname, $args);
		if (!$ok) {
			return null;
		}
		return $output_fname;
	}
}

?>