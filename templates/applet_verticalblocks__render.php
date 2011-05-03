<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/
?>
<div id="<?php echo $unique_id; ?>" <?php echo $cls . " " . $sty; ?>>
	<?php
		$entries = $catalog->entries();
		$first = true;
		foreach($entries as $ent) {
			if ($first) {
				$cls = " class=\"first-item\"";
				$first = false;
			} else {
				$cls = "";
			}
			?>
			<div <?php echo $cls; ?>>
				<?php $ent->as_html(); ?>
			</div>
	<?php } ?>
</div>
