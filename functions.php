<?php
/**
 * _advent_s functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _advent_s
 */

if ( ! function_exists( '_advent_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _advent_s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _advent_s, use a find and replace
	 * to change '_advent_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_advent_s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', '_advent_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_advent_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
endif;
add_action( 'after_setup_theme', '_advent_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _advent_s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_advent_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_advent_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _advent_s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_advent_s' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', '_advent_s' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_advent_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _advent_s_scripts() {

	if (!is_admin()) {
		 wp_dequeue_style( 'wp-block-library' ); // Wordpress core
	}

	// wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick/slick.min.js', array(), '20151215', true );
	
	wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/styles.css?v='.time() );

	// wp_register_script('modernizr', get_stylesheet_directory_uri() . '/assets/js/modernizr-custom.min.js', array(), '', false );
 //    wp_enqueue_script('modernizr');


    wp_register_script('script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '', true );
    wp_enqueue_script('script');
}
add_action( 'wp_enqueue_scripts', '_advent_s_scripts' );


function emersonthis_custom_menu_page_removing() {
  // remove_menu_page( 'index.php' );                  //Dashboard
  // remove_menu_page( 'jetpack' );                    //Jetpack* 
  //remove_menu_page( 'edit.php' );                   //Posts
  // remove_menu_page( 'upload.php' );                 //Media
  // remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  // remove_menu_page( 'themes.php' );                 //Appearance
  // remove_menu_page( 'plugins.php' );                //Plugins
  // remove_menu_page( 'users.php' );                  //Users
  // remove_menu_page( 'tools.php' );                  //Tools
  // remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', 'emersonthis_custom_menu_page_removing' );


$editor = get_role('editor');
   
$editor->add_cap('edit_theme_options');


function emersonthis_edit_form_after_title() {
    $tip = '<strong>TIP:</strong> To create a single line break use SHIFT+RETURN. By default, RETURN creates a new paragraph.';
    echo '<p style="margin-bottom:0;">'.$tip.'</p>';
}
add_action(
    'edit_form_after_title',
    'emersonthis_edit_form_after_title'
);



function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

add_image_size('masthead2x', 2400);
add_image_size('masthead-big', 1920);
add_image_size('masthead', 1600);
add_image_size('masthead-md', 1400);
add_image_size('masthead-small', 1200);
add_image_size('md', 800);
add_image_size('half', 620);
add_image_size('third', 430);



if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array('page_title' => 'Theme Settings', 'position' => '12.2'));

}
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 


function yoasttobottom() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


//Remove JQuery migrate
function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        
        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}

add_action('wp_default_scripts', 'remove_jquery_migrate');

add_filter( 'automatic_updater_disabled', '__return_true' );

update_option( 'sticky_posts', array() );

include_once('inc/gutenberg.php');


add_filter( 'rest_user_query', '__return_null' );
add_filter( 'rest_prepare_user', '__return_null' );


add_action( 'send_headers', 'send_frame_options_header', 10, 0 );

function tg_enable_strict_transport_security_hsts_header_wordpress() {
    header( 'Strict-Transport-Security: max-age=31536000' );
}
add_action( 'send_headers', 'tg_enable_strict_transport_security_hsts_header_wordpress' );


add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);