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
		$even = false;
		foreach($entries as $ent) {
			$classes = array();
			if ($first) {
				$classes[] = "first-entry";
				$first = false;
			}
			if ($even) {
				$classes[] = "even";
			} else {
				$classes[] = "odd";
			}
			$even = !$even;

			$classes[] = "kintassa-catalog-entry-{$ent->id}";
			$classes[] = "kintassa-catalog-entry";

			$cls = "class=\"" . implode(" ", $classes) . "\"";
			?>
			<div <?php echo $cls; ?>>
				<div class="name"><?php echo $ent->name; ?></div>
				<div class="description"><?php echo $ent->description; ?></div>
				<div class="image">
					<img src="<?php echo $applet->finder->uri_from_id($ent->id); ?>">
				</div>
			</div>
	<?php } ?>
</div>
