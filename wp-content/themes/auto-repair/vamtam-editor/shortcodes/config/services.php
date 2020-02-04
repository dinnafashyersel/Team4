<?php
return array(
	'name' => __( 'Service Box', 'auto-repair' ) ,
	'desc' => __( 'Please note that the service box may not work properly in one half to full width layouts.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'cog1' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Style', 'auto-repair' ) ,
			'id' => 'fullimage',
			'default' => 'false',
			'type' => 'select',
			'options' => array(
				'false' => __( 'Style big icon with zoom out', 'auto-repair' ),
				'true' => __( 'Style standard with an image or an icon ', 'auto-repair' ),
			),
			'field_filter' => 'fbs',
		) ,

		array(
			'name' => __( 'Icon', 'auto-repair' ) ,
			'desc' => __( 'This option overrides the "Image" option.', 'auto-repair' ),
			'id' => 'icon',
			'default' => 'apple',
			'type' => 'icons',
		) ,
		array(
			"name" => __( "Icon Color", 'auto-repair' ) ,
			"id" => "icon_color",
			"default" => 'accent6',
			"prompt" => '',
			"options" => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),
			) ,
			"type" => "select",
		) ,
		array(
			'name' => __( 'Icon Size', 'auto-repair' ),
			'id' => 'icon_size',
			'type' => 'range',
			'default' => 62,
			'min' => 8,
			'max' => 100,
			'class' => 'fbs fbs-true',
		),
		array(
			'name' => __( 'Icon Background', 'auto-repair' ),
			'id' => 'background',
			'default' => 'accent1',
			'type' => 'color',
			'class' => 'fbs fbs-false',
		),

		array(
			'name' => __( 'Image', 'auto-repair' ) ,
			'desc' => __( 'This option can be overridden by the "Icon" option.', 'auto-repair' ),
			'id' => 'image',
			'default' => '',
			'type' => 'upload',
		) ,

		array(
			'name' => __( 'Title', 'auto-repair' ) ,
			'id' => 'title',
			'default' => 'This is a title',
			'type' => 'text',
		) ,

		array(
			'name' => __( 'Description', 'auto-repair' ) ,
			'id' => 'html-content',
			'default' => 'This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.

Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.',
			'type' => 'editor',
			'holder' => 'textarea',
		) ,

		array(
			'name' => __( 'Text Alignment', 'auto-repair' ) ,
			'id' => 'text_align',
			'default' => 'justify',
			'type' => 'select',
			'options' => array(
				'justify' => 'justify',
				'left' => 'left',
				'center' => 'center',
				'right' => 'right',
			)
		) ,
		array(
			'name' => __( 'Link', 'auto-repair' ) ,
			'id' => 'button_link',
			'default' => '/',
			'type' => 'text'
		) ,

		array(
			'name' => __( 'Button Text', 'auto-repair' ) ,
			'id' => 'button_text',
			'default' => 'learn more',
			'type' => 'text'
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
