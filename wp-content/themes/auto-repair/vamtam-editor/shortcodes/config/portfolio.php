<?php
/**
 * Portfolio shortcode options
 *
 * @package wpv
 * @subpackage editor
 */


return array(
	'name' => __( 'Portfolio', 'auto-repair' ) ,
	'desc' => __( 'Please note that this element shows already created portfolio posts. To create one go to the Portfolios tab in the WordPress main navigation menu on the left - Add New. ' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'grid2' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'portfolio',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __( 'Layout', 'auto-repair' ) ,
			'id' => 'layout',
			'desc' => __('Static - no filtering.<br/>
				Filtering - Enable filtering for the portfolio items depending on their category.<br/>
				Srollable - shows the portfolio items in a slider', 'auto-repair') ,
			'default' => '',
			'type' => 'select',
			'options' => array(
				'static' => __( 'Static', 'auto-repair' ),
				'fit-rows' => __( 'Filtering - Static', 'auto-repair' ),
				'masonry' => __( 'Filtering - Masonry', 'auto-repair' ),
				'scrollable' => __( 'Scrollable', 'auto-repair' ),
			),
			'field_filter' => 'fbs',
		) ,
		array(
			'name' => __( 'No Paging', 'auto-repair' ) ,
			'id' => 'nopaging',
			'desc' => __( 'If the option is on, it will disable pagination. You can set the type of pagination in General Settings - Posts - Pagination Type. ', 'auto-repair' ) ,
			'default' => false,
			'type' => 'toggle',
			'class' => 'fbs fbs-static fbs-fit-rows fbs-masonry',
		) ,
		array(
			'name' => __( 'Columns', 'auto-repair' ) ,
			'id' => 'column',
			'default' => 4,
			'type' => 'range',
			'min' => 1,
			'max' => 4,
		) ,
		array(
			'name' => __( 'Limit', 'auto-repair' ) ,
			'desc' => __( 'Number of item to show per page. If you set it to -1, it will display all portfolio items.', 'auto-repair' ) ,
			'id' => 'max',
			'default' => '4',
			'min' => -1,
			'max' => 100,
			'step' => '1',
			'type' => 'range'
		) ,

		array(
			'name' => __( 'Display Title', 'auto-repair' ) ,
			'id' => 'title',
			'desc' => __( 'If the option is on, it will display the title of the portfolio post.<br/><br/>', 'auto-repair' ) ,
			'default' => 'false',
			'type' => 'select',
			'options' => array(
				'false' => __( 'No Title', 'auto-repair' ),
				'below' => __( 'Below Media', 'auto-repair' ),
			),
		) ,
		array(
			'name' => __( 'Display Description', 'auto-repair' ) ,
			'id' => 'desc',
			'desc' => __( 'If the option is on, it will display short description of the portfolio item.', 'auto-repair' ) ,
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __( 'Button Text', 'auto-repair' ) ,
			'id' => 'more',
			'default' => __( 'Read more', 'auto-repair' ) ,
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Group', 'auto-repair' ) ,
			'id' => 'group',
			'desc' => __( 'If the option is on, the lightbox will display left and right arrows and  you can see all the portfolio posts from the same category.', 'auto-repair' ) ,
			'default' => true,
			'type' => 'toggle',
			'class' => 'fbs fbs-static fbs-fit-rows fbs-masonry',
		) ,
		array(
			'name' => __( 'Categories (optional)', 'auto-repair' ) ,
			'desc' => __( 'All categories will be shown if none are selected. Please note that if you do not see categories, there are none created most probably. You can use ctr + click to select multiple categories.', 'auto-repair' ) ,
			'id' => 'cat',
			'default' => array() ,
			'target' => 'portfolio_category',
			'type' => 'multiselect',
		) ,
		array(
			'name' => __( 'Portfolio Posts (optional)', 'auto-repair' ) ,
			'desc' => __( 'All portfolio posts will be shown if none are selected. If you select any posts here, this option will override the category option above. You can use ctr + click to select multiple posts.', 'auto-repair' ) ,
			'id' => 'ids',
			'default' => array() ,
			'target' => 'portfolio',
			'type' => 'multiselect',
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
				'single' => __( 'Title with divider next to it ', 'auto-repair' ),
				'double' => __( 'Title with divider below', 'auto-repair' ),
				'no-divider' => __( 'No Divider', 'auto-repair' ),
			),
		) ,
	) ,
);
