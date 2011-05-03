<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once('kcat_catalog.php');
require_once('kcat_catalog_entry.php');

global $wpdb;

function kintassa_catalogs_create_tables() {
	global $wpdb;

	$gallery_tbl_name = KintassaCatalog::table_name();

	$gallery_tbl_sql = <<<SQL
		CREATE TABLE {$gallery_tbl_name} (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`name` VARCHAR(128) NULL ,
			`width` INT NULL ,
			`height` INT NULL ,
			`display_mode` VARCHAR(16),
			PRIMARY KEY (`id`)
		)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET = utf8
		COLLATE = utf8_unicode_ci;
SQL;

	$entries_tbl_name = KintassaCatalogEntry::table_name();

	$entries_tbl_sql = <<<SQL
		CREATE  TABLE `{$entries_tbl_name}` (
		  `id` INT NOT NULL AUTO_INCREMENT ,
		  `sort_pri` INT NULL DEFAULT 0 ,
		  `filepath` VARCHAR(4096) NULL ,
		  `name` VARCHAR(255) NULL ,
		  `mimetype` VARCHAR(255) NULL ,
		  `description` VARCHAR(255) NULL ,
		  `catalog_id` INT NOT NULL,
		  PRIMARY KEY (`id`)
		)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET = utf8
		COLLATE = utf8_unicode_ci;
SQL;

	if (!KintassaMicroORMObject::table_exists($gallery_tbl_name)) {
		$wpdb->query($gallery_tbl_sql);
	}

	if (!KintassaMicroORMObject::table_exists($entries_tbl_name)) {
		$wpdb->query($entries_tbl_sql);
	}
}

function kintassa_catalogs_setup_db() {
	$dbver = get_option("kintassa_catalogs_dbver", null);
	if ($dbver == null) {
		kintassa_catalogs_create_tables();
		add_option("kintassa_catalogs_dbver", "1.0");
	} else {
		// already installed, no upgrades needed (as non exist yet)
	}
}

?>