<?php
/**
 * Theme options / Styles / Body
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'Body', 'auto-repair' ),
	'type' => 'start',
),

array(
	'name' => __( 'Where are these options used?', 'auto-repair' ),
	'desc' => __( 'The page body is the area between the header and the footer. The page title, the body top widget areas and the sidebars are located here. You can change the style of these areas using the options below.', 'auto-repair' ),
	'type' => 'info',
),

array(
	'name' => __( 'Backgrounds', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Body Background', 'auto-repair' ),
	'desc' => __( 'If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'auto-repair' ),
	'id' => 'main-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size,attachment'
),

array(
	'name' => __( 'Typography', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Body Font', 'auto-repair' ),
	'desc' => __( 'This is the general font used in the body and the sidebars. Please note that the styles of the heading fonts are located in the general typography tab.', 'auto-repair' ),
	'id' => 'primary-font',
	'type' => 'font',
	'min' => 1,
	'max' => 20,
	'lmin' => 1,
	'lmax' => 40,
),

array(
	'name' => __( 'Links', 'auto-repair' ),
	'type' => 'color-row',
	'inputs' => array(
		'css_link_color' => array(
			'name' => __( 'Normal:', 'auto-repair' ),
		),
		'css_link_visited_color' => array(
			'name' => __( 'Visited:', 'auto-repair' ),
		),
		'css_link_hover_color' => array(
			'name' => __( 'Hover:', 'auto-repair' ),
		),
	),
),

	array(
		'type' => 'end'
	),

);