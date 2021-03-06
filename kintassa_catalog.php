<?php
/*
Plugin Name: Kintassa Catalog
Plugin URI: http://www.kintassa.com/projects/kintassa_catalog/
Description: A catalog page editing and presentation plugin
Version: 1.0
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa for licensing.
*/

if (!function_exists('kintassa_core')) {
	require_once ( WP_PLUGIN_DIR . '/Kintassa_Core/kintassa_core.php' );
}

function kin_cat_inc($subpath) {
	$full_subpath = "src/" . $subpath;
	if (DIRECTORY_SEPARATOR == "/") {
		$real_subpath = $full_subpath;
	} else {
		$real_subpath = str_replace("/", DIRECTORY_SEPARATOR, $full_subpath);
	}
	return dirname(__file__) . DIRECTORY_SEPARATOR . $real_subpath;
}

require_once(kintassa_core('kin_wp_plugin.php'));
require_once(kin_cat_inc('kcat_config.php'));
require_once(kin_cat_inc('kcat_db.php'));
require_once(kin_cat_inc('kcat_menu.php'));
require_once(kin_cat_inc('kcat_shortcode.php'));
require_once(kin_cat_inc('kcat_db.php'));
require_once(kin_cat_inc('kcat_tags.php'));

class KintassaCatalogPlugin extends KintassaWPPlugin {
	function __construct() {
		parent::__construct(__file__);

		$kintassa_catalogs_menu = new KintassaCatalogMenu();
		$kintassa_catalogs_shortcode = new KintassaCatalogShortcode();

		add_action('init', array($this, 'install_scripts'));

		$write_dirs = array(KCAT_UPLOAD_PATH, KCAT_CACHE_PATH);
		foreach ($write_dirs as $wd) {
			if (!file_exists($wd)) {
				exit("ERROR: '$wd' does not exist!");
			}

			if (!is_writeable($wd)) {
				exit("ERROR: '$wd' is not writeable!");
			}
		}
	}

	function install_scripts() {
        $myStyleUrl = plugins_url('/stylesheets/kintassa_catalogs.css', __file__);
	    wp_register_style('kintassa_catalogs', $myStyleUrl);

		wp_enqueue_script("jquery");
        wp_enqueue_style('kintassa_catalogs');
	}

	function install() {
		kintassa_catalogs_setup_db();
	}

	function remove() {
	}
}

// instanciate the plugin
$kCatalogPlugin = new KintassaCatalogPlugin();
$kCatalogPlugin->install();

?>