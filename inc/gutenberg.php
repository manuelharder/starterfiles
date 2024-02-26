<?php


add_filter( 'allowed_block_types_all', 'gutenberg_allowed_block_types', 10, 2 );
function gutenberg_allowed_block_types( $allowed_blocks, $post ) {


    return array(
        'core/image',
        'core/paragraph',
        'core/heading',
        //'core/list',
        //'core/table',
        'core/html',
        'acf/text',
        
    );
}

add_action('acf/init', 'my_acf_init');
function my_acf_init() {

    remove_theme_support( 'core-block-patterns' );
    
    // check function exists
    if( function_exists('acf_register_block') ) {
        
    

         acf_register_block(array(
            'name'              => 'text',
            'title'             => __('Text'),
            'description'       => __('Text'),
            'render_callback'   => 'my_acf_block_render_callback',
            'category'          => 'formatting',
            'mode' => 'edit',
            'icon'              => '',
            'keywords'          => array( 'text' ),
        ));


  
    }
}



function my_acf_block_render_callback( $block ) {

    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);
    if( file_exists( get_theme_file_path("template-parts/blocks/{$slug}.php") ) ) {
        include( get_theme_file_path("template-parts/blocks/{$slug}.php") );
    }
}


add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style() {
    wp_enqueue_style('admin_css', get_stylesheet_directory_uri() .'/assets/css/admin.css' );
}

function plugin_mce_css( $mce_css ) {
  if ( !empty( $mce_css ) )
    $mce_css .= ',';
    $mce_css .= get_stylesheet_directory_uri() .'/assets/css/editor.css?v=';
    return $mce_css;
  }
add_filter( 'mce_css', 'plugin_mce_css' );

function add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );

//add custom styles to the WordPress editor
function my_custom_styles( $init_array ) {  
 
    $style_formats = array(  
        // These are the custom styles

        array(  
            'title' => 'Button',  
            'block' => 'a',  
            'classes' => 'btn',
            'wrapper' => false,
        ),

        array(  
            'title' => 'Margin Bottom',  
            'inline' => 'span',
            'classes' => 'margin-bottom',
        ),


    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );


                        


function themeprefix_wrap_alignment( $block_content, $block ) {

    if ($block['blockName'] == 'core/heading') {
        $block_content = sprintf(
            '<div class="container">%1$s</div>',
            $block_content
        );
    }

    if ($block['blockName'] == 'core/paragraph') {
        $block_content = sprintf(
            '<div class="container">%1$s</div>',
            $block_content
        );
    }

    if ($block['blockName'] == 'core/image') {
        $block_content = sprintf(
            '<div class="container">%1$s</div>',
            $block_content
        );
    }

    return $block_content;
}
add_filter( 'render_block', 'themeprefix_wrap_alignment', 10, 2 );

