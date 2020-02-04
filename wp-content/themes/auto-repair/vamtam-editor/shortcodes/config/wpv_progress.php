<?php
return array(
	'name' => __( 'Progress Indicator', 'auto-repair' ) ,
	'desc' => __( 'You can choose from % indicator or animated number.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'meter-medium' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'wpv_progress',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Type', 'auto-repair' ),
			'id' => 'type',
			'type' => 'select',
			'default' => 'percentage',
			'options' => array(
				'percentage' => __( 'Percentage', 'auto-repair' ),
				'number' => __( 'Number', 'auto-repair' ),
			),
			'field_filter' => 'fpis',
		),

		array(
			'name' => __( 'Percentage', 'auto-repair' ) ,
			'id' => 'percentage',
			'default' => 0,
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'unit' => '%',
			'class' => 'fpis fpis-percentage',
		) ,

		array(
			'name'    => __( 'Value', 'auto-repair' ) ,
			'id'      => 'value',
			'default' => 0,
			'type'    => 'range',
			'min'     => 0,
			'max'     => 100000,
			'class'   => 'fpis fpis-number',
		) ,

		array(
			'name' => __( 'Before Value', 'auto-repair' ) ,
			'id' => 'before_value',
			'default' => '',
			'type' => 'text',
			'class' => 'fpis fpis-number',
		) ,

		array(
			'name' => __( 'After Value', 'auto-repair' ) ,
			'id' => 'after_value',
			'default' => '',
			'type' => 'text',
			'class' => 'fpis fpis-number',
		) ,

		array(
			'name' => __( 'Track Color', 'auto-repair' ) ,
			'id' => 'bar_color',
			'default' => 'accent1',
			'type' => 'color',
			'class' => 'fpis fpis-percentage',
		) ,

		array(
			'name' => __( 'Bar Color', 'auto-repair' ) ,
			'id' => 'track_color',
			'default' => 'accent7',
			'type' => 'color',
			'class' => 'fpis fpis-percentage',
		) ,

		array(
			'name' => __( 'Value Color', 'auto-repair' ) ,
			'id' => 'value_color',
			'default' => 'accent2',
			'type' => 'color',
		) ,

	) ,
);
