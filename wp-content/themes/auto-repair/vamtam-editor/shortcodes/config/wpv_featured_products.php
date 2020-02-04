<?php
return array(
	'name' => __( 'Featured Products', 'auto-repair' ) ,
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'cart1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'wpv_featured_products',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Columns', 'auto-repair' ) ,
			'id' => 'columns',
			'default' => 4,
			'min' => 2,
			'max' => 4,
			'type' => 'range',
		) ,
		array(
			'name' => __( 'Limit', 'auto-repair' ) ,
			'desc' => __( 'Maximum number of products.', 'auto-repair' ) ,
			'id' => 'per_page',
			'default' => 3,
			'min' => 1,
			'max' => 50,
			'type' => 'range',
		) ,

		array(
			'name' => __( 'Order By', 'auto-repair' ) ,
			'id' => 'orderby',
			'default' => 'date',
			'type' => 'radio',
			'options' => array(
				'date' => __( 'Date', 'auto-repair' ),
				'menu_order' => __( 'Menu Order', 'auto-repair' ),
			),
		) ,

		array(
			'name' => __( 'Order', 'auto-repair' ) ,
			'id' => 'order',
			'default' => 'desc',
			'type' => 'radio',
			'options' => array(
				'desc' => __( 'Descending', 'auto-repair' ),
				'asc' => __( 'Ascending', 'auto-repair' ),
			),
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
