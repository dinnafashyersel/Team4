<?php
return array(
	'name' => __( 'Box with a Link', 'auto-repair' ) ,
	'desc' => __( 'You can set a link, background color and hover color to a section of the website and place your content there.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'link5' ),
		'size' => '30px',
		'lheight' => '40px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'linkarea',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Background Color', 'auto-repair' ) ,
			'id' => 'background_color',
			'default' => '',
			'prompt' => __( 'No background', 'auto-repair' ),
			'options' => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),
			),
			'type' => 'select'
		) ,
		array(
			'name' => __( 'Hover Color', 'auto-repair' ) ,
			'id' => 'hover_color',
			'default' => 'accent1',
			'prompt' => __( 'No background', 'auto-repair' ),
			'options' => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),
			),
			'type' => 'select'
		) ,

		array(
			'name' => __( 'Link', 'auto-repair' ) ,
			'id' => 'href',
			'default' => '',
			'type' => 'text',
		) ,

		array(
			"name" => __( "Target", 'auto-repair' ) ,
			"id" => "target",
			"default" => '_self',
			"options" => array(
				"_blank" => __( 'Load in a new window', 'auto-repair' ) ,
				"_self" => __( 'Load in the same frame as it was clicked', 'auto-repair' ) ,
			) ,
			"type" => "select",
		) ,

		array(
			'name' => __( 'Contents', 'auto-repair' ) ,
			'id' => 'html-content',
			'default' => __('This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'auto-repair'),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,

		array(
			'name' => __( 'Icon', 'auto-repair' ) ,
			'desc' => __( 'This option overrides the "Image" option.', 'auto-repair' ),
			'id' => 'icon',
			'default' => '',
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
		),

		array(
			'name' => __( 'Image', 'auto-repair' ) ,
			'desc' => __( 'The image will appear above the content.<br/><br/>', 'auto-repair' ),
			'id' => 'image',
			'default' => '',
			'type' => 'upload',
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
