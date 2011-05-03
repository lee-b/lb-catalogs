<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_page.php'));
require_once('kcat_config.php');
require_once('kcat_catalog_addform.php');

class KintassaCatalogAddPage extends KintassaPage {
	function content() {
		$addForm = new KintassaCatalogAddForm("KintassaCatalog_add");
		$addForm->execute();
	}
}

?>