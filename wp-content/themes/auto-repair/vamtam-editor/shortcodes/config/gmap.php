<?php
return array(
	'name' => __( 'Google Maps', 'auto-repair' ) ,
	'desc' => __('In order to enable Google Map you need:<br>
				 Insert the Google Map element into the editor, open its option panel by clicking on the icon- edit on the right of the element and fill in all fields necessary.
' , 'auto-repair'),
		'icon' => array(
		'char' => WPV_Editor::get_icon( 'location1' ),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'gmap',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __( 'Address (optional)', 'auto-repair' ) ,
			'desc' => __( 'Unless you\'ve filled in the Latitude and Longitude options, please enter the address that you want to be shown on the map. If you encounter any errors about the maximum number of address translation requests per page, you should either use the latitude/longitude options or upgrade to the paid Google Maps API.', 'auto-repair' ),
			'id' => 'address',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Latitude', 'auto-repair' ) ,
			'desc' => __( 'This option is not necessary if an address is set.<br/><br/>', 'auto-repair' ),
			'id' => 'latitude',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Longitude', 'auto-repair' ) ,
			'desc' => __( 'This option is not necessary if an address is set.<br/><br/>', 'auto-repair' ),
			'id' => 'longitude',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Zoom', 'auto-repair' ) ,
			'desc' => __( 'Default map zoom level.<br/><br/>', 'auto-repair' ),
			'id' => 'zoom',
			'default' => '14',
			'min' => 1,
			'max' => 19,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __( 'Marker', 'auto-repair' ) ,
			'desc' => __( 'Enable an arrow pointing at the address.<br/><br/>', 'auto-repair' ),
			'id' => 'marker',
			'default' => true,
			'type' => 'toggle'
		) ,
		array(
			'name' => __( 'HTML', 'auto-repair' ) ,
			'desc' => __( 'HTML code to be shown in a popup above the marker.<br/><br/>', 'auto-repair' ),
			'id' => 'html',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Popup Marker', 'auto-repair' ) ,
			'desc' => __( 'Enable to open the popup above the marker by default.<br/><br/>', 'auto-repair' ),
			'id' => 'popup',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __( 'Controls (optional)', 'auto-repair' ) ,
			'desc' => sprintf( __( 'This option is intended to be used only by advanced users and is not necessary for most use cases. Please refer to the <a href="%s" title="Google Maps API documentation">API documentation</a> for details.', 'auto-repair' ), 'https://developers.google.com/maps/documentation/javascript/controls' ),
			'id' => 'controls',
			'size' => 30,
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __( 'Scrollwheel', 'auto-repair' ) ,
			'id' => 'scrollwheel',
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __( 'Maptype (optional)', 'auto-repair' ) ,
			'id' => 'maptype',
			'default' => 'ROADMAP',
			'options' => array(
				'ROADMAP' => __( 'Default road map', 'auto-repair' ) ,
				'SATELLITE' => __( 'Google Earth satellite', 'auto-repair' ) ,
				'HYBRID' => __( 'Mixture of normal and satellite', 'auto-repair' ) ,
				'TERRAIN' => __( 'Physical map', 'auto-repair' ) ,
			) ,
			'type' => 'select',
		) ,

		array(
			'name' => __( 'Color (optional)', 'auto-repair' ) ,
			'desc' => __( 'Defines the overall hue for the map. It is advisable that you avoid gray colors, as they are not well-supported by Google Maps.', 'auto-repair' ),
			'id' => 'hue',
			'default' => '',
			'prompt' => __( 'Default', 'auto-repair' ) ,
			'options' => array(
				'accent1' => __( 'Accent 1', 'auto-repair' ),
				'accent2' => __( 'Accent 2', 'auto-repair' ),
				'accent3' => __( 'Accent 3', 'auto-repair' ),
				'accent4' => __( 'Accent 4', 'auto-repair' ),
				'accent5' => __( 'Accent 5', 'auto-repair' ),
				'accent6' => __( 'Accent 6', 'auto-repair' ),
				'accent7' => __( 'Accent 7', 'auto-repair' ),
				'accent8' => __( 'Accent 8', 'auto-repair' ),
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __( 'Width (optional)', 'auto-repair' ) ,
			'desc' => __( 'Set to 0 is the full width.<br/><br/>', 'auto-repair' ) ,
			'id' => 'width',
			'default' => 0,
			'min' => 0,
			'max' => 960,
			'step' => '1',
			'type' => 'range'
		) ,
		array(
			'name' => __( 'Height', 'auto-repair' ) ,
			'id' => 'height',
			'default' => '400',
			'min' => 0,
			'max' => 960,
			'step' => '1',
			'type' => 'range'
		) ,


		array(
			'name' => __( 'Title (optioanl)', 'auto-repair' ) ,
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
				'single' => __( 'Title with divider next to it', 'auto-repair' ),
				'double' => __( 'Title with divider below', 'auto-repair' ),
				'no-divider' => __( 'No Divider', 'auto-repair' ),
			),
		) ,
	) ,
);