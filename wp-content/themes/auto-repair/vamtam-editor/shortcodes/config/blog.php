<?php

/**
 * Blog shortcode options
 *
 * @package wpv
 * @subpackage editor
 */


return array(
	'name' => 'Blog',
	'desc' => __( 'Please note that this element shows already created blog posts. To create one go to the Posts tab in the WordPress main navigation menu on the left - add new. You do not have to go to Settings - Reading to set the blog listing page.' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'blog' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'blog',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __( 'Layout', 'auto-repair' ),
			'desc' => __('Big images - this is the standard layout in one column. <br/>
				Small images, Small Images - Scrollable, Small images - Masonry - the posts in these layouts come in boxes with image on top and text below. They come in 2,3,4 columns.', 'auto-repair') ,
			'id' => 'layout',
			'type' => 'select',
			'default' => 'normal',
			'options' => array(
				'normal' => __( 'Big Images', 'auto-repair' ),
				'small' => __( 'Small Images - Normal', 'auto-repair' ),
				'scroll-x' => __( 'Small Images - Scrollable', 'auto-repair' ),
				'masonry' => __( 'Small Images - Masonry', 'auto-repair' ),
			),
			'field_filter' => 'fbs',
		),
		array(
			'name' => __( 'Columns', 'auto-repair' ) ,
			'desc' => __( 'Number of posts to show per row.', 'auto-repair' ) ,
			'id' => 'column',
			'default' => 2,
			'min' => 1,
			'max' => 4,
			'type' => 'range',
			'class' => 'fbs fbs-small fbs-scroll-x fbs-masonry',
		) ,
		array(
			'name' => __( 'Limit', 'auto-repair' ) ,
			'desc' => __( 'Number of posts to show per page.', 'auto-repair' ) ,
			'id' => 'count',
			'default' => 3,
			'min' => 1,
			'max' => 50,
			'type' => 'range',
		) ,

		array(
			'name' => __( 'Display Post Content', 'auto-repair' ) ,
			'id' => 'show_content',
			'desc' => __('Big Images Layout: If the option is on, it will display the content of the post, otherwise it will display the excerpt.<br>
				Small Images - Normal, Scrollable, Masonry: If the option is on, the post excerpt will be shown, otherwise no content will be shown.', 'auto-repair') ,
			'default' => false,
			'type' => 'toggle',
		) ,
		array(
			'name' => __( 'Nopaging', 'auto-repair' ) ,
			'id' => 'nopaging',
			'desc' => __( 'If the option is on, it will disable pagination. You can set the type of pagination in General Settings - Posts - Pagination Type. ', 'auto-repair' ) ,
			'default' => true,
			'type' => 'toggle',
			'class' => 'fbs fbs-normal fbs-small fbs-masonry',
		) ,
		array(
			'name' => __( 'Category (optional)', 'auto-repair' ) ,
			'desc' => __( 'All categories will be shown if none are selected. Please note that if you do not see categories, there are none created most probably. You can use ctr + click to select multiple categories', 'auto-repair' ) ,
			'id' => 'cat',
			'default' => array() ,
			'target' => 'cat',
			'type' => 'multiselect',
			'layout' => 'checkbox',
		) ,
		array(
			'name' => __( 'Posts (optional)', 'auto-repair' ) ,
			'desc' => __( 'All posts will be shown if none are selected. If you select any posts here, this option will override the category option above. You can use ctr + click to select multiple posts.', 'auto-repair' ) ,
			'id' => 'posts',
			'default' => array() ,
			'target' => 'post',
			'type' => 'multiselect',
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



