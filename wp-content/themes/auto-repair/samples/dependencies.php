<?php

/**
 * Declare plugin dependencies
 *
 * @package wpv
 */

/**
 * Declare plugin dependencies
 */
function wpv_register_required_plugins() {
	$plugins = array(
		array(
			'name' => 'Classic Editor',
			'slug' => 'classic-editor',
			'required' => true,
		),

		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
			'required' => false,
		),

		array(
			'name' => 'WP Retina 2x',
			'slug' => 'wp-retina-2x',
			'required' => false,
		),

		array(
			'name' => 'MailPoet 3',
			'slug' => 'mailpoet',
			'required' => false,
		),

		array(
			'name' => 'WooCommerce',
			'slug' => 'woocommerce',
			'required' => false,
		),

		array(
			'name' => 'Vamtam Push Menu',
			'slug' => 'vamtam-push-menu',
			'source' => WPV_PLUGINS . 'vamtam-push-menu.zip',
			'required' => false,
			'version' => '1.3.0',
		),

		array(
			'name' => 'Vamtam Twitter',
			'slug' => 'vamtam-twitter',
			'source' => WPV_PLUGINS . 'vamtam-twitter.zip',
			'required' => false,
			'version' => '1.0.0',
		),

		array(
			'name' => 'Revolution Slider',
			'slug' => 'revslider',
			'source' => WPV_PLUGINS . 'revslider.zip',
			'required' => false,
			'version' => '5.0.9',
		),

		array(
			'name'     => 'Booked',
			'slug'     => 'booked',
			'source'   => 'https://boxyupdates.com/get/?action=download&slug=booked',
			'required' => false,
			'version'  => '1.7.12',
			'external_url' => 'https://boxyupdates.com/get/?action=download&slug=booked',
		),
	);

	$config = array(
		'default_path' => '',    // Default absolute path to pre-packaged plugins
		'is_automatic' => true,  // Automatically activate plugins after installation or not
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'wpv_register_required_plugins' );

