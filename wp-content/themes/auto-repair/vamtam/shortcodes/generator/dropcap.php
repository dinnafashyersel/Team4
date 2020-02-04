<?php
return array(
	'name'    => __( 'Drop Cap', 'auto-repair' ) ,
	'value'   => 'dropcap',
	'options' => array(
		array(
			'name'    => __( 'Type', 'auto-repair' ) ,
			'id'      => 'type',
			'default' => '1',
			'type'    => 'select',
			'options' => array(
				'1' => __( 'Type 1', 'auto-repair' ),
				'2' => __( 'Type 2', 'auto-repair' ),
			),
		) ,
		array(
			'name'    => __( 'Letter', 'auto-repair' ) ,
			'id'      => 'letter',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => __( 'Text', 'auto-repair' ) ,
			'id'      => 'text',
			'default' => '',
			'type'    => 'text',
		) ,
	) ,
);
