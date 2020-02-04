<?php

/**
 * Theme functions. Initializes the Vamtam Framework.
 *
 * @package  wpv
 */

require_once( 'vamtam/classes/framework.php' );

new WpvFramework( array(
	'name' => 'auto-repair',
	'slug' => 'auto-repair',
) );

// TODO remove next line when the editor is fully functional, to be packaged as a standalone module with no dependencies to the theme
define( 'VAMTAM_EDITOR_IN_THEME', true ); include_once THEME_DIR . 'vamtam-editor/editor.php';

// only for one page home demos
function wpv_onepage_menu_hrefs( $atts, $item, $args ) {
	if ( 'custom' === $item->type && 0 === strpos( $atts['href'], '/#' ) ) {
		$atts['href'] = $GLOBALS['wpv_inner_path'] . $atts['href'];
	}
	return $atts;
}

if ( ( $path = parse_url( get_home_url(), PHP_URL_PATH ) ) !== null ) {
	$GLOBALS['wpv_inner_path'] = untrailingslashit( $path );
	add_filter( 'nav_menu_link_attributes', 'wpv_onepage_menu_hrefs', 10, 3 );
}

remove_action( 'admin_head', 'jordy_meow_flattr', 1 );

if ( get_transient( '_booked_welcome_screen_activation_redirect' ) ) {
	delete_transient( '_booked_welcome_screen_activation_redirect' );
}

// Envato Hosted compatibility
add_filter( 'option_wpv_envato-license-key', 'vamtam_envato_hosted_license_key' );
function vamtam_envato_hosted_license_key( $value ) {
	if ( defined( 'SUBSCRIPTION_CODE' ) ) {
		return SUBSCRIPTION_CODE;
	}

	return $value;
}

// Renames a meta field
function vamtam_migrate_description_field_name() {
	if ( ! get_option( 'vamtam_description_field_renamed', false ) ) {
		$posts = get_posts( [
			'posts_per_page' => -1,
			'post_type' => WpvFramework::$complex_layout,
			'meta_query' => [
				[
					'key' => 'description',
					'compare' => 'EXIST'
				]
			]
		] );

		foreach ( $posts as $post ) {
			update_post_meta( $post->ID, '_vamtam_description', get_post_meta( $post->ID, 'description', true ) );
			delete_post_meta( $post->ID, 'description' );
		}

		$posts = get_posts( [
			'posts_per_page' => -1,
			'post_type' => 'nav_menu_item',
			'meta_query' => [
				[
					'key' => 'description',
					'compare' => 'EXIST'
				]
			]
		] );

		foreach ( $posts as $post ) {
			delete_post_meta( $post->ID, 'description' );
		}

		update_option( 'vamtam_description_field_renamed', true );
	}
}

add_action( 'shutdown', 'vamtam_migrate_description_field_name' );

