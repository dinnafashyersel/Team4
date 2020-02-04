<?php

function wpv_shortcode_dropcap( $atts, $content = null, $code ) {
	$original_atts = $atts;
	$atts          = shortcode_atts( array(
	 'type'   => 1,
	 'color'  => '',
	 'letter' => '',
	), $atts );

	$code .= $atts['type'];

	$dropcap = "<span class='$code {$atts['color']}'>" . $atts[ 'letter' ] . '</span>';

	if ( ! empty( $content ) && ! ctype_space( $content ) ) {
		return '<div class="clearfix dropcap-wrapper"><div class="dropcap-left">' . $dropcap . '</div><div class="dropcap-text">' . $content . '</div> </div>';
	}

	return $dropcap;
}
add_shortcode( 'dropcap', 'wpv_shortcode_dropcap' );