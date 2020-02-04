<?php

/**
 * Contact info shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __( 'Contact Info', 'auto-repair' ) ,
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'vcard' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'contact_info',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __( 'Name', 'auto-repair' ),
			'id' => 'name',
			'default' => 'Nick Perry',
			'size' => 30,
			'type' => 'text'
		),
		array(
			'name' => __( 'Color', 'auto-repair' ),
			'id' => 'color',
			'default' => 'accent2',
			'prompt' => __( '---', 'auto-repair' ),
			'options' => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),

			),
			'type' => 'select',
		),
		array(
			'name' => __( 'Phone', 'auto-repair' ),
			'id' => 'phone',
			'default' => '+23898933i',
			'size' => 30,
			'type' => 'text'
		),
		array(
			'name' => __( 'Cell Phone', 'auto-repair' ),
			'id' => 'cellphone',
			'default' => '+23898933i',
			'size' => 30,
			'type' => 'text'
		),
		array(
			'name' => __( 'Email', 'auto-repair' ),
			'id' => 'email',
			'default' => 'office@test.com',
			'type' => 'text'
		),
		array(
			'name' => __( 'Address', 'auto-repair' ),
			'id' => 'address',
			'default' => 'London',
			'size' => 30,
			'type' => 'textarea'
		),


		array(
			'name' => __( 'Title (optional)', 'auto-repair' ) ,
			'desc' => __( 'The column title is placed just above the element.', 'auto-repair' ),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __( 'Title Type (optional)', 'auto-repair' ) ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __( 'Title with divider next to it', 'auto-repair' ),
				'double' => __( 'Title with divider below', 'auto-repair' ),
				'no-divider' => __( 'No Divider', 'auto-repair' ),
			),
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
