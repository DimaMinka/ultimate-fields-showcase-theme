<?php
use UF3\Options_Page;

// Register theme supports
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
register_nav_menu( 'main-menu', __( 'Main Menu', 'showcase' ) );

/**
 * Add a page for theme options and module control.
 */
add_action( 'uf.init', 'showcase_options_page' );
function showcase_options_page() {
	$page = Options_Page::create( 'theme-options', __( 'Theme Options', 'showcase' ) )
		->set_type( 'appearance' );

	Module_Loader::get_instance()->register_options_container( $page );
}

/**
 * Initialize sidebars.
 */
add_action( 'widgets_init', 'showcase_sidebars' );
function showcase_sidebars() {
	register_sidebar(array(
		'id'            => 'default-sidebar',
		'name'          => __( 'Default sidebar', 'showcase' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
}

/**
 * Enqueue scripts and styles for enabled modules.
 */
add_action( 'wp_enqueue_scripts', 'showcase_scripts_styles' );
function showcase_scripts_styles() {
	wp_enqueue_style( 'lato-font', 'https://fonts.googleapis.com/css?family=Lato:300,400,700' );
	wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'showcase', get_stylesheet_uri() );
}