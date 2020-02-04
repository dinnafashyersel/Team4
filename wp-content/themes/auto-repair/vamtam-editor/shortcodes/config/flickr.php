<?php
return array(
	'name' => __( 'Flickr', 'auto-repair' ) ,
	'desc' => __( 'This element is usefull if you have a Flickr account. Use <a href="http://idgettr.com/" target="_blank">idGettr</a> if you don\'t know your ID.<br/><br/>.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'flickr' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'flickr',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __( 'Flickr ID', 'auto-repair' ),
			'desc' => __( 'Use <a href="http://idgettr.com/" target="_blank">idGettr</a> if you don\'t know your ID.<br/><br/>', 'auto-repair' ),
			'id' => 'id',
			'default' => '',
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Type', 'auto-repair' ),
			'id' => 'type',
			'default' => 'page',
			'options' => array(
				'user' => __( 'User', 'auto-repair' ),
				'group' => __( 'Group', 'auto-repair' ),
			),
			'type' => 'select',
		),
		
		array(
			'name' => __( 'Count', 'auto-repair' ),
			'desc' => '',
			'id' => 'count',
			'default' => 4,
			'min' => 0,
			'max' => 20,
			'type' => 'range'
		),
		array(
			'name' => __( 'Display', 'auto-repair' ),
			'id' => 'display',
			'default' => 'latest',
			'options' => array(
				'latest' => __( 'Latest', 'auto-repair' ),
				'random' => __( 'Random', 'auto-repair' ),
			),
			'type' => 'select',
		),
		
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
	

	) ,
);
