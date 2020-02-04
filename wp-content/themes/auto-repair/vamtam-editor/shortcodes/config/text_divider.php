<?php
return array(
	'name' => __( 'Text Divider', 'auto-repair' ) ,
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'minus' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'text_divider',
	'controls' => 'name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Type', 'auto-repair' ) ,
			'id' => 'type',
			'default' => 'single',
			'options' => array(
				'single' => __( 'Title in the middle', 'auto-repair' ) ,
				'double' => __( 'Title above divider', 'auto-repair' ) ,
			) ,
			'type' => 'select',
			'class' => 'add-to-container',
			'field_filter' => 'ftds',
		) ,
		array(
			'name' => __( 'Text', 'auto-repair' ) ,
			'id' => 'html-content',
			'default' => __( 'Text Divider', 'auto-repair' ),
			'type' => 'editor',
			'class' => 'ftds ftds-single ftds-double',
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
