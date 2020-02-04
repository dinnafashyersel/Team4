<?php
return array(
	'name' => __( 'IFrame', 'auto-repair' ) ,
	'desc' => __( 'You can embed a website using this element.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'tablet' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'iframe',
	'controls' => 'size name clone edit delete',
	'options' => array(
		
		array(
			'name' => __( 'Source', 'auto-repair' ) ,
			'desc' => __( 'The URL of the page you want to display. Please note that the link should be in this format - http://www.google.com.<br/><br/>', 'auto-repair' ),
			'id' => 'src',
			'size' => 30,
			'default' => 'http://apple.com',
			'type' => 'text',
			'holder' => 'div',
			'placeholder' => __( 'Click edit to set iframe source url', 'auto-repair' ),
		) ,
		array(
			'name' => __( 'Width', 'auto-repair' ) ,
			'desc' => __( 'You can use % or px as units for width.<br/><br/>', 'auto-repair' ) ,
			'id' => 'width',
			'size' => 30,
			'default' => '100%',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Height', 'auto-repair' ) ,
			'desc' => __( 'You can use px as units for height.<br/><br/>', 'auto-repair' ) ,
			'id' => 'height',
			'size' => 30,
			'default' => '400px',
			'type' => 'text',
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
	) ,
);
