<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_page.php'));
require_once('kcat_config.php');
require_once('kcat_catalog_tableform.php');

class KintassaCatalogTablePage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		$table_name = "KintassaCatalog_list";

		$col_map = array(
			"id"				=> null,
			"name"				=> "Name",
			"display_mode"		=> "Display Mode"
		);

		$table_name = KintassaCatalog::table_name();
		$pager = new KintassaCatalogDBResultsPager($table_name);

		$row_opts = KintassaCatalogRowOptionsForm::Edit | KintassaCatalogRowOptionsForm::Delete;
		$row_form_fac = new KintassaCatalogRowOptionsFactory($row_opts);
		$this->table_form = new KintassaCatalogTableForm($table_name, $col_map, $pager, $row_form_fac);
	}

	function content() {
		$this->table_form->execute();

		$page_args = array(
			"mode" => "catalog_add",
		);
		$page_uri = KintassaUtils::admin_path("KintassaCatalogMenu", "mainpage", $page_args);

		echo("<a href=\"{$page_uri}\" class=\"button\">Add Catalog</a>");
	}
}

?>