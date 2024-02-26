 <div class="block block--image <?php echo isset($block['className']) ? $block['className'] : ''; ?> <?php echo get_field('margin_bottom'); ?>" id="<?php echo $block['id']; ?>" data-id="<?php if (isset($block['anchor'])) echo $block['anchor']; ?>">


	<div class="container container--small">


		<?php if (get_field('bild')) { 

				$img = get_field('bild');
		?>

			<figure>

				<img src="<?php echo $img['sizes']['two-thirds']; ?>"
					srcset="<?php echo $img['sizes']['masthead-big']; ?> 1920w,
							<?php echo $img['sizes']['masthead']; ?> 1600w,
							<?php echo $img['sizes']['masthead-md']; ?> 1400w,
							<?php echo $img['sizes']['masthead-small']; ?> 1200w,
							<?php echo $img['sizes']['large']; ?> 1024w,
							<?php echo $img['sizes']['two-thirds']; ?> 960w,
							<?php echo $img['sizes']['md']; ?> 800w" 
					sizes="(min-width:1041px) 960px, 95vw" loading="lazy"
					width="<?php echo $img['width']; ?>" height="<?php echo $img['height']; ?>"
					alt="<?php echo $img['alt']; ?>">

				<?php if (get_field('caption')) { ?>
					<figcaption><?php echo get_field('caption'); ?></figcaption>
				<?php } ?>
			</figure>

		<?php } ?>

	</div>

</div>