<?php

/**
 * Theme options / Import / Quick Import
 *
 * @package wpv
 * @subpackage auto-repair
 */

$disabled = $disabled_content = '';

if ( wpv_get_option( 'used-one-click-import' ) ) {
	$disabled_content = 'disabled';
}

$revslider = function_exists( 'is_plugin_active' ) && is_plugin_active( 'revslider/revslider.php' );
$booked    = function_exists( 'is_plugin_active' ) && is_plugin_active( 'booked/booked.php' );

return array(

array(
	'name' => __( 'Quick Import', 'auto-repair' ),
	'type' => 'start',
	'nosave' => true,
),

array(
	'name' => __( 'What is included in the content import?', 'auto-repair' ),
	'desc' => __( 'The sample data for the Contact Form 7 plugin is part of the "content import". If you indend to use this plugin now or at a later time, please make sure that you have installed and enabled it <strong>before</strong> importing the demo content.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __( 'Content Import', 'auto-repair' ),
	'desc' => __( 'You are advised to use this importer only on new WordPress sites, as in doing so you will end up with quite a lot of example posts, pages, slides and portfolio items.', 'auto-repair' ),
	'title' => __( 'Import Dummy Content', 'auto-repair' ),
	'link' => $disabled_content !== 'disabled' ? wp_nonce_url( admin_url( 'admin.php?import=wpv&step=2' ), 'wpv-import' ) : 'javascript:void( 0 )', // xss ok
	'type' => 'button',
	'button_class' => "$disabled_content",
),

array(
	'name' => __( 'Widget Import', 'auto-repair' ),
	'desc' => __( 'Using this importer will overwrite your current sidebar settings', 'auto-repair' ),
	'title' => __( 'Import Widgets', 'auto-repair' ),
	'link' => wp_nonce_url( admin_url( 'admin.php?import=wpv_widgets' ), 'wpv-import' ), // xss ok
	'type' => 'button',
),

array(
	'name' => __( 'Slider Revolution', 'auto-repair' ),
	'title' => __( 'Import Slider Revolution Samples', 'auto-repair' ),
	'link' => $revslider ? wp_nonce_url( 'admin.php?import=wpv_revslider', 'wpv-import-revslider' ) : 'javascript:void( 0 )',
	'type' => 'button',
	'button_class' => $revslider ? '' : 'disabled',
),

array(
	'name'         => esc_html__( 'Booked', 'auto-repair' ),
	'title'        => esc_html__( 'Import Booked Settings', 'auto-repair' ),
	'desc'         => esc_html__( 'Using this importer will overwrite your current Booked settings', 'auto-repair' ),
	'link'         => $booked ? wp_nonce_url( 'admin.php?import=vamtam_booked', 'vamtam-import-booked' ) : 'javascript:void( 0 )',
	'type'         => 'button',
	'button_class' => $booked ? 'vamtam-import-button' : 'disabled',
),

	array(
		'type' => 'end',
	),

);
