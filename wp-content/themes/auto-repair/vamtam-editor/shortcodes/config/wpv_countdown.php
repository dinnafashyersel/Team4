<?php
return array(
	'name' => __( 'Countdown', 'auto-repair' ) ,
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'clock' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'wpv_countdown',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Date and Time', 'auto-repair' ) ,
			'desc' => __( 'Any <a href="http://www.php.net/manual/en/datetime.formats.compound.php">compount time format</a> accepted by PHP. "Common Log Format" is recommended if your server is in different time zone from you.', 'auto-repair' ),
			'id' => 'datetime',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( '"Finished" text', 'auto-repair' ) ,
			'id' => 'done',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Description text', 'auto-repair' ) ,
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
		) ,
		array(
			'name' => __( 'Title (optional)', 'auto-repair' ) ,
			'desc' => __( 'The title is placed just above the element.<br/><br/>', 'auto-repair' ),
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