<?php

return array(
	'name'    => __( 'Icon', 'auto-repair' ) ,
	'value'   => 'icon',
	'options' => array(
		array(
			'name'    => __( 'Name', 'auto-repair' ) ,
			'id'      => 'name',
			'default' => '',
			'type'    => 'icons',
		) ,
		array(
			'name'    => __( 'Color (optional)', 'auto-repair' ) ,
			'id'      => 'color',
			'default' => '',
			'prompt'  => '',
			'type'    => 'select',
			'options' => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),
			) ,
		) ,
		array(
			'name'    => __( 'Size', 'auto-repair' ),
			'id'      => 'size',
			'type'    => 'range',
			'default' => 16,
			'min'     => 8,
			'max'     => 100,
		),
		array(
			'name'    => __( 'Style', 'auto-repair' ) ,
			'id'      => 'style',
			'default' => '',
			'prompt'  => __( 'Default', 'auto-repair' ),
			'type' => 'select',
			'options' => array(
				'inverted-colors' => __( 'Invert colors', 'auto-repair' ),
				'box'             => __( 'Box', 'auto-repair' ),
				'border'          => __( 'Border', 'auto-repair' ),
			) ,
		) ,
	)
);