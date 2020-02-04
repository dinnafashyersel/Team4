<?php

/**
 * Theme options / General / Posts
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'Posts and Content', 'auto-repair' ),
	'type' => 'start',
),

array(
	'name' => __( 'Blog and Portfolio Listing Pages and Archives', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Pagination Type', 'auto-repair' ),
	'desc' => __( 'Please note that you will need WP-PageNavi plugin installed if you chose "paged" style.', 'auto-repair' ),
	'id' => 'pagination-type',
	'type' => 'select',
	'options' => array(
		'paged' => __( 'Paged', 'auto-repair' ),
		'load-more' => __( 'Load more button', 'auto-repair' ),
		'infinite-scrolling' => __( 'Infinite scrolling', 'auto-repair' ),
	),
	'class' => 'slim',
),


array(
	'name' => __( 'Blog Posts', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( '"View All Posts" Link', 'auto-repair' ),
	'desc' => __('In a single blog post view in the top you will find navigation with 3 buttons. The middle gets you to the blog listing view.<br>
You can place the link here.', 'auto-repair'),
	'id' => 'post-all-items',
	'type' => 'text',
	'static' => true,
	'class' => 'slim',
),

array(
	'name' => __( 'Show "Related Posts" in Single Post View', 'auto-repair' ),
	'desc' => __( 'Enabling this option will show more posts from the same category when viewing a single post.', 'auto-repair' ),
	'id' => 'show-related-posts',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __( '"Related Posts" title', 'auto-repair' ),
	'id' => 'related-posts-title',
	'type' => 'text',
	'class' => 'slim',
),

array(
	'name' => __( 'Show Post Author', 'auto-repair' ),
	'desc' => __( 'Blog post meta info, works for the single blog post view.', 'auto-repair' ),
	'id' => 'show-post-author',
	'type' => 'toggle',
	'class' => 'slim'
),
array(
	'name' => __( 'Show Categories and Tags', 'auto-repair' ),
	'desc' => __( 'Blog post meta info, works for the single blog post view.', 'auto-repair' ),
	'id' => 'meta_posted_in',
	'type' => 'toggle',
	'class' => 'slim',
),
array(
	'name' => __( 'Show Post Timestamp', 'auto-repair' ),
	'desc' => __( 'Blog post meta info, works for the single blog post view.', 'auto-repair' ),
	'id' => 'meta_posted_on',
	'type' => 'toggle',
	'class' => 'slim',
),
array(
	'name' => __( 'Show Comment Count', 'auto-repair' ),
	'desc' => __( 'Blog post meta info, works for the single blog post view.', 'auto-repair' ),
	'id' => 'meta_comment_count',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __( 'Portfolio Posts', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( '"View All Portfolios" Link', 'auto-repair' ),
	'desc' => __('In a single portfolio post view in the top you will find navigation with 3 buttons. The middle gets you to the portfolio listing view.<br>
You can place the link here.', 'auto-repair'),
	'id' => 'portfolio-all-items',
	'type' => 'text',
	'static' => true,
	'class' => 'slim',
),
array(
	'name' => __( 'Show "Related Portfolios" in Single Portfolio View', 'auto-repair' ),
	'desc' => __( 'Enabling this option will show more portfolio posts from the same category in the single portfolio post.', 'auto-repair' ),
	'id' => 'show-related-portfolios',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __( '"Related Portfolios" title', 'auto-repair' ),
	'id' => 'related-portfolios-title',
	'type' => 'text',
	'class' => 'slim',
),

array(
	'name' => __( 'URL Prefix for Single Portfolios', 'auto-repair' ),
	'desc' => __( 'Use an unique string without spaces. It must not be the same as any other URL slugs (used on pages, etc.).', 'auto-repair' ),
	'id' => 'portfolio-slug',
	'type' => 'text',
	'class' => 'slim',
),

	array(
		'type' => 'end'
	),
);