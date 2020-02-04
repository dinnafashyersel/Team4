<?php

/**
 * Blockquote shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __( 'Testimonials', 'auto-repair' ) ,
	'desc' => __( 'Please note that this element shows already created testimonials. To create one go to Testimonials tab in the WordPress main navigation menu on the left - add new.  ' , 'auto-repair' ),
	'icon' => array(
		'char' => WPV_Editor::get_icon( 'quotes-left' ),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'blockquote',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __( 'Layout', 'auto-repair' ) ,
			'id' => 'layout',
			'default' => 'slider',
			'type' => 'select',
			'options' => array(
				'slider' => __( 'Slider', 'auto-repair' ),
				'static' => __( 'Static', 'auto-repair' ),
			),
			'field_filter' => 'fbl',
		) ,
		array(
			'name' => __( 'Categories (optional)', 'auto-repair' ) ,
			'desc' => __( 'By default all categories are active. Please note that if you do not see catgories, most probably there are none created.  You can use ctr + click to select multiple categories.' , 'auto-repair' ),
			'id' => 'cat',
			'default' => array() ,
			'target' => 'testimonials_category',
			'type' => 'multiselect',
		) ,
		array(
			'name' => __( 'IDs (optional)', 'auto-repair' ) ,
			'desc' => __( ' By default all testimonials are active. You can use ctr + click to select multiple IDs.', 'auto-repair' ) ,
			'id' => 'ids',
			'default' => array() ,
			'target' => 'testimonials',
			'type' => 'multiselect',
		) ,

		array(
			'name' => __( 'Automatically rotate', 'auto-repair' ) ,
			'id' => 'autorotate',
			'default' => false,
			'type' => 'toggle',
			'class' => 'fbl fbl-slider',
		) ,

		array(
			'name' => __( 'Title (optional)', 'auto-repair' ) ,
			'desc' => __( 'The title is placed just above the element.', 'auto-repair' ),
			'id' => 'column_title',
			'default' => __( '', 'auto-repair' ) ,
			'type' => 'text'
		) ,


		array(
			'name' => __( 'Title Type (optional)', 'auto-repair' ) ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __( 'Title with devider next to it.', 'auto-repair' ),
				'double' => __( 'Title with devider under it.', 'auto-repair' ),
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
