<?php
return 	array(
	'name' => __( 'Team Member', 'auto-repair' ),
	'icon' => array(
		'char'    => WPV_Editor::get_icon( 'profile' ),
		'size'    => '26px',
		'lheight' => '39px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'team_member',
	'controls' => 'size name clone edit delete',
	'options'  => array(

		array(
			'name'    => __( 'Name', 'auto-repair' ),
			'id'      => 'name',
			'default' => 'Nikolay Yordanov',
			'type'    => 'text',
			'holder'  => 'h5',
		),
		array(
			'name'    => __( 'Position', 'auto-repair' ),
			'id'      => 'position',
			'default' => 'Web Developer',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Link', 'auto-repair' ),
			'id'      => 'url',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Email', 'auto-repair' ),
			'id'      => 'email',
			'default' => 'support@vamtam.com',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Phone', 'auto-repair' ),
			'id'      => 'phone',
			'default' => '+448786562223',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Picture', 'auto-repair' ),
			'id'      => 'picture',
			'default' => 'http://makalu.vamtam.com/wp-content/uploads/2013/03/people4.png',
			'type'    => 'upload'
		),

		array(
			'name'    => __( 'Biography', 'auto-repair' ) ,
			'id'      => 'html-content',
			'default' => __( 'This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'auto-repair' ),
			'type'    => 'editor',
			'holder'  => 'textarea',
		) ,

		array(
			'name'    => __( 'Google+', 'auto-repair' ),
			'id'      => 'googleplus',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'LinkedIn', 'auto-repair' ),
			'id'      => 'linkedin',
			'default' => '',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Facebook', 'auto-repair' ),
			'id'      => 'facebook',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Twitter', 'auto-repair' ),
			'id'      => 'twitter',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'YouTube', 'auto-repair' ),
			'id'      => 'youtube',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Pinterest', 'auto-repair' ),
			'id'      => 'pinterest',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'LastFM', 'auto-repair' ),
			'id'      => 'lastfm',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Instagram', 'auto-repair' ),
			'id'      => 'instagram',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Dribble', 'auto-repair' ),
			'id'      => 'dribble',
			'default' => '/',
			'type'    => 'text'
		),
		array(
			'name'    => __( 'Vimeo', 'auto-repair' ),
			'id'      => 'vimeo',
			'default' => '/',
			'type'    => 'text'
		),

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
	),
);
