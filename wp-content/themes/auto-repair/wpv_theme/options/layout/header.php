<?php

/**
 * Theme options / Layout / Header
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(
array(
	'name' => __( 'Header', 'auto-repair' ),
	'type' => 'start',
),

array(
	'name' => __( 'Header Layout', 'auto-repair' ),
	'desc' => __( 'Please note that the theme uses Revolution Slider and its option panel is found in the WordPress navigation menu on the left', 'auto-repair' ),
	'type' => 'info',
),

array(
	'name'        => __( 'Header Layout', 'auto-repair' ),
	'type'        => 'autofill',
	'class'       => 'no-box ' . ( wpv_get_option( 'header-logo-type' ) === 'names' ? 'hidden' : ''), // xss ok
	'option_sets' => array(
		array(
			'name'   => __( 'One row, left logo, menu on the right', 'auto-repair' ),
			'image'  => WPV_ADMIN_ASSETS_URI . 'images/header-layout-1.png',
			'values' => array(
				'header-layout' => 'logo-menu',
			),
		),
		array(
			'name'   => __( 'Two rows; left-aligned logo on top, right-aligned text and search', 'auto-repair' ),
			'image'  => WPV_ADMIN_ASSETS_URI . 'images/header-layout-2.png',
			'values' => array(
				'header-layout' => 'logo-text-menu',
			),
		),
		array(
			'name'   => __( 'Two rows; centered logo on top', 'auto-repair' ),
			'image'  => WPV_ADMIN_ASSETS_URI . 'images/header-layout-3.png',
			'values' => array(
				'header-layout' => 'standard',
			),
		),
	),
),


array(
	'name' => __( 'Header Height', 'auto-repair' ),
	'desc' => __( 'This is the area above the slider.', 'auto-repair' ),
	'id'   => 'header-height',
	'type' => 'range',
	'min'  => 30,
	'max'  => 300,
	'unit' => 'px',
),
array(
	'name' => __( 'Sticky Header', 'auto-repair' ),
	'desc' => __( 'This option is switched off automatically for mobile devices because the animation is not well supported by the majority of the mobile devices.', 'auto-repair' ),
	'id'   => 'sticky-header',
	'type' => 'toggle',
),


array(
	'name' => __( 'Enable Header Search', 'auto-repair' ),
	'id'   => 'enable-header-search',
	'type' => 'toggle',
),

array(
	'name'  => __( 'Full Width Header', 'auto-repair' ),
	'id'    => 'full-width-header',
	'type'  => 'toggle',
	'class' => 'fhl fhl-logo-menu',
),

array(
	'name'    => __( 'Top Bar Layout', 'auto-repair' ),
	'id'      => 'top-bar-layout',
	'type'    => 'select',
	'options' => array(
		''            => __( 'Disabled', 'auto-repair' ),
		'menu-social' => __( 'Left: Menu, Right: Social Icons', 'auto-repair' ),
		'social-menu' => __( 'Left: Social Icons, Right: Menu', 'auto-repair' ),
		'text-menu'   => __( 'Left: Text, Right: Menu', 'auto-repair' ),
		'menu-text'   => __( 'Left: Menu, Right: Text', 'auto-repair' ),
		'social-text' => __( 'Left: Social Icons, Right: Text', 'auto-repair' ),
		'text-social' => __( 'Left: Text, Right: Social Icons', 'auto-repair' ),
		'fulltext'    => __( 'Text only', 'auto-repair' ),
	),
	'field_filter' => 'ftbl',
),

array(
	'name'  => __( 'Top Bar Text', 'auto-repair' ),
	'desc'  => __( 'You can place plain text, HTML and shortcodes.', 'auto-repair' ),
	'id'    => 'top-bar-text',
	'type'  => 'textarea',
	'class' => 'ftbl ftbl-menu-text ftbl-text-menu ftbl-social-text ftbl-text-social ftbl-fulltext',
),

array(
	'name'  => __( 'Top Bar Social Text Lead', 'auto-repair' ),
	'id'    => 'top-bar-social-lead',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Facebook Link', 'auto-repair' ),
	'id'    => 'top-bar-social-fb',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Twitter Link', 'auto-repair' ),
	'id'    => 'top-bar-social-twitter',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar LinkedIn Link', 'auto-repair' ),
	'id'    => 'top-bar-social-linkedin',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Google+ Link', 'auto-repair' ),
	'id'    => 'top-bar-social-gplus',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Flickr Link', 'auto-repair' ),
	'id'    => 'top-bar-social-flickr',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Pinterest Link', 'auto-repair' ),
	'id'    => 'top-bar-social-pinterest',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Dribbble Link', 'auto-repair' ),
	'id'    => 'top-bar-social-dribbble',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Instagram Link', 'auto-repair' ),
	'id'    => 'top-bar-social-instagram',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar YouTube Link', 'auto-repair' ),
	'id'    => 'top-bar-social-youtube',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'  => __( 'Top Bar Vimeo Link', 'auto-repair' ),
	'id'    => 'top-bar-social-vimeo',
	'type'  => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name'    => __( 'Header Layout', 'auto-repair' ), // dummy option, do not remove
	'id'      => 'header-layout',
	'type'    => 'select',
	'class'   => 'hidden',
	'options' => array(
		'standard'       => __( 'Two rows; centered logo on top', 'auto-repair' ),
		'logo-menu'      => __( 'One row, left logo, menu on the right', 'auto-repair' ),
		'logo-text-menu' => __( 'Two rows; left-aligned logo on top, right-aligned text and search', 'auto-repair' ),
	),
	'field_filter' => 'fhl',
),

array(
	'name'   => __( 'Header Text Area', 'auto-repair' ),
	'desc'   => __( 'You can place text/HTML or any shortcode in this field. The text will appear in the header on the left hand side.', 'auto-repair' ),
	'id'     => 'phone-num-top',
	'type'   => 'textarea',
	'static' => true,
),

array(
	'name' => __( 'Mobile Header', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name'   => __( 'Enable Below', 'auto-repair' ),
	'id'     => 'mobile-top-bar-resolution',
	'type'   => 'range',
	'min'    => 320,
	'max'    => 4000,
	'static' => true,
),

array(
	'name'   => __( 'Enable Search in Logo Bar', 'auto-repair' ),
	'id'     => 'mobile-search-in-header',
	'type'   => 'toggle',
	'static' => true,
),

array(
	'name'   => __( 'Mobile Top Bar', 'auto-repair' ),
	'id'     => 'mobile-top-bar',
	'type'   => 'textarea',
	'static' => true,
),

	array(
		'type' => 'end'
	),

);