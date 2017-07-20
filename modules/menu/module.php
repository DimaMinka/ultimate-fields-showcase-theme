<?php
use UF3\Container;
use UF3\Field;

add_action( 'uf.init', 'showcase_menu_fields' );
function showcase_menu_fields() {
	Container::create( 'Menu Item' )
		->add_location( 'menu_item', array(
			'levels' => 1
		))
		->add_fields(array(
			Field::create( 'icon', 'menu_icon', __( 'Icon', 'showcase' ) )
				->add_set( 'font-awesome' ),
			Field::create( 'select', 'sub_menu_type', __( 'Sub menu', 'showcase' ) )
				->set_input_type( 'radio' )
				->add_options(array(
					'normal'  => __( 'Display sub-menu items', 'showcase' ),
					'widgets' => __( 'Display widgets', 'showcase' )
				)),
			Field::create( 'sidebar', 'menu_sidebar', __( 'Sidebar', 'showcase' ) )
				->add_dependency( 'sub_menu_type', 'widgets' )
				->make_editable()
		));
}

/**
 * Overwrite the walker for the mega menu.
 *
 * @param mixed[] $args The arguments that will be used for wp_nav_menu() in the header.
 */
add_filter( 'showcase.main_menu_args', 'showcase_menu_walker' );
function showcase_menu_walker( $args ) {
	$locations = get_nav_menu_locations();

	# Check if there is an actual menu in use in the header
	if( isset( $locations[ 'main-menu' ] ) ) {
		require_once( __DIR__ . '/class-showcase-menu-walker.php' );
		$args[ 'walker' ] = new Showcase_Menu_Walker;
	}

	return $args;
}

/**
 * Adds icons to normal menu items.
 *
 * @param string   $title The menu item's title.
 * @param WP_Post  $item  The current menu item.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return string
 */
add_filter( 'nav_menu_item_title', 'showcase_menu_item_title', 10, 4 );
function showcase_menu_item_title( $title, $item, $args, $depth ) {
	if( $depth > 0 ) {
		return $title;
	}

	$icon = get_value( 'menu_icon', $item->ID );
	if( $icon ) {
		$icon  = '<span class ="fa ' . $icon . '"></span>';
		$title = $icon . $title;
	}

	return $title;
}