<?php
/**
 * Theme options / Styles / Footer
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'Footer', 'auto-repair' ),
	'type' => 'start',
),

array(
	'name' => __( 'Where are these options used?', 'auto-repair' ),
	'desc' => __('The footer is the area below the body down to the bottom of your site. It consist of two main areas - the footer and the sub-footer. You can change the style of these areas using the options below.<br/>
		Please not that the footer map options are located in general settings - footer map tab.', 'auto-repair'),
	'type' => 'info',
),

array(
	'name' => __( 'Backgrounds', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Widget Areas Background', 'auto-repair' ),
	'desc' => __( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'auto-repair' ),
	'id' => 'footer-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size,attachment,position',
),

array(
	'name' => __( 'Sub-footer Background', 'auto-repair' ),
	'desc' => __( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'auto-repair' ),
	'id' => 'subfooter-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size'
),

array(
	'name' => __( 'Typography', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Widget Areas Text', 'auto-repair' ),
	'desc' => __( 'This is the general font used for the footer widgets.', 'auto-repair' ),
	'id' => 'footer-sidebars-font',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __( 'Widget Areas Titles', 'auto-repair' ),
	'desc' => __( 'Please note that this option will override the general headings style set in the General Typography" tab.', 'auto-repair' ),
	'id' => 'footer-sidebars-titles',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __( 'Sub-footer', 'auto-repair' ),
	'desc' => __( 'You can place your text/HTML in the General Settings option page.', 'auto-repair' ),
	'id' => 'sub-footer',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __( 'Links', 'auto-repair' ),
	'type' => 'color-row',
	'inputs' => array(
		'css_footer_link_color' => array(
			'name' => __( 'Normal:', 'auto-repair' ),
		),
		'css_footer_link_visited_color' => array(
			'name' => __( 'Visited:', 'auto-repair' ),
		),
		'css_footer_link_hover_color' => array(
			'name' => __( 'Hover:', 'auto-repair' ),
		),
	),
),

	array(
		'type' => 'end'
	),

);