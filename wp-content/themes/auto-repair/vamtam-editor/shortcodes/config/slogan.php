<?php

/**
 * Slogan shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __( 'Call Out Box', 'auto-repair' ) ,
	'desc' => __( 'You can place the call out box into а column - color box elemnent in order to have background color.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'font-size' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'slogan',
	'controls' => 'size name clone edit delete handle',
	'options' => array(
		array(
			'name' => __( 'Content', 'auto-repair' ) ,
			'id' => 'html-content',
			'default' => __( '<h1>You can place your call out box text here</h1>', 'auto-repair' ),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __( 'Button Text', 'auto-repair' ) ,
			'id' => 'button_text',
			'default' => 'Button Text',
			'type' => 'text'
		) ,
		array(
			'name' => __( 'Button Link', 'auto-repair' ) ,
			'id' => 'link',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __( 'Button Icon', 'auto-repair' ) ,
			'id' => 'button_icon',
			'default' => 'cart',
			'type' => 'icons',
		) ,
		array(
			'name' => __( 'Button Icon Style', 'auto-repair' ),
			'type' => 'select-row',
			'selects' => array(
				'button_icon_color' => array(
					'desc' => __( 'Color:', 'auto-repair' ),
					"default" => "accent 1",
					"prompt" => '',
					"options" => array(
						'accent1' => __( 'Accent 1', 'auto-repair' ),
						'accent2' => __( 'Accent 2', 'auto-repair' ),
						'accent3' => __( 'Accent 3', 'auto-repair' ),
						'accent4' => __( 'Accent 4', 'auto-repair' ),
						'accent5' => __( 'Accent 5', 'auto-repair' ),
						'accent6' => __( 'Accent 6', 'auto-repair' ),
						'accent7' => __( 'Accent 7', 'auto-repair' ),
						'accent8' => __( 'Accent 8', 'auto-repair' ),
					) ,
				),
				'button_icon_placement' => array(
					'desc' => __( 'Placement:', 'auto-repair' ),
					"default" => 'left',
					"options" => array(
						'left' => __( 'Left', 'auto-repair' ),
						'right' => __( 'Right', 'auto-repair' ),
					) ,
				),
				),
		),
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
