<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_utils.php'));
require_once('kcat_config.php');
require_once('kcat_mainpage.php');
require_once('kcat_catalog_addform.php');
require_once('kcat_catalog_editform.php');
require_once('kcat_catalog.php');
require_once('kcat_catalog_entry.php');
require_once('kcat_about_page.php');

class KintassaCatalogMenu {
	function __construct() {
		$this->menu_title = "Catalogs";
		add_action('admin_menu', array(&$this, 'add_menus'));
	}

	function add_page($label, $perms, $method_name) {
		$page_title = $label;
		$menu_title = $label;
		$capability = $perms;
		$func = array(&$this, $method_name);
		add_menu_page($page_title, $menu_title, $capability, $this->classify_slug($method_name), &$func);
	}

	function classify_slug($slug) {
		$cls = get_class($this);
		$full_slug = $cls . "_" .  $slug;
		return $full_slug;
	}

	function add_subpage($parent, $label, $perms, $method_name) {
		$page_title = $label;
		$menu_title = $label;
		$capability = $perms;
		$func = array(&$this, $method_name);
		add_submenu_page($this->classify_slug($parent), $page_title, $menu_title, $capability, $this->classify_slug($method_name), &$func);
	}

	function add_menus() {
		$mainpage = 'mainpage';
		$this->add_page($this->menu_title, 'administrator', $mainpage);
		$this->add_subpage($mainpage, 'About', 'administrator', 'about');
	}

	function mainpage() {
		$title = null; // mainpage is just a dispatcher, so no title
		$main_page = new KintassaCatalogMainPage($title);
		$main_page->execute();
	}

	function about() {
		$about_page = new KintassaCatalogAboutPage(__("About Kintassa Catalog"));
		$about_page->execute();
	}
}

?>