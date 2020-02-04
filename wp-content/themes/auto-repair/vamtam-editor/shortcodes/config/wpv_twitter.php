<?php
return array(
	"name" => __( "Twitter Timeline", 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'twitter' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value" => "wpv_twitter",
	'controls' => 'size name clone edit delete',
	"options" => array(

		array(
			'name' => __( 'Type', 'auto-repair' ) ,
			'id' => 'type',
			'default' => 'user',
			'type' => 'select',
			'options' => array(
				'user' => __( 'Single user', 'auto-repair' ),
				'search' => __( 'Search results ', 'auto-repair' ),
			),
		) ,

		array(
			'name' => __( 'Username or Search Terms', 'auto-repair' ) ,
			'id' => 'param',
			'default' => '',
			'type' => 'text',
		) ,

		array(
			'name' => __( 'Number of Tweets', 'auto-repair' ) ,
			'id' => 'limit',
			'default' => 5,
			'type' => 'range',
			'min' => 1,
			'max' => 20,
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
	),
);
