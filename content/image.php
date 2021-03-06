<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to use this product.
*/

// initialise wordpress //////////////////////////////////////////////////////

error_reporting(E_ALL);

function find_parent_file($fn) {
	$current_dir = dirname(__file__);

	while (realpath($current_dir) != "/") {
		$current_dir = $current_dir . "/..";
		$fn_path = $current_dir . "/" . $fn;
		if (file_exists($fn_path)) {
			return realpath($fn_path);
		}
	}

	return null;
}

$wp_load = find_parent_file("wp-load.php");
if(!$wp_load) {
	exit("Couldn't locate wordpress!");
}
require_once($wp_load);

// real code starts here /////////////////////////////////////////////////////

require_once(kin_cat_inc('kcat_config.php'));
require_once(kintassa_core('kin_utils.php'));
require_once(kin_cat_inc('kcat_image_finder.php'));
require_once(kin_cat_inc('kcat_catalog_entry.php'));
require_once(kin_cat_inc('kcat_catalog.php'));

function send_catalog_entry_image_by_id($id, $w, $h) {
	assert(KintassaUtils::isInteger($w));
	assert(KintassaUtils::isInteger($h));
	if($w <= 0) { exit("Invalid width: $w"); }
	if($h <= 0) { exit("Invalid width: $h"); }

	// load basic image details from db
	$ent = new KintassaCatalogEntry($id);
	if ($ent->is_dirty()) {
		exit("ERROR: Couldn't load catalog entry: $id");
	}
	$ctype = $ent->mime_type();

	// find/generate a version of the image that's scaled correctly for this
	// gallery
	$finder = new KintassaCatalogEntryImageFinder(KCAT_CACHE_PATH, $w, $h);
	$path = $finder->image_path_from_id($id);
	if (!$path) {
		exit("ERROR: Couldn't locate image file for image id $id");
	}

	// render results
	header("Content-type: {$ctype}");
	readfile($path);
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$width = $_GET['width'];
	$height = $_GET['height'];
	if (!KintassaUtils::isInteger($id)) {
		exit("Error: invalid image ID requested");
	}
	if ( !KintassaUtils::isInteger($width) ) {
		exit("Error: invalid image width requested -- not an integer");
	}
	if ( ($width <= 0) || ($width > 2048) ) {
		exit("Error: invalid image width requested -- bad dimensions");
	}
	if ( !KintassaUtils::isInteger($height) ) {
		exit("Error: invalid image height requested -- not an integer");
	}
	if ( ($height <= 0) || ($height > 2048) ) {
		exit("Error: invalid image height requested -- bad dimensions");
	}

	send_catalog_entry_image_by_id($id, $width, $height);
} else {
	header("HTTP/1.0 404 Not found");
	header("Status: 404 Not found");
	echo("<html><head><title>Not found</title><body>The requested image doesn't exist (any longer?)</body></html>");
	echo("The requested image doesn't exist (any longer?)");
}

?>