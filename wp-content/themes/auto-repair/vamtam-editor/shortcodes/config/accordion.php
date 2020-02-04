<?php
return array(
	"name" => __( "Accordion", 'auto-repair' ),
	'desc' => __( 'Adding panes, changing the name of the pane and adding content into the panes is done when the accordion element is toggled.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'menu1' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value" => "accordion",
	'controls' => 'size name clone edit delete always-expanded',
	'callbacks' => array(
		'init' => 'init-accordion',
		'generated-shortcode' => 'generate-accordion',
	),
	"options" => array(

		array(
			'name' => __( 'Allow All Panes to be Closed', 'auto-repair' ) ,
			'desc' => __( 'If enabled, the accordion will load with collapsed panes. Clicking on the title of the currently active pane will close it. Clicking on the title of an inactive pane will change the active pane.', 'auto-repair' ),
			'id' => 'collapsible',
			'default' => true,
			'type' => 'toggle'
		) ,

		array(
			'name' => __( 'Pane Background', 'auto-repair' ) ,
			'id' => 'closed_bg',
			'default' => 'accent1',
			'type' => 'color'
		) ,

		array(
			'name' => __( 'Title Color', 'auto-repair' ) ,
			'id' => 'title_color',
			'default' => 'accent8',
			'type' => 'color'
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
