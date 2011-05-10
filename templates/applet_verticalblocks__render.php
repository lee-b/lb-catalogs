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

	?>

	<img class="applet-verticalblocks-divider" src="<?php echo $divider_uri; ?>">

	<?php
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
			<div class="image">
				<?php
					$image_uri = $applet->finder->uri_from_id($ent->id);

				if ($ent->link) {
					?><a href="<?php echo $ent->link; ?>"><?php
				}
				?><img src="<?php echo $image_uri; ?>"><?php
				if ($ent->link) {
					?></a><?php
				}
				?>
			</div>
			<div class="details">
				<div class="name">
					<?php if ($ent->link) { ?>
						<a href="<?php echo $ent->link; ?>">
					<?php }

					echo $ent->name;

					if ($ent->link) { ?>
						</a>
					<?php } ?>
				</div>
				<div class="description"><?php echo $ent->description; ?></div>
			</div>
		</div>

		<img class="applet-verticalblocks-divider" src="<?php echo $divider_uri; ?>">
	<?php } ?>
</div>
