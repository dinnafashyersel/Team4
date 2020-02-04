<?php
return array(
	'name' => __( 'Text/Image Block', 'auto-repair' ) ,
	'desc' => __('Please note that you can style your text with the help of the VamTam shortcodes found in the editor icon board at the top. Look for the V button. <br/>
		You can insert an image by the button -Add Media- found above the editor when you open the element option panel.<br/>
		You can toggle the element and insert plane text if you are in a rush.' , 'auto-repair'),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'file3' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'text',
	'controls' => 'size name edit delete clone handle',
	'options' => array(


		array(
			'name' => __( 'Content', 'auto-repair' ) ,
			'id' => 'html-content',
			'default' => '',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,



		array(
			'name' => __( 'Title (optional)', 'auto-repair' ) ,
			'desc' => __( 'The column title is placed just above the element.<br/><br/>', 'auto-repair' ),
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
