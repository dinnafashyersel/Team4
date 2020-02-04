<?php
return array(
	'name' => __( 'Divider', 'auto-repair' ) ,
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'minus' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'divider',
	'controls' => 'name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Type', 'auto-repair' ) ,
			'desc' => __( '"Clear floats" is just a div element with <em>clear:both</em> styles. Although it is safe to say that unless you already know how to use it, you will not need this, you can <a href="https://developer.mozilla.org/en-US/docs/CSS/clear">click here for a more detailed description</a>.', 'auto-repair' ),
			'id' => 'type',
			'default' => 1,
			'options' => array(
				1 => __( 'Divider line 1 px with accent line', 'auto-repair' ) ,
				2 => __( 'Divider double lines', 'auto-repair' ) ,
				3 => __( 'Divider line 1 px', 'auto-repair' ) ,
				'clear' => __( 'Clear floats', 'auto-repair' ) ,
			) ,
			'type' => 'select',
			'class' => 'add-to-container',
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
