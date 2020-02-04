<?php
/**
 * Vamtam Post Options
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'General', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name'    => __( 'Cite', 'auto-repair' ) ,
	'id'      => 'testimonial-author',
	'default' => '',
	'type'    => 'text',
) ,

array(
	'name'    => __( 'Link', 'auto-repair' ) ,
	'id'      => 'testimonial-link',
	'default' => '',
	'type'    => 'text',
) ,

array(
	'name'    => __( 'Rating', 'auto-repair' ) ,
	'id'      => 'testimonial-rating',
	'default' => 5,
	'type'    => 'range',
	'min'     => 0,
	'max'     => 5,
) ,

array(
	'name'    => __( 'Summary', 'auto-repair' ) ,
	'id'      => 'testimonial-summary',
	'default' => '',
	'type'    => 'text',
) ,

);
