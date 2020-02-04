<?php
/**
 * Vamtam Post Format Options
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(

array(
	'name' => __( 'Standard', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-0',
),

array(
	'name' => __( 'How do I use standard post format?', 'auto-repair' ),
	'desc' => __( 'Just use the editor below.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __( 'Aside', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-aside',
),

array(
	'name' => __( 'How do I use aside post format?', 'auto-repair' ),
	'desc' => __( 'Just use the editor below. The post title will not be shown publicly.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __( 'Link', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-link',
),

array(
	'name' => __( 'How do I use link post format?', 'auto-repair' ),
	'desc' => __( 'Use the editor below for the post body, put the link in the option below.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __( 'Link', 'auto-repair' ),
	'id' => 'wpv-post-format-link',
	'type' => 'text',
),

// --

array(
	'name' => __( 'Image', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-image',
),

array(
	'name' => __( 'How do I use image post format?', 'auto-repair' ),
	'desc' => __( 'Use the standard Featured Image option.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __( 'Video', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-video',
),

array(
	'name' => __( 'How do I use video post format?', 'auto-repair' ),
	'desc' => __( 'Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __( 'Link', 'auto-repair' ),
	'id' => 'wpv-post-format-video-link',
	'type' => 'text',
),

// --

array(
	'name' => __( 'Audio', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-audio',
),

array(
	'name' => __( 'How do I use auido post format?', 'auto-repair' ),
	'desc' => __( 'Put the url of the audio below. You must use an oEmbed provider supported by WordPress or a file supported by the [audio] shortcode which comes with WordPress.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __( 'Link', 'auto-repair' ),
	'id' => 'wpv-post-format-audio-link',
	'type' => 'text',
),

// --

array(
	'name' => __( 'Quote', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-quote',
),

array(
	'name' => __( 'How do I use quote post format?', 'auto-repair' ),
	'desc' => __( 'Simply fill in author and link fields', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __( 'Author', 'auto-repair' ),
	'id' => 'wpv-post-format-quote-author',
	'type' => 'text',
),

array(
	'name' => __( 'Link', 'auto-repair' ),
	'id' => 'wpv-post-format-quote-link',
	'type' => 'text',
),

// --

array(
	'name' => __( 'Gallery', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-gallery',
),

array(
	'name' => __( 'How do I use gallery post format?', 'auto-repair' ),
	'desc' => __( 'Use the "Add Media" in a text/image block element to create a gallery.This button is also found in the top left side of the visual and text editors.', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __( 'Status', 'auto-repair' ),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-status',
),

array(
	'name' => __( 'How do I use this post format?', 'auto-repair' ),
	'desc' => __( '...', 'auto-repair' ),
	'type' => 'info',
	'visible' => true,
),

);
