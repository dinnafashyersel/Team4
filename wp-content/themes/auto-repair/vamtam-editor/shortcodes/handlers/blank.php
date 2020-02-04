<?php

class WPV_Blank {
	public function __construct() {
		add_shortcode( 'blank', array(&$this, 'blank') );
		add_shortcode( 'push', array(&$this, 'blank') );
	}

	public function blank($atts, $content = null) {
		extract(shortcode_atts(array(
	  'h'            => false,
	  'hide_low_res' => false,
	  'class'        => '',
		), $atts));

		$h = intval( $h );

		$type = $h < 0 ? 'margin-bottom' : 'height';

		$style = "{$type}:{$h}px";

		if ( $hide_low_res ) {
			$class .= ' wpv-hide-lowres';
		}

		return '<div class="push ' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '"></div>';
	}
}

new WPV_blank;
