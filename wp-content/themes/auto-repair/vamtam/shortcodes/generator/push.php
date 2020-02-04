<?php
return array(
	'name'    => __( 'Vertical Blank Space', 'auto-repair' ) ,
	'value'   => 'push',
	'options' => array(
		array(
			'name'    => __( 'Height', 'auto-repair' ) ,
			'id'      => 'h',
			'default' => 30,
			'min'     => -200,
			'max'     => 200,
			'type'    => 'range',
		) ,
		array(
			'name'    => __( 'Hide on Low Resolutions', 'auto-repair' ) ,
			'id'      => 'hide_low_res',
			'default' => false,
			'type'    => 'toggle',
		) ,
		array(
			'name'    => __( 'Class', 'auto-repair' ) ,
			'id'      => 'class',
			'default' => '',
			'type'    => 'text',
		) ,
	) ,
);
