 <div class="block block--text <?php echo isset($block['className']) ? $block['className'] : ''; ?> <?php echo get_field('margin_bottom'); ?>" id="<?php echo $block['id']; ?>" data-id="<?php if (isset($block['anchor'])) echo $block['anchor']; ?>">


	<div class="container container--tiny margin-bottom--big">

		<?php if (get_field('headline')) { ?>
			<div class="margin-bottom--med text--center">
				<h3><?php echo get_field('headline'); ?></h3>
			</div>
		<?php } ?>

		<?php echo get_field('text'); ?>

	</div>

</div>