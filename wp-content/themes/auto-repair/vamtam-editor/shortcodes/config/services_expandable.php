<?php

/**
 * Expandable services shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __( 'Expandable Box ', 'auto-repair' ) ,
	'desc' => __( 'You have open and closed states of the box and you can set diffrenet content and background of each state.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'expand1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services_expandable',
	'controls' => 'size name clone edit delete',
	'callbacks' => array(
		'init' => 'init-expandable-services',
		'generated-shortcode' => 'generate-expandable-services',
	),
	'options' => array(
		array(
			'name' => __( 'Closed Background', 'auto-repair' ) ,
			'type' => 'background',
			'id'   => 'background',
			'only' => 'color,image,repeat,size',
			'sep'  => '_',
		) ,

		array(
			'name'    => __( 'Expanded Background', 'auto-repair' ) ,
			'type'    => 'color',
			'id'      => 'hover_background',
			'default' => 'accent1',
		) ,

		array(
			'name'    => __( 'Closed state image', 'auto-repair' ) ,
			'id'      => 'image',
			'default' => '',
			'type'    => 'upload'
		) ,

		array(
			'name'    => __( 'Closed state icon', 'auto-repair' ) ,
			'desc'    => __( 'The icon will not be visable if you have an image in the option above.', 'auto-repair' ),
			'id'      => 'icon',
			'default' => '',
			'type'    => 'icons',
		) ,
		array(
			"name"    => __( "Icon Color", 'auto-repair' ) ,
			"id"      => "icon_color",
			"default" => 'accent6',
			"type"    => "color",
		) ,
		array(
			'name'    => __( 'Icon Size', 'auto-repair' ),
			'id'      => 'icon_size',
			'type'    => 'range',
			'default' => 62,
			'min'     => 8,
			'max'     => 100,
		),

		array(
			'name'    => __( 'Title', 'auto-repair' ) ,
			'type'    => 'text',
			'id'      => 'title',
			'default' => '',
		) ,

		array(
			'name'    => __( 'Closed state text', 'auto-repair' ) ,
			'id'      => 'closed',
			'default' => __( 'Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'auto-repair' ),
			'type'    => 'textarea',
			'class'   => 'noattr',
		) ,

		array(
			'name'    => __( 'Expanded state', 'auto-repair' ) ,
			'id'      => 'html-content',
			'default' => '[split]',
			'type'    => 'editor',
			'holder'  => 'textarea',
		) ,

		array(
			'name'    => __( 'Element Animation (optional)', 'auto-repair' ) ,
			'id'      => 'column_animation',
			'default' => 'none',
			'type'    => 'select',
			'options' => array(
				'none'        => __( 'No animation', 'auto-repair' ),
				'from-left'   => __( 'Appear from left', 'auto-repair' ),
				'from-right'  => __( 'Appear from right', 'auto-repair' ),
				'from-top'    => __( 'Appear from top', 'auto-repair' ),
				'from-bottom' => __( 'Appear from bottom', 'auto-repair' ),
				'fade-in'     => __( 'Fade in', 'auto-repair' ),
				'zoom-in'     => __( 'Zoom in', 'auto-repair' ),
			),
		) ,
	) ,
);
