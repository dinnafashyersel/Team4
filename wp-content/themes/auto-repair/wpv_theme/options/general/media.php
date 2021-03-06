<?php
/**
 * Theme options / General / Media
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'Media', 'auto-repair' ),
	'type' => 'start',

),

array(
	'name' => __( 'How do I use these options?', 'auto-repair' ),
	'desc' => sprintf( __( 'These options control the size of some of the images used by the theme. <br><br> <strong>Changes are not immediate</strong><br><br> If you have changed any of these options, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'auto-repair' ), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ),
	'type' => 'info',
	'class' => "important",
),

array(
	'name' => __( 'Portfolio', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Portfolio Listing Featured Images Width-to-Height Ratio', 'auto-repair' ),
	'desc' => __( 'You can set it to 0 to disable this and the option below  and show the real size of the images.', 'auto-repair' ),
	'id' => 'portfolio-loop-images-wth',
	'type' => 'range',
	'min' => 0,
	'max' => 3,
	'step' => 0.05,
),



array(
	'name' => __( 'Single Portfolio Page Featured Image Width-to-Height Ratio', 'auto-repair' ),
	'desc' => __( 'You can set it to 0 to disable this and the option below  and show the real size of the images.', 'auto-repair' ),
	'id' => 'single-portfolio-images-wth',
	'type' => 'range',
	'min' => 0,
	'max' => 3,
	'step' => 0.05,
),




array(
	'name' => __( 'Blog', 'auto-repair' ),
	'type' => 'separator',
),

array(
	'name' => __( 'Blog Listing Image Width-to-Height Ratio', 'auto-repair' ),
	'desc' => __( 'You can set it to 0 to disable this and the option below  and show the real size of the images.', 'auto-repair' ),
	'id' => 'post-loop-images-wth',
	'type' => 'range',
	'min' => 0,
	'max' => 3,
	'step' => 0.05,
),





array(
	'name' => __( 'Blog Single Post Image Width-to-Height Ratio', 'auto-repair' ),
	'desc' => __( 'You can set it to 0 to disable this and the option below  and show the real size of the images.', 'auto-repair' ),
	'id' => 'single-post-images-wth',
	'type' => 'range',
	'min' => 0,
	'max' => 3,
	'step' => 0.05,
),


array(
	'name' => __( 'Blog Small Featured Image Width-to-Height Ratio', 'auto-repair' ),
	'desc' => __( 'This image is used in News Style Blog in columns. You can set it to 0 to disable this and the option below  and show the real size of the images.', 'auto-repair' ),
	'id' => 'post-small-images-wth',
	'type' => 'range',
	'min' => 0,
	'max' => 3,
	'step' => 0.05,
),


	array(
		'type' => 'end'
	),
);
