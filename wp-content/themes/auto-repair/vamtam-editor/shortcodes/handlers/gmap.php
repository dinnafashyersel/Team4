<?php

class WPV_Gmap {
	public function __construct() {
		add_shortcode( 'gmap', array(__CLASS__, 'shortcode') );
	}

	public static function shortcode($atts, $content = null, $code = 'gmap') {
		extract(shortcode_atts(array(
			"width"            => false,
			"height"           => '400',
			"address"          => '',
			"latitude"         => 0,
			"longitude"        => 0,
			"zoom"             => 14,
			"html"             => '',
			"popup"            => 'false',
			"controls"         => '[]',
			"scrollwheel"      => 'true',
			"maptype"          => 'ROADMAP',
			"marker"           => 'true',
			'align'            => false,
			'hue'              => '',
			'invert_lightness' => 'false',
		), $atts));

		$width       = ($width && is_numeric( $width )) ? 'width:'.$width.'px;' : '';
		$height      = ($height && is_numeric( $height )) ? 'height:'.$height.'px;' : '';
		$align       = $align ? 'align'.$align : '';
		$id          = rand( 100,1000 );
		$inline_html = $html;

		$scrollwheel      = wpv_sanitize_bool( $scrollwheel );
		$invert_lightness = wpv_sanitize_bool( $invert_lightness );
		$marker           = wpv_sanitize_bool( $marker );
		$popup            = wpv_sanitize_bool( $popup );

		if ( empty($controls) ) {
			$controls = '[]';
		}

		if ( empty($latitude) ) {
			$latitude = 0;
		}

		if ( empty($longitude) ) {
			$longitude = 0;
		}

		if ( !empty($hue) ) {
			$hue = ','.json_encode( array(
				'hue' => wpv_sanitize_accent( $hue ),
			) );
		}

		ob_start();

		$params = array(
			'zoom'        => intval( $zoom ),
			'controls'    => json_decode( $controls ),
			'maptype'     => $maptype,
			'scrollwheel' => $scrollwheel,
			'custom'      => array(
				'styles' => array(
					array(
						'stylers' => array(
							array( 'inverse_lightness' => $invert_lightness ),
							$hue,
						),
					),
				),
			),
		);

		if ( $marker ) {
			$params['markers'] = array(
				array(
					'address'   => $address,
					'latitude'  => $latitude,
					'longitude' => $longitude,
					'html'      => $inline_html,
					'popup'     => $popup,
				),
			);
		} else {
			$params['latitude']  = $latitude;
			$params['longitude'] = $longitude;
			$params['address']   = $address;
		}

?>

	<div class="frame"><div id="google_map_<?php echo esc_attr( $id ) ?>" class="google_map <?php echo esc_attr( $align ) ?>" style="<?php echo esc_attr( $width . $height ) // xss ok ?>"></div></div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery("#google_map_<?php echo esc_attr( $id ) ?>").gMap( <?php echo json_encode( $params ) // xss ok ?> );
	});
	</script>

<?php
		return ob_get_clean();
	}
}

new WPV_Gmap;
