<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _advent_s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<link rel="preload" href="/wp-content/themes/_advent_s/assets/fonts/subset-Lora-Bold.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/wp-content/themes/_advent_s/assets/fonts/subset-Poppins-SemiBold.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="/wp-content/themes/_advent_s/assets/fonts/subset-Poppins-Light.woff2" as="font" type="font/woff2" crossorigin>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content', '_advent_s' ); ?></a>

	<header id="masthead" class="site-header js-load" role="banner">
		<div class="container relative">

            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php  echo wp_get_attachment_image_src(get_theme_mod( 'custom_logo' ), "min")[0]; ?>"        alt="<?php bloginfo('name'); ?>" />
                </a>
            </div><!-- .site-branding -->
      
	        <button id="mToggle" type="button" class="site-header__toggle btn--toggle js-navigation-toggle" data-target="#mobile-nav" >
	            <span class="sr-only">Menu</span>
	            <span class="icon-bar"></span>
                <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	        </button>

            <nav class="header-nav hidden--mobile">
	        	<?php wp_nav_menu( array('menu' => 'main nav' ) );  ?>
            </nav>

        </div>
	</header><!-- #masthead -->



	<nav id="mobile-nav" class="site-nav nav-mobile element-hidden" role="navigation">
	    <div class="nav-mobile__inner">
	        <?php wp_nav_menu( array( 'theme_location' => 'menu', 'menu' => 'main nav' ) );  ?>    
	    </div>
	</nav>
