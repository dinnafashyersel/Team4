<?php
return array(
	"name" => "Sitemap",
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'list' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value" => "sitemap",
	'controls' => 'size name clone edit delete',
	'class' => 'slim',
	"options" => array(
		array(
			'name' => __( 'General', 'auto-repair' ),
			'type' => 'separator',
		),
			array(
				"name" => __( "Filter", 'auto-repair' ) ,
				"id" => "shows",
				"default" => array(),
				"options" => array(
					"pages" => __( "Pages", 'auto-repair' ) ,
					"categories" => __( "Categories", 'auto-repair' ) ,
					"posts" => __( "Posts", 'auto-repair' ) ,
					"portfolios" => __( "Portfolios", 'auto-repair' ) ,
				) ,
				"type" => "multiselect",
			) ,

			array(
				"name" => __( "Limit", 'auto-repair' ) ,
				"desc" => __( "Sets the number of items to display.<br>leaving this setting as 0 displays all items.", 'auto-repair' ) ,
				"id" => "number",
				"default" => 0,
				"min" => 0,
				"max" => 200,
				"type" => "range"
			) ,

			array(
				"name" => __( "Depth", 'auto-repair' ) ,
				"desc" => __( "This parameter controls how many levels in the hierarchy are to be included. <br> 0: Displays pages at any depth and arranges them hierarchically in nested lists<br> -1: Displays pages at any depth and arranges them in a single, flat list<br> 1: Displays top-level Pages only<br> 2, 3 … Displays Pages to the given depth", 'auto-repair' ) ,
				"id" => "depth",
				"default" => 0,
				"min" => - 1,
				"max" => 5,
				"type" => "range"
			) ,

		array(
			'name' => __( 'Posts and portfolios', 'auto-repair' ),
			'type' => 'separator',
		),
			array(
				"name" => __( "Show comments", 'auto-repair' ) ,
				"id" => "show_comment",
				"desc" => '',
				"default" => true,
				"type" => "toggle"
			) ,
			array(
				"name" => __( "Specific post categories", 'auto-repair' ) ,
				"id" => "post_categories",
				"default" => array() ,
				"target" => 'cat',
				"type" => "multiselect",
			) ,
			array(
				"name" => __( "Specific posts", 'auto-repair' ) ,
				"desc" => __( "The specific posts you want to display", 'auto-repair' ) ,
				"id" => "posts",
				"default" => array() ,
				"target" => 'post',
				"type" => "multiselect",
			) ,
			array(
				"name" => __( "Specific portfolio categories", 'auto-repair' ) ,
				"id" => "portfolio_categories",
				"default" => array() ,
				"target" => 'portfolio_category',
				"type" => "multiselect",
			) ,
		
		array(
			'name' => __( 'Categories', 'auto-repair' ),
			'type' => 'separator',
		),
			array(
				"name" => __( "Show Count", 'auto-repair' ) ,
				"id" => "show_count",
				"desc" => __( "Toggles the display of the current count of posts in each category.", 'auto-repair' ) ,
				"default" => true,
				"type" => "toggle"
			) ,
			array(
				"name" => __( "Show Feed", 'auto-repair' ) ,
				"id" => "show_feed",
				"desc" => __( "Display a link to each category's <a href='http://codex.wordpress.org/Glossary#RSS' target='_blank'>rss-2</a> feed.", 'auto-repair' ) ,
				"default" => true,
				"type" => "toggle"
			) ,
			array(
			'name' => __( 'Title', 'auto-repair' ) ,
			'desc' => __( 'The column title is placed just above the element.', 'auto-repair' ),
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
