<?php
/**
 * Vamtam Portfolio Format Selector
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'Portfolio Format', 'auto-repair' ),
	'type' => 'separator'
),

array(
	'name' => __( 'Portfolio Data Type', 'auto-repair' ),
	'desc' => __('Image - uses the featured image (default)<br />
				  Gallery - use the featured image as a title image but show additional images too<br />
				  Video/Link - uses the "portfolio data url" setting<br />
				  Document - acts like a normal post<br />
				  HTML - overrides the image with arbitrary HTML when displaying a single portfolio page. Does not work with the ajax portfolio.
				', 'auto-repair'),
	'id' => 'portfolio_type',
	'type' => 'radio',
	'options' => array(
		'image' => __( 'Image', 'auto-repair' ),
		'gallery' => __( 'Gallery', 'auto-repair' ),
		'video' => __( 'Video', 'auto-repair' ),
		'link' => __( 'Link', 'auto-repair' ),
		'document' => __( 'Document', 'auto-repair' ),
		'html' => __( 'HTML', 'auto-repair' ),
	),
	'default' => 'image',
),

);
