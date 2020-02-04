<?php

/**
 * Column shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __( 'Column - Color Box', 'auto-repair' ) ,
	'desc' => __('Once inserted into the editor you can change its width using +/- icons on the left.<br/>
	You can insert any element into by draging and dropping it onto the box. <br/>
	You can drag and drop column into column for complex layouts.<br/>
	You can move any element outside of the column by drag and drop.<br/>
	You can set color/image background on any column.
	' , 'auto-repair'),
	'icon' => array(
		'char'    => WPV_Editor::get_icon( 'table1' ),
		'size'    => '26px',
		'lheight' => '39px',
		'family'  => 'vamtam-editor-icomoon',
	),
	'value'    => 'column',
	'controls' => 'size name clone edit delete handle',
	'options'  => array(

		array(
			'name' => __( 'Background Parallax', 'auto-repair' ),
			'desc' => __('The parallax effect will affect only the image background of the column not the elements you place into it.<br/>
You can insert column into column with transparent background images and thus create multi layers parallax effects. <br/>
Parallax - Simple, align in the middle  - the column background is positioned - center/center   when it is in the middle of the screen.<br/>
Parallax - Fixed attachment - the column background is positioned top center when the column is at the top of the screen.<br/>
The option bellow controls speed and direction of the animation.<br/>
The parallax effect will be disabled on mobile devices as they do not yet properly support this animations and may cause different issues.
', 'auto-repair'),
			'id'      => 'parallax_bg',
			'type'    => 'select',
			'default' => 'disabled',
			'options' => array(
				'disabled'  => __( 'Disabled', 'auto-repair' ),
				'to-centre' => __( 'Simple, align at the middle', 'auto-repair' ),
				'fixed'     => __( 'Fixed attachment', 'auto-repair' ),
			),
			'field_filter' => 'fbprlx',
		),

		array(
			'name'    => __( 'Background Parallax Inertia', 'auto-repair' ),
			'desc'    => __( 'The option controls speed and direction of the animation. Minus means against the scroll direction. Plus means with the direction of the scroll. The bigger the number the higher the speed. ', 'auto-repair' ),
			'id'      => 'parallax_bg_inertia',
			'type'    => 'range',
			'min'     => -5,
			'max'     => 5,
			'step'    => 0.05,
			'default' => -.2,
			'class'   => 'fbprlx fbprlx-fixed fbprlx-to-centre',
		),

		array(
			'name'         => __( 'Full Screen Mode', 'auto-repair' ),
			'desc'         => __( 'Extend the background of the column to the end of the screen. This is basicly a full screen mode.', 'auto-repair' ),
			'id'           => 'extended',
			'type'         => 'toggle',
			'default'      => false,
			'class'        => 'hide-1-2 hide-1-3 hide-1-4 hide-1-5 hide-1-6 hide-2-3 hide-2-5 hide-3-5 hide-4-5 hide-5-6',
			'field_filter' => 'fbe',
		),

		array(
			'name'    => __( 'Use Left/Right Padding', 'auto-repair' ) ,
			'id'      => 'extended_padding',
			'default' => true,
			'type'    => 'toggle',
			'class'   => 'hide-inner fbe fbe-true' . ( wpv_get_option( 'site-layout-type' ) == 'full' ? ' hidden': ''), // xss ok
		) ,

		array(
			'name' => __( 'Background Color / Image', 'auto-repair' ),
			'desc' => __( 'Please note that the background image left/right positions, as well as the cover option will not work as expected if the option Full Screen Mode is ON.', 'auto-repair' ),
			'id'   => 'background',
			'type' => 'background',
			'only' => 'color,image,repeat,position,size,attachment',
			'sep'  => '_',
		),

		array(
			'name'    => __( 'Hide the Background Image on Lower Resolutions', 'auto-repair' ),
			'id'      => 'hide_bg_lowres',
			'type'    => 'toggle',
			'default' => false,
		),

		array(
			'name'  => __( 'Background Video', 'auto-repair' ),
			'desc'  => __( 'Insert self-hosted video. Please note that if the video is the first element below the menu, It will not work properly in Chrome. You should use Layered Slider instead.', 'auto-repair' ),
			'id'    => 'background_video',
			'type'  => 'upload',
			'video' => true,
			'class' => 'fbprlx fbprlx-disabled',
		),

		array(
			'name'   => __( 'Vertical Padding', 'auto-repair' ),
			'desc'   => __( 'Positive values increase the blank space at the top/bottom of the column. Negative values are interpreted as setting the blank space so that the column is a certain amount of px shorter than the window. 0 means no padding.<br><br> Having both values set to a negative number will center the content vertically. In this case only the <em>top</em> value is used in the calculations.', 'auto-repair' ),
			'id'     => 'vertical_padding',
			'type'   => 'range-row',
			'ranges' => array(
				'vertical_padding_top' => array(
					'desc'    => __( 'Top', 'auto-repair' ),
					'default' => 0,
					'unit'    => 'px',
					'min'     => -500,
					'max'     => 500,
				),
				'vertical_padding_bottom' => array(
					'desc'    => __( 'Bottom', 'auto-repair' ),
					'default' => 0,
					'unit'    => 'px',
					'min'     => -500,
					'max'     => 500,
				),
			),
		),

		array(
			'name'    => __( '"Read More" Button Link (optional)', 'auto-repair' ) ,
			'desc'    => __( 'If enabled, the column will have a button on the right.<br/><br/>', 'auto-repair' ),
			'id'      => 'more_link',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbe fbe-false',
		) ,

		array(
			'name'    => __( '"Read More" Button Text (optional)', 'auto-repair' ) ,
			'desc'    => __( 'If enabled, the column will have a button on the right.<br/><br/>', 'auto-repair' ),
			'id'      => 'more_text',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbe fbe-false',
		) ,

		array(
			'name'    => __( 'Left Border', 'auto-repair' ) ,
			'id'      => 'left_border',
			'default' => 'transparent',
			'type'    => 'color'
		) ,

		array(
			'name'    => __( 'Class (Optional)', 'auto-repair' ) ,
			'desc'    => __( 'If you would like to add a specific class or ID for any element, you can do this by first wrapping the element in a Column, and then adding your chosen class/ID to the respective column options. In the case of the ID, you need to enter an alphanumeric string without any spaces. In the case of the Class option, you need to enter a space-separated list of classes without dots (similar to how you would use HTMLs class  attribute). If you have entered my-column-class as the columns class, you can then use the following CSS selector for this column: .my-column-class', 'auto-repair' ),
			'id'      => 'class',
			'default' => '',
			'type'    => 'text'
		) ,

		array(
			'name'    => __( 'ID (Optional)', 'auto-repair' ) ,
			'desc'    => __('If you would like to add a specific class or ID for any element, you can do this by first wrapping the element in a Column, and then adding your chosen class/ID to the respective column options. In the case of the ID, you need to enter an alphanumeric string without any spaces. In the case of the Class option, you need to enter a space-separated list of classes without dots (similar to how you would use HTMLs class attribute). If you have entered my-column-class as the columns class, you can then use the following CSS selector for this column:
			.my-column-class<br/><br/>', 'auto-repair'),
			'id'      => 'id',
			'default' => '',
			'type'    => 'text'
		) ,

		array(
			'name'    => __( 'Title (optional)', 'auto-repair' ) ,
			'desc'    => __( 'The column title is placed at the top of the column.', 'auto-repair' ),
			'id'      => 'title',
			'default' => '',
			'type'    => 'text',
		) ,
		array(
			'name'    => __( 'Title Type (optional)', 'auto-repair' ) ,
			'id'      => 'title_type',
			'default' => 'single',
			'type'    => 'select',
			'options' => array(
				'single'     => __( 'Title with divider next to it', 'auto-repair' ),
				'double'     => __( 'Title with divider below', 'auto-repair' ),
				'no-divider' => __( 'No Divider', 'auto-repair' ),
			),
		) ,
		array(
			'name'    => __( 'Element Animation (optional)', 'auto-repair' ) ,
			'id'      => 'animation',
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
			'class' => 'fbprlx fbprlx-disabled',
		) ,


	) ,
);
