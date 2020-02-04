<?php

/**
 * Theme options / General / General Settings
 *
 * @package wpv
 * @subpackage auto-repair
 */

return array(
array(
	'name' => __( 'General Settings', 'auto-repair' ),
	'type' => 'start'
),

array(
	'name' => __( 'Header Logo Type', 'auto-repair' ),
	'id'   => 'header-logo-type',
	'type' => 'select',
	'options' => array(
		'image'      => __( 'Image', 'auto-repair' ),
		'site-title' => __( 'Site Title', 'auto-repair' ),
	),
	'static'       => true,
	'field_filter' => 'fblogo',
),

array(
	'name'   => __( 'Custom Logo Picture', 'auto-repair' ),
	'desc'   => __( 'Please Put a logo which exactly twice the width and height of the space that you want the logo to occupy. The real image size is used for retina displays.', 'auto-repair' ),
	'id'     => 'custom-header-logo',
	'type'   => 'upload',
	'static' => true,
	'class'  => 'fblogo fblogo-image',
),

array(
	'name'   => __('Alternative Logo', 'auto-repair'),
	'desc'   => __('This logo is used when you are using the transparent sticky header. It must be the same size as the main logo.', 'auto-repair'),
	'id'     => 'custom-header-logo-transparent',
	'type'   => 'upload',
	'static' => true,
	'class'  => 'fblogo fblogo-image',
),

array(
	'name'   => __( 'First Left Name', 'auto-repair' ),
	'id'     => 'header-name-left-top',
	'type'   => 'text',
	'static' => true,
	'class'  => 'fblogo fblogo-names',
),

array(
	'name'   => __( 'Last Left Name', 'auto-repair' ),
	'id'     => 'header-name-left-bottom',
	'type'   => 'text',
	'static' => true,
	'class'  => 'fblogo fblogo-names',
),

array(
	'name'   => __( 'First Right Name', 'auto-repair' ),
	'id'     => 'header-name-right-top',
	'type'   => 'text',
	'static' => true,
	'class'  => 'fblogo fblogo-names',
),

array(
	'name'   => __( 'Last Right Name', 'auto-repair' ),
	'id'     => 'header-name-right-bottom',
	'type'   => 'text',
	'static' => true,
	'class'  => 'fblogo fblogo-names',
),

array(
	'name'   => __( 'Splash Screen Logo', 'auto-repair' ),
	'id'     => 'splash-screen-logo',
	'type'   => 'upload',
	'static' => true,
),

array(
	'name'   => __( 'Google Maps API Key', 'auto-repair' ),
	'desc'   => __("This option is required since June 22, 2016. Paste your Google Maps API Key here. If you don't have one, please sign up for a <a href='https://developers.google.com/maps/documentation/javascript/get-api-key'>Google Maps API key</a>.", 'auto-repair'),
	'id'     => 'gmap_api_key',
	'type'   => 'text',
	'static' => true,
),

array(
	'name'   => __( 'Google Analytics Key', 'auto-repair' ),
	'desc'   => __( "Paste your key here. It should be something like UA-XXXXX-X. We're using the faster asynchronous loader, so you don't need to worry about speed.", 'auto-repair' ),
	'id'     => 'analytics_key',
	'type'   => 'text',
	'static' => true,
),

array(
	'name' => __( '"Scroll to Top" Button', 'auto-repair' ),
	'desc' => __( 'It is found in the bottom right side. It is sole purpose is help the user scroll a long page quickly to the top.', 'auto-repair' ),
	'id'   => 'show_scroll_to_top',
	'type' => 'toggle',
),

array(
	'name'    => __( 'Feedback Button', 'auto-repair' ),
	'desc'    => __( 'It is found on the right hand side of your website. You can chose from a "link" or a slide out form(widget area).The slide out form is configured as a standard widget. You can use the same form you are using for your "contact us" page.', 'auto-repair' ),
	'id'      => 'feedback-type',
	'type'    => 'select',
	'options' => array(
		'none'    => __( 'None', 'auto-repair' ),
		'link'    => __( 'Link', 'auto-repair' ),
		'sidebar' => __( 'Slide out widget area', 'auto-repair' ),
	),
),

array(
	'name' => __( 'Feedback Button Link', 'auto-repair' ),
	'desc' => __( 'If you have chosen a "link" in the option above, place the link of the button here, usually to your contact us page.', 'auto-repair' ),
	'id'   => 'feedback-link',
	'type' => 'text',
),

array(
	'name'   => __( 'Share Icons', 'auto-repair' ),
	'desc'   => __( 'Select the social media you want enabled and for which parts of the website', 'auto-repair' ),
	'type'   => 'social',
	'static' => true,
),

array(
	'name'   => __( 'Custom JavaScript', 'auto-repair' ),
	'desc'   => __( 'If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Option Panel please place your javascript in this field. The contents of this field are placed near the <strong>&lt;/body&gt;</strong> tag, which improves the load times of the page.', 'auto-repair' ),
	'id'     => 'custom_js',
	'type'   => 'textarea',
	'rows'   => 15,
	'static' => true,
),

array(
	'name'  => __( 'Custom CSS', 'auto-repair' ),
	'desc'  => __( 'If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Options Panel please place your CSS in this field.', 'auto-repair' ),
	'id'    => 'custom_css',
	'type'  => 'textarea',
	'rows'  => 15,
	'class' => 'top-desc',
),

array(
	'type' => 'end'
)
);