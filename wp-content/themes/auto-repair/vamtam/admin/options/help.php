<?php
return array(
	'name' => __( 'Help', 'auto-repair' ),
	'auto' => true,
	'config' => array(

		array(
			'name' => __( 'Help', 'auto-repair' ),
			'type' => 'title',
			'desc' => '',
		),

		array(
			'name' => __( 'Help', 'auto-repair' ),
			'type' => 'start',
			'nosave' => true,
		),
//----
		array(
			'type' => 'docs',
		),

			array(
				'type' => 'end',
			),
	),
);