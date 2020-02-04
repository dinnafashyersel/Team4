<?php
return array(
	'name' => __( 'Contact Form 7', 'auto-repair' ) ,
	'desc' => __( 'Please note that the theme uses the Contact Form 7 plugin for building forms and its option panel is found in the WordPress navigation menu on the left. ' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'pencil1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'contact-form-7',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Choose By ID', 'auto-repair' ) ,
			'id' => 'id',
			'default' => '',
			'prompt' => '',
			'options' => WPV_Editor::get_wpcf7_posts( 'ID' ),
			'type' => 'select',
		) ,

		array(
			'name' => __( 'Choose By Title', 'auto-repair' ) ,
			'id' => 'title',
			'default' => '',
			'prompt' => '',
			'options' => WPV_Editor::get_wpcf7_posts( 'post_title' ),
			'type' => 'select',
		) ,

		array(
			'name' => __( 'Title (optional)', 'auto-repair' ) ,
			'desc' => __( 'The title is placed just above the element.', 'auto-repair' ),
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
				'double' => __( 'Title with divider under it ', 'auto-repair' ),
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
