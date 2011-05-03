<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once('kcat_catalog.php');

/***
 * publically callable function for rendering galleries in templates
 */
function kintassa_catalog($catalog_id) {
	$cat = new KintassaCatalog($catalog_id);
	$rendered_gallery = $cat->render();
}

?>
