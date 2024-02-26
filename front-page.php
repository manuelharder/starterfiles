<?php
/**
 *	
 * @package _advent_s
 */

get_header(); ?>

<div id="content" class="content-area">
	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) : the_post(); ?>

				
			<?php the_content(); ?>
			

		<?php endwhile; ?>

	</main>
</div>

<?php
get_footer();
